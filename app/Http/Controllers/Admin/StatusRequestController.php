<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatusRequest;
use App\Models\StatusRequestDetail;
use App\Models\StatusRequestHistory;
use App\Models\StatusRequestNote;
use App\Models\studentPoetry;
use App\Services\Modules\MCampus\Campus;
use App\Services\Modules\MExamination\Examination;
use App\Services\Modules\MSemeter\Semeter;
use App\Services\Traits\TResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StatusRequestController extends Controller
{
    use TResponse;

    //

    public function __construct(
        private StatusRequest        $statusRequest,
        private StatusRequestNote    $statusRequestNote,
        private StatusRequestDetail  $statusRequestDetail,
        private StatusRequestHistory $statusRequestHistory,
        private Examination          $examination,
        private Campus               $campus,
        private Semeter              $semeter,
        private studentPoetry        $studentPoetry,
    )
    {
    }

    public function index()
    {

        $examination = $this->examination->getList();

        $statusRequestsQuery = $this->statusRequest::with([
            'poetry',
            'notes:id,status_request_id,note,created_at',
            'notes.details:id,status_request_note_id,student_poetry_id,confirmed_by',
            'histories' => function ($query) {
                $query->select('id', 'status_request_id', 'type', 'created_at', 'created_by')->orderByDesc('created_at');
            },
            'histories.createdBy:id,name,email',
        ]);

        if (auth()->user()->hasRole('admin')) {
            $statusRequestsQuery->where('campus_id', auth()->user()->campus_id);
        } elseif (request()->has('campus_id') && !empty(request()->campus_id)) {
            $statusRequestsQuery->where('campus_id', request()->campus_id);
        }

        if (request()->has('semester_id') && !empty(request()->semester_id)) {
            $statusRequestsQuery->where('semester_id', request()->semester_id);
        }

        $semesters = $this->semeter->getList()->select('id', 'name', 'id_campus')->get();

        $campuses = [];

        if (auth()->user()->hasRole('super admin')) {
            $campuses = $this->campus->getList()::query()->select('id', 'name')->get();
        }

        $statusRequests = $statusRequestsQuery
            ->paginate();

        foreach ($statusRequests as $statusRequest) {
            $examDate = $statusRequest->poetry->exam_date;

            $start = Carbon::make($examDate . ' ' . $examination->find($statusRequest->poetry->start_examination_id)->started_at);
            $end = Carbon::make($examDate . ' ' . $examination->find($statusRequest->poetry->finish_examination_id)->finished_at);

            $statusRequest->out_of_time = !Carbon::now()->isBetween($start, $end);

        }

        return view('pages.status-request.index', compact('statusRequests', 'campuses', 'semesters'));

    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'semester_id' => 'required|integer|exists:semester,id',
            'campus_id' => 'required|integer|exists:campuses,id',
            'poetry_id' => 'required|integer|exists:poetry,id',
//            'note' => 'required|string',
            'statusRequestDetail' => 'required|array',
            'created_by' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->responseApi(false, $validator->errors()->first(), 400);
        }

        try {
            $statusRequest = $this->statusRequest::where([
                'campus_id' => $request->campus_id,
                'poetry_id' => $request->poetry_id,
            ])->first();

            DB::beginTransaction();

            $statusRequestDetail = $request->statusRequestDetail;

            if ($statusRequest) {
                $statusRequestNoteIds = $statusRequest->notes()->pluck('id')->toArray();

                $studentPoetryIdsRequest = collect($request->statusRequestDetail)->pluck('student_poetry_id');

                $studentPoetryIds = $this->statusRequestDetail::query()
                    ->whereIn('status_request_note_id', $statusRequestNoteIds)
                    ->whereIn('student_poetry_id', $studentPoetryIdsRequest)
                    ->pluck('student_poetry_id')
                    ->toArray();

                $studentPoetryIdsRequest = $studentPoetryIdsRequest->diff($studentPoetryIds)->toArray();

                $statusRequestDetail = collect($statusRequestDetail)->filter(function ($item) use ($studentPoetryIdsRequest) {
                    return in_array($item['student_poetry_id'], $studentPoetryIdsRequest);
                })->toArray();

                if (count($statusRequestDetail) <= 0) {
                    return $this->responseApi(false, 'Yêu cầu đã tồn tại', 400);
                }

                $statusRequest->updated_at = Carbon::now();

                $statusRequest->save();

            } else {
                $statusRequest = $this->statusRequest::create([
                    'semester_id' => $request->semester_id,
                    'campus_id' => $request->campus_id,
                    'poetry_id' => $request->poetry_id,
                    'created_by' => $request->created_by,
                ]);

            }

            $statusRequestNote = $statusRequest->notes()->create([
//                'note' => $request->note,
            ]);

            $statusRequestNote->details()->createMany($statusRequestDetail);

            $statusRequest->histories()->create([
                'type' => config('util.STATUS_REQUEST.HISTORY.TYPE_KEYS.CREATE'),
                'created_by' => $statusRequest->created_by,
            ]);

            DB::commit();

            event(new \App\Events\StatusRequestCreateEvent($statusRequest, $statusRequestNote));

            return $this->responseApi(true, 'Gửi yêu cầu thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            $error = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
            return $this->responseApi(false, $error, 500);
        }
    }

    public function detail($id)
    {
        $statusRequest = $this->statusRequest::with([
            'poetry',
            'notes' => function ($query) {
                $query->select('id', 'status_request_id', 'note', 'created_at')->orderByDesc('created_at');
            },
            'notes.details' => function ($query) {
                $query->select('id', 'status_request_note_id', 'student_poetry_id', 'confirmed_by', 'note');
                if (request()->has('email')) {
                    $query->whereHas('studentPoetry.userStudent', function ($query) {
                        $query->where('email', 'like', '%' . request()->email . '%');
                    });
                }
            },
            'histories:id,status_request_id,type,created_at,created_by',
            'notes.details.user:id,name,email'
        ])->find($id);

        $semester = $this->semeter->find($statusRequest->semester_id);

        $block = $semester->blocks()->select('id', 'name')->where('name', 'Block 1')->first();

        if (!$statusRequest) {
            return redirect()->route('admin.status-request.index')->with('error', 'Không tìm thấy yêu cầu');
        }

        $examination = $this->examination->getList();

        $studentPoetries = $this->studentPoetry::with([
            'userStudent:id,name,email,mssv',
        ])
            ->whereIn('id', $statusRequest->notes->pluck('details')->flatten()->pluck('student_poetry_id'))
            ->get();

        $examDate = $statusRequest->poetry->exam_date;

        $start = Carbon::make($examDate . ' ' . $examination->find($statusRequest->poetry->start_examination_id)->started_at);
        $end = Carbon::make($examDate . ' ' . $examination->find($statusRequest->poetry->finish_examination_id)->finished_at);

        $statusRequest->out_of_time = !(Carbon::now()->isBetween($start, $end));

        return view('pages.status-request.detail', compact('statusRequest', 'studentPoetries', 'semester', 'block', 'start', 'end'));
    }

    public function approve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'statusRequestDetail' => 'required|array',
            'confirmed_by' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->responseApi(false, $validator->errors()->first(), 400);
        }

        try {
            $statusRequest = $this->statusRequest::with([
                'poetry',
                'notes:id,status_request_id,note,created_at',
                'notes.details:id,status_request_note_id,student_poetry_id,confirmed_by',
                'histories:id,status_request_id,type,created_at,created_by',
            ])->find($id);

            if (!$statusRequest) {
                return $this->responseApi(false, 'Không tìm thấy yêu cầu', 404);
            }

            $statusRequestDetail = collect($request->statusRequestDetail);

            $statusRequestDetailIds = $statusRequestDetail->pluck('id')->toArray();

            $studentPoetryIdsRequest = $statusRequestDetail->pluck('student_poetry_id');

            $this->statusRequestDetail::query()
                ->whereIn('id', $statusRequestDetailIds)
                ->update([
                    'confirmed_by' => $request->confirmed_by,
                    'updated_at' => Carbon::now(),
                ]);

            $this->studentPoetry::query()
                ->whereIn('id', $studentPoetryIdsRequest)
                ->update([
                    'status' => '1',
                    'updated_at' => Carbon::now(),
                ]);

            $statusRequest->histories()->create([
                'type' => config('util.STATUS_REQUEST.HISTORY.TYPE_KEYS.APPROVE'),
                'created_by' => $request->confirmed_by,
            ]);

            return $this->responseApi(true, 'Duyệt yêu cầu thành công');

        } catch (\Exception $e) {
            $error = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
            return $this->responseApi(false, $error, 500);
        }
    }

    public function listApi()
    {
        $statusRequestsQuery = $this->statusRequest::with([
//            'poetry',
//            'notes:id,status_request_id,note,created_at',
//            'notes.details:id,status_request_note_id,student_poetry_id,confirmed_by',
            'user:id,name,email',
            'campus:id,name',
//            'histories' => function ($query) {
//                $query->select('id', 'status_request_id', 'type', 'created_at', 'created_by')->orderByDesc('created_at');
//            },
//            'histories.createdBy:id,name,email',
        ])
            ->select('id', 'campus_id', 'created_at', 'created_by', 'updated_at')
            ->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
            ->orderByDesc('updated_at');

        if (auth()->user()->hasRole('admin')) {
            $statusRequestsQuery->where('campus_id', auth()->user()->campus_id);
        } elseif (request()->has('campus_id')) {
            $statusRequestsQuery->where('campus_id', request()->campus_id);
        }

        $statusRequests = $statusRequestsQuery->get()->map(function ($item) {
            $item->update_at = Carbon::parse($item->updated_at)->format('H:i');
            $item->created_by = Str::replace(config('util.END_EMAIL_FPT'), '', $item->user->email);
            $item->link = route('admin.status-requests.detail', $item->id);
            return $item;
        });

//        foreach ($statusRequests as $statusRequest) {
//            $examDate = $statusRequest->poetry->exam_date;
//
//            $start = Carbon::make($examDate . ' ' . $statusRequest->poetry->start_examination->started_at);
//            $end = Carbon::make($examDate . ' ' . $statusRequest->poetry->finish_examination->finished_at);
//
//            $statusRequest->out_of_time = !Carbon::now()->isBetween($start, $end);
//
//        }

        return $this->responseApi(true, $statusRequests);
    }
}
