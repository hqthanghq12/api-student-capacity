<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AccountMultiImport implements WithMultipleSheets
{
    protected $request;
    public function __construct($request){
        $this->request = $request;
    }
    public function sheets(): array
    {
        return [
            'hn' => new AccountImport($this->request, 1),
            // 'hcm' => new AccountImport($this->request, 2),
        ];
    }

    public function getValuesFromImports() {
        $sheets = $this->sheets();
        $values = [];
        foreach ($sheets as $key => $sheet) {
            $values[$key] = $sheet->getResults();
        }
        return $values;
    }
}
