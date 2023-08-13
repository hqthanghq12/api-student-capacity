<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\User;
use App\Models\modelroles;
use App\Services\Modules\MContest\MContestInterface;
use App\Services\Modules\MUser\MUserInterface;
use App\Services\Traits\TCheckUserDrugTeam;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Google\Service\Script\Content;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Spatie\Permission\Models\Role;
use App\Models\ResultCapacity;
use App\Models\playtopic;
use App\Services\Modules\MSemeter\Semeter;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\branches;
use App\Models\Campus;

class UserController extends Controller
{
    use TUploadImage, TCheckUserDrugTeam, TResponse;


    public function __construct(
        private MUserInterface    $user,
        private MContestInterface $contest,
        private User              $modeluser,
        private Role              $role,
        private ResultCapacity    $resultCap,
        private playtopic         $playtopic,
        private Semeter           $interfaceSemeter,
        private branches          $branches,
        private Campus            $campus
    )
    {
    }

    public function TeamUserSearch(Request $request)
    {

        try {
            $usersNotTeam = User::where('status', config('util.ACTIVE_STATUS'))->pluck('id');
            $usersTeamNot = $this->checkUserDrugTeam($request->id_contest, $usersNotTeam);

            $users = User::select('id', 'name', 'email', 'avatar')
                ->search($request->key, ['name', 'email'])
                ->whereIn('id', $usersTeamNot['user-pass'])
                ->limit(5)->get();
            return response()->json([
                'status' => true,
                'payload' => $users,
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }


    public function list(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $pageNumber = $request->has('page') ? intval($request->page) : 1;
        $pageSize = $request->has('pageSize') ? intval($request->pageSize) : config('util.DEFAULT_PAGE_SIZE');
        $status = $request->has('status') ? $request->status : config('util.ACTIVE_STATUS');
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";

        $query = User::with('roles')->where(function ($q) use ($keyword) {
            return $q->where('name', 'like', "%" . $keyword . "%")
                ->orWhere("email", 'like', "%" . $keyword . "%");
        })->where('status', $status);

        if ($request->has('roleId')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('id', $request->roleId);
            });
        }

        $offset = ($pageNumber - 1) * $pageSize;
        $totalItem = $query->count();
        if ($sortBy == 'desc') {
            $query = $query->orderByDesc($orderBy);
        } else {
            $query = $query->orderBy($orderBy);
        }

        $responseData = $query->skip($offset)->take($pageSize)->get();
        return response()->json([
            'status' => true,
            'payload' => [
                'data' => $responseData,
                'pagination' => [
                    'currentPage' => $pageNumber,
                    'pageSize' => $pageSize,
                    'totalItem' => $totalItem,
                    'totalPage' => ceil($totalItem / $pageSize)
                ]
            ]
        ]);
    }

    public function Listpoint($id)
    {
        $user = DB::table('users')->find($id);
        $subjectIdToSubjectInfo = DB::table('subject')->select('id', 'name', 'code_subject')->get()->keyBy('id')->toArray();
        $subjectIdToSubjectName = collect($subjectIdToSubjectInfo)->pluck('name', 'id')->toArray();
        $subjectIdToSubjectCode = collect($subjectIdToSubjectInfo)->pluck('code_subject', 'id')->toArray();

        $campusCodeToCampusName = DB::table('campuses')->select('id', 'name')->pluck('name', 'id')->toArray();
        $examinationIdToExaminationName = DB::table('examination')->select('id', 'name')->pluck('name', 'id')->toArray();
        $classIdToClassName = DB::table('class')->select('id', 'name')->pluck('name', 'id')->toArray();
        $semesterIdToSemesterName = DB::table('semester')->select('id', 'name')->pluck('name', 'id')->toArray();

        $point = $this->playtopic
            ->query()
            ->select([
                'playtopic.exam_name',
                'block_subject.id_subject',
                'poetry.id_semeter',
                'playtopic.exam_time',
                'poetry.id_class',
                'result_capacity.scores',
                'result_capacity.created_at',
                'result_capacity.updated_at',
            ])
            ->join('student_poetry', 'student_poetry.id', '=', 'playtopic.student_poetry_id')
            ->join('poetry', 'poetry.id', '=', 'student_poetry.id_poetry')
            ->join('block_subject', 'block_subject.id', '=', 'poetry.id_block_subject')
            ->join('result_capacity', 'result_capacity.playtopic_id', '=', 'playtopic.id')
            ->where('student_poetry.id_student', $id)
            ->get();
//        dd($campusCodeToCampusName);
        foreach ($point as $item) {
            $item->semester_name = $semesterIdToSemesterName[$item->id_semeter];
            $item->campus_name = $campusCodeToCampusName[$user->campus_id];
            $item->class_name = $classIdToClassName[$item->id_class];
            $item->examination_name = $item->exam_time;
            $item->subject_name = $subjectIdToSubjectName[$item->id_subject];
            $item->subject_code = $subjectIdToSubjectCode[$item->id_subject];
        }



//        $point = $this->playtopic->where('id_user', $id)->get();
        return view('pages.Students.accountStudent.viewpoint', ['point' => $point, 'user' => $user, 'id' => $id]);
    }

    public function Exportpoint($id_user)
    {
        $subjectIdToSubjectInfo = DB::table('subject')->select('id', 'name', 'code_subject')->get()->keyBy('id')->toArray();
        $subjectIdToSubjectName = collect($subjectIdToSubjectInfo)->pluck('name', 'id')->toArray();
        $subjectIdToSubjectCode = collect($subjectIdToSubjectInfo)->pluck('code_subject', 'id')->toArray();

        $campusCodeToCampusName = DB::table('campuses')->select('id', 'name')->pluck('name', 'id')->toArray();
        $examinationIdToExaminationName = DB::table('examination')->select('id', 'name')->pluck('name', 'id')->toArray();
        $classIdToClassName = DB::table('class')->select('id', 'name')->pluck('name', 'id')->toArray();
        $semesterIdToSemesterName = DB::table('semester')->select('id', 'name')->pluck('name', 'id')->toArray();

        $point = $this->playtopic
            ->query()
            ->select([
                'playtopic.exam_name',
                'block_subject.id_subject',
                'poetry.id_semeter',
                'playtopic.exam_time',
                'poetry.id_class',
                'result_capacity.scores',
                'result_capacity.created_at',
                'result_capacity.updated_at',
            ])
            ->join('student_poetry', 'student_poetry.id', '=', 'playtopic.student_poetry_id')
            ->join('poetry', 'poetry.id', '=', 'student_poetry.id_poetry')
            ->join('block_subject', 'block_subject.id', '=', 'poetry.id_block_subject')
            ->join('result_capacity', 'result_capacity.playtopic_id', '=', 'playtopic.id')
            ->where('student_poetry.id_student', $id_user)
            ->get();
        $user = DB::table('users')->find($id_user);
//        dd($user);
        $data = [];
        foreach ($point as $key => $value) {
//            $resultCapacity = $value->userStudent->resultCapacity->where('exam_id',$value->id_exam)->first();
//            if(isset($resultCapacity->scores) && $resultCapacity->scores  !== null){
            if (isset($value->scores)) {
                $data[] = [
                    $key + 1,
                    $subjectIdToSubjectCode[$value->id_subject],
                    $semesterIdToSemesterName[$value->id_semeter],
                    $classIdToClassName[$value->id_class],
                    $value->scores,
                    1,
                    $value->scores > 5 ? 'Đạt' : 'Không đạt'
                ];
            }
        }
        $spreadsheet = new Spreadsheet();
        // Thực hiện xử lý dữ liệu
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'TT');
        $sheet->setCellValue('B1', 'Mã Môn');
        $sheet->setCellValue('C1', 'Môn Học');
        $sheet->setCellValue('D1', 'Lớp');
        $sheet->setCellValue('E1', 'Điểm');
        $sheet->setCellValue('F1', 'Lần học');
        $sheet->setCellValue('G1', 'Trạng thái');
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $row = 2;
        $column = 1;
        foreach ($data as $recordata) {
            foreach ($recordata as $value) {
                $sheet->setCellValueByColumnAndRow($column, $row, $value);
                $sheet->getStyleByColumnAndRow($column, $row)->applyFromArray($borderStyle);
                $column++;
            }
            $row++;
            $column = 1;
        }
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        // Định dạng căn giữa và màu nền cho hàng tiêu đề
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');

        $writer = new Xlsx($spreadsheet);
        $outputFileName = 'diem_thi_cua_sinh_vien_' . $user->name . '_' . $user->mssv . '.xlsx';
        $writer->save($outputFileName);
        return response()->download($outputFileName)->deleteFileAfterSend(true, $outputFileName);
    }

