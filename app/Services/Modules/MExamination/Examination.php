<?php

namespace App\Services\Modules\MExamination;
use App\Models\examination as modelExamination;
class Examination implements MExaminationInterface
{
    public function __construct(
        private modelExamination $modelExamination
    )
    {
    }

    public function getList()
    {
        try {
            return $this->modelExamination->all();
        }catch (\Exception $e){
            return $e;
        }
    }
}
