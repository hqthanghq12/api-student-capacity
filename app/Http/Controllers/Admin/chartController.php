<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Traits\TCheckUserDrugTeam;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use App\Services\Modules\MSemeter\Semeter;
use App\Models\block;
use App\Models\Campus;
use App\Services\Modules\poetry\poetry;

class chartController extends Controller
{
    use TUploadImage, TCheckUserDrugTeam, TResponse;

    public function __construct(
        private poetry  $poetry,
        private Semeter $interfaceSemeter,

    )
    {
    }

    public function index()
    {
        if (auth()->user()->hasRole('teacher')) {
            return redirect()->route('admin.semeter.index');
        }
        $listCampusQuery = Campus::query();
        if (!(auth()->user()->hasRole('super admin'))) {
            $listCampusQuery->where('id', auth()->user()->campus_id);
        }
        $listCampus = $listCampusQuery->get();
        $dataResult = $this->poetry->ListPoetryChart();
        return view('pages.chart.index', ['listcampus' => $listCampus, 'data' => $dataResult]);
    }

    public function detail()
    {
        return view('pages.chart.chart');
    }

    public function semeter($id_campus)
    {
        $listSemeter = $this->interfaceSemeter->getListByCampus($id_campus);

        return response()->json(['data' => $listSemeter], 200);
    }

    public function block($id_semeter)
    {
        $listBlock = block::query()->where('id_semeter', $id_semeter)->where('name', 'Block 1')->get();
        return response()->json(['data' => $listBlock], 200);
    }
}
