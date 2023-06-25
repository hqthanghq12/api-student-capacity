<?php

namespace App\Services\Modules\MSemeter;



interface MSemeterInterface
{
    public function GetSemeter();

    public function getItemSemeter($id);

    public function getName($id);

    public function getListByCampus($idCampus);
}
