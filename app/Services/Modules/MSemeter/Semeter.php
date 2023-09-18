<?php

namespace App\Services\Modules\MSemeter;

use App\Models\poetry as modelPoetry;
use App\Models\semeter as SemeterModel;
use App\Models\studentPoetry;

class Semeter implements MSemeterInterface
{

    public function __construct(private SemeterModel $modelSemeter, private modelPoetry $modelPoetry)
    {

    }

    public function ListSemeter()
    {
        return $this->modelSemeter::all();
    }

    public function GetSemeter()
    {
        $dataQuery = $this->modelSemeter::query();
        if (!(auth()->user()->hasRole('super admin'))) {
            $dataQuery->where('id_campus', auth()->user()->campus_id);
        }
        if (auth()->user()->hasRole('teacher')) {
            $dataQuery->with('blocks');
        }
        $data = $dataQuery->paginate(5);
        return $data;
    }

    public function getAllSemeter()
    {
        $dataQuery = $this->modelSemeter::query();
        if (!(auth()->user()->hasRole('super admin'))) {
            $dataQuery->where('id_campus', auth()->user()->campus_id);
        }
        $data = $dataQuery->get();
        return $data;
    }

    public function GetSemeterAPI($codeCampus)
    {
        $semesterAndCount = studentPoetry::query()
            ->selectRaw('poetry.id_semeter, count(student_poetry.id_student) as total_student')
            ->join('poetry', 'poetry.id', '=', 'student_poetry.id_poetry')
            ->where('poetry.exam_date', date('Y-m-d'))
            ->where('student_poetry.id_student', auth()->user()->id)
            ->groupBy(['poetry.id_semeter', 'student_poetry.id_student'])
            ->pluck('total_student', 'id_semeter');

        $data = $this->modelSemeter
            ->where('id_campus', $codeCampus)
            ->whereIn('id', $semesterAndCount->keys()->toArray())
            ->get();
        return $data;
        foreach ($data as $value) {
            $value->total_student = $semesterAndCount[$value->id];
        }

        return $data;
    }

    public function getItemSemeter($id)
    {
        try {
            return $this->modelSemeter->find($id);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getName($id)
    {
        try {
            return $this->modelSemeter->find($id)->name;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getListByCampus($id_campus)
    {
        try {
            return $this->modelSemeter->where('id_campus', $id_campus)->get();
        } catch (\Exception $e) {
            return $e;
        }
    }

}
