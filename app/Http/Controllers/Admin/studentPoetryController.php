<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\playtopic;
use App\Models\poetry;
use App\Models\subject;
use App\Models\User;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use App\Services\Modules\MStudentManager\PoetryStudent;
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
        $id_block_subject = $this->poetry->query()->where('id', $id)->first()->id_block_subject;
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
        ]);
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
//        $data = null;
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
        if (!auth()->user()->hasRole('super admin')) {
            $studentsQuery->where('campus_id', auth()->user()->campus_id);
        }
        $students = $studentsQuery->get();
        $emailFiltered = $students->pluck('email')->toArray();
        $userSuccessCount = count($emailFiltered);
        $userFailedCount = count(array_diff($request->emailStudent, $emailFiltered));
//        foreach ($request->emailStudent as $value) {
//            $data[] = $this->PoetryStudent->findUser($value, $request->id_poetry);
//        }
//        $errors = 0;
//        $data = array_filter($data, function ($item) use (&$errors) {
//            if (!is_object($item)) {
//                $errors++;
//            }
//            return is_object($item);
//        });


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
            return response(['message' => "Thành công cho học sinh thi lại"], 200);
        } catch (\Throwable $th) {
            return response(['message' => 'Thất bại khi cho học sinh thi lại'], 404);
        }
    }
}
