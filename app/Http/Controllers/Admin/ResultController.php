<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\poetry;
use App\Models\Question;
use App\Models\Result;
use App\Models\Round;
use App\Models\studentPoetry;
use App\Services\Modules\MResultCapacity\ResultCapacity;
use App\Services\Modules\MRound\MRoundInterface;
use App\Services\Traits\TResponse;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    use TResponse;

    public function __construct(
        private MRoundInterface $round,
        private ResultCapacity  $resultCapacity
    )
    {
    }

    public function indexApi($id_round)
    {
        try {
            $data = $this->round->results($id_round);
            if (!$data) throw new \Exception("Không tìm thấy lịch sử ");
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }

    public function index($id_round)
    {
        $round = $this->round->find($id_round);
        $teams = $this->round->getTeamByRoundId($id_round);
        return view('pages.round.detail.result.index', compact('round', 'teams'));
    }

    public function resultCapacity($id)
    {
        $result = $this->resultCapacity
            ->where(
                ['playtopic_id' => $id],
                ['resultCapacityDetail', 'user', 'playtopic']
            );
        $playtopic = $result->playtopic;
        $user = $result->user;
        $resultCapacityDetail = $result->resultCapacityDetail;
        $questionsId = json_decode($playtopic->questions_order);
        $questions = Question::query()
            ->whereIn('id', $questionsId)
            ->with(['answers', 'images'])
            ->get();

        $totalQuestion = $resultCapacityDetail->count();

        $poetry = poetry::query()->where('id', function ($query) use ($playtopic) {
            $query->select('id_poetry')
                ->from((new studentPoetry())->getTable())
                ->where('id', $playtopic->student_poetry_id);
        })->first();

        $subject = $poetry->block_subject->subject;

        $semester = $poetry->semeter;

        $block = $semester->blocks->where('name', 'Block 1')->first();

        return view('pages.poetry.playtopic.result', compact(
            'result',
            'playtopic',
            'user',
            'resultCapacityDetail',
            'questions',
            'totalQuestion',
            'questionsId',
            'subject',
            'poetry',
            'semester',
            'block'
        ));
    }
}
