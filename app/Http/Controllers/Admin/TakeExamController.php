<?php

namespace App\Http\Controllers\Admin;

use App\Models\Answer as AnswerAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Services\Modules\MAnswer\Answer;
use App\Services\Modules\MContest\Contest;
use App\Services\Modules\MExam\MExamInterface;
use App\Services\Modules\MQuestion\Question;
use App\Services\Modules\MResultCapacity\MResultCapacityInterface;
use App\Services\Modules\MResultCapacityDetail\MResultCapacityDetailInterface;
use App\Services\Modules\MRound\Round;
use App\Services\Modules\MRoundTeam\RoundTeam;
use App\Services\Modules\MTakeExam\TakeExam;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\playtopic;

class TakeExamController extends Controller
{
    use TUploadImage, TResponse;

    public function __construct(
        private Round                          $round,
        private MExamInterface                 $exam,
        private Contest                        $contest,
        private Team                           $team,
        private RoundTeam                      $roundTeam,
        private TakeExam                       $takeExam,
        private MResultCapacityInterface       $resultCapacity,
        private Question                       $question,
        private Answer                         $answer,
        private AnswerAlias                    $answerModel,
        private MResultCapacityDetailInterface $resultCapacityDetail,
        private playtopic                      $playtopic,
    )
    {
    }


    /**
     *
     * @OA\Post(
     *     path="/api/v1/take-exam/student-submit",
     *     description="",
     *     tags={"TakeExam","Contest","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="number",
     *                      property="id",
     *                  ),
     *                  @OA\Property(
     *                      type="string",
     *                      property="result_url",
     *                  ),
     *                  @OA\Property(
     *                      type="string",
     *                      property="file_url",
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function checkTakeExam(Request $request)
    {
//        $resultCapacity = $this->resultCapacity->findByUserExam($request->id_user, $request->id_exam);
        $resultCapacity = $this->resultCapacity->findByUserPlaytopic($request->id_user, $request->id_exam);
        return $this->responseApi(true, $resultCapacity);
    }

    public function takeExamStudentSubmit(Request $request, DB $dB)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'result_url' => 'url',
                'file_url' => 'file|mimes:zip,docx,word,rar,rtf'
            ],
            [
                'result_url.url' => 'Sai định dạng !!!',
                'file_url.mimes' => 'Định dạng phải là : zip, docx, word, rtf !!!',
                'file_url.file' => 'Sai định dạng !!!',
                'id.required' => 'Thiếu id !',
            ]
        );
        if ($validate->fails())
            return $this->responseApi(false, ['error' => $validate->errors()]);
        $dB::beginTransaction();
        try {
            $takeExam = $this->takeExam->find($request->id);
            if (is_null($takeExam))
                return $this->responseApi(false, 'Không tồn tại trên hệ thống !!');
            if ($takeExam->status == config('util.TAKE_EXAM_STATUS_COMPLETE') && empty($request->result_url) && empty($request->file_url)) {
                if (Storage::disk('s3')->has($takeExam->file_url ?? "Default")) Storage::disk('s3')->delete($takeExam->file_url);
                $takeExam->file_url = null;
                $takeExam->result_url = null;
                $takeExam->status = config('util.TAKE_EXAM_STATUS_UNFINISHED');
                $mesg = 'Hủy bài thành công !!';
            } else {
                if ($request->has('file_url')) {
                    $fileUrl = $request->file('file_url');
                    $filename = $this->uploadFile($fileUrl);
                    $takeExam->file_url = $filename;
                } else {
                    if (Storage::disk('s3')->has($takeExam->file_url ?? "Default")) Storage::disk('s3')->delete($takeExam->file_url);
                    $takeExam->file_url = null;
                }
                if (request('result_url')) {
                    $takeExam->result_url = $request->result_url;
                } else {
                    $takeExam->result_url = null;
                }
                if (!request('file_url') && !request('result_url')) {
                    $takeExam->status = config('util.TAKE_EXAM_STATUS_UNFINISHED');
                }
                $takeExam->status = config('util.TAKE_EXAM_STATUS_COMPLETE');
                $mesg = 'Nộp bài thành công !!';
            }
            $takeExam->save();
            $dB::commit();
            return $this->responseApi(true, $mesg, ['takeExam' => $takeExam]);
        } catch (\Throwable $th) {
            $dB::rollBack();
            dump($th);
            return $this->responseApi(false, 'Lỗi hệ thống !!');
        }
    }

    private function getContest($id, $type = 0)
    {
        try {
            $contest = $this->contestModel->whereId($id, $type);
            return $contest;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     *
     * @OA\Post(
     *     path="/api/v1/take-exam/check-student-capacity",
     *     description="",
     *     tags={"TakeExam","Capacity","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="number",
     *                      property="round_id",
     *                  ),
     *
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function checkStudentCapacity(Request $request)
    {
        $user_id = auth('sanctum')->user()->id;
        $validate = Validator::make(
            $request->all(),
            [
                'round_id' => 'required|integer',
            ],
            [
                'round_id.required' => 'Chưa nhập trường này !',
                'round_id.integer' => 'Sai định dạng !',
            ]
        );
        if ($validate->fails()) return $this->responseApi(true, $validate->errors());
        try {
            $round = $this->round->find($request->round_id);
            $exam = $this->exam->whereGet(['round_id' => $request->round_id])->pluck('id');
            if (is_null($round) || is_null($exam)) return $this->responseApi(false, 'Lỗi truy cập hệ thống !!');
            $resultCapacity = $this->resultCapacity->whereInExamUser($exam, $user_id);
            if ($resultCapacity) {
                $resultCapacity->load('exam:id,max_ponit');
                if ($resultCapacity->status == config('util.STATUS_RESULT_CAPACITY_DOING')) {
                    return $this->responseApi(true, config('util.STATUS_RESULT_CAPACITY_DOING'), ['message' => "Đang làm !!"]);
                } else {
                    return $this->responseApi(true, config('util.STATUS_RESULT_CAPACITY_DONE'), ['result' => $resultCapacity, 'message' => "Đã làm !!"]);
                }
            } else {
                return $this->responseApi(false, "Chưa làm !!");
            }
        } catch (\Throwable $th) {
            return $this->responseApi(false, 'Lỗi hệ thống !!');
        }
    }


    /**
     *
     * @OA\Post(
     *     path="/api/v1/take-exam/student-capacity",
     *     description="Trả về đề bài đánh giá năng lực , nếu lần đầu làm sẽ tạo bản ghi mới với trạng thái là đang làm  , nếu đang làm dở sẽ trả vè bài làm trước đó ",
     *     tags={"TakeExam","Capacity","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="number",
     *                      property="round_id",
     *                  ),
     *
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */

