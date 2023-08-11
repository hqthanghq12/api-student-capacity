<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\playtopic;
use App\Models\poetry;
use App\Models\studentPoetry;
use App\Models\subject;
use App\Models\User;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use App\Services\Modules\MStudentManager\PoetryStudent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\Modules\MExam\Exam;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class studentPoetryController extends Controller
{
    use TUploadImage, TResponse;

    public function __construct(
        private PoetryStudent $PoetryStudent,
        private Exam          $exam,
        private poetry        $poetry,
    )
    {
    }

    public function index($id, $id_poetry, $idBlock)
    {
        $liststudent = $this->PoetryStudent->GetStudents($id);
        $poetry = $this->poetry->query()->where('id', $id)->first();
        $start = DB::table('examination')->where('id', $poetry->start_examination_id)->first()->started_at;
        $end = DB::table('examination')->where('id', $poetry->finish_examination_id)->first()->finished_at;
        $start_time = $poetry->exam_date . ' ' . $start;
        $end_time = $poetry->exam_date . ' ' . $end;
        $is_in_time = time() >= strtotime($start_time) && time() < strtotime($end_time);
        if (auth()->user()->hasRole('teacher')) {
            $isAllow = time() < strtotime($start_time) && $liststudent->count() == 0;
        } else {
            $isAllow = true;
        }
        $id_block_subject = $poetry->id_block_subject;
        $id_subject = DB::table('block_subject')->where('id', $id_block_subject)->first()->id_subject;
//        if (!$liststudent) return abort(404);
        $examsList = $this->exam->getListExam($id_subject);
//        dd($liststudent);
        return view('pages.poetry.students.index', [
            'student' => $liststudent,
            'id' => $id,
            'id_subject' => $id_subject,
            'exams_list' => $examsList,
            'id_poetry' => $id_poetry,
            'idBlock' => $idBlock,
            'id_block_subject' => $id_block_subject,
            'is_allow' => $isAllow,
            'is_in_time' => $is_in_time,
        ]);
    }

    public function export($id, $id_poetry, $idBlock)
    {
        $user = (new User())->getTable();
        $poetry = (new poetry())->getTable();
        $model = new studentPoetry();
        $table = $model->getTable();
        $liststudentQuery = $model::query()
            ->select(
                [
                    "{$table}.id",
                    "{$table}.id_student",
                    "playtopic.exam_name",
                    "{$table}.status",
                    "playtopic.has_received_exam",
                    "playtopic.exam_time",
                    "{$user}.name as nameStudent",
                    "{$user}.email as emailStudent",
                    "{$user}.mssv",
                    "{$poetry}.id_block_subject",
                    'result_capacity.scores',
                    'result_capacity.created_at',
                    'result_capacity.updated_at',
                ]
            )
            ->leftJoin($user, "{$user}.id", '=', "{$table}.id_student")
            ->leftJoin($poetry, "{$poetry}.id", '=', "{$table}.id_poetry")
            ->leftJoin('playtopic', "playtopic.student_poetry_id", '=', "{$table}.id")
            ->leftJoin('result_capacity', "result_capacity.playtopic_id", '=', "playtopic.id")
            ->where("{$table}.id_poetry", $id)
            ->orderBy("{$table}.id")
            ->orderByDesc('result_capacity.scores');

        if (request()->has('byDay') && request()->get('byDay') == 'true') {
            $currentDate = Carbon::now();

            // Đặt thời gian bắt đầu và kết thúc trong ngày hiện tại
            $startOfDay = $currentDate->startOfDay()->format('Y-m-d H:i:s');
            $endOfDay = $currentDate->endOfDay()->format('Y-m-d H:i:s');
//            dd($startOfDay, $endOfDay);
            $liststudentQuery->whereBetween('result_capacity.updated_at', [$startOfDay, $endOfDay]);
        }
        $liststudent = $liststudentQuery->get();
        $data = [];
        $key = 0;
        foreach ($liststudent as $value) {
            $start = Carbon::parse($value->created_at);
            $end = Carbon::parse($value->updated_at);
            if ($value->scores !== null) {
                $data[] = [
                    ++$key,
                    $value->emailStudent,
                    $value->scores,
                    $end->diffForHumans($start),
                    $end->format('H:i d-m-Y'),
                ];
            }
        }
        $spreadsheet = new Spreadsheet();
        // Thực hiện xử lý dữ liệu
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'TT');
        $sheet->setCellValue('B1', 'Email');
        $sheet->setCellValue('C1', 'Điểm');
        $sheet->setCellValue('D1', 'Thời gian làm bài');
        $sheet->setCellValue('E1', 'Thời gian nôp bài');
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $row = 2;
        $column = 1;
        foreach ($data as $recordata) {
            foreach ($recordata as $value) {
                $sheet->setCellValueByColumnAndRow($column, $row, $value);
                $sheet->getStyleByColumnAndRow($column, $row)->applyFromArray($borderStyle);
                $column++;
            }
            $row++;
            $column = 1;
        }
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(10);
        // Định dạng căn giữa và màu nền cho hàng tiêu đề
        $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:E1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');

        $writer = new Xlsx($spreadsheet);
        $outputFileName = 'diem_thi.xlsx';
        if (request()->has('byDay') && request()->get('byDay') == 'true') {
            $outputFileName = 'diem_thi_' . Carbon::now()->format('d-m-Y') . '.xlsx';
        }
        $writer->save($outputFileName);
        return response()->download($outputFileName)->deleteFileAfterSend(true, $outputFileName);
    }

    public function listUser($id)
    {
        if (!($liststudent = $this->PoetryStudent->GetStudents($id))) return abort(404);
        return view('pages.Students.accountStudent.listpoetry', [
            'student' => $liststudent,
            'id' => $id
        ]);
    }

    public function UserExportpoint($id)
    {
        $liststudent = $this->PoetryStudent->GetStudentsResponse($id);
        $spreadsheet = new Spreadsheet();

        // Thực hiện xử lý dữ liệu
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'STT');
        $sheet->setCellValue('B1', 'Tên sinh viên');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Mã sinh viên');
        $sheet->setCellValue('E1', 'Điểm');
        $sheet->setCellValue('F1', 'Ca Thi');

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $row = 2;
        $column = 1;
        foreach ($liststudent as $recordata) {
            foreach ($recordata as $value) {
                $sheet->setCellValueByColumnAndRow($column, $row, $value);
                $sheet->getStyleByColumnAndRow($column, $row)->applyFromArray($borderStyle);
                $column++;
            }
            $row++;
            $column = 1;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);

