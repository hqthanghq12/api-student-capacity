<?php

namespace App\Services\Modules\MSemeter;
use App\Models\poetry as modelPoetry;
use App\Models\semeter as SemeterModel;
class Semeter implements MSemeterInterface
{

    public function __construct(private SemeterModel $modelSemeter,   private modelPoetry $modelPoetry){

    }
    public function ListSemeter(){
        return $this->modelSemeter::all();
    }
    public function GetSemeter()
    {
        $data = $this->modelSemeter::paginate(5);
        return $data;
    }

    public function GetSemeterAPI()
    {
        $data = $this->modelSemeter::paginate(5);
        foreach ($data as $value){
            $value['total_poetry'] = $this->modelPoetry->where('id_semeter',$value->id)->count();
        }

        return $data;
    }

    public function getItemSemeter($id){
        try {
            return $this->modelSemeter->find($id);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getName($id){
        try {
            return $this->modelSemeter->find($id)->name;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getListByCampus($id_campus){
        try {
            return $this->modelSemeter->where('id_campus',$id_campus)->get();
        } catch (\Exception $e) {
            return $e;
        }
    }

}
