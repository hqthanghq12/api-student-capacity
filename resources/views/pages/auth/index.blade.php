@extends('layouts.main')
@section('title', 'Quản lý tài khoản ')
@section('page-title', 'Quản lý tài khoản ')
@section('content')
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css"/>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
    <div class="card card-flush p-4">
        <div>
            <div class="alert alert-primary">
                Xin chào {{ auth()->user()->name }} , bạn thuộc quyền
                {{ \Str::ucfirst(auth()->user()->roles[0]->name == 'super admin' ? 'Admin HO' : auth()->user()->roles[0]->name)  }}
                @if (!auth()->user()->hasRole('super admin'))
                    cơ sở {{ auth()->user()->campus->name }}
                @endif
                <span data-bs-toggle="tooltip" title="Tải lại trang " role="button"
                      class="refresh-btn svg-icon svg-icon-primary svg-icon-2x">
                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Update.svg--><svg
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path
                                d="M8.43296491,7.17429118 L9.40782327,7.85689436 C9.49616631,7.91875282 9.56214077,8.00751728 9.5959027,8.10994332 C9.68235021,8.37220548 9.53982427,8.65489052 9.27756211,8.74133803 L5.89079566,9.85769242 C5.84469033,9.87288977 5.79661753,9.8812917 5.74809064,9.88263369 C5.4720538,9.8902674 5.24209339,9.67268366 5.23445968,9.39664682 L5.13610134,5.83998177 C5.13313425,5.73269078 5.16477113,5.62729274 5.22633424,5.53937151 C5.384723,5.31316892 5.69649589,5.25819495 5.92269848,5.4165837 L6.72910242,5.98123382 C8.16546398,4.72182424 10.0239806,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 L6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C10.6885336,6 9.44767246,6.42282109 8.43296491,7.17429118 Z"
                                fill="#000000" fill-rule="nonzero"/>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </div>
            <div class="row">
                <div class="col-12 text-end">
                    <label data-bs-toggle="modal" data-bs-target="#kt_modal_1" type="button"
                           class="btn btn-light-primary me-3" id="kt_file_manager_new_folder">

                        <!--end::Svg Icon-->Thêm tài khoản
                    </label>
                </div>
            </div>
        </div>

        <div class="row card-format">

            <div class=" col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="   form-group ">
                    <label class="form-label">Lọc theo quyền </label>
                    <select id="select-role" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                            data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option value="0">Chọn quyền</option>
                        @foreach ($roles as $role)
                            <option
                                @selected(request('role') == $role->name) value="{{ $role->name }}">{{ $role->name == "super admin" ? "Admin HO" : $role->name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="form-group">
                    <label class="form-label">Tình trạng </label>
                    <select id="select-status" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                            data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option value="3" @selected(!request()->has('status'))>Chọn tình trạng</option>
                        <option @selected(request('status') == 1) value="1">Kích hoạt
                        </option>
                        <option @selected(request()->has('status') && request('status') == 0) value="0">Không kích hoạt
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="  form-group">
                    <label class="form-label">Tìm kiếm </label>
                    <input type="text" value="{{ request('q') ?? '' }}" placeholder="*Enter tìm kiếm ..."
                           class=" ip-search form-control">
                </div>
            </div>

        </div>

        <div>
            <div class="back">

                <span data-bs-toggle="tooltip" title="Đóng lọc" class="btn-hide svg-icon svg-icon-primary svg-icon-2x">
                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Stockholm-icons/Navigation/Angle-up.svg--><svg
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"/>
                            <path
                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                fill="#000000" fill-rule="nonzero"/>
                        </g>
                    </svg>
                </span>

                <span data-bs-toggle="tooltip" title="Mở lọc" class="btn-show svg-icon svg-icon-primary svg-icon-2x">
                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Angle-down.svg--><svg
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"/>
                            <path
                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                fill="#000000" fill-rule="nonzero"
                                transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999) "/>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>

            </div>
        </div>


        <div class="table-responsive table-responsive-md">
            <table class="table table-row-bordered table-row-gray-300 gy-7  table-hover ">
                <thead>
                <tr>
                    <th>
                        Tên tài khoản
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Cơ sở
                    </th>
                    <th>Tình trạng</th>
                    <th>Quyền</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $key => $user)
                    <tr>
                        <td>
                            {{ $user->name }}
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            {{ $campusIdToCampusName[$user->campus_id] }}
                        </td>
                        {{-- @if (count($user->roles) > 0) --}}
                        <td>
                            @if (count($user->roles) > 0 && ($user->roles[0]->name == 'super admin' || auth()->user()->roles[0]->id == $user->roles[0]->id))
                                <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Stop.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                       fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24"
                                                              height="24"/>
                                                        <path
                                                            d="M12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 Z M12,20 C16.418278,20 20,16.418278 20,12 C20,7.581722 16.418278,4 12,4 C7.581722,4 4,7.581722 4,12 C4,16.418278 7.581722,20 12,20 Z M19.0710678,4.92893219 L19.0710678,4.92893219 C19.4615921,5.31945648 19.4615921,5.95262146 19.0710678,6.34314575 L6.34314575,19.0710678 C5.95262146,19.4615921 5.31945648,19.4615921 4.92893219,19.0710678 L4.92893219,19.0710678 C4.5384079,18.6805435 4.5384079,18.0473785 4.92893219,17.6568542 L17.6568542,4.92893219 C18.0473785,4.5384079 18.6805435,4.5384079 19.0710678,4.92893219 Z"
                                                            fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                    </g>
                                                </svg>
                                    <!--end::Svg Icon-->
                                            </span>
                                {{ $user->status == 1 ? 'Hoạt động ' : 'Đã gỡ ' }}
                            @else
                                <div data-bs-toggle="tooltip" title="Cập nhât trạng thái "
                                     class="form-check form-switch">
                                    <input value="{{ $user->status }}" data-id="{{ $user->id }}"
                                           class="form-select-status form-check-input"
                                           @checked($user->status == 1) type="checkbox" role="switch">
                                </div>
                            @endif
                        </td>
                        <td>
                            @if (count($user->roles) > 0 && ($user->roles[0]->name == 'super admin' || auth()->user()->id == $user->id))
                                <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Stop.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                       fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24"
                                                              height="24"/>
                                                        <path
                                                            d="M12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 Z M12,20 C16.418278,20 20,16.418278 20,12 C20,7.581722 16.418278,4 12,4 C7.581722,4 4,7.581722 4,12 C4,16.418278 7.581722,20 12,20 Z M19.0710678,4.92893219 L19.0710678,4.92893219 C19.4615921,5.31945648 19.4615921,5.95262146 19.0710678,6.34314575 L6.34314575,19.0710678 C5.95262146,19.4615921 5.31945648,19.4615921 4.92893219,19.0710678 L4.92893219,19.0710678 C4.5384079,18.6805435 4.5384079,18.0473785 4.92893219,17.6568542 L17.6568542,4.92893219 C18.0473785,4.5384079 18.6805435,4.5384079 19.0710678,4.92893219 Z"
                                                            fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                    </g>
                                                </svg>
                                    <!--end::Svg Icon-->
                                            </span>
                                {{ $user->roles[0]->name == 'super admin' ? "Admin HO" : $user->roles[0]->name }}
                            @else
                                @if (count($user->roles) == 0)
                                    Không có quyền
                                @else
                                    {{ $user->roles[0]->name }}
                                @endif
                            @endif


                        </td>
                        <td>
                            @if (count($user->roles) == 0 || (auth()->user()->roles[0]->id != $user->roles[0]->id))
                                <div class="menu-item px-3">
                                    <button class="btn-edit btn btn-info" data-id="{{ $user->id }}">
                                        Chỉnh sửa
                                    </button>
                                </div>
                            @endif
                        </td>
                        {{-- @else --}}
                        {{-- <td>Không có quyền !</td> --}}
                        {{-- <td>Không có quyền !</td> --}}
                        {{-- @endif --}}
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
            {{ $users->appends(request()->all())->links('pagination::bootstrap-4') }}
        </div>

    </div>
    {{--    form add--}}
    <div class="modal fade" tabindex="-1" id="kt_modal_1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm tài khoản</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="form-submit" action="{{ route('admin.acount.add') }}">
                    @csrf
                    {{--                    <input type="hidden" id="semeter_id" value="{{ $id_poetry }}">--}}

                    <div class="form-group m-10">
                        <input type="text" class="form-control" placeholder="name" id="name_add"/>
                    </div>
                    <div class="form-group m-10">
                        <input type="email" class="form-control form-control" id="email_add"
                               placeholder="name@example.com"/>
                    </div>
{{--                    <div class="form-group m-10">--}}
{{--                        <select class="form-select" name="subject" id="branches_id">--}}
{{--                            <option selected value="">--Chi Nhánh--</option>--}}
{{--                            @foreach($branches as $value)--}}
{{--                                <option value="{{ $value->id }}">{{ $value->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
                    <div class="form-group m-10">
                        <select class="form-select" name="subject" id="campus_id">
                            <option selected value="">--Cơ sở--</option>
                            @foreach($campus as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-10">
                        <select class="form-select" id="roles_id">
                            <option selected value="0">--Chức vụ--</option>
                            @foreach($roles as $value)
                                @if(auth()->user()->roles[0]->id != $value->id)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-10">
                        <select class="form-select" name="status" id="status_add">
                            <option selected value="">Trạng thái</option>
                            <option value="1">Kích hoạt</option>
                            <option value="0">Chưa kích hoạt</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="upload-basis" class=" btn btn-primary">Tải lên</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--    form sửa--}}
    <div class="modal fade" tabindex="-1" id="edit_modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa tài khoản </h5>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="form-update">
                    @csrf
                    <input type="hidden" name="id_update" id="id_update">
                    <div class="form-group m-10">
                        <input type="text" class="form-control" placeholder="name" id="name_update"/>
                    </div>
                    <div class="form-group m-10">
                        <input type="email" class="form-control form-control" disabled id="email_update"
                               placeholder="name@example.com"/>
                    </div>
{{--                    <div class="form-group m-10">--}}
{{--                        <select class="form-select" name="subject" id="branches_id_update">--}}
{{--                            <option value="0">--Chi Nhánh--</option>--}}
{{--                            @foreach($branches as $value)--}}
{{--                                <option value="{{ $value->id }}">{{ $value->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
                    <div class="form-group m-10">
                        <select class="form-select" name="subject" id="campus_id_update">
                            <option selected value="">--Cơ sở--</option>
                            @foreach($campus as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-10">
                        <select class="form-select" id="roles_id_update">
                            <option selected value="0">--Chức vụ--</option>
                            @foreach($roles as $value)
                                @if(auth()->user()->roles[0]->id != $value->id)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-10">
                        <select class="form-select" name="status" id="status_update_update">
                            <option selected value="">Trạng thái</option>
                            <option value="1">Kích hoạt</option>
                            <option value="0">Chưa kích hoạt</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-update" class=" btn btn-primary">Tải lên</button>
                    </div>
                </form>
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

        let btnEdit = document.querySelectorAll('.btn-edit');
        let btnUpdate = document.querySelector('#btn-update');
        let url = "/admin/acount?";
        const _token = "{{ csrf_token() }}";
        const sort = '{{ request()->has('sort') ? (request('sort') == 'desc' ? 'asc' : 'desc') : 'asc' }}';
        const start_time =
            '{{ request()->has('start_time') ? \Carbon\Carbon::parse(request('start_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
        const end_time =
            '{{ request()->has('end_time') ? \Carbon\Carbon::parse(request('end_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
    </script>
    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script src="assets/js/system/auth/auth.js"></script>
    <script>
        $('#upload-basis').click(function (e) {
            e.preventDefault();
            var url = $('#form-submit').attr("action");
            var name_add = $('#name_add').val();
            var email_add = $('#email_add').val();
            var branches_id = $('#branches_id').val();
            var campus_id = $('#campus_id').val();
            var roles_id = $('#roles_id').val();
            var status = $('#status_add').val();
            var dataAll = {
                '_token': _token,
                'name_add': name_add,
                'email_add': email_add,
                'branches_id': branches_id,
                'campus_id': campus_id,
                'roles_id': roles_id,
                'status': status,

            }
            $.ajax({
                type: 'POST',
                url: url,
                data: dataAll,
                success: (response) => {
                    console.log(response)
                    $('#form-submit')[0].reset();
                    notify(response.message);
                    wanrning('Đang tải dữ liệu mới ...');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                    $('#kt_modal_1').modal('hide');
                },
                error: function (response) {
                    // console.log(response.responseText)
                    errors(response.responseText);
                    // $('#ajax-form').find(".print-error-msg").find("ul").html('');
                    // $('#ajax-form').find(".print-error-msg").css('display','block');
                    // $.each( response.responseJSON.errors, function( key, value ) {
                    //     $('#ajax-form').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                    // });

                }
            });

        })
    </script>
    {{--    Sửa --}}
    <script>
        update(btnEdit)

        function update(btns) {
            for (const btnupdate of btns) {
                btnupdate.addEventListener('click', () => {
                    wanrning('Đang tải dữ liệu vui lòng chờ ...');
                    const id = btnupdate.getAttribute("data-id");
                    $.ajax({
                        url: `/admin/acount/edit/${id}`,
                        type: 'GET',
                        success: function (response) {
                            console.log(response.data.roles?.[0]);
                            notify('Tải dữ liệu thành công !')
                            $('#name_update').val(response.data.name);
                            $('#email_update').val(response.data.email);
                            $('#branches_id_update').val(response.data.branch_id);
                            $('#campus_id_update').val(response.data.campus_id);
                            $('#roles_id_update').val(response.data.roles?.[0]?.id ?? 0);
                            $('#status_update_update').val(response.data.status);
                            $('#id_update').val(response.data.id)
                            console.log(response.data);
                            // const selectSubject = document.getElementById("subject_id_update");
                            // let html = "";
                            // const btnEnvent = document.getElementById("semeter_id_update");
                            // if(response.data.subject.length > 0){
                            //     html = response.data.subject.map((value)=>{
                            //         return `<option value="${value.id}" ${response.data.poetry.id_subject == value.id ? 'selected' : ''} >${value.name}</option>`
                            //     }).join(' ')
                            // }else {
                            //     html = '<option value="">Không có data</option>';
                            // }
                            // selectSubject.innerHTML = html
                            // eventSubject(btnEnvent,selectSubject)
                            // $('#subject_id_update').val(response.data.id_subject);

                            // $('#status_update').val(response.data.poetry.status);
                            // $('#id_update').val(response.data.poetry.id)

                            // Gán các giá trị dữ liệu lấy được vào các trường tương ứng trong modal
                            $('#edit_modal').modal('show');
                        },
                        error: function (response) {
                            console.log(response);
                            // Xử lý lỗi
                        }
                    });
                })
            }
        }

        onupdate(btnUpdate)

        function onupdate(btn) {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                var name_update = $('#name_update').val();
                var email_update = $('#email_update').val();
                var branches_id_update = $('#branches_id_update').val();
                var campus_id_update = $('#campus_id_update').val();
                var roles_id_update = $('#roles_id_update').val();
                var status_update_update = $('#status_update_update').val();
                var id = $('#id_update').val();
                var dataAll = {
                    '_token': _token,
                    'name_update': name_update,
                    'email_update': email_update,
                    'branches_id_update': branches_id_update,
                    'campus_id_update': campus_id_update,
                    'roles_id_update': roles_id_update,
                    'status_update_update': status_update_update,
                }
                $.ajax({
                    type: 'PUT',
                    url: `admin/acount/update/${id}`,
                    data: dataAll,
                    success: (response) => {
                        console.log(response)
                        $('#form-submit')[0].reset();
                        notify(response.message);
                        // const idup =  `data-id='${response.data.id}'`;
                        // // console.log(idup);
                        // var buttons = document.querySelector('button.btn-edit['+idup+']');
                        // const elembtn = buttons.parentNode.parentNode.parentNode.parentNode.childNodes ;
                        // // console.log(elembtn)
                        // elembtn[1].innerText = response.data.name_semeter;
                        // elembtn[3].innerText = response.data.name_subject;
                        // elembtn[5].innerText = response.data.nameClass;
                        // elembtn[7].innerText = response.data.nameExamtion;
                        // const output = response.data.status_update == 1 ? true : false;
                        // // console.log(elembtn[5].childNodes[1].childNodes[1]);
                        // elembtn[9].childNodes[1].childNodes[1].checked= output
                        // elembtn[11].innerText =  response.data.start_time1;
                        // elembtn[13].innerText =  response.data.end_time2;
                        //
                        // btnEdit = document.querySelectorAll('.btn-edit');
                        // update(btnEdit)
                        // btnDelete = document.querySelectorAll('.btn-delete');
                        // dele(btnDelete)
                        notify(response.message);
                        wanrning('Đang tải dữ liệu mới ...');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                        // $('#edit_modal').modal('hide');
                    },
                    error: function (response) {
                        // console.log(response.responseText)
                        errors(response.responseText);
                        // $('#ajax-form').find(".print-error-msg").find("ul").html('');
                        // $('#ajax-form').find(".print-error-msg").css('display','block');
                        // $.each( response.responseJSON.errors, function( key, value ) {
                        //     $('#ajax-form').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        // });

                    }
                });
            })
        }
    </script>
@endsection
