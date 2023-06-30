<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Modules\MClass\classModel;
use App\Services\Modules\MClassSubject\ClassSubject;
use App\Services\Modules\MExamination\Examination;
use App\Services\Modules\MStudentManager\PoetryStudent;
use App\Services\Modules\MSubjects\Subject;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\Modules\poetry\poetry;
use App\Services\Modules\MSemeter\Semeter;
use App\Models\Campus;

class PoetryController extends Controller
{
    use TUploadImage, TResponse;

    public function __construct(
        private poetry        $poetry,
        private Semeter       $semeter,
        private Subject       $subject,
        private Examination   $examination,
        private ClassSubject  $classSubject,
        private classModel    $class,
        private PoetryStudent $PoetryStudent,
    )
    {
    }

    public function index($id, $idblock, Request $request)
    {
//        $data = $this->oneindexApi(140);
//        dd($data);
        $data = $this->poetry->ListPoetry($id, $idblock, $request);
        $semeter = $this->semeter->ListSemeter();
        $name = $this->semeter->getName($id);
        $listExamination = $this->examination->getList();
        $ListSubject = $this->subject->getItemSubjectSetemerReponse($idblock);
        $blockSubjectIdToName = $ListSubject->pluck('name', 'id');
        $listClass = $this->class->getClass();
        $usersQuery = User::query()
            ->with('campus')
            ->withWhereHas('roles', function ($query) {
                $query->where('id', config('util.TEACHER_ROLE'));
            });
        $listCampusQuery = (new Campus())->query();
        if (!auth()->user()->hasRole('super admin')) {
            $listCampusQuery->where('id', auth()->user()->campus_id);
            $usersQuery->where('campus_id', auth()->user()->campus_id);
        }
        $listCampus = $listCampusQuery->get();
        $teachers = $usersQuery->get();
        return view('pages.poetry.index', [
            'poetry' => $data,
            'semeter' => $semeter,
            'listSubject' => $ListSubject,
            'id_poetry' => $id,
            'listcampus' => $listCampus,
            'idBlock' => $idblock,
            'name' => $name,
            'listExamination' => $listExamination,
            'listClass' => $listClass,
            'blockSubjectIdToName' => $blockSubjectIdToName,
            'teachers' => $teachers,
        ]);
    }

    public function ListPoetryRespone($id_subject)
    {
        $data = $this->poetry->ListPoetryRespone($id_subject);
        return response()->json(['data' => $data], 200);
    }

    public function ListPoetryResponedetail(Request $request)
    {
        $data = $this->poetry->ListPoetryDetail($request->semeter, $request->block, $request->subject, $request->class);
        return response()->json(['data' => $data], 200);
    }

    public function ListPoetryResponedetailChart(Request $request)
    {

        $dataResult = $this->poetry->ListPoetryDetailChart($request->idcampus, $request->idsemeter, $request->idblock);
//        $dataWithStudents = [];

//        $poetryIds = array_column($dataResult, 'id_poetry');
//        return response()->json(['data' => $dataResult], 200);
//        foreach ($dataResult as $value) {
//            $studentsDetail = $this->PoetryStudent->GetStudentsDetail($value['id_poetry']);
//            $dataWithStudents['namePoetry'][] = $value['name'];
//            $dataWithStudents['student']['total'][] = $studentsDetail->count();
//            $dataWithStudents['student']['tookExam'][] = $studentsDetail->whereNotNull('scores')->count();
//            $dataWithStudents['student']['notExam'][] = $studentsDetail->whereNull('scores')->count();
//        }


        return response()->json(['data' => $dataResult], 200);
    }

    public function indexApi($id, $id_user)
    {
        if (!($data = $this->poetry->ListPoetryApi($id, $id_user))) return $this->responseApi(false);
        return $this->responseApi(true, $data);
    }

    public function oneindexApi($id_poetry)
    {
        if (!($data = $this->poetry->onePoetryApi($id_poetry))) return $this->responseApi(false);
        return $this->responseApi(true, $data);
    }

