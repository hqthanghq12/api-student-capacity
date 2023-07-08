<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rules\UniqueSubjectAndBlock;
use App\Services\Modules\MContest\MContestInterface;
use App\Services\Modules\MContestUser\MContestUserInterface;
use App\Services\Modules\MSubjects\Subject;
use App\Services\Modules\MMajor\MMajorInterface;
use App\Services\Modules\MSkill\MSkillInterface;
use App\Services\Modules\MTeam\MTeamInterface;
use App\Services\Modules\poetry\poetry;
use App\Services\Traits\TResponse;
use App\Services\Traits\TStatus;
use App\Services\Traits\TTeamContest;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\block;
use App\Models\blockSubject;

class subjectController extends Controller
{
    use TUploadImage, TResponse, TTeamContest, TStatus;

    public function __construct(
        private MContestInterface     $contest,
        private MMajorInterface       $majorRepo,
        private Subject               $subject,
        private poetry                $poetry,

        // private Major $major,
        private MTeamInterface        $teamRepo,
        // private Team $team,
        private DB                    $db,
        private Storage               $storage,
        private MSkillInterface       $skill,
        private MContestUserInterface $contestUser,
    )
    {
    }

    public function apiIndex()
    {
        if (!($data = $this->subject->ListSubjectApi())) return $this->responseApi(false);
        return $this->responseApi(true, $data);
    }

    public function ListSubject($id)
    {
        $data = $this->subject->ListSubjectRespone($id);
        return response()->json(['data' => $data], 200);
    }

    public function setemer($id)
    {
        $this->checkTypeContest();
        if (!($data = $this->subject->getItemSubjectSetemer($id))) return abort(404);
//        dd($data);
        if (!($listSubject = $this->subject->List($id))) return abort(404);
        $listBlock = block::where('id_semeter', $id)->get();
        return view('pages.semeter.subject.index', [
            'subjects' => $data,
            'listSubject' => $listSubject,
            'id_semeter' => $id,
            'listBlock' => $listBlock
        ]);
    }

    public function getsemeter($id)
    {

        $this->checkTypeContest();
        if (!($data = $this->subject->getItemSubjectSetemerReponse($id))) return abort(404);
//        if (!($listSubject = $this->subject->List())) return abort(404);
        return response()->json(['data' => $data], 200);
//        return view('pages.semeter.subject.index', [
//            'subjects' => $data,
//            'listSubject' => $listSubject,
//            'id_semeter' => $id
//        ]);
    }

    public function getsemeterEdit($id, $id_poety)
    {
        if (!($ouput = $this->subject->getItemSubjectSetemerReponse($id))) return abort(404);
        $poetry = $this->poetry->getItempoetry($id_poety);
        $data['subject'] = $ouput;
        $data['poetry'] = $poetry;
        return response()->json(['data' => $data], 200);
//        return view('pages.semeter.subject.index', [
//            'subjects' => $data,
//            'listSubject' => $listSubject,
//            'id_semeter' => $id
//        ]);
    }

    public function edit($id)
    {
        try {
            $subject = $this->subject->getItemSubject($id);
            return response()->json([
                'message' => "Thành công",
                'data' => $subject,
            ], 200);
        } catch (\Throwable $th) {
            return response(['message' => "Thêm thất bại"], 404);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'namebasis' => 'required|min:2|unique:subject,name',
                'code_subject' => 'required|unique:subject,code_subject',
                'status' => 'required'
            ],
            [
                'namebasis.unique' => 'Tên Môn Đã tồn tại',
                'namebasis.required' => 'Không để trống tên Môn !',
                'code_subject.required' => 'Không để trống mã môn !',
                'code_subject.unique' => 'Mã Môn đã tồn tại',
                'namebasis.min' => 'Tối thiếu 2 ký tự',
                'status.required' => 'Vui lòng chọn trạng thái'
            ]
        );

