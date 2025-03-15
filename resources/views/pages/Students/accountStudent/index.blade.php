@extends('layouts.main')
@section('title', 'Quản lý sinh viên ')
@section('page-title', 'Quản lý sinh viên ')
@section('content')
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css"/>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="mb-5">
                {{ Breadcrumbs::render('Students' ) }}
            </div>
            <div class="card card-flush p-4">

            <div class="row">
                <div class="col-4">
                    <select class="form-select"  id="semeters" data-control="select2" data-placeholder="Chọn kỳ">
                        <option value=""></option>
                        @foreach($semeters as $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
{{--                <div class="col-4 d-none">--}}
{{--                    <select class="form-select" id="blocks">--}}
{{--                        <option>-- Chọn Block --</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
                <div class="col-4">
                    <select class="form-select" id="subjects" data-placeholder="Chọn môn">
                        <option value="">Chọn Môn</option>
                    </select>
                </div>
                <div class="col-4">
                    <select class="form-select" id="classSubject" data-placeholder="Lớp học">
                        <option value="">Lớp học</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-5 my-4 ">
                </div>
                <div class="col-2 my-4">
                    <button type="button" class="btn btn-primary er fs-6 px-8 py-4" id="searchResult">Tra cứu</button>
                </div>
                <div class="col-2 my-4"></div>
                <div class="col-3 my-4 text-end" id="btnExport">

                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-p-0 card-flush">
                        <div class="card-body">
                            <table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="table-data">
                                <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase">
                                    <th class="min-w-100px">Tên sinh viên</th>
                                    <th class="min-w-100px">Email</th>
                                    <th class="min-w-100px">Mã Sinh viên</th>
                                    <th class="min-w-100px">Cơ sở</th>
                                </tr>
                                <!--end::Table row-->
                                </thead>
                                <tbody class="fw-bold text-gray-600">
{{--                                <tr >--}}
{{--                                    <td>--}}
{{--                                        <a href="#" class="text-dark text-hover-primary">Summer 2023</a>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <a href="#" class="text-dark text-hover-primary">Block 1</a>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <div class="badge badge-light-success">Môn Toán</div>--}}
{{--                                    </td>--}}
{{--                                    <td data-order="2022-03-10T14:40:00+05:00">VIE1026.06</td>--}}
{{--                                    <td class="text-end pe-0">Ca 3</td>--}}
{{--                                    <td class="text-end"><button class="btn btn-primary er fs-6 px-4 py-2">Xem Thêm</button></td>--}}
{{--                                </tr>--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
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
                autotimeout: 3000,
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
        const _token = "{{ csrf_token() }}";
        let selectSemeter = document.querySelector('#semeters');
        const start_time =
            '{{ request()->has('start_time') ? \Carbon\Carbon::parse(request('start_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
        const end_time =
            '{{ request()->has('end_time') ? \Carbon\Carbon::parse(request('end_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
    </script>
    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script src="assets/js/system/auth/auth.js"></script>
    <script src="{{ asset('assets/js/system/ManageStudent/students.js') }}"></script>
@endsection