    public function create(Request $request)
    {
        $rules = [
            'semeter_id' => 'required',
            'id_block' => 'required',
            'block_subject_id' => 'required',
            'room' => 'required',
            'campus_id' => 'required',
            'start_examination_id' => 'required|numeric',
            'finish_examination_id' => 'required|numeric|gte:start_examination_id',
            'class_id' => 'required',
            'assigned_user' => 'required',
            'status' => 'required',
            'exam_date' => 'required|date|after:yesterday'
        ];
        $validator = Validator::make(
            $request->all(),
            $rules,
            [
                'semeter_id.required' => 'Thiếu id kỳ học !',
                'id_block.required' => 'Thiếu id block !',
                'block_subject_id.required' => 'Vui lòng chọn môn học !',
                'room.required' => 'Vui lòng điền tên phòng !',
                'campus_id.required' => 'Vui lòng chọn cơ sở !',
                'start_examination_id.required' => 'Vui lòng chọn ca bắt đầu!',
                'finish_examination_id.required' => 'Vui lòng chọn ca kết thúc!',
                'finish_examination_id.gte' => 'Ca thi kết thúc không được nhỏ hơn ca thi bắt đầu!',
                'class_id.required' => 'Vui lòng chọn lớp!',
                'assigned_user.required' => 'Vui lòng chọn giáo viên!',
                'status.required' => 'Vui lòng chọn trạng thái',
                'exam_date.required' => 'Vui lòng chọn ngày thi',
                'exam_date.after' => 'Ngày thi không được nhỏ hơn ngày hôm nay',
            ]
        );

        if ($validator->fails() == 1) {
            $errors = $validator->errors();
            $fields = array_keys($rules);
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error, 404);
                    }
                }
            }

        }
        if ($request->finish_examination_id < $request->start_examination_id + 1) {
            return response("Vui lòng chọn ca kết thúc sao cho hợp lý!", 404);
        }
        [$assigned_user_id, $assigned_user_campus_id] = explode('|', $request->assigned_user);
        if ($request->campus_id != $assigned_user_campus_id) {
            return response("Vui lòng chọn giáo viên phù hợp với cơ sở", 404);
        }

        $checkIsset = DB::table('poetry')->where([
            ['id_block', '=', $request->id_block],
            ['room', '=', $request->room],
            ['id_campus', '=', $request->campus_id],
            ['status', '=', $request->status],
            ['exam_date', '=', $request->exam_date],
        ])
            ->whereBetween('start_examination_id', [$request->start_examination_id, $request->start_examination_id + 1])
            ->join('block_subject', 'block_subject.id', '=', 'id_block_subject')
            ->first();
        if (!empty($checkIsset)) {
            return response("Phòng thi này đã tồn tại ca thi bạn chọn, vui lòng chọn lựa chọn khác", 404);
        }
        $poetryIdMax = DB::table('poetry')->max('id') ?? 0;
        $data = [
            [
                'parent_poetry_id' => 0,
                'id' => ++$poetryIdMax,
                'id_semeter' => $request->semeter_id,
                'id_block_subject' => $request->block_subject_id,
                'room' => $request->room,
                'id_campus' => $request->campus_id,
                'start_examination_id' => $request->start_examination_id,
                'finish_examination_id' => $request->finish_examination_id,
                'id_class' => $request->class_id,
                'assigned_user_id' => $assigned_user_id,
                'status' => $request->status,
                'exam_date' => $request->exam_date,
            ],
            [
                'parent_poetry_id' => $poetryIdMax,
                'id' => ++$poetryIdMax,
                'id_semeter' => $request->semeter_id,
                'id_block_subject' => $request->block_subject_id,
                'room' => $request->room,
                'id_campus' => $request->campus_id,
                'start_examination_id' => $request->start_examination_id + 1,
                'finish_examination_id' => null,
                'id_class' => $request->class_id,
                'assigned_user_id' => $assigned_user_id,
                'status' => $request->status,
                'exam_date' => $request->exam_date,
            ],
        ];

//        DB::table('poetry')->insert($data);
//        $id = DB::getPdo()->lastInsertId();
//        $data['id'] = array_merge($data, $this->poetry->getItem($id));
        $poetry = \App\Models\poetry::query()->insert($data);
