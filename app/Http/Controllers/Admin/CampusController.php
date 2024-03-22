<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Traits\TResponse;
use App\Services\Traits\TStatus;
use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CampusController extends Controller
{
    use TStatus, TResponse;

    private $campus;
    private $modulesCampus;

    public function __construct(Campus $campus, \App\Services\Modules\MCampus\Campus  $modulesCampus)
    {
        $this->campus = $campus;
        $this->modulesCampus = $modulesCampus;
    }

    public function index(){
        $campus = $this->campus::paginate(6);
        return view('pages.campus.index',['campus' => $campus]);
    }

    public function edit($id){
        try{
            $campus = $this->campus::find($id);
            return response()->json([
                'message' => "Thành công",
                'data' => $campus,
            ],200);
        }catch (\Throwable $th){
            return response( ['message' => "Thêm thất bại"],404);
        }
    }

    public function update(Request $request,$id){
        $validator =  Validator::make(
            $request->all(),
            [
                'namebasis' => 'required|min:3',
                'code' => 'required'
            ],
            [
                'namebasis.required' => 'Không để trống tên cơ sở !',
                'namebasis.min' => 'Tối thiếu 3 ký tự',
                'code.required' => 'Không để trống mã cơ sở'
            ]
        );
        if($validator->fails() == 1){
            $errors = $validator->errors();
            $fields = ['namebasis', 'code'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error,404);
                    }
                }
            }

        }
        $campus = $this->campus::find($id);
        if (!$campus) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }
        $campus->name = $request->namebasis;
        $campus->code = $request->code;
        $campus->created_at = $request->start_time;
        $campus->updated_at = $request->end_time;

        $campus->save();
        $data = $request->all();
        $data['id'] = $id;
        return response( ['message' => "Cập nhật thành công",'data' =>$data],200);
    }

    public function store(Request $request){
        $validator =  Validator::make(
            $request->all(),
            [
                'namebasis' => 'required|min:3|unique:campuses,name',
                'code' => 'required|unique:campuses,code'
            ],
            [
                'namebasis.unique' => 'Tên cơ sở đã tồn tại',
                'code.unique' => 'Mã cơ sở đã tồn tại',
                'namebasis.required' => 'Không để trống tên cơ sở !',
                'namebasis.min' => 'Tối thiếu 3 ký tự',
                'code.required' => 'Không để trống mã cơ sở'
            ]
        );

        if($validator->fails() == 1){
            $errors = $validator->errors();
            $fields = ['namebasis', 'code'];
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
            'code' => $request->code,
            'created_at' => now(),
            'updated_at' => now()
        ];

        DB::table('campuses')->insert($data);
        $id = DB::getPdo()->lastInsertId();
        $data = $request->all();
        $data['id'] = $id;
            return response( ['message' => "Thêm thành công",'data' =>$data],200);

    }

    public function delete($id){
        try {
        $this->campus::find($id)->delete();
        return response( ['message' => "Xóa Thành công"],200);
        } catch (\Throwable $th) {
            return response( ['message' => "Xóa Thất bại"],404);
        }
    }

    public function apiIndex()
    {
        try {
            $data = $this->modulesCampus->apiIndex();
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false);
        }
    }
}
