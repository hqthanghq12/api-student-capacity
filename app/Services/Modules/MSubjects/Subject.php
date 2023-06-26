<?php

namespace App\Services\Modules\MSubjects;

use App\Models\subject as SubjectModel;
use Illuminate\Support\Facades\DB;
use App\Models\semeter_subject;

class Subject
{
    public function __construct(private SubjectModel $mSubject)
    {
    }

    public function getListSb()
    {
        return $this->mSubject;
    }

    public function List($id)
    {
        try {
//            $existingSubjectIds = $this->mSubject::whereHas('semester_subject', function ($query) use ($id) {
//                $query->where('id_semeter', $id);
//            })
//                ->with(['semester_subject'])
//                ->pluck('id')
//                ->toArray();

//            $subjects = $this->mSubject::whereNotIn('id', $existingSubjectIds)
//                ->get();
            $existingSubjectIds = $this->mSubject::all();
            return $existingSubjectIds;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function ListSubjectRespone($id)
    {
        try {
            $records = $this->mSubject->whereHas('block_subject',function($q) use ($id){
                return $q->where('id_block',$id);
            })->get();
            return $records;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function ListSubject()
    {
        try {
            return $this->getListSb()
                ->paginate(5);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function ListSubjectApi()
    {
        try {
            return $this->getListSb()
                ->paginate(5);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getItemSubject($id)
    {
        {
            try {
                return $this->mSubject->find($id);
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    public function getItemSubjectSetemer($id)
    {
        {
            try {
                $subjects = $this->mSubject::whereHas('semester_subject', function ($query) use ($id) {
                    $query->where('semester_subject.id_semeter', $id);
                })->paginate(5);
                foreach ($subjects as $value) {
                    $semeterSubject = semeter_subject::where('id_semeter', '=', $id)->where('id_subject', '=', $value->id)->first();
                    $value->id_subject_semeter = $semeterSubject->id;
                    $value->statusSubject = $semeterSubject->status;
                }
//                dd($subjects[0]->semester_subject[0]->id);
                return $subjects;
            } catch (\Exception $e) {
                dd($e);
            }
        }
    }

    public function getItemSubjectSetemerReponse($id)
    {
        {
            try {
                $subjects = $this->mSubject::query()
                    ->select('block_subject.id', 'subject.name')
                    ->where('block_subject.id_block', $id)
                    ->join('block_subject', 'block_subject.id_subject', '=', 'subject.id')
                    ->orderBy('created_at', 'desc')->get();
//                $subjects1 = $this->mSubject::with('semester_subject')
//                    ->whereHas('semester_subject', function ($query) use ($id) {
//                        return $query->where('id_semeter', $id)->get();
//                    })
//                    ->paginate(10);
                return $subjects;
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    public function createSubjectSemater($idSubject, $idSemeter)
    {
        {
            try {
                $subjects = $this->mSubject::find($idSubject);
                $subjects->semester_subject()->attach($idSemeter);
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    public function updateStatusSemeter($idSemeterSubject, $status)
    {
        {
            try {
                $semetersubject = semeter_subject::find($idSemeterSubject);
                $semetersubject->status = $status;
                $semetersubject->updated_at = now();
                $semetersubject->save();
            } catch (\Exception $e) {
                return $e;
            }
        }
    }

    public function removeSubjectSemater($idSubject, $idSemeter)
    {
        {
            try {
                $subjects = $this->mSubject::find($idSubject);
                if ($subjects) {
                    $subjects->semester_subject()
                        ->wherePivot('id_semeter', $idSemeter)
                        ->detach($idSemeter);
                }
            } catch (\Exception $e) {
                return false;
            }
        }
    }

}
