<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Modules\MStudentManager\PoetryStudent;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use App\Services\Modules\playtopics\playtopic;
use App\Services\Modules\MCampus\Campus;
use App\Services\Modules\MExam\Exam;
use App\Models\Exam as ModelExam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class playtopicController extends Controller
{
    use TUploadImage, TResponse;

    public function __construct(
        private playtopic     $playtopicModel,
        private Campus        $Campus,
        private Exam          $exam,
        private PoetryStudent $PoetryStudent,
        private ModelExam     $modelExam
    )
    {
    }

    public function index($id, $id_subject)
    {
        $playtopic = $this->playtopicModel->getList($id);
        $total = count($playtopic) == 0 ? 0 : $playtopic[0]->total;
        $campusList = $this->Campus->getList()->get();
        return view('pages.poetry.playtopic.index', ['playtopics' => $playtopic, 'campusList' => $campusList, 'id_subject' => $id_subject, 'id_poetry' => $id, 'total' => $total]);
    }

    public function show($id)
    {
//        return $id;
        $round = $this->exam->getItemApi($id);
//        return $round;
        if (is_null($round)) {
            return $this->responseApi(false, 'Không tồn tại trong hệ thống !');
        }
//        {
//            $round->with(['contest' => function ($q) {
//                return $q->with(['rounds' => function ($q) {
//                    $q->orderBy('start_time', 'asc');
//                    $q->setEagerLoads([]);
//                    return $q;
//                }]);
//            }, 'type_exam', 'judges', 'teams' => function ($q) {
//                return $q->with('members');
//            }]);
        return $this->responseApi(
            true, $round);
//            return $this->responseApi(
//                true,
//                $round
//                    ->get()
//                    ->map(function ($col, $key) {
//                        if ($key > 0) return;
//                        $col = $col->toArray();
//                        $user = [];
//                        foreach ($col['judges'] as $judge) {
//                            array_push($user, $judge['user']);
//                        }
//                        $arrResult = array_merge($col, [
//                            'judges' => $user
//                        ]);
//                        return $arrResult;
//                    })[0]
//            );
//        }
    }

    public function indexApi($id_user, $id_poetry, $id_campus, $id_subject)
    {
        if (!($data = $this->playtopicModel->getExamApi($id_user, $id_poetry, $id_campus, $id_subject))) return $this->responseApi(false);
        return $this->responseApi(true, $data);
    }

    public function listExam($idCampus, $idSubject)
    {
        $data = $this->exam->getListExam($idCampus, $idSubject);

        return response()->json(['data' => $data], 200);

    }

    public function AddTopic(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'campuses_id' => 'required',
                'mixing' => 'required',
                'id_subject' => 'required',
                'exam_id' => 'required'
            ],
            [
                'mixing.required' => 'Vui lòng chọn chế độ trộn câu hỏi!',
                'campuses_id.required' => 'Vui lòng chọn cơ sở!',
                'exam_id.required' => 'Vui lòng chọn đề!',
                'id_subject.required' => 'Không có data môn học'
            ]
        );

        if ($validator->fails() == 1) {
            $errors = $validator->errors();
            $fields = ['mixing', 'campuses_id', 'id_subject', 'exam_id'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error, 404);
                    }
                }
            }

        }

        if (!($liststudent = $this->PoetryStudent->GetStudents($request->id_poetry))) return abort(404);

        if (count($liststudent) == 0) {
            return response('Không có học sinh trong ca thi này', 404);
        }
        $is_mixing = $request->mixing == 1;
        $questions = DB::table('exam_questions')
            ->select('question_id')
            ->where('exam_id', $request->exam_id)
            ->pluck('question_id')->toArray();
//        $dataInsertArr = [];
        foreach ($liststudent as $object) {
            if ($is_mixing) shuffle($questions);
            $dataInsert = [
                'id_user' => $object->id_student,
                'id_exam' => $request->exam_id,
                'id_poetry' => $request->id_poetry,
                'id_campus' => $request->campuses_id,
                'id_subject' => $request->id_subject,
                'total' => 1,
                'questions_order' => json_encode($questions),
                'created_at' => now(),
                'updated_at' => null
            ];
//            $dataInsertArr[] = $dataInsert;
            DB::table('playtopic')->insert($dataInsert);
        }

//        DB::table('playtopic')->insert($dataInsertArr);
        return response(['message' => "Thành công " . '<br>Vui lòng chờ 5s để làm mới dữ liệu'], 200);
    }

    public function AddTopicReload(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'campuses_id' => 'required',
                'mixing' => 'required',
                'id_subject' => 'required',
                'exam_id' => 'required'
            ],
            [
                'mixing.required' => 'Vui lòng chọn chế độ trộn câu hỏi!',
                'campuses_id.required' => 'Vui lòng chọn cơ sở!',
                'exam_id.required' => 'Vui lòng chọn đề!',
                'id_subject.required' => 'Không có data môn học'
            ]
        );

        if ($validator->fails() == 1) {
            $errors = $validator->errors();
            $fields = ['mixing', 'campuses_id', 'id_subject', 'exam_id'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error, 404);
                    }
                }
            }

        }

        if (!($liststudent = $this->PoetryStudent->GetStudents($request->id_poetry))) return abort(404);

        if (count($liststudent) == 0) {
            return response('Không có học sinh trong ca thi này', 404);
        }

        $playtopic = $this->playtopicModel->getList($request->id_poetry);
        foreach ($playtopic as $value) {
            $value->delete();
        }
//        DB::table('playtopic')->where('id_poetry', $request->id_poetry)->delete();

        $is_mixing = $request->mixing == 1;
        $questions = DB::table('exam_questions')
            ->select('question_id')
            ->where('exam_id', $request->exam_id)
            ->pluck('question_id')->toArray();
//        $dataInsertArr = [];
        foreach ($liststudent as $object) {
            if ($is_mixing) shuffle($questions);
            $dataInsert = [
                'id_user' => $object->id_student,
                'id_exam' => $request->exam_id,
                'id_poetry' => $request->id_poetry,
                'id_campus' => $request->campuses_id,
                'id_subject' => $request->id_subject,
                'total' => 1,
                'questions_order' => json_encode($questions),
                'created_at' => now(),
                'updated_at' => null
            ];
//            $dataInsertArr[] = $dataInsert;
            DB::table('playtopic')->insert($dataInsert);
        }
//        DB::table('playtopic')->insert($dataInsertArr);
        return response(['message' => "Thành công " . '<br>Vui lòng chờ 5s để làm mới dữ liệu'], 200);
    }
}