    public function takeExamStudentCapacity(Request $request, DB $dB)
    {
        $user_id = auth('sanctum')->user()->id;
        $validate = Validator::make(
            $request->all(),
            [
                'round_id' => 'required|integer',
            ],
            [
                'round_id.required' => 'Chưa nhập trường này !',
                'round_id.integer' => 'Sai định dạng !',
            ]
        );
        if ($validate->fails())
            return $this->responseApi(true, $validate->errors());
        $dB::beginTransaction();
        try {
            $round = $this->round->find($request->round_id);
            if (is_null($round)) return $this->responseApi(false, 'Lỗi truy cập hệ thống !!');
            $exam = $this->exam->whereGet(['round_id' => $request->round_id])->pluck('id');
            if (is_null($exam)) return $this->responseApi(false, 'Lỗi truy cập hệ thống !!');
            $resultCapacity = $this->resultCapacity->whereInExamUser($exam, $user_id);
            if ($resultCapacity) {
                $exam = $this->exam->find($resultCapacity->exam_id);
            } else {
                $exam = $this->exam->where(['round_id' => $request->round_id])->inRandomOrder()->first();
                $resultCapacityNew = $this->resultCapacity->create([
                    'scores' => 0,
                    'status' => config('util.STATUS_RESULT_CAPACITY_DOING'),
                    'exam_id' => $exam->id,
                    'user_id' => $user_id,
                    'type' => $exam->type
                ]);
            }
            $exam->load(['questions' => function ($q) {
                return $q->with([
                    'answers' => function ($q) {
                        return $q->select(['id', 'content', 'question_id']);
                    },
                    'images' => function ($q) {
                        return $q->select(['id', 'path', 'img_code', 'question_id']);
                    },
                ]);
            }]);
            $dB::commit();
            if ($resultCapacity) {
                return $this->responseApi(true, $exam, ['exam_at' => $resultCapacity->created_at]);
            } else {
                return $this->responseApi(true, $exam, ['exam_at' => $resultCapacityNew->created_at]);
            }
        } catch (\Throwable $th) {
            $dB::rollBack();
//            dd($th);
            return $this->responseApi(false, 'Lỗi hệ thống !!');
        }
    }

