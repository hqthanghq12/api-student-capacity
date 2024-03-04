<?php

namespace App\Services\Modules\poetry;

use App\Models\blockSubject;
use App\Models\ClassModel;
use App\Models\examination;
use App\Models\poetry as modelPoetry;
use App\Models\semeter;
use App\Models\studentPoetry;
use App\Models\subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class poetry implements MPoetryInterface
{
    public function __construct(
        private modelPoetry $modelPoetry
    )
    {
    }

    public function ListPoetry($id, $idblock, $request, $orderBy = null)
    {
        try {
            $records = $this->modelPoetry
                ->query()
                ->select('poetry.*', DB::raw('COALESCE(COUNT(student_poetry.id), 0) as student_count'))
                ->with([
                    'child_poetry',
                    'semeter',
                    'classsubject',
                    'user',
                    'campus',
                    'block_subject'
                ])
                ->where([
                    ['poetry.id_semeter', $id],
                    ['poetry.parent_poetry_id', 0]
                ])
                ->groupBy('poetry.id')
                ->leftJoin('student_poetry', 'poetry.id', '=', 'student_poetry.id_poetry')
                ->withWhereHas('block_subject', function ($q) use ($idblock) {
                    $q->where('id_block', $idblock);
                });
            if (!empty($request->gv)) {
                $records->where('poetry.assigned_user_id', $request->gv);
            }
            if (!empty($request->ct)) {
                $records->where('poetry.start_examination_id', $request->ct);
            }
            if (!empty($request->s)) {
                $records->where('poetry.id_block_subject', $request->s);
            }
            if (!empty($request->c)) {
                $records->where('poetry.id_class', $request->c);
            }
            if (!empty($orderBy)) {
                $records
                    ->orderBy('student_count', $orderBy);
            }
            if (!auth()->user()->hasRole('super admin')) {
                $records->where('poetry.id_campus', auth()->user()->campus->id);
            }
            if (auth()->user()->hasRole('teacher')) {
                $records->where('poetry.assigned_user_id', auth()->user()->id);
            }

            $data = $records->orderBy('id', 'desc')->paginate(10);

            foreach ($data as $poetry) {
                $poetry->examination = 'Ca ' . $poetry->start_examination_id;
                if ($poetry->child_poetry->count() > 0) {
                    $examinationChildArr = $poetry->child_poetry->pluck('start_examination_id')->toArray();

                    $poetry->examination .= ', ' . implode(',', $examinationChildArr);
                }
            }
            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function ListPoetryRespone($idSubject)
    {
        try {
            $records = $this->modelPoetry
                ->with(['classsubject' => function ($q) {
                    return $q->select('id', 'name', 'code_class');
                }])
                ->whereHas('block_subject', function ($subQuery) use ($idSubject) {
                    $subQuery->where('id_subject', $idSubject);
                })
                ->get();
            return $records;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function ListPoetryDetail($idSemeter, $idBlock, $id_subject, $id_class)
    {
        try {
            $query = $this->modelPoetry->query()
                ->where('status', 1);

            if ($idSemeter) {
                $query->where('id_semeter', $idSemeter);
            }


            if ($idBlock && !$id_subject) {
                $query->whereHas('block_subject', function ($subQuery) use ($idBlock) {
                    $subQuery->where('id_block', $idBlock);
                });
            }

            if ($idBlock && $id_subject) {
                $query->whereHas('block_subject', function ($subQuery) use ($idBlock, $id_subject) {
                    $subQuery->where('id_block', $idBlock)->where('id_subject', $id_subject);
                });
            }

            if ($id_subject && $id_class) {
                $query->where('id_class', $id_class);
            }

            $records = $query->pluck('id');

            $studentRecords = studentPoetry::whereIn('id_poetry', $records)
                ->pluck('id_student')->unique()
                ->values();

            $student = User::query()
                ->select(['id', 'name', 'email', 'mssv', 'campus_id'])
                ->whereIn('id', $studentRecords)
                ->with(['campus'])
                ->get();

            return $student;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function ListPoetryDetailChart($idcampus, $idSemeter, $idBlock)
    {
        try {
            $records = $this->modelPoetry->when(!empty($idcampus), function ($query) use ($idcampus) {
                $query->where('id_campus', $idcampus);
            })
                ->when(!empty($idSemeter) && empty($idBlock), function ($query) use ($idSemeter) {
                    $query->where('id_semeter', $idSemeter);
                })
                ->when(!empty($idBlock), function ($query) use ($idBlock) {
                    $query->whereHas('block_subject', function ($subQuery) use ($idBlock) {
                        $subQuery->where('id_block', $idBlock);
                    });
                })
                ->with(['student_poetry', 'student_poetry.playtopic.resultCapacity', 'semeter', 'campus', 'block_subject.block'])
                ->withCount(['student_poetry AS total_student_poetry',
                        'student_poetry as total_playtopic' => function ($query) {
                            $query->whereDoesntHave('playtopic');
                        },
                        'student_poetry as total_no_resultCapacity' => function ($query) {
                            $query->whereDoesntHave('playtopic.resultCapacity');
                        }]
                )
                ->groupBy('id_semeter', 'id_block_subject', 'id_class', 'room', 'assigned_user_id', 'id_campus', 'exam_date')
                ->get();
            $totalPoetry = $records->groupBy('id_semeter')->map(function ($group) {
                return $group->count();
            });

//            T

//            $result = $records->map(function ($record) use ($totalPoetry) {
//                return [
//                    'name' => $record->campus->name .'-' .$record->semeter->name .'-'. $record->block_subject->block->name ,
//                    'total_no_resultCapacity' => $record->total_no_resultCapacity,
//                    'total_playtopic' => $record->total_playtopic,
//                    'total_student_poetry' => $record->total_student_poetry,
//                    'total_succes_capacity' => $record->total_student_poetry - $record->total_no_resultCapacity,
//                    'totalPoetry' => $totalPoetry
//                ];
//            });


//           tổng số sinh viên
            $totalStudentPoetry = $records->sum('total_student_poetry');
//            tổng số sinh đã thêm nhưng chưa phát đề
            $totalPlayTopic = $records->sum('total_playtopic');
//            Tổng số sinh viên chưa thi
            $totalNoResultCapacity = $records->sum('total_no_resultCapacity');
//            Sinh viên đã thi
            $total_succes_capacity = $totalStudentPoetry - $totalNoResultCapacity;

//            $records->idblock =  $records->pluck('block_subject');
//            số ca thi
            $totalPoetry = $records->groupBy('id_semeter')->map(function ($group) {
                return $group->count();
            });
            $totalPoetry = $totalPoetry->sum();


            $data = [
                'totalStudentPoetry' => $totalStudentPoetry,
                'totalPlaytopic' => $totalPlayTopic,
                'totalNoResultCapacity' => $totalNoResultCapacity,
                'total_succes_capacity' => $total_succes_capacity,
                'totalPoetry' => $totalPoetry
            ];

            return $data;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function ListPoetryChart()
    {
        try {
            $records = $this->modelPoetry->with(['student_poetry', 'student_poetry.playtopic.resultCapacity', 'semeter', 'campus', 'block_subject.block'])
                ->withCount(['student_poetry AS total_student_poetry',
                        'student_poetry as total_playtopic' => function ($query) {
                            $query->whereDoesntHave('playtopic');
                        },
                        'student_poetry as total_no_resultCapacity' => function ($query) {
                            $query->whereDoesntHave('playtopic.resultCapacity');
                        }]
                )
                ->groupBy('id_semeter', 'id_block_subject', 'id_class', 'room', 'assigned_user_id', 'id_campus', 'exam_date')
                ->get();

//            T

//            $result = $records->map(function ($record) use ($totalPoetry) {
//                return [
//                    'name' => $record->campus->name .'-' .$record->semeter->name .'-'. $record->block_subject->block->name ,
//                    'total_no_resultCapacity' => $record->total_no_resultCapacity,
//                    'total_playtopic' => $record->total_playtopic,
//                    'total_student_poetry' => $record->total_student_poetry,
//                    'total_succes_capacity' => $record->total_student_poetry - $record->total_no_resultCapacity,
//                    'totalPoetry' => $totalPoetry
//                ];
//            });


//           tổng số sinh viên
            $totalStudentPoetry = $records->sum('total_student_poetry');
//            tổng số sinh đã thêm nhưng chưa phát đề
            $totalPlayTopic = $records->sum('total_playtopic');
//            Tổng số sinh viên chưa thi
            $totalNoResultCapacity = $records->sum('total_no_resultCapacity');
//            Sinh viên đã thi
            $total_succes_capacity = $totalStudentPoetry - $totalNoResultCapacity;

//            $records->idblock =  $records->pluck('block_subject');
//            số ca thi
            $totalPoetry = $records->groupBy('id_semeter')->map(function ($group) {
                return $group->count();
            });
            $totalPoetry = $totalPoetry->sum();


            $data = [
                'totalStudentPoetry' => $totalStudentPoetry,
                'totalPlaytopic' => $totalPlayTopic,
                'totalNoResultCapacity' => $totalNoResultCapacity,
                'total_succes_capacity' => $total_succes_capacity,
                'totalPoetry' => $totalPoetry
            ];

            return $data;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function ListPoetryApi($id, $id_user)
    {
        try {
            $records = $this->modelPoetry
                ->query()
                ->select([
                    'poetry.id',
                    'poetry.id_block_subject',
                    'poetry.start_examination_id',
                    'poetry.finish_examination_id',
                    'poetry.room',
                    'poetry.assigned_user_id',
                    'poetry.id_campus',
                    'poetry.exam_date',
                    'semester.name as name_semeter',
                    'class.name as name_class',
                    'playtopic.exam_time',
                    'playtopic.exam_name',
                    'playtopic.rejoined_at',
                    'result_capacity.created_at',
                    'result_capacity.status',
                ])
                ->join('semester', 'semester.id', '=', 'poetry.id_semeter')
                ->join('class', 'class.id', '=', 'poetry.id_class')
                ->join('student_poetry', 'student_poetry.id_poetry', '=', 'poetry.id')
                ->join('playtopic', 'playtopic.student_poetry_id', '=', 'student_poetry.id')
                ->leftJoin('result_capacity', 'result_capacity.playtopic_id', '=', 'playtopic.id')
                ->where([
                    ['poetry.id_semeter', $id],
                    ['student_poetry.id_student', $id_user],
                    ['playtopic.has_received_exam', 1],
                    ['poetry.status', 1],
                    ['student_poetry.status', 1],
                    ['exam_date', date('Y-m-d')],
                ])
                ->orderBy('playtopic.created_at', 'DESC')
                ->orderBy('poetry.start_examination_id', 'DESC')
                ->get();
            $blockSubjectIds = $records->pluck('id_block_subject');
            $blockSubjectIdToSubjectName = blockSubject::query()
                ->select('subject.name', 'block_subject.id')
                ->join('subject', 'subject.id', 'block_subject.id_subject')
                ->whereIn('block_subject.id', $blockSubjectIds)->get()->pluck('name', 'id');
            $examinations = examination::query()
                ->select('id', 'started_at', 'finished_at')
                ->get();
            $data = [];
            $data['name_item'] = $records[0]->name_semeter;
            foreach ($records as $value) {
//                if ($value->playtopic === null) {
//                    continue;
//                }
                $start = $examinations->where('id', $value->start_examination_id)->first();

                $finish = $examinations->where('id', $value->finish_examination_id)->first();

                $start_time = Carbon::make($value->exam_date . " " . $start->started_at);

                $finish_time = Carbon::make($value->exam_date . " " . $finish->finished_at);

                $rejoin = $value->rejoined_at ? Carbon::make($value->rejoined_at) : null;

                $rejoinFifteen = $rejoin ? clone $rejoin : null;

                $startTen = clone $start_time;

                if ($rejoinFifteen) $rejoinFifteen->addMinutes(15);

                $is_in_time = (
                    ($rejoin && $start_time->isPast() && now()->isBetween($rejoin, $rejoinFifteen))
                    || (now()->isBetween($start_time, $finish_time) && now()->isBefore($startTen->addMinutes(10)))
                );

                $have_done = (!empty($value->created_at) && $value->status == 1);
                $data['data'][] = [
                    "id" => $value->id,
                    "name_semeter" => $value->name_semeter,
                    'id_block_subject' => $value->id_block_subject,
                    "name_subject" => $blockSubjectIdToSubjectName[$value['id_block_subject']],
                    "name_class" => $value->name_class,
                    "room_name" => $value->room,
                    "exam_time" => $value->exam_time,
                    "exam_type" => 0,
                    'is_in_time' => $is_in_time,
                    'have_done' => $have_done,
                    'start_time' => $start->started_at,
                    'finish_time' => $finish->finished_at,
                ];
            }
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function onePoetryApi($id_poetry)
    {
        try {
            $records = $this->modelPoetry::select('start_time', 'end_time')->find($id_poetry);
            return $records;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getItem($id)
    {
        try {
            $poetry = $this->modelPoetry::find($id);
            $data = ['name_semeter' => $poetry->semeter->name, 'name_subject' => $poetry->subject->name, 'nameClass' => $poetry->classsubject->name, 'nameExamtion' => $poetry->examination->name, 'name_campus' => $poetry->campus->name];
            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getItempoetry($id)
    {
        {
            try {
                return $this->modelPoetry->with('user')->find($id);
            } catch (\Exception $e) {
                return false;
            }
        }
    }
}