// Định dạng căn giữa và màu nền cho hàng tiêu đề
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');

        $writer = new Xlsx($spreadsheet);
        $outputFileName = 'diem_thi_sinh_vien_ca_thi_' . $id . '.xlsx';
        $writer->save($outputFileName);
        return response()->download($outputFileName)->deleteFileAfterSend(true, $outputFileName);
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'emailStudent' => 'required',
                'status' => 'required'
            ],
            [
                'emailStudent.required' => 'Không để trống email!',
                'status.required' => 'Vui lòng chọn trạng thái!'
            ]
        );

        if ($validator->fails() == 1) {
            $errors = $validator->errors();
            $fields = ['emailStudent', 'status'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error, 404);
                    }
                }
            }

        }
        $id_poetry = $request->id_poetry;
        $subject_id = DB::table('poetry')
            ->where('poetry.id', $id_poetry)
            ->join('block_subject', 'poetry.id_block_subject', '=', 'block_subject.id')
            ->first()->id_subject;
//        $data = null;
        $user = User::query()->whereIn('email', $request->emailStudent)->get();
//        foreach ($user as $item) {
//            dd($item->roles);
//        }
        $studentsQuery = User::query()
            ->with('poetry_student')
            ->select(['id', 'email'])
            ->whereIn('email', $request->emailStudent)
            ->whereHas('roles', function ($query) {
                $query->where('id', config('util.STUDENT_ROLE'));
            })
            ->whereDoesntHave('poetry_student', function ($query) use ($id_poetry) {
                $query->where('id_poetry', $id_poetry);
            });
//        if (!auth()->user()->hasRole('super admin')) {
//            $studentsQuery->where('campus_id', auth()->user()->campus_id);
//        }
        $students = $studentsQuery->get();
//        dd($students);
        $emailFiltered = $students->pluck('email')->toArray();
