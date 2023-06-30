<?php

namespace App\Services\Modules\playtopics;

use App\Models\examination;
use App\Models\playtopic as modelPlayTopics;
class playtopic
{

    public function __construct(
        private modelPlayTopics $modelPlayTopic
    )
    {
    }

    public function getList($id_poetry){
        try {
            return $this->modelPlayTopic->where('id_poetry','=',$id_poetry)->paginate(10);
        }catch(\Exception $e){
            return $e;
        }
    }

    public function getExamApi($id_user,$id_poetry,$id_campus,$id_block_subject){
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
                ->where('student_poetry.id_student','=',$id_user)
                ->where('student_poetry.id_poetry','=',$id_poetry)
                ->where('poetry.id_block_subject','=',$id_block_subject)->first();

            $poetryIdToPoetryTime = examination::query()
                ->select('id', 'started_at', 'finished_at')
                ->get()->mapWithKeys(function ($item) {
                    return [$item['id'] => ['started_at' => $item['started_at'], 'finished_at' => $item['finished_at']]];
                })->toArray();
            $start_time = $records->exam_date . " " . $poetryIdToPoetryTime[$records->start_examination_id]['started_at'];
            $finish_time = $records->exam_date . " " . $poetryIdToPoetryTime[$records->finish_examination_id]['finished_at'];
            $start_time_timestamp = strtotime($start_time);
            $rejoin_timestamp = strtotime($records->rejoined_at);
            $records->is_in_time = (
                (time() >= $rejoin_timestamp && time() < strtotime("+15 minutes", $rejoin_timestamp))
                || (time() >= $start_time_timestamp && time() < strtotime("+15 minutes", $start_time_timestamp) && time() < strtotime($finish_time))
            );
            $records->have_done = (!empty($records->status) && $records->status == 1);
            $records->start_time = $start_time;
            $records->finish_time = $finish_time;
//            $records['name_campus'] = $records->campusName;
//            foreach ($records as $value){
//                $data[] = [
//                    ""
//                ]
//            }
            return $records;
        }catch(\Exception $e){
            return $e;
        }
    }
}
