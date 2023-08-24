<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Modules\MSubjects\Subject;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use App\Services\Modules\MBlock\Block;
class BlockController extends Controller
{
    use TUploadImage, TResponse;
    public function __construct(
        private Block                          $block,
        private Subject                        $subject
    )
    {
    }
    public function index($id_semeter){
        $blockOne = $this->block->getWhereList($id_semeter)->where('name', 'Block 1')->first();
        $data = $this->subject->ListSubjectRespone($blockOne->id);
        return response()->json(['data' => $data, 'block_id' => $blockOne->id], 200);
    }

    public function block($id_semeter){
        $data = $this->block->getWhereList($id_semeter);
        return view('pages.blocks.index',['data' => $data,'id' => $id_semeter]);
    }
}