        if ($validator->fails() == 1) {
            $errors = $validator->errors();
            $fields = ['namebasis', 'code_subject', 'status'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error, 404);
                    }
                }
            }

        }
        $data = [
            'name' => $request->namebasis,
            'status' => $request->status,
            'code_subject' => $request->code_subject,
            'created_at' => now(),
            'updated_at' => now()
        ];

        DB::table('subject')->insert($data);
        $id = DB::getPdo()->lastInsertId();
        $data = $request->all();
        $data['id'] = $id;
        return response(['message' => "Thêm thành công", 'data' => $data], 200);
    }

    public function create_semeter(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'subject_id' => ['required', new UniqueSubjectAndBlock($request->subject_id, $request->block_id)],
                'id_semeter' => 'required',
                'block_id' => ['required', new UniqueSubjectAndBlock($request->subject_id, $request->block_id)],
            ],
            [
                'subject_id.required' => 'Vui lòng chọn môn học !',
                'id_semeter.required' => 'Vui lòng chọn kỳ học !',
                'block_id.required' => 'Vui lòng chọn blocks !',
            ]
        );

        if ($validator->fails() == 1) {
            $errors = $validator->errors();
            $fields = ['subject_id', 'id_semeter', 'block_id'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error, 404);
                    }
                }
            }

        }
        $blocks = explode('|', $request->block_id);
        $dataInsertArr = [];
        foreach ($blocks as $block) {
            $dataInsertArr[] = [
                'id_subject' => $request->subject_id,
                'id_block' => $block
            ];
        }
        blockSubject::insert($dataInsertArr);
//        blockSubject::insert(
//            [
//                'id_subject' => $request->subject_id,
//                'id_block' =>  $request->block_id
//            ]
//        );
        $data = $this->subject->getItemSubject($request->subject_id);
        $this->subject->createSubjectSemater($request->subject_id, $request->id_semeter);

        return response(['message' => "Thêm thành công",], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'namebasis' => 'required|min:3',
                'status' => 'required'
            ],
            [
                'namebasis.required' => 'Không để trống tên cơ sở !',
                'namebasis.min' => 'Tối thiếu 3 ký tự',
                'status.required' => 'Không để trống mã cơ sở'
            ]
        );
        if ($validator->fails() == 1) {
            $errors = $validator->errors();
            $fields = ['namebasis', 'status'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error, 404);
                    }
                }
            }

        }
        $campus = $this->subject->getItemSubject($id);
        if (!$campus) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }
        $campus->name = $request->namebasis;
        $campus->status = $request->status;
        $campus->created_at = $request->start_time;
        $campus->updated_at = $request->end_time;

        $campus->save();
        $data = $request->all();
        $data['id'] = $id;
        return response(['message' => "Cập nhật thành công", 'data' => $data], 200);
    }

    public function index()
    {
        $this->checkTypeContest();
        if (!($data = $this->subject->ListSubject())) return abort(404);
        return view('pages.subjects.index', [
            'subjects' => $data
        ]);
    }

    public function now_status(Request $request, $id)
    {
        $campus = $this->subject->getItemSubject($id);
        if (!$campus) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }
        $campus->status = $request->status;
        $campus->save();
        $data = $request->all();
        $data['id'] = $id;
        return response(['message' => "Cập nhật trạng thái thành công", 'data' => $data], 200);
    }

    public function now_status_semeter($id, Request $request)
    {
        try {
//            return response( ['message' => $id],404);
            $this->subject->updateStatusSemeter($id, $request->status);
            $data = $request->all();
            $data['id'] = $id;
            return response(['message' => "Cập nhật trạng thái thành công", 'data' => $data], 200);
        } catch (\Throwable $th) {
            return response(['message' => $th], 404);
        }
    }

    public function delete($id)
    {
        try {
            $this->subject->getItemSubject($id)->delete();
            return response(['message' => "Xóa Thành công"], 200);
        } catch (\Throwable $th) {
            return response(['message' => "Xóa Thất bại"], 404);
        }
    }

    public function delete_semeter($id_subject, $id_semeter)
    {
        try {
            $this->subject->removeSubjectSemater($id_subject, $id_semeter);
            return response(['message' => "Xóa Thành công"], 200);
        } catch (\Throwable $th) {
            return response(['message' => "Xóa Thất bại vui lòng liên hệ bộ phận kỹ thuật"], 404);
        }

    }

    private function checkTypeContest()
    {
        if (request('type') != config('util.TYPE_CONTEST') && request('type') != config('util.TYPE_TEST')) abort(404);
    }
}
