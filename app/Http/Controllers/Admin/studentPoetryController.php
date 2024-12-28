<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\examination;
use App\Models\ExamQuestion;
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
use Illuminate\Support\Str;
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
        $poetry = $this->poetry->query()->with(['classsubject', 'block_subject'])->where('id', $id)->first();
        $start = DB::table('examination')->where('id', $poetry->start_examination_id)->first()->started_at;
        $end = DB::table('examination')->where('id', $poetry->finish_examination_id)->first()->finished_at;
        $start_time = Carbon::make($poetry->exam_date . ' ' . $start);
        $end_time = Carbon::make($poetry->exam_date . ' ' . $end);
        $has_started = $start_time->isPast();
        $is_in_time = now()->isBetween($start_time, $end_time);
        $isAllow = !(auth()->user()->hasRole('teacher'));
        $startTimeTen = clone $start_time;
//        if (auth()->user()->hasRole('teacher')) {
//            $isAllow = $start_time->isFuture() && $liststudent->count() == 0;
//        } else {
//            $isAllow = true;
//        }

//        dd($start_time->isFuture(), now()->format('Y-m-d H:i:s'));

        if (auth()->user()->hasRole('teacher')) {
            $canActive = !$start_time->isFuture();
        } else {
            $canActive = !(now()->isBefore($startTimeTen->addMinutes(10)));
        }

        $exam_date = Carbon::parse($poetry->exam_date)->format('d-m-Y');

        $today = Carbon::now()->format('d-m-Y');

        $isInDate = $exam_date == $today;

