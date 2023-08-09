<?php

namespace App\Services\Modules\MStudentManager;

use App\Models\poetry;
use App\Models\studentPoetry;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\modelroles;
use Illuminate\Support\Facades\Validator;

class PoetryStudent implements MPoetryStudentsInterface
{
    private $table;

    public function __construct(
        private studentPoetry $model
    )
    {
        $this->table = $this->model->getTable();
    }

    public function GetStudents($id_poetry)
    {
        $user = (new User())->getTable();
        $poetry = (new poetry())->getTable();
        $data = $this->model::query()
            ->select(
                [
                    "{$this->table}.id",
                    "{$this->table}.id_student",
                    "playtopic.exam_name",
                    "{$this->table}.status",
                    "playtopic.has_received_exam",
                    "playtopic.exam_time",
                    "{$user}.name as nameStudent",
                    "{$user}.email as emailStudent",
                    "{$user}.mssv",
                    "{$poetry}.id_block_subject",
                    'result_capacity.scores',
                    'result_capacity.updated_at',
                ]
            )
            ->leftJoin($user, "{$user}.id", '=', "{$this->table}.id_student")
            ->leftJoin($poetry, "{$poetry}.id", '=', "{$this->table}.id_poetry")
            ->leftJoin('playtopic', "playtopic.student_poetry_id", '=', "{$this->table}.id")
            ->leftJoin('result_capacity', "result_capacity.playtopic_id", '=', "playtopic.id")
            ->where("{$this->table}.id_poetry", $id_poetry)
            ->orderBy("{$this->table}.id")
            ->paginate(10);
        return $data;
        try {

        } catch (\Exception $e) {
            return false;
        }
    }

    public function GetStudentsDetail($id_poetry)
    {
        try {
            $user = (new User())->getTable();
            $poetry = (new poetry())->getTable();
            $data = $this->model::query()
                ->select(
                    [
                        "{$this->table}.id",
                        "{$this->table}.id_student",
                        "playtopic.exam_name",
                        "{$this->table}.status",
                        "playtopic.has_received_exam",
                        "playtopic.exam_time",
                        "{$user}.name as nameStudent",
                        "{$user}.email as emailStudent",
                        "{$user}.mssv",
                        "{$poetry}.id_subject",
                        'result_capacity.scores'
                    ]
                )
                ->leftJoin($user, "{$user}.id", '=', "{$this->table}.id_student")
                ->leftJoin($poetry, "{$poetry}.id", '=', "{$this->table}.id_poetry")
                ->leftJoin('playtopic', "playtopic.student_poetry_id", '=', "{$this->table}.id")
                ->leftJoin('result_capacity', "result_capacity.playtopic_id", '=', "playtopic.id")
                ->where("{$this->table}.id_poetry", $id_poetry)
                ->orderBy("{$this->table}.id")
                ->get();
            return $data;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function GetStudentsResponse($id_poetry)
    {
        try {
            $user = (new User())->getTable();
            $data = $this->model::query()
                ->select(
                    [
                        "{$this->table}.id",
                        "{$user}.name as nameStudent",
                        "{$user}.email as emailStudent",
                        "{$user}.mssv",
                        'result_capacity.scores'
                    ]
                )
                ->leftJoin($user, "{$user}.id", '=', "{$this->table}.id_student")
                ->leftJoin('playtopic', "playtopic.student_poetry_id", '=', "{$this->table}.id")
                ->leftJoin('result_capacity', "result_capacity.playtopic_id", '=', "playtopic.id")
                ->where("{$this->table}.id_poetry", $id_poetry)
                ->orderBy("{$this->table}.id")
                ->paginate(10);
            $excelData = [];
            foreach ($data as $key => $item) {
                if (isset($item->scores)) {
                    $excelData[] = [
                        $key + 1,
                        $item->nameStudent,
                        $item->emailStudent,
                        $item->mssv,
                        $item->scores,
                        'Ca thi ' . $id_poetry
                    ];
                }
            }
            return $excelData;


        } catch (\Exception $e) {
            return false;
        }
    }

    public function Store()
    {
        try {
            return $this->model::all();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function findUser($email, $poetryStd)
    {
        try {
            $users = User::where('email', $email)->first();
            $role = modelroles::where('model_id', $users->id)->first();
            if ($role->role_id != 3) {
                return 'Người dùng ' . $email . ' Không phải Sinh viên không thể thêm vào lớp';
            }
            $checkStudent = $this->model::where('id_student', $users->id)->where('id_poetry', $poetryStd)->get();
            if (count($checkStudent) >= 1) {
                return 'Người dùng đã tồn tại';
            }
            return $users;
        } catch (\Exception $e) {
            return 'Không tồn tại sinh viên có email là ' . $email;
        }
    }

    public function Item($id)
    {
        try {
            return $this->model::find($id);
        } catch (\exception $e) {
            return $e;
        }
    }

}