//        $data = $request->all();
        return response(['message' => "Thêm thành công", 'data' => $poetry], 200);
    }

    public function now_status(Request $request, $id)
    {
        $poetry = $this->poetry->getItempoetry($id);
        if (!$poetry) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }
        $poetry->status = $request->status;
        $poetry->updated_at = now();
        $poetry->save();
        $data = $request->all();
        $data['id'] = $id;
        return response(['message' => "Cập nhật trạng thái thành công", 'data' => $data], 200);
    }

    public function delete($id)
    {
        try {
            $this->poetry->getItempoetry($id)->delete();
            DB::table('student_poetry')->where('id_poetry',$id)->delete();
            return response( ['message' => "Xóa Thành công"],200);
        } catch (\Throwable $th) {
            return response(['message' => 'Xóa thất bại'], 404);
        }
    }

    public function edit($id)
    {
        try {
            $poetry = $this->poetry->getItempoetry($id);
            return response()->json([
                'message' => "Thành công",
                'data' => $poetry,
            ], 200);
        } catch (\Throwable $th) {
            return response(['message' => "Thêm thất bại"], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'semeter_id_update' => 'required',
            'id_block_update' => 'required',
            'block_subject_id_update' => 'required',
            'room_update' => 'required',
            'campus_id_update' => 'required',
            'start_examination_id_update' => 'required|numeric',
            'finish_examination_id_update' => 'required|numeric|gte:start_examination_id_update',
            'class_id_update' => 'required',
            'assigned_user_update' => 'required',
            'status_update' => 'required',
            'exam_date_update' => 'required|date|after:yesterday'
        ];
        $validator = Validator::make(
            $request->all(),
            $rules,
            [
                'semeter_id_update.required' => 'Thiếu id kỳ học !',
                'id_block_update' => "Thiếu block",
                'block_subject_id_update.required' => 'Vui lòng chọn môn học !',
                'room.required_update' => 'Vui lòng điền tên phòng !',
                'campus_id_update.required' => 'Vui lòng chọn cơ sở !',
                'start_examination_id_update.required' => 'Vui lòng chọn ca bắt đầu!',
                'finish_examination_id_update.required' => 'Vui lòng chọn ca kết thúc!',
                'finish_examination_id_update.gte' => 'Ca thi kết thúc không được nhỏ hơn ca thi bắt đầu!',
                'class_id_update.required' => 'Vui lòng chọn lớp!',
                'assigned_user_update.required' => 'Vui lòng chọn giáo viên!',
                'status_update.required' => 'Vui lòng chọn trạng thái',
                'exam_date_update.required' => 'Vui lòng chọn ngày thi',
                'exam_date_update.after' => 'Ngày thi không được nhỏ hơn ngày hôm nay',
            ]
        );

        if ($validator->fails() == 1) {
            $errors = $validator->errors();
            $fields = array_keys($rules);
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error, 404);
                    }
                }
            }

        }
        if ($request->finish_examination_id_update < $request->start_examination_id_update + 1) {
            return response("Vui lòng chọn ca kết thúc sao cho hợp lý!", 404);
        }
        [$assigned_user_id_update, $assigned_user_campus_id_update] = explode('|', $request->assigned_user_update);
        if ($request->campus_id_update != $assigned_user_campus_id_update) {
            return response("Vui lòng chọn giáo viên phù hợp với cơ sở", 404);
        }

        $checkIsset = DB::table('poetry')->where([
            ['id_block', '=', $request->id_block_update],
            ['room', '=', $request->room_update],
            ['id_campus', '=', $request->campus_id_update],
            ['status', '=', $request->status_update],
            ['exam_date', '=', $request->exam_date_update],
            ['poetry.id', '<>', $id],
            ['poetry.parent_poetry_id', '<>', $id],
        ])
            ->whereBetween('start_examination_id', [$request->start_examination_id_update, $request->start_examination_id_update + 1])
            ->join('block_subject', 'block_subject.id', '=', 'id_block_subject')
            ->first();
        if (!empty($checkIsset)) {
            return response("Phòng thi này đã tồn tại ca thi bạn chọn, vui lòng chọn lựa chọn khác", 404);
        }
        $data = [
            'id_semeter' => $request->semeter_id_update,
            'id_block_subject' => $request->block_subject_id_update,
            'room' => $request->room_update,
            'id_campus' => $request->campus_id_update,
            'start_examination_id' => $request->start_examination_id_update,
            'finish_examination_id' => $request->finish_examination_id_update,
            'id_class' => $request->class_id_update,
            'assigned_user_id' => $assigned_user_id_update,
            'status' => $request->status_update,
            'exam_date' => $request->exam_date_update,
        ];
        $data2 = [
            'id_semeter' => $request->semeter_id_update,
            'id_block_subject' => $request->block_subject_id_update,
            'room' => $request->room_update,
            'id_campus' => $request->campus_id_update,
            'start_examination_id' => $request->start_examination_id_update + 1,
            'finish_examination_id' => null,
            'id_class' => $request->class_id_update,
            'assigned_user_id' => $assigned_user_id_update,
            'status' => $request->status_update,
            'exam_date' => $request->exam_date_update,
            'parent_poetry_id' => $id,
        ];
        $poetryModel = new \App\Models\poetry();
        $poetryModel->query()->where('id', $id)->update($data);
        $poetryModel->query()->where('parent_poetry_id', $id)->update($data2);
//        dd($data);
//        $poetry = $this->poetry->getItempoetry($id);
//        if (!$poetry) {
//            return response()->json(['message' => 'Không tìm thấy'], 404);
//        }
//        $poetry->id_semeter = $request->semeter_id_update;
//        $poetry->id_subject = $request->subject_id_update;
//        $poetry->id_class = $request->class_id_update;
//        $poetry->id_examination = $request->examination_id_update;
//        $poetry->id_campus = $request->campus_id_update;
//        $poetry->status = $request->status_update;
//        $poetry->start_time = $request->start_time_semeter;
//        $poetry->end_time = $request->end_time_semeter;
//        $poetry->updated_at = now();

//        $poetry->save();
//        $data = $request->all();
//        $data['id'] = $id;
//        $data = array_merge($data, $this->poetry->getItem($id));
        return response(['message' => "Cập nhật thành công", 'data' => $data], 200);
    }

    function formatdate($dateformat)
    {
        $date_start = $dateformat;
        $timestamp = strtotime($date_start);
        return date('d-m-Y', $timestamp);

    }

}
