<?php

namespace App\Services\Modules\MCampus;

use App\Models\Contest;
use App\Models\Major;
use App\Models\Round;
use App\Services\Traits\TUploadImage;

class Campus
{
    private $campus;
    public function __construct(\App\Models\Campus $campus)
    {
        $this->campus = $campus;
    }

    public function getList()
    {
        return $this->campus;
    }

    public function apiIndex()
    {
        try {
            return $this->getList()
                ->get();
        } catch (\Exception $e) {
            return false;
        }
    }
}
