<?php

namespace App\Services\Modules\MStudentManager;

interface MPoetryStudentsInterface
{
    public function Store();
    public function GetStudents($id_poetry);
    public function findUser($emailUser,$idPoetry);
    public function Item($id);
}
