<?php

namespace App\Services\Modules\MAnswer;

use App\Models\Answer as ModelsAnswer;

class Answer
{

    public function __construct(
        private ModelsAnswer $model
    ) {
    }
    public function findById($id, $param = [], $with = [])
    {
        $query = $this->model::whereId($id)
            ->hasRequest($param)
            ->with($with)->first();
        return $query;
    }
    public function whereInId($id = [], $param = [])
    {
        // $query = $this->model::whereIn('id', $id)
        //     ->hasRequest($param)
        //     ->with($with)->get();
        // dd($param);
        $query = $this->model::whereIn('id', $id)->hasRequest($param)->get();
        return $query;
    }
}