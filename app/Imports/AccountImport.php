<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class AccountImport implements ToModel, WithHeadingRow, WithBatchInserts, WithUpserts, WithEvents
{
    protected $request;
    protected $campuses;

    private $results = [];
    private $total = 0;
    private $errorImport = [];
    private $errorCampus = [];
    private $existedEmail = [];
    private $sheetNames = [];

    public function __construct($request, $campuses)
    {
        $this->request = $request;
        $this->campuses = $campuses;
    }

    public function uniqueBy()
    {
        return 'email';
    }

    // lọc qua các sheet để lấy tên sheet
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetNames[] = $event->getSheet()->getDelegate()->getTitle();
            }
        ];
    }

    // lấy tên sheet
    private function getSheetNames(): string
    {
        return Str::lower($this->sheetNames[0]);
    }

    // lọc qua các dòng trong file excel để lấy dữ liệu và xử lý
    public function model(array $row)
    {
        $role_id = $this->request->input('roles_id_add_excel') ?? config('util.STUDENT_ROLE');
        $password = "123@123";
        if(isset($this->campuses[$this->getSheetNames()])){
            $campuse_id = $this->campuses[$this->getSheetNames()];
            $checkUser = User::where('email', $row['email'])->where('status', 0)->whereNotIn('email', $this->errorCampus)->first();
            if($checkUser){
                $this->results[] = [
                    'email' => $row['email'],
                    'password' => $password,
                ];
                $checkUser->status = 1;
                $checkUser->mssv = $row['ma_sinh_vien'];
                $checkUser->name = $row['ho_va_ten'];
                $checkUser->password = Hash::make($password);
                $checkUser->campus_id = $campuse_id;
                $checkUser->save();
                $this->existedEmail[] = $row['email'];
            }
            else {
                if($row['email'] == null || $row['ma_sinh_vien'] == null || $row['ho_va_ten'] == null){
                    $this->errorImport[] = $row['email'];
                } else {
                    $checkExitUser = User::where('email', $row['email'])->where('status', 1)->first();
                    if(!$checkExitUser){
                        $role = Role::find($role_id);
                        if ($role) {
                            $this->total++;
                            $this->results[] = [
                                'email' => $row['email'],
                                'password' => $password,
                            ];
                            $role->users()->create([
                                'mssv' => $row['ma_sinh_vien'],
                                'name' => $row['ho_va_ten'],
                                'email' => $row['email'],
                                'status' => 1,
                                'avatar' => "https://play-lh.googleusercontent.com/0UNPGXC2cP3GdbREaJQyBUDlhgUZlKJ8janqR_O2rVlQwinIoStuRRIEVzIKPslZIQ",
                                'campus_id' => $campuse_id,
                                'password' => Hash::make($password),
                            ]);
                        } else {
                            $this->errorImport[] = $row['email'];
                        }
                    }  else {
                        $this->total++;
                        $this->results[] = [
                            'email' => $row['email'],
                            'password' => $password,
                        ];
                        $checkExitUser->mssv = $row['ma_sinh_vien'];
                        $checkExitUser->name = $row['ho_va_ten'];
                        $checkExitUser->password = Hash::make($password);
                        $checkExitUser->campus_id = $campuse_id;
                        $checkExitUser->save();
                        $this->existedEmail[] = $row['email'];
                    }
                }
            }
        } else {
            $this->errorCampus[] = $row['email'];
        }
    }

    // số lượng dòng dữ liệu được xử lý mỗi lần
    public function batchSize(): int
    {
        return 1000;
    }

    public function getResults(): mixed
    {
        return [
            'results' => $this->results,
            'total' => $this->total,
            'errorImport' => $this->errorImport,
            'errorCampus' => $this->errorCampus,
            'existedEmail' => $this->existedEmail,
        ];
    }
}
