<?php

namespace App\Services\Modules\MBlock;
use App\Models\block as model;
class Block
{
    private $block;
    public function __construct(model $model)
    {
        $this->block = $model;
    }

    public function getWhereList($id){
        return $this->block->where('id_semeter',$id)->get();
    }

    public function getAllIdBlockOne($ids){
        return $this->block
        ->selectRaw(' MIN(id) as min_id')
        ->whereIn('id_semeter',$ids)
        ->groupBy('id_semeter')
        ->get();
    }

}