//        dd($emailFiltered);
//        dd($request->emailStudent);
        $userSuccessCount = count($emailFiltered);
        $userFailedCount = count(array_diff($request->emailStudent, $emailFiltered));
        $poetriesId = [];
        $maxStudentPoetryId = DB::table('student_poetry')->max('id');
        $dataInsertArr = [];
        foreach ($students as $object) {
            $dataInsert = [
                'id' => ++$maxStudentPoetryId,
                'id_poetry' => $id_poetry,
                'id_student' => $object->id,
                'status' => $request->status,
                'created_at' => now(),
                'updated_at' => null
            ];
            $poetriesId[] = $maxStudentPoetryId;
            $dataInsertArr[] = $dataInsert;
        }
        $dataInsertPlaytopicArr = [];
        if (!empty($poetriesId)) {
            $examsId = DB::table('exams')
                ->select('id', 'name')
                ->where('subject_id', $subject_id)
                ->where('total_questions', ">", 0)
                ->where('status', 1)
                ->get();
            if ($examsId->count() == 0) {
                return response("Không có đề trong ngân hàng đề", 404);
            }
            $exams = [];
            $examsCount = $examsId->count();
            $studentsCount = collect($poetriesId)->count();
            if ($studentsCount < $examsCount) {
                $examsId = $examsId->random($studentsCount);
                $examsCount = $studentsCount;
            }
            $studentPerExam = (int)floor($studentsCount / $examsCount);
            $examsIdArr = $examsId->toArray();
            for ($i = 0; $i < $examsCount; $i++) {
                $exam = (array)$examsIdArr[$i];
                $studentsGet = ($i == $examsCount - 1) ? $studentsCount : $studentPerExam;
                $studentsCount -= $studentsGet;
                $exams[$exam['id']] = [
                    'id' => $exam['id'],
                    'name' => $exam['name'],
                    'total' => $studentsGet,
                ];
            }
            $questionsByExamId = DB::table('exam_questions')
                ->select(['exam_questions.question_id', 'exam_questions.id', 'exam_questions.exam_id'])
                ->whereIn('exam_questions.exam_id', $examsId->pluck('id'))
                ->get()
                ->groupBy('exam_id')
                ->map(function ($item) {
                    return $item->pluck('question_id')->toArray();
                });
            shuffle($poetriesId);
            foreach ($poetriesId as $poetry_id) {
                $randomExamId = array_rand($exams, 1);
                $questions = $questionsByExamId[$randomExamId];
                $exam_name = $exams[$randomExamId]['name'];
                if (--$exams[$randomExamId]['total'] <= 0) {
                    unset($exams[$randomExamId]);
                }
                shuffle($questions);
                $dataInsertPlaytopicArr[] = [
                    'student_poetry_id' => $poetry_id,
                    'has_received_exam' => 1,
                    'exam_name' => $exam_name,
                    'questions_order' => json_encode($questions),
                    'exam_time' => 90,
                ];
            }
        }
        DB::table('student_poetry')->insert($dataInsertArr);
        if (!empty($dataInsertPlaytopicArr)) {
            DB::table('playtopic')->insert($dataInsertPlaytopicArr);
        }
        return response(['message' => "Thành công " . $userSuccessCount . '<br> Thất bại ' . $userFailedCount . '<br>Vui lòng chờ 5s để làm mới dữ liệu', 'data' => $students], 200);
    }

    public function now_status(Request $request, $id)
    {
        $studentPoetry = $this->PoetryStudent->Item($id);
        if (!$studentPoetry) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }
        $studentPoetry->status = $request->status;
        $studentPoetry->updated_at = now();
        $studentPoetry->save();
        $data = $request->all();
        $data['id'] = $id;
        return response(['message' => "Cập nhật trạng thái thành công", 'data' => $data], 200);
    }

    public function delete($id)
    {
        try {
            $this->PoetryStudent->Item($id)->delete();
            return response(['message' => "Xóa Thành công"], 200);
        } catch (\Throwable $th) {
            return response(['message' => 'Xóa thất bại'], 404);
        }
    }

    public function rejoin($id)
    {
        try {
            $playtopic = playtopic::query()
                ->where('student_poetry_id', $id)
                ->first();
            $playtopic->update(['rejoined_at' => now()]);
            DB::table('result_capacity')->where('playtopic_id', $playtopic->id)->delete();
            return response(['message' => "Thành công cho sinh viên thi lại"], 200);
        } catch (\Throwable $th) {
            return response(['message' => 'Thất bại khi cho sinh viên thi lại'], 404);
        }
    }
}
