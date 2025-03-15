<?php

namespace App\Services\Modules\poetry;

interface MPoetryInterface
{
    public function ListPoetry($id, $idblock, $request);

    public function getItem($id);

}
