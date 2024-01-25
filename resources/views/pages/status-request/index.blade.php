@extends('layouts.main')
@section('title', "Danh sách yêu cầu mở trạng thái")
@section('page-title', 'Danh sách yêu cầu mở trạng thái')
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
            {{--            <div class="card card-flush p-4">--}}
            {{--            </div>--}}
            <div class="card card-flush p-4">
                <form action="" class="my-5 p-3">
                    <div class="row align-items-end justify-content-end">
                        @hasrole('super admin')
                        <div class="col-5">
                            <label for="" class="form-label">Lọc theo cơ sở</label>
                            <select name="campus_id" id="form-campus"
                                    class="form-select form-select-solid form-select-lg">
                                <option value="">Chọn cơ sở</option>
                                @foreach($campuses as $campus)
                                    <option
                                        value="{{ $campus->id }}"
                                        @selected($campus->id == request()->get('campus_id'))
                                    >
                                        {{ $campus->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endhasrole
                        <div class="col-5">
                            <label for="" class="form-label">Lọc theo học kỳ</label>
                            <select name="semester_id" id="form-semester"
                                    class="form-select form-select-solid form-select-lg">
                                <option value="semester_id">Chọn học kỳ</option>
                                @foreach($semesters as $semester)
                                    <option
                                        value="{{ $semester->id }}"
                                        @selected($semester->id == request()->get('semester_id'))
                                    >{{ $semester->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-secondary">Lọc</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class=" col-12">

                        <h1>
                            Danh sách yêu cầu mở trạng thái
                        </h1>
                    </div>
                </div>

                <div class="table-responsive table-responsive">
                    <table id="table-data" class="table table-row-bordered table-row-gray-300 gy-7  table-hover">
                        <thead>
                        <tr>
                            @hasrole('super admin')
                            <th scope="col">Cơ sở</th>
                            @endhasrole
                            <th scope="col">Học kỳ</th>
                            <th scope="col">Ca thi</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Người yêu cầu</th>
                            <th scope="col">Tạo lúc</th>
                            <th scope="col">Cập nhật lúc</th>
                            <th scope="col">Được mở</th>
                            <th colspan="2"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($statusRequests->count() > 0)
                            @foreach($statusRequests as $key => $value)
                                @php($details = $value->notes->pluck('details')->flatten())
                                <tr>
                                    @hasrole('super admin')
                                    <td>
                                        {{ $campuses->find($value->campus_id)->name }}
                                    </td>
                                    @endhasrole
                                    <td>
                                        {{ $semesters->find($value->semester_id)->name }}
                                    </td>
                                    <td>
                                        {{ $value->poetry_id }}
                                    </td>
                                    <td>
                                        {{ $value->out_of_time ? "Qua giờ thi" : "Đang thi" }}
                                    </td>
                                    <td>
                                        {{ \Str::replaceLast(config('util.END_EMAIL_FPT'), '', $value->user->email) }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($value->created_at)->diffForHumans() }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($value->created_at)->format('H:i d-m-Y') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($value->updated_at)->diffForHumans() }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($value->updated_at)->format('H:i d-m-Y') }}
                                    </td>
                                    <td>
                                        {{ $details->whereNotNull('confirmed_by')->count()  }}/{{ $details->count() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.status-requests.detail', $value->id) }}">
                                            Xem chi tiết
                                        </a>
                                    </td>
                                    <td>
                                        <button
                                            class="btn btn-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-history-{{ $value->id }}"
                                        >
                                            Xem lịch sử
                                        </button>
                                        <div class="modal fade" tabindex="-1" id="modal-history-{{ $value->id }}"
                                             style="display: none;"
                                             aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            Lịch sử thao tác yêu cầu của ca thi {{ $value->poetry_id }}
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        @foreach($value->histories as $index => $history)
                                                            <div class="mb-3">
                                                                <p class="fw-bold m-0 p-0 text-primary">
                                                                    {{ $index + 1 . '.' }} {{ \Carbon\Carbon::parse($history->created_at)->format('H:i d-m-Y') }}
                                                                </p>
                                                                <p>
                                                                    <span class="fw-bold">
                                                                        {{ \Str::replace(config('util.END_EMAIL_FPT'), '', $history->createdBy->email) }}
                                                                    </span>
                                                                    đã thực hiện thao tác
                                                                    <span class="fw-bold">
                                                                        {{ \Str::lower(config('util.STATUS_REQUEST.HISTORY.TYPES')[$history->type]) }}
                                                                    </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
                    @if($statusRequests->count() > 0)
                        <nav>
                            <ul class="pagination">
                                {{ $statusRequests->links() }}
                            </ul>
                        </nav>
                    @endif
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
        let semesters = @json($semesters);

        const campusSelect = $('#form-campus');
        const semesterSelect = $('#form-semester');

        const renderSemesters = (campusId, semesterId = undefined) => {
            let semestersFilter = semesters.filter(semester => semester.id_campus == campusId);

            if (semestersFilter.length == 0) {
                semestersFilter = semesters;
            }

            semesterSelect.html(`<option value="">Chọn học kỳ</option>`);

            let semestersHtml = semestersFilter.map(semester => {
                return `<option value="${semester.id}" ${semesterId && semesterId == semester.id ? 'selected' : ''}>${semester.name}</option>`
            });

            semesterSelect.append(semestersHtml);
        }

        campusSelect.on('change', function () {
            renderSemesters($(this).val());
        });

        let semester_id = "{{ request()->get('semester_id') }}";
        renderSemesters(campusSelect.val(), semester_id);

    </script>
@endsection