//        $canActive = !(auth()->user()->hasRole('super admin') && now()->isBefore($start_time->addMinutes(10))) || (!auth()->user()->hasRole('super admin') && $is_in_time);
//        dd($canActive);
        $id_block_subject = $poetry->id_block_subject;
        $id_subject = DB::table('block_subject')->where('id', $id_block_subject)->first()->id_subject;
        $examsList = $this->exam->getListExam($id_subject);
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
            'poetry' => $poetry,
            'has_started' => $has_started,
            'can_active' => $canActive,
            'is_in_date' => $isInDate,
        ]);
    }

    public function export($id, $id_poetry, $idBlock)
    {
        $user = (new User())->getTable();
        $poetry = (new poetry())->getTable();
        $model = new studentPoetry();
        $table = $model->getTable();
        $poetryRecord = $this->poetry->query()->with(['classsubject', 'block_subject'])->where('id', $id)->first();
        $subject = $poetryRecord->block_subject->subject->name;
        $class = $poetryRecord->classsubject->name;
        $room = $poetryRecord->room;

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
                    'result_capacity.status as result_status',
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
            if (!$value->scores) {
                $result_status = 'Chưa thi';
            } elseif ($value->result_status == 1) {
                $result_status = 'Đã thi';
            } elseif ($value->result_status == 0) {
                $result_status = 'Đang thi';
            }
//            if ($value->scores !== null) {
            $data[] = [
                ++$key,
                $value->emailStudent,
                $value->mssv,
                $value->nameStudent,
                $result_status,
                $value->scores ?? "Chưa thi",
                !$value->scores ? "Chưa thi" : $end->longAbsoluteDiffForHumans($start, 3),
                !$value->scores ? "Chưa thi" : $end->format('H:i d-m-Y'),
            ];
//            }
        }
        $spreadsheet = new Spreadsheet();
        // Thực hiện xử lý dữ liệu
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'TT');
        $sheet->setCellValue('B1', 'Email');
        $sheet->setCellValue('C1', 'Mã sinh viên');
        $sheet->setCellValue('D1', 'Tên sinh viên');
        $sheet->setCellValue('E1', 'Trạng thái');
        $sheet->setCellValue('F1', 'Điểm');
        $sheet->setCellValue('G1', 'Thời gian làm bài');
        $sheet->setCellValue('H1', 'Thời gian nôp bài');
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
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        // Định dạng căn giữa và màu nền cho hàng tiêu đề
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Điểm thi ca ' . $poetryRecord->start_examination_id . ' - ' . $room . ' - ' . $subject . ' - ' . $class;
        $outputFileName = $fileName . '.xlsx';
        if (request()->has('byDay') && request()->get('byDay') == 'true') {
            $outputFileName = Carbon::now()->format('d-m-Y') . ' _ ' . $fileName . '.xlsx';
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

        $poetry = $this->poetry->query()->where('id', $id_poetry)->first();

        $examination = examination::query()
            ->select(['id', 'started_at', 'finished_at'])
            ->whereIn('id', [$poetry->start_examination_id, $poetry->finish_examination_id])
            ->get();

        $start = $examination->where('id', $poetry->start_examination_id)->first()->started_at;
        $end = $examination->where('id', $poetry->finish_examination_id)->first()->finished_at;

        $start_time = Carbon::make($poetry->exam_date . ' ' . $start);
        $end_time = Carbon::make($poetry->exam_date . ' ' . $end);

        if ($start_time->isPast()) {
            $msg = $end_time->isPast() ? 'Đã kết thúc thi' : 'Đã bắt đầu thi';
            return response("{$msg}, không thể thêm sinh viên", 404);
        }

        $studentsQuery = User::query()
            ->with('poetry_student')
            ->select(['id', 'email'])
            ->whereIn('email', $request->emailStudent)
//            ->whereHas('roles', function ($query) {
//                $query->where('id', config('util.STUDENT_ROLE'));
//            })
            ->whereDoesntHave('poetry_student', function ($query) use ($id_poetry) {
                $query->where('id_poetry', $id_poetry);
            });

        $students = $studentsQuery->get();

        $emailFiltered = $students->pluck('email')->toArray();

        $userSuccessCount = count($emailFiltered);

        $userFailedCount = count(array_diff($request->emailStudent, $emailFiltered));

        $dataInsertArr = [];

        foreach ($students as $object) {
            $dataInsert = [
                'id_poetry' => $id_poetry,
                'id_student' => $object->id,
                'status' => $request->status,
                'created_at' => now(),
                'updated_at' => null
            ];
            $dataInsertArr[] = $dataInsert;
        }
        DB::table('student_poetry')->insert($dataInsertArr);

        return response(['message' => "Thành công " . $userSuccessCount . '<br> Thất bại ' . $userFailedCount . '<br>Vui lòng chờ 5s để làm mới dữ liệu', 'data' => $students], 200);
    }

    public function now_status(Request $request, $id)
    {
        $studentPoetry = $this->PoetryStudent->Item($id);
        if (!$studentPoetry) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }

        $poetry = $this->poetry::query()->find($studentPoetry->id_poetry);

        $examination = examination::query()
            ->select(['id', 'started_at', 'finished_at'])
            ->whereIn('id', [$poetry->start_examination_id, $poetry->finish_examination_id])
            ->get();

        $start = $examination->where('id', $poetry->start_examination_id)->first()->started_at;

        $start_time = Carbon::make($poetry->exam_date . ' ' . $start);

        if (!auth()->user()->hasRole('teacher')) {
            $start_time->addMinutes(10);
        }

        if ($start_time->isPast()) {
            return response()->json(['message' => 'Đã bắt đầu thi, không thể thay đổi trạng thái, hãy gửi yêu cầu tới admin cơ sở hoặc khảo thí để có thể mở trạng thái thi cho sinh viên'], 404);
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
            if (!$playtopic = playtopic::query()->where('student_poetry_id', $id)->first()) abort(404);

            $poetry = $playtopic->studentPoetry->poetry;

            $is_in_date = Carbon::parse($poetry->exam_date)->format('d-m-Y') == Carbon::now()->format('d-m-Y');

            if (!$is_in_date) {
                return response(['message' => 'Ca thi này đã qua hoặc chưa tới ngày thi, không thể cho sinh viên thi lại'], 404);
            };

            $playtopic->update(['rejoined_at' => now()]);
            DB::table('result_capacity')->where('playtopic_id', $playtopic->id)->delete();
            return response(['message' => "Thành công cho sinh viên thi lại"], 200);
        } catch (\Throwable $th) {
            return response(['message' => 'Thất bại khi cho sinh viên thi lại'], 404);
        }
    }
}
