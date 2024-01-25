@extends('layouts.main')
@section('title', "Yêu cầu mở trạng thái cho ca thi số " . $statusRequest->poetry_id)
@section('page-title', 'Danh sách sinh viên cần mở trạng thái')
@section('content')
    <style>
        .tag-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .tag {
            display: flex;
            align-items: center;
            background-color: #f2f2f2;
            border-radius: 5px;
            padding: 5px;
            margin: 2px;
        }

        .tag-label {
            margin-right: 5px;
        }

        .tag-close {
            cursor: pointer;
        }

        .tag-input {
            height: 30px;
            padding: 5px;
        }
    </style>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css"/>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="mb-5">
                {{--                {{ Breadcrumbs::render('manageSemeter',['id' => $id,'id_poetry' => $id_poetry,'id_block' => $idBlock]) }}--}}
            </div>
            <div class="card card-flush p-4">
                <form action="" class="my-5 p-3">
                    <label for="email">Tìm kiếm theo email</label>
                    <div class="row">
                        <div class="col-10">
                            <input type="search" name="email" id="" class="form-control col-9"
                                   value="{{ request('email') ?? '' }}">
                        </div>
                        <div class="col-2">
                            <button class="btn btn-secondary">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <div>
                            <h1>
                                Danh sách sinh viên yêu cầu mở trạng thái cho ca thi số
                                <a
                                    href="{{ route('admin.poetry.manage.index', ['id' => $statusRequest->poetry_id, 'id_poetry' => $semester->id, 'id_block' => $block->id]) }}"
                                    target="_blank"
                                    class="text-decoration-underline"
                                >
                                    {{ $statusRequest->poetry_id }}
                                </a>
                                @if($statusRequest->out_of_time)
                                    <span class="badge badge-light-danger">
                                    Ca thi này đã hết hạn xác nhận
                                </span>
                                @endif
                            </h1>
                            <div>
                                Ca: {{ $statusRequest->poetry->start_examination_id }} | Ngày: {{ \Carbon\Carbon::parse($statusRequest->poetry->exam_date)->format('d-m-Y') }} | {{ $start->format('H:i') }} - {{ $end->format('H:i') }}
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="{{ route('admin.status-requests.list') }}" class="btn btn-secondary mx-3">Quay
                                lại</a>
                            @if($statusRequest->notes->pluck('details')->flatten()->whereNull('confirmed_by')->count() > 0 && !$statusRequest->out_of_time)
                                <button class="btn btn-primary" id="btn-confirm">Xác nhận</button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="table-responsive table-responsive">
                    <table id="table-data" class="table table-row-bordered table-row-gray-300 gy-7  table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th scope="col">Tên sinh viên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Mã sinh viên</th>
                            <th scope="col">Ghi chú</th>
                            <th scope="col">Xác nhận bởi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($statusRequest->notes->count() > 0)
                            @foreach($statusRequest->notes as $key => $note)
                                @if($note->details->count() > 0)
                                    <tr>
                                        <td colspan="7">
                                        <span class="fw-bold">
                                            {{ Carbon\Carbon::parse($note->created_at)->format('H:i d-m-Y') }}:
                                            {{ $note->note }}
                                        </span>
                                        </td>
                                    </tr>
                                    @foreach($note->details as $detail)
                                        @php($student = $studentPoetries->find($detail->student_poetry_id))
                                        <tr>
                                            <td>
                                                @if(!$detail?->user && !$statusRequest->out_of_time)
                                                    <input type="checkbox" checked
                                                           class="form-check-input checkbox-student-request"
                                                           data-id="{{ $detail->id }}" name="" id="">
                                                    <input type="hidden" class="student-poetry-id"
                                                           value="{{ $detail->student_poetry_id }}">
                                                @endif
                                            </td>
                                            <td>
                                                {{ $student->userStudent->name }}
                                            </td>
                                            <td>
                                                {{ $student->userStudent->email }}
                                            </td>
                                            <td>
                                                {{ $student->userStudent->mssv }}
                                            </td>
                                            <td>
                                                {{ $detail->note }}
                                            </td>
                                            <td>
                                                {{ $detail?->user ? \Str::replace(config('util.END_EMAIL_FPT'), '', $detail->user->email) : 'Chưa xác nhận' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        @else
                            <tr id="error_null">
                                <td colspan="10">
                                    <h1 class="text-center">Không có yêu cầu nào</h1>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
@endsection
@section('page-script')
    <script>

        function notify(message) {
            new Notify({
                status: 'success',
                title: 'Thành công',
                text: `${message}`,
                effect: 'fade',
                speed: 300,
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 5000,
                gap: 20,
                distance: 20,
                type: 1,
                position: 'right top'
            })
        }

        function wanrning(message) {
            new Notify({
                status: 'warning',
                title: 'Đang chạy',
                text: `${message}`,
                effect: 'fade',
                speed: 300,
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 3000,
                gap: 20,
                distance: 20,
                type: 1,
                position: 'right top'
            })
        }

        function errors(message) {
            new Notify({
                status: 'error',
                title: 'Lỗi',
                text: `${message}`,
                effect: 'fade',
                speed: 300,
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 3000,
                gap: 20,
                distance: 20,
                type: 1,
                position: 'right top'
            })
        }

        function formatDate(DateValue) {

            var date = new Date(DateValue);

            var day = date.getDate();
            var month = date.getMonth() + 1; // Ghi chú: Tháng bắt đầu từ 0 (0 = tháng 1)
            var year = date.getFullYear();

            const formattedDate = day + "-" + month + "-" + year;
            return formattedDate;
        }

        const _token = "{{ csrf_token() }}";

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script>
        const btnConfirm = $('#btn-confirm');

        let statusRequestDetail = $('.checkbox-student-request:checked').map(function () {
            return {
                id: $(this).attr('data-id'),
                student_poetry_id: $(this).parent().parent().find('.student-poetry-id').val()
            };
        }).get();

        for (const ele of $('.checkbox-student-request')) {
            ele.addEventListener('click', (e) => {
                statusRequestDetail = $('.checkbox-student-request:checked').map(function () {
                    return {
                        id: $(this).attr('data-id'),
                        student_poetry_id: $(this).parent().parent().find('.student-poetry-id').val()
                    };
                }).get();
                if (statusRequestDetail.length > 0) {
                    btnConfirm.prop('disabled', false);
                } else {
                    btnConfirm.prop('disabled', true);
                }

            })
        }

        btnConfirm.on('click', function () {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xác nhận?',
                text: "Sau khi xác nhận, bạn sẽ không thể hoàn tác lại điều này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',

                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.status-requests.approve', $statusRequest->id) }}",
                        method: "POST",
                        data: {
                            _token,
                            statusRequestDetail,
                            confirmed_by: "{{ auth()->user()->id }}"
                        },
                        success: function (data) {
                            if (data.status) {
                                notify(data.payload);
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                errors(data.message);
                            }
                        },
                        error: function (err) {
                            errors('Đã có lỗi xảy ra, vui lòng thử lại sau');
                        }
                    })
                }
            })
        })
    </script>
@endsection