    private function getStudents()
    {
        try {
            $limit = 10;
            $users = $this->modeluser::status(request('status') ?? null)
                ->sort(request('sort') == 'asc' ? 'asc' : 'desc', request('sort_by') ?? null, 'users')
                ->search(request('q') ?? null, ['name', 'email'])
                ->has_role(request('role') ?? null)
                ->paginate(request('limit') ?? $limit);

            return $users;
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function getUser()
    {
        try {
            $limit = 10;
            $usersQuery = $this->modeluser::status(request('status') ?? null)
                ->sort(request('sort') == 'asc' ? 'asc' : 'desc', request('sort_by') ?? null, 'users')
                ->with('roles', function ($query) {
                    $query->orderBy('id', 'asc');
                })
                ->search(request('q') ?? null, ['name', 'email'])
                ->has_role(request('role') ?? null)
                ->where('id', '<>', auth()->user()->id)
                ->whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'student');
                });
            if (!auth()->user()->hasRole('super admin')) {
                $usersQuery
                    ->where('campus_id', auth()->user()->campus_id)
                    ->whereDoesntHave('roles', function ($query) {
                        $query->where('name', 'super admin');
                    });
            }
            $users = $usersQuery->paginate(request('limit') ?? $limit);

            return $users;
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function getStudent()
    {
        try {
            $limit = 10;
            $users = $this->modeluser::sort(request('sort') == 'asc' ? 'asc' : 'desc', request('sort_by') ?? null, 'users')
                ->search(request('q') ?? null, ['name', 'email'])
                ->has_role('student')
                ->paginate(request('limit') ?? $limit);
            return $users;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function index()
    {
        if (!$users = $this->getUser()) return response()->json(
            [
                'status' => false,
                'payload' => 'Trang không tồn tại !'
            ],
            404
        );
        $users = array_merge(
            $users->toArray(),
            [
                'roles' => Role::all()
                    ->map(function ($role) {
                        return [
                            'value' => $role->id,
                            'slug_name' => \Str::slug($role->name, " "),
                            'name' => \Str::title($role->name),
                        ];
                    })
            ]
        );
        return response()->json(
            [
                'status' => true,
                'payload' => $users
            ],
            200
        );
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name_add' => 'required',
                'email_add' => 'required|unique:users,email',
                'branches_id' => 'required',
                'campus_id' => 'required',
                'status' => 'required',
                'roles_id' => 'required|numeric|min:1',
            ],
            [
                'name_add.required' => 'Không để trống tên tài khoản!',
                'email_add.required' => 'Không để trống email!',
                'email_add.unique' => 'Email này đã tồn tại',
                'branches_id.required' => 'Vui lòng chọn Chi nhánh!',
                'campus_id.required' => 'Vui lòng chọn cơ sở!',
                'roles_id.required' => 'Vui lòng chọn chức vụ cho tài khoản!',
                'status.required' => 'Vui lòng chọn trạng thái!',
                'roles_id.min' => 'Vui lòng chọn chức vụ',
            ]
        );
        if ($validator->fails() == 1) {
            $errors = $validator->errors();
            $fields = ['name_add', 'email_add', 'branches_id', 'campus_id', 'roles_id', 'status'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error, 404);
                    }
                }
            }

        }
        if (!auth()->user()->hasRole('super admin')) {
            if ($request->campus_id !== auth()->user()->campus_id) {
                return response('Bạn không có quyền thêm tài khoản vào cơ sở này', 404);
            }
            if ($request->roles_id <= auth()->user()->roles[0]->id) {
                return response('Bạn không có quyền thêm tài khoản với chức vụ ngang hoặc lớn hơn mình', 404);
            }
        }
        $data = [
            'name' => $request->name_add,
            'email' => $request->email_add,
            'avatar' => NULL,
            'status' => $request->status,
            'mssv' => NULL,
            'branch_id' => $request->branches_id,
            'campus_id' => $request->campus_id
        ];
        DB::table('users')->insert($data);
        $id = DB::getPdo()->lastInsertId();
        DB::table('model_has_roles')->insert(
            [
                'role_id' => $request->roles_id,
                'model_type' => 'App\Models\User',
                'model_id' => $id
            ]
        );
        return response(['message' => "Thành công <br>Vui lòng chờ 5s để làm mới dữ liệu", 'data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name_update' => 'required',
                'email_update' => 'required',
                'branches_id_update' => 'required',
                'campus_id_update' => 'required',
                'status_update_update' => 'required',
                'roles_id_update' => 'required|numeric|min:1',
            ],
            [
                'name_update.required' => 'Không để trống tên tài khoản!',
                'email_update.required' => 'Không để trống email!',
                'branches_id_update.required' => 'Vui lòng chọn Chi nhánh!',
                'campus_id_update.required' => 'Vui lòng chọn cơ sở!',
                'roles_id_update.required' => 'Vui lòng chọn chức vụ cho tài khoản!',
                'status_update_update.required' => 'Vui lòng chọn trạng thái!',
                'roles_id_update.min' => 'Vui lòng chọn chức vụ',
            ]
        );

        if ($validator->fails() == 1) {
            $errors = $validator->errors();
            $fields = ['name_update', 'email_update', 'branches_id_update', 'campus_id_update', 'roles_id_update', 'status_update_update'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error, 404);
                    }
                }
            }

        }
        if (!auth()->user()->hasRole('super admin')) {
            if ($request->campus_id_update != auth()->user()->campus_id) {
                return response('Bạn không có quyền thêm tài khoản vào cơ sở này', 404);
            }
            if ($request->roles_id_update <= auth()->user()->roles[0]->id) {
                return response('Bạn không có quyền thêm tài khoản với chức vụ ngang hoặc lớn hơn mình', 404);
            }
        }
        $user = User::find($id);
        $user->name = $request->name_update;
        $user->email = $request->email_update;
        $user->status = $request->status_update_update;
        $user->branch_id = $request->branches_id_update;
        $user->campus_id = $request->campus_id_update;
        $user->save();

        $role = modelroles::query()
            ->updateOrCreate(
                ['model_id' => $id],
                [
                    'role_id' => $request->roles_id_update,
                    'model_type' => 'App\Models\User',
                    'model_id' => $id,
                ]
            );
        return response(['message' => "Thành công <br>Vui lòng chờ 5s để làm mới dữ liệu"], 200);
    }

    public function edit($id)
    {
        try {
            $user = User::find($id);
            return response()->json([
                'message' => "Thành công",
                'data' => $user,
            ], 200);
        } catch (\Throwable $th) {
            return response(['message' => "Thêm thất bại"], 404);
        }
    }

    public function listStudent()
    {
        $listSemeter = $this->interfaceSemeter->GetSemeter();
        return view('pages.Students.accountStudent.index', ['semeters' => $listSemeter]);
    }

    public function listAdmin()
    {
        if (!$users = $this->getUser()) return abort(404);
        $branches = $this->branches::all();
        $rolesModel = $this->role->query();
        $CampusModel = $this->campus->query();
        if (!auth()->user()->hasRole('super admin')) {
            $rolesModel->where('id', '<>', config('util.SUPER_ADMIN_ROLE'));
            $CampusModel->where('id', auth()->user()->campus_id);
        }
        $roles = $rolesModel->get();
        $Campus = $CampusModel->get();
        $campusIdToCampusName = $Campus->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->all();
        return view('pages.auth.index', ['users' => $users, 'roles' => $roles, 'branches' => $branches, 'campus' => $Campus, 'campusIdToCampusName' => $campusIdToCampusName,]);
    }

    public function stdManagement()
    {
        if (!$users = $this->getStudent()) return abort(404);
        $roles = $this->role::all();
        return view('pages.Students.index', ['users' => $users, 'roles' => $roles]);
    }

    private function checkRole()
    {
        if (auth()->user()->hasAnyRole(['admin', 'super admin'])) return true;
        return false;
    }

    public function un_status($id)
    {
        if (!$this->checkRole()) return response()->json([
            'status' => false,
            'payload' => 'Không thể câp nhật trạng thái !',
        ]);
        try {
            $user = $this->modeluser::find($id);
            $user->update([
                'status' => 0,
            ]);

            return response()->json([
                'status' => true,
                'payload' => 'Success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng thái !',
            ]);
        }
    }

    public function re_status($id)
    {
        if (!$this->checkRole()) return response()->json([
            'status' => false,
            'payload' => 'Không thể câp nhật trạng thái !',
        ]);
        try {
            $user = $this->modeluser::find($id);
            $user->update([
                'status' => 1,
            ]);
            return response()->json([
                'status' => true,
                'payload' => 'Success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng thái !',
            ]);
        }
    }


    public function changeRole(Request $request)
    {

        $data = explode("&&&&", $request->role);

        if (!$role = $this->role::whereName($data[0])->first()) return response()->json([
            'status' => false,
            'payload' => 'Không có quyền  !',
        ]);
        if (!$user = $this->modeluser::find($data[1])) return response()->json([
            'status' => false,
            'payload' => 'Không tìm thấy tài khoản  !',
        ]);
        if (auth()->user()->id == $user->id) return response()->json([
            'status' => false,
            'payload' => 'Không thể câp nhật quyền của chính mình !',
        ]);
        if (auth()->user()->roles[0]->name == 'super admin') {
            $user->syncRoles($role);
        } else {
            if ($role->name == 'super admin') return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật quyền cao hơn mình cho người khác  !',
            ]);
            if ($user->roles[0]->name == 'super admin') return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật quyền cao nhất  !',
            ]);
            $user->syncRoles($role);
        }
        return response()->json([
            'status' => true,
            'payload' => 'Cập nhật thành công  !',
        ]);
    }

    public function get_user_by_token(Request $request)
    {
        return response([
            'status' => true,
            'payload' => $request->user()->toArray()
        ]);
    }
    //    public function add_user(Request $request)
    //    {
    //        // validator
    //        $validator = Validator::make(
    //            $request->all(),
    //            [
    //                'name' => 'required|max:255',
    //                'email' => 'required|email|max:255|unique:users',
    //            ],
    //            [
    //                'name.required' => 'Chưa nhập trường này !',
    //                'name.max' => 'Độ dài tên không phù hợp!',
    //
    //                'email.required' => 'Chưa nhập trường này !',
    //                'email.email' => 'Không đúng định dạng email !',
    //                'email.max' => 'Độ dài email không phù hợp!',
    //                'email.unique' => 'Email đã tồn tại!',
    //            ]
    //        );
    //        // dd($validator->errors()->toArray());
    //        if ($validator->fails()) {
    //            return response()->json([
    //                'status' => false,
    //                'payload' => $validator->errors()
    //            ]);
    //        }
    //        DB::beginTransaction();
    //        try {
    //            $model = new User();
    //            $model->fill($request->all());
    //            $model->save();
    //            $role = Role::find($request->role_id);
    //            $model->assignRole($role->name);
    //            DB::commit();
    //        } catch (Exception $ex) {
    //            Log::error("Lỗi tạo tài khoản:");
    //            Log::info("post data: " . json_encode($request->all()));
    //            DB::rollBack();
    //            return response()->json([
    //                'status' => false,
    //                'payload' => $ex->getMessage()
    //            ]);
    //        }
    //        return response()->json([
    //            'status' => true,
    //            'payload' => $model->toArray()
    //        ]);
    //    }

    public function block_user(Request $request, $id)
    {
        if ($request->user()->id == $id) {
            return response()->json([
                'status' => false,
                'payload' => "Không được phép thực hiện hành động này!"
            ], 403);
        }
        $user = User::find($id);
        if ($user) {
            $user->status = config('util.INACTIVE_STATUS');
            $user->save();
            return response()->json([
                'status' => true,
                'payload' => $user
            ]);
        }
        return response()->json([
            'status' => false,
            'payload' => "Không tìm thấy tài khoản"
        ], 404);
    }

    public function updateRoleUser(Request $request, $id)
    {
        $user = $this->modeluser::find($id);
        if (is_null($user)) {
            return response()->json([
                'status' => false,
                'payload' => 'Lỗi tài khoản không tồn tại !'
            ]);
        } else {
            $role = Role::find($request->role_id);
            if (is_null($role)) {
                return response()->json([
                    'status' => false,
                    'payload' => 'Quyền này không tồn tại !'
                ]);
            } else {
                // dd($user->roles()->first());
                $user->syncRoles($role->name);
                return response()->json([
                    'status' => true,
                    'payload' => $user->roles()->get()
                ]);
            }
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/contest-joined-and-not-joined",
     *     description="Description api contests",
     *     tags={"User-Joined-Contest"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Tìm kiếm ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Lọc theo trạng thái ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Lọc theo chiều asc hoặc desc ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Các cột cần lọc  ",
     *         required=false,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function contestJoinedAndNotJoined()
    {
        if (!($data = $this->contest->apiIndex())) return $this->responseApi(false);
        return $this->responseApi(true, $data);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/contest-joined",
     *     description="Description api contests",
     *     tags={"User-Joined-Contest"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Tìm kiếm ",
     *         required=false,
     *     ),
     *       @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Giới hạn hiển thị",
     *         required=false,
     *     ),
     *          @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Trạng thái",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Lọc theo chiều asc hoặc desc ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Các cột cần lọc  ",
     *         required=false,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function contestJoined()
    {
        $contest = $this->user->contestJoined();
        return $this->responseApi(true, $contest);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users/edit",
     *     description="Description api edit user",
     *     tags={"User","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="string",
     *                      property="name",
     *                  ),
     *                  @OA\Property(
     *                      type="file",
     *                      property="avatar",
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function updateDetailUser(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:4|max:50',
            ],
            [
                'name.required' => 'Tên không được bỏ trống !',
                'name.min' => 'Tên không nhỏ hơn 4 ký tự !',
                'name.max' => 'Tên không lớn hơn 50 ký tự !',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'payload' => $validator->errors(),
            ]);
        }
        $user = auth('sanctum')->user();

        if ($request->has('avatar')) {
            $validatorImage = Validator::make(
                $request->all(),
                [
                    'avatar' => 'image|mimes:jpeg,png,jpg|max:10000',
                ],
                [
                    'avatar.image' => 'Ảnh không được bỏ trống  !',
                    'avatar.mimes' => 'Ảnh không đúng định dạng  !',
                    'avatar.max' => 'Ảnh này kích cỡ quá lớn  !',
                ]
            );
            if ($validatorImage->fails()) {
                return response()->json([
                    'status' => false,
                    'payload' => $validatorImage->errors(),
                ]);
            }
            $nameAvatar = $this->uploadFile($request->avatar, $user->avatar ?? '');
            $user->update([
                'name' => $request->name,
                'avatar' => $nameAvatar,
            ]);
            return response()->json([
                'status' => true,
                'payload' => $user,
            ]);
        }
        $user->update([
            'name' => $request->name,
        ]);
        return response()->json([
            'status' => true,
            'payload' => $user,
        ]);
    }
}
