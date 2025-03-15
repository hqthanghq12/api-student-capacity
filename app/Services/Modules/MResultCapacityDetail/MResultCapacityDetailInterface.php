<?php

namespace App\Services\Modules\MResultCapacityDetail;

interface MResultCapacityDetailInterface
{

    public function create($data = []);

    public function insert($data = []);

    public function getHistoryByResultCapacityId($id);

    public function checkExam($id_user,$id_exam);
}
