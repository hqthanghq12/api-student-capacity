<?php

namespace App\Services\Modules\MClass;
use App\Models\ClassModel as modelClass;
class classModel implements MClassInterface
{
    public function __construct(
        private modelClass $modelClass
    )
    {
    }

    public function getClass()
    {
        try {
            return $this->modelClass->all();
        }catch (\exception $e){
            return $e;
        }
    }
}
