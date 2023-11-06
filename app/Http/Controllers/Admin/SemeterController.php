<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use App\Services\Modules\MSemeter\Semeter;
use App\Services\Modules\MBlock\Block;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Campus;
class SemeterController extends Controller
{
    use TUploadImage, TResponse;
    public function __construct(
        private Semeter $semeter,
        private Block $block
    )
    {
    }

    public function index(){
        $data = $this->semeter->GetSemeter();

        //Tao mang
        $ids=[];
        foreach($data as $key=>$value){
            $ids[]=$value->id;
        }
        $block_id= $this->block->getAllIdBlockOne($ids);
        $campusListQuery = Campus::query();
        if (!(auth()->user()->hasRole('super admin'))) {
            $campusListQuery->where('id', auth()->user()->campus_id);
        }
        $campusList = $campusListQuery->get();
        return view('pages.semeter.index',['setemer' => $data,'campusList' => $campusList,'id'=>$block_id]);
    }

    public function ListSemeter($id_semeter){
        $data = $this->semeter->GetSemeter();
        return response()->json(['data' => $data], 200);
    }

    public function indexApi($codeCampus){
        if (!($data = $this->semeter->GetSemeterAPI($codeCampus)))  return $this->responseApi(false);
        return $this->responseApi(true, $data);
    }
    public function edit($id){
        try{
            $subject = $this->semeter->getItemSemeter($id);
            return response()->json([
                'message' => "Thành công",
                'data' => $subject,
            ],200);
        }catch (\Throwable $th){
            return response( ['message' => "Thêm thất bại"],404);
        }
    }
    public function create(Request $request){
        $validator =  Validator::make(
            $request->all(),
            [
                'namebasis' => 'required|min:3|unique:semester,name',
                'campus_id' => 'required',
                'status' => 'required',
                'start_time_semeter' => 'nullable',
                'end_time_semeter' => 'nullable|date|after:start_time_semeter'
            ],
            [
                'namebasis.unique' => 'Tên kỳ học đã tồn tại',
                'namebasis.required' => 'Không để trống tên Môn !',
                'campus_id.required' => 'Vui lòng chọn cơ sở',
                'namebasis.min' => 'Tối thiếu 3 ký tự',
                'status.required' => 'Vui lòng chọn trạng thái',
                'start_time_semeter.nullable' => 'Vui lòng chọn thời gian bắt đầu',
                'end_time_semeter.nullable' => 'Vui lòng chọn thời gian kết thúc',
                'end_time_semeter.after' => 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu',
            ]
        );

        if($validator->fails() == 1){
            $errors = $validator->errors();
            $fields = ['namebasis','campus_id','status','start_time_semeter','end_time_semeter'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error,404);
                    }
                }
            }

        }
        $data = [
            'name' => $request->namebasis,
            'id_campus' => $request->campus_id,
            'status' => $request->status,
            'start_time' => $request->start_time_semeter,
            'end_time' => $request->end_time_semeter,
            'created_at' => now(),
            'updated_at' => NULL
        ];


        DB::table('semester')->insert($data);
        $id = DB::getPdo()->lastInsertId();
        $Blocks = [];
        for ($i = 0; $i < 2;$i++){
            $Blocks[] = [
                'name' => 'Block ' .$i+1,
                'id_semeter' => $id,
            ];
        }
        DB::table('block_semeter')->insert($Blocks);
        $data = $request->all();
        $data['id'] = $id;
        return response( ['message' => "Thêm thành công",'data' =>$data],200);
    }
    public function update(Request $request,$id){
        $validator =  Validator::make(
            $request->all(),
            [
                'namebasis' => 'required|min:3',
                'campus_id_update' => 'required',
                'status' => 'required',
                'start_time_semeter' => 'nullable|date',
                'end_time_semeter' => 'nullable|date|after:start_time_semeter'
            ],
            [
                'namebasis.required' => 'Không để trống tên kỳ học !',
                'campus_id_update.required' => 'Không để trống tên cơ sở !',
                'namebasis.min' => 'Tối thiếu 3 ký tự',
                'status.required' => 'Vui lòng chọn trạng thái',
                'start_time_semeter.nullable' => 'Vui lòng chọn thời gian bắt đầu',
                'end_time_semeter.nullable' => 'Vui lòng chọn thời gian kết thúc',
                'end_time_semeter.after' => 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu',
            ]
        );
        if($validator->fails() == 1){
            $errors = $validator->errors();
            $fields = ['namebasis','campus_id_update','status','start_time_semeter','end_time_semeter'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error,404);
                    }
                }
            }

        }
        $semeter = $this->semeter->getItemSemeter($id);
        if (!$semeter) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }
        $semeter->name = $request->namebasis;
        $semeter->id_campus = $request->campus_id_update;
        $semeter->status = $request->status;
        $semeter->start_time = $request->start_time_semeter;
        $semeter->end_time = $request->end_time_semeter;
        $semeter->updated_at = $request->end_time;

        $semeter->save();
        $data = $request->all();
        $data['end_time_semeter'] =  $this->formatdate($data['end_time_semeter']);
        $data['start_time_semeter'] =   $this->formatdate($data['start_time_semeter']);
        $data['id'] = $id;
        return response( ['message' => "Cập nhật thành công",'data' => $data],200);
    }
    public function now_status(Request $request,$id){
        $campus = $this->semeter->getItemSemeter($id);
        if (!$campus) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }
        $campus->status = $request->status;
        $campus->updated_at = now();
        $campus->save();
        $data = $request->all();
        $data['id'] = $id;
        return response( ['message' => "Cập nhật trạng thái thành công",'data' =>$data],200);
    }
    public function delete($id){
        try {
            $this->semeter->getItemSemeter($id)->delete();
            return response( ['message' => "Xóa Thành công"],200);
        } catch (\Throwable $th) {
            return response( ['message' => "Xóa Thất bại"],404);
        }
    }

    public function formatdate($dateformat){
        $date_start = $dateformat;
        $timestamp = strtotime($date_start);
        return date('d-m-Y', $timestamp);

    }
}
