<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exam\ExamNewRequest;
use App\Http\Requests\Exam\RequestExam;
use App\Models\Exam;
use App\Models\Question;
use App\Services\Traits\TUploadImage;
use App\Models\Round;
use App\Services\Modules\MExam\MExamInterface;
use App\Services\Modules\MRound\MRoundInterface;
use App\Services\Traits\TResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Services\Modules\MCampus\Campus;
use App\Models\subject;

class ExamController extends Controller
{
    use TUploadImage, TResponse;

    public function __construct(
        private MExamInterface  $repoExam,
        private Campus $campus,
        private Exam            $exam,
        private MRoundInterface $repoRound,
        private Round           $round,
        private Question        $question,
        private DB              $db,
        private MExamInterface  $examModel,
        private subject $subject
    )
    {
    }

    public function getHistory($id)
    {
        try {
            $data = $this->repoRound->getResult($id);
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }

    public function un_status($id_exam)
    {
        try {
            $data = $this->updateStatus($id_exam, 0);
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }

    public function re_status($id_exam)
    {
        try {
            $data = $this->updateStatus($id_exam, 1);
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }

    private function updateStatus($id, $status)
    {
        if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) throw new \Exception("Bạn không đủ thẩm quyền ! ");
        $exam = $this->exam::whereId($id)->withCount('resultCapacity')->first();
        if ($exam->resultCapacity_count > 0) throw new \Exception("Không thể cập nhật trạng thái !");
        $exam->update(['status' => $status]);
        return $exam;
    }

//    public function index($id_round)
//    {
//        $round = $this->round::find($id_round);
//        $exams = $this->exam::where('round_id', $id_round)->orderByDesc('id')->get()->load('round');
//        return view(
//            'pages.round.detail.exam.index',
//            [
//                'round' => $round,
//                'exams' => $exams
//            ]
//        );
//    }

    public function index($id_subject)
    {
//        $exams = $this->examModel->find(11);
//        $exam = $this->examModel->whereGet(['id' => 18])->pluck('id');
////        $exam = $this->examModel->whereGet(['id' => 18])->pluck('id');
//        dd($exam);
        $exams = $this->exam::where('subject_id', $id_subject)->orderByDesc('id')->get();
//        dd($exams[1]->campus->name);
        $nameSubject = $this->subject::find($id_subject);
        return view(
            'pages.subjects.exam_subject.index',
            [
                'exams' => $exams,
                'id' => $id_subject,
                'name' => $nameSubject,
            ]
        );
    }

//    public function create($id_round)
//    {
//        $round = $this->round::find($id_round)->load('contest');
//        if ($round->contest->type != request('type') ?? 0) abort(404);
//        if (is_null($round)) return abort(404);
//        return view(
//            'pages.round.detail.exam.form-add',
//            [
//                'round' => $round,
//            ]
//        );
//    }

    public function create($id,$name)
    {
        $campus = $this->campus->apiIndex();
//        if ($round->contest->type != request('type') ?? 0) abort(404);
//        if (is_null($round)) return abort(404);
        return view(
            'pages.subjects.exam_subject.form-add',
            [
                'campus' => $campus,
                'id' => $id,
                'name' => $name
            ]
        );
    }

//    public function store(RequestExam $request, $id_round)
//    {
//        try {
//            $type = 0;
//            $round = $this->round::findOrFail($id_round)->load('contest');
//            if ($round->contest->type == 1) $type = 1;
//            if ($type == 0) {
//                $validatorContest = Validator::make(
//                    $request->all(),
//                    [
//                        'external_url' => 'required|mimes:zip,docx,word|max:10000',
//                    ]
//                );
//                if ($validatorContest->fails()) {
//                    return redirect()->back()->withErrors($validatorContest)->withInput();
//                }
//            }
//            $dataMer = [];
//            if ($type == 0) $dataMer = [
//                'round_id' => $id_round,
//                'external_url' => $this->uploadFile($request->external_url),
//                'type' => $type,
//                'status' => 1
//            ];
//            if ($type == 1) $dataMer = [
//                'round_id' => $id_round,
//                'type' => $type,
//                'status' => 1,
//                'external_url' => 'null',
//                'time' => $round->time_exam,
//                'time_type' => $round->time_type_exam,
//            ];
//
//            // $filename = $this->uploadFile($request->external_url);
//            $dataCreate = array_merge($request->only([
//                'name',
//                'description',
//                'max_ponit',
//                'ponit',
//            ]), $dataMer);
//
//            $this->exam::create($dataCreate);
//            if ($round->contest->type == 1) return redirect()->route('admin.contest.show.capatity', ['id' => $round->contest->id]);
//            return redirect()->route('admin.exam.index', ['id' => $id_round]);
//        } catch (\Throwable $th) {
//            Log::info($th->getMessage());
//            return abort(404);
//        }
//    }
    public function store(ExamNewRequest $request)
    {
        try {
//            dd($request->all());

             $dataMer = [
                 'name' => $request->name,
                 'description' =>  $request->description,
                'round_id' => 36,
                'type' => 1,
                'status' => 1,
                'external_url' => 'null',
                'time' => NULL,
                'time_type' => 'null',
                 'subject_id' => $request->id,
                 'campus_id' => 1,

            ];

            // $filename = $this->uploadFile($request->external_url);
//            $dataCreate = array_merge($request->only([
//                'name',
//                'description',
//                'campus_exam'
//            ]), $dataMer);
            $this->exam::create($dataMer);
            return redirect()->route('admin.exam.index', $request->id);
        } catch (\Throwable $th) {
//            Log::info($th->getMessage());
            return $th;
        }
    }



    public function destroy($id)
    {
        try {
            $exam = $this->exam::find($id);
            $exam->delete($id);
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function edit($id_round, $id)
    {

        $round = $this->round::findOrFail($id_round);
        $exam = $this->exam::whereId($id)->where('round_id', $id_round)->first();

        if (is_null($exam)) return abort(404);
        return view(
            'pages.round.detail.exam.form-edit',
            [
                'exam' => $exam,
                'round' => $round,
            ]
        );
    }

    public function update(RequestExam $request, $id_round, $id)
    {
        $type = 0;
        $examModel = $this->exam::findOrFail($id);
        $round = $this->round::findOrFail($id_round)->load('contest');

        if ($round->contest->type == 1) $type = 1;
        if ($type == 0) {
            if ($request->has('external_url')) {
                $validatorContest = Validator::make(
                    $request->all(),
                    [
                        'external_url' => 'required|mimes:zip,docx,word|file|max:10000',
                    ],
                    [
                        'external_url.mimes' => 'Trường đề thi không đúng định dạng !',
                        'external_url.required' => 'Không bỏ trống trường đề bài !',
                        'external_url.file' => 'Trường đề bài phải là một file  !',
                        'external_url.max' => 'Trường đề bài dung lượng quá lớn !',
                    ]
                );

                if ($validatorContest->fails()) {
                    return redirect()->back()->withErrors($validatorContest)->withInput();
                }
            }
        }


        $this->db::beginTransaction();
        try {

            if ($request->has('external_url')) {
                $fileImage = $request->file('external_url');
                $external_url = $this->uploadFile($fileImage, $examModel->external_url);
                $examModel->external_url = $external_url;
            }
            $examModel->name = $request->name;
            $examModel->description = $request->description;
            $examModel->max_ponit = $request->max_ponit;

            $examModel->ponit = $request->ponit;
            $examModel->round_id = $id_round;
            $examModel->save();
            $this->db::commit();
            if ($round->contest->type == 1) return Redirect::route('admin.contest.show.capatity', ['id' => $round->contest->id]);
            return Redirect::route('admin.exam.index', ['id' => $id_round]);
        } catch (\Throwable $th) {
            $this->db::rollBack();
            return Response::json([
                'status' => false,
                'payload' => $th
            ]);
        }
    }

    public function get_by_round($id)
    {
        try {
            $exams = $this->exam::where('round_id', $id)->where('type', 1)->with(['questions' => function ($q) {
                return $q->with('answers');
            }])->get();
            $questions = $this->question::with([
                'answers'
            ])->take(10)->get();
            return response()->json([
                'status' => true,
                'payload' => $exams,
                'question' => $questions
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Hệ thống đã xảy ra lỗi '
            ], 404);
        }
    }

    public function showQuestionAnswerExams($id)
    {
        try {
            $exam = $this->exam::whereId($id)
                ->where('type', 1)
                ->first();
            $questions = $exam
                ->questions()
                ->with([
                    'answers', 'skills'
                ])
                ->status(request('status'))
                ->search(request('q') ?? null, ['content'])
                ->sort((request('sort') == 'asc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'questions')
                ->whenWhereHasRelationship(request('skill') ?? null, 'skills', 'skills.id', (request()->has('skill') && request('skill') == 0) ? true : false)
                ->when(request()->has('level'), function ($q) {
                    $q->where('rank', request('level'));
                })
                ->when(request()->has('type'), function ($q) {
                    $q->where('type', request('type'));
                })
                ->get();
            // ->paginate(request('limit') ?? 5);
            // $questionsSave = $exam
            //     ->questions()
            //     ->get()
            //     ->map(function ($data) {
            //         return [
            //             'name' => $data->content,
            //             'id' => $data->id,
            //         ];
            //     });
            $questionsSave = $questions
                ->map(function ($data) {
                    return [
                        'name' => $data->content,
                        'id' => $data->id,
                    ];
                });
            $questionsAll = $this->question::with([
                'answers', 'skills'
            ])->take(10)->get();
            return response()->json([
                'status' => true,
                'payload' => [
                    'data' => $questions
                ],
                'question' => $questionsAll,
                'questionsSave' => $questionsSave
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Hệ thống đã xảy ra lỗi ' . $th->getMessage()
            ], 404);
        }
    }
}
