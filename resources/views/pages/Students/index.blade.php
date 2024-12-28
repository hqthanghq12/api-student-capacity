@extends('layouts.main')
@section('title', 'Quản lý tài khoản ')
@section('page-title', 'Quản lý tài khoản ')
@section('content')

    <div class="card card-flush p-4">
        <div>
            <div class="alert alert-primary">
                Xin chào {{ auth()->user()->name }} , bạn thuộc quyền
                {{ \Str::ucfirst(auth()->user()->roles[0]->name) }}
                cơ sở {{ auth()->user()->campus->name }}
                <span data-bs-toggle="tooltip" title="Tải lại trang " role="button"
                      class="refresh-btn svg-icon svg-icon-primary svg-icon-2x">
                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Update.svg--><svg
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <path
                                d="M8.43296491,7.17429118 L9.40782327,7.85689436 C9.49616631,7.91875282 9.56214077,8.00751728 9.5959027,8.10994332 C9.68235021,8.37220548 9.53982427,8.65489052 9.27756211,8.74133803 L5.89079566,9.85769242 C5.84469033,9.87288977 5.79661753,9.8812917 5.74809064,9.88263369 C5.4720538,9.8902674 5.24209339,9.67268366 5.23445968,9.39664682 L5.13610134,5.83998177 C5.13313425,5.73269078 5.16477113,5.62729274 5.22633424,5.53937151 C5.384723,5.31316892 5.69649589,5.25819495 5.92269848,5.4165837 L6.72910242,5.98123382 C8.16546398,4.72182424 10.0239806,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 L6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C10.6885336,6 9.44767246,6.42282109 8.43296491,7.17429118 Z"
                                fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </div>
        </div>

        <div class="row card-format">



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
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                </span>

                <span data-bs-toggle="tooltip" title="Mở lọc" class="btn-show svg-icon svg-icon-primary svg-icon-2x">
                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Angle-down.svg--><svg
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                fill="#000000" fill-rule="nonzero"
                                transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999) " />
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
                    <th>Chức Năng </th>
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
                            <button  class="btn-edit btn btn-primary"  data-id="{{ $user->id }}" type="button">
                                Xem chi tiết
                            </button>
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
            {{ $users->appends(request()->all())->links('pagination::bootstrap-4') }}
        </div>

    </div>


@endsection
@section('page-script')
    <script>
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
@endsection
