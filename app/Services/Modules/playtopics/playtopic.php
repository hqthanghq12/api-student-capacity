<?php

namespace App\Services\Modules\playtopics;

use App\Models\examination;
use App\Models\playtopic as modelPlayTopics;
use Carbon\Carbon;

class playtopic
{

    public function __construct(
        private modelPlayTopics $modelPlayTopic
    )
    {
    }

    public function getList($id_poetry)
    {
        try {
            return $this->modelPlayTopic->where('id_poetry', '=', $id_poetry)->paginate(10);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getExamApi($id_user, $id_poetry, $id_campus, $id_block_subject)
    {
        try {
            $records = $this->modelPlayTopic
                ->query()
                ->select([
                    'playtopic.id',
                    'playtopic.exam_name as name',
                    'playtopic.rejoined_at',
                    'playtopic.questions_order as questions',
                    'subject.name as name_subject',
                    'result_capacity.status',
                    'poetry.exam_date',
                    'poetry.start_examination_id',
                    'poetry.finish_examination_id',
                ])
                ->leftJoin('student_poetry', 'student_poetry.id', '=', 'playtopic.student_poetry_id')
                ->leftJoin('poetry', 'poetry.id', '=', 'student_poetry.id_poetry')
                ->leftJoin('block_subject', 'block_subject.id', '=', 'poetry.id_block_subject')
                ->leftJoin('subject', 'subject.id', '=', 'block_subject.id_subject')
                ->leftJoin('result_capacity', 'result_capacity.playtopic_id', '=', 'playtopic.id')
                ->where('student_poetry.id_student', '=', $id_user)
                ->where('student_poetry.id_poetry', '=', $id_poetry)
                ->where('poetry.id_block_subject', '=', $id_block_subject)->first();

            $poetryIdToPoetryTime = examination::query()
                ->select('id', 'started_at', 'finished_at')
                ->get()->mapWithKeys(function ($item) {
                    return [$item['id'] => ['started_at' => $item['started_at'], 'finished_at' => $item['finished_at']]];
                })->toArray();

            $start = $poetryIdToPoetryTime[$records->start_examination_id]['started_at'];

            $finish = $poetryIdToPoetryTime[$records->finish_examination_id]['finished_at'];

            $start_time = Carbon::make($records->exam_date . " " . $start);

            $finish_time = Carbon::make($records->exam_date . " " . $finish);

            $rejoin = $records->rejoined_at ? Carbon::make($records->rejoined_at) : null;

            $rejoinFifteen = $rejoin ? clone $rejoin : null;

            $startTen = clone $start_time;

            if ($rejoinFifteen) $rejoinFifteen->addMinutes(15);

            $records->is_in_time = (
                ($rejoin && $start_time->isPast() && now()->isBetween($rejoin, $rejoinFifteen))
                || (now()->isBetween($start_time, $finish_time)
//                    && now()->isBefore($startTen->addMinutes(10))
                )
            );

            $records->have_done = (!empty($records->status) && $records->status == 1);

            $records->start_time = $start_time->format('Y-m-d H:i');

            $records->finish_time = $finish_time->format('Y-m-d H:i');

//            $records['name_campus'] = $records->campusName;
//            foreach ($records as $value){
//                $data[] = [
//                    ""
//                ]
//            }
            return $records;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