    public function takeExamStudent(Request $request, DB $dB)
    {
        try {
            $user_id = auth('sanctum')->user()->id;
            $dB::beginTransaction();
            $playtopic = $this->playtopic->query()->where('id', $request->id)->pluck('id');
//            if (is_null($exam)) return $this->responseApi(false, 'Lỗi truy cập hệ thống !!');
            if (is_null($playtopic)) return $this->responseApi(false, 'Lỗi truy cập hệ thống !!');
//            $resultCapacity = $this->resultCapacity->whereInExamUser($exam, $user_id);
            $resultCapacity = $this->resultCapacity->whereInPlaytopicUser($playtopic[0], $user_id);
            if ($resultCapacity) {
//                $exam = $this->exam->find($resultCapacity->exam_id);
                $playtopic = $this->playtopic->query()->find($resultCapacity->playtopic_id);
            } else {
//                $exam = $this->exam->where(['id' => $request->id])->inRandomOrder()->first();
                $playtopic = $this->playtopic->query()->where(['id' => $request->id])->first();
                $resultCapacityNew = $this->resultCapacity->create([
                    'scores' => 0,
                    'status' => config('util.STATUS_RESULT_CAPACITY_DOING'),
//                    'exam_id' => $exam->id,
                    'user_id' => $user_id,
                    'type' => config('util.TYPE_TEST'),
                    'playtopic_id' => $playtopic->id,
                ]);
            }
            $string = $playtopic->questions_order;
            $arrayOrder = json_decode($string);
//            $arrayOrder = explode(',',trim($string, '[]'));
//            $exam->test = $arrayOrder;
//        return $string;
            $questions = $this->question->findInId($arrayOrder, ['answers', 'images']);
//        $questions = \App\Models\Question::whereIn('id', $arrayOrder)->get();
//            $exam->load(['questions' => function ($q) use ($arrayOrder) {
//                $q->orderByRaw("FIELD(questions.id, " . implode(",", $arrayOrder) . ")");
//                $q->with([
//                    'answers' => function ($q) {
//                        return $q->select(['id', 'content', 'question_id']);
//                    },
//                    'images' => function ($q) {
//                        return $q->select(['id', 'path', 'img_code', 'question_id']);
//                    }
//                ]);
//            }]);
            $data = [
                'id' => $playtopic->id,
                'name' => $playtopic->exam_name,
                'total_questions' => count($arrayOrder),
                'time' => $playtopic->exam_time,
                'questions' => $questions,
                'questions_order' => $playtopic->questions_order,
            ];
            $dB::commit();
            if ($resultCapacity) {
                return $this->responseApi(true, $data, ['exam_at' => $resultCapacity->created_at]);
            } else {
                return $this->responseApi(true, $data, ['exam_at' => $resultCapacityNew->created_at]);
            }
//            $exam = $this->exam->whereGet(['id' => $request->id])->pluck('id');
        } catch (\Throwable $th) {
            $dB::rollBack();
//            dd($th);
            return $this->responseApi(false, "Lỗi hệ thống");
        }
    }

