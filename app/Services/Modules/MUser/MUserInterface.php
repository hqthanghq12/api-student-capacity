<?php

namespace App\Services\Modules\MUser;

interface MUserInterface
{
    public function contestJoined();

    public function getTotalStudentAcount();

    public function getModelQuery();

    public function getModelClass();
}
