<?php

namespace App\Services\Traits;

trait UsesExamConnection
{
    public function getConnectionName()
    {
        return config('util.EXAM_CONNECTION');
    }
}