    /**
     *
     * @OA\Post(
     *     path="/api/v1/take-exam/student-capacity-submit",
     *     description="",
     *     tags={"TakeExam","Capacity","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="string",
     *                      property="exam_id",
     *                  ),
     *                   @OA\Property(
     *                      type="string",
     *                      property="data",
     *                  ),
     *
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function takeExamStudentCapacitySubmit(Request $request, DB $db)
    {
        $db::beginTransaction();
        try {
            $falseAnswer = 0;
            $trueAnswer = 0;
            $score = 0;
            $user_id = auth('sanctum')->user()->id;
//        $exam = $this->exam->findById($request->exam_id, ['questions'], ['max_ponit', 'ponit'], false);
            $playtopic = $this->playtopic->query()->where(['id' => $request->playtopic_id])->first();
            $questions_count = collect(json_decode($playtopic->questions_order))->count();
//        $score_one_question = $exam->max_ponit / $exam->questions_count;
            $score_one_question = config('util.MAX_POINT') / $questions_count;
//        $donotAnswer = $exam->questions_count - count($request->data);
            $donotAnswer = $questions_count - count($request->data);

            $answerIds = collect($request->data)->map(function ($data) {
                return $data['type'] == 1 ? $data['answerIds'] : $data['answerId'];
            })->flatten()->filter()->toArray();

            $answers = $this->answerModel->query()->whereIn('id', $answerIds)->get()->keyBy('id');

            foreach ($request->data as $key => $data) {
                if ($data['type'] == 0) {
                    if ($data['answerId'] == null) {
                        $donotAnswer += 1;
                    } else {
//                        $answer = $this->answer->findById(
//                            $data['answerId'],
//                            [
//                                'question_id' => $data['questionId'],
//                                'is_correct' => config('util.ANSWER_TRUE'),
//                            ]
//                        );
//                        if ($answer && $data['answerId'] === $answer->id) {
//                            $score += $score_one_question;
//                            $trueAnswer += 1;
//                        } else {
//                            $falseAnswer += 1;
//                        }
                        $answer = $answers[$data['answerId']] ?? null;
                        if ($answer && $data['questionId'] === $answer->question_id && $answer->is_correct === config('util.ANSWER_TRUE')) {
                            $score += $score_one_question;
                            $trueAnswer += 1;
                        } else {
                            $falseAnswer += 1;
                        }
                    }
                } else {
                    if (count($data['answerIds']) > 0 && count($data['answerIds']) <= 1) {
                        $falseAnswer += 1;
                    } else if (count($data['answerIds']) <= 0) {
                        $donotAnswer += 1;
                    } else {
//                        $answer = $this->answer->whereInId(
//                            $data['answerIds'],
//                            [
//                                'question_id' => $data['questionId'],
//                                'is_correct' => config('util.ANSWER_TRUE'),
//                            ]
//                        );
                        $answer = $answers->only($data['answerIds']);
                        if (count($data['answerIds']) === count($answer)) {
                            $score += $score_one_question;
                            $trueAnswer += 1;
                        } else {
                            $falseAnswer += 1;
                        }
                    }
                }

            }
//        $resultCapacity = $this->resultCapacity->findByUserExam($user_id, $request->exam_id);
            $resultCapacity = $this->resultCapacity->findByUserPlaytopic($user_id, $request->playtopic_id);
//        return $score;

            $resultCapacity->update([
                'scores' => $score,
                'status' => config('util.STATUS_RESULT_CAPACITY_DONE'),
                'donot_answer' => $donotAnswer,
                'false_answer' => $falseAnswer,
                'true_answer' => $trueAnswer,
            ]);
            $dataInsert = [];
            foreach ($request->data as $data) {
                if ($data['type'] == 0) {
                    $dataInsert[] = [
                        'result_capacity_id' => $resultCapacity->id,
                        'question_id' => $data['questionId'],
                        'answer_id' => $data['answerId'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                } else {
                    foreach ($data['answerIds'] as $dataAns) {
                        $dataInsert[] = [
                            'result_capacity_id' => $resultCapacity->id,
                            'question_id' => $data['questionId'],
                            'answer_id' => $dataAns,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
//                $this->resultCapacityDetail->create([
//                    'result_capacity_id' => $resultCapacity->id,
//                    'question_id' => $data['questionId'],
//                    'answer_id' => $data['answerId'],
//                ]);
            }
            $this->resultCapacityDetail->insert($dataInsert);
            $db::commit();
            return $this->responseApi(
                true,
                $resultCapacity,
                [
//                    'exam' => $exam,
                    'playtopic' => $playtopic,
                    'score' => $score,
                    'donotAnswer' => $donotAnswer,
                    'falseAnswer' => $falseAnswer,
                    'trueAnswer' => $trueAnswer
                ]
            );
        } catch (\Throwable $th) {
            $db::rollBack();
            $err = "Lỗi nộp bài: " . json_encode([
                    'msg' => "{$th->getMessage()}",
                    'line' => $th->getLine(),
                    'file' => $th->getFile(),
                    'user_id' => auth('sanctum')->user()->id,
                    'data' => $request->all(),
                ]);
            Log::error($err);
            return $th->getMessage();
        }
    }


    /**
     *
     * @OA\Post(
     *     path="/api/v1/take-exam/student-capacity-history",
     *     description="",
     *     tags={"TakeExam","TakeExamHistory","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="number",
     *                      property="result_capacity_id",
     *                  ),
     *
     *
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function takeExamStudentCapacityHistory(Request $request)
    {
        $resultCapacity = $this->resultCapacity->where(['id' => $request->result_capacity_id]);
        $exam = $this->exam->find($resultCapacity->exam_id);
        $exam->load([
            'questions' => function ($q) use ($resultCapacity) {
                return $q->with([
                    'answers',
                    'resultCapacityDetail' => function ($q) use ($resultCapacity) {
                        return $q
                            ->where('result_capacity_id', $resultCapacity->id);
                        // ->selectRaw('result_capacity_detail.answer_id as answer_id, question_id')
                        // ->groupBy('question_id');
                    }
                ]);
            }
        ]);
        return $this->responseApi(true, $resultCapacity, ['exam' => $exam]);
    }
}
