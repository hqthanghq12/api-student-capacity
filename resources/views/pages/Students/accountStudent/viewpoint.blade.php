@extends('layouts.main')
@section('title', 'Quản lý sinh viên')
@section('page-title', 'Quản lý sinh viên')
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
                {{ Breadcrumbs::render('StudentsPointDetail',$id) }}
            </div>
            <div class="card card-flush p-4">
                <div class="row">
                    <div class=" col-lg-6">

                        <h1>
                            Bảng Điểm Sinh Viên {{ $user->name }}
                        </h1>
                    </div>
                    <div class="col-lg-6 text-end">
                        <div class="menu-item px-3">
                            <button type="button" onclick="location.href='{{ route('manage.student.export',$id) }}'" class="btn btn-light-primary" >
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                                <span class="svg-icon svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor"></rect>
																<path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor"></path>
																<path d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="#C4C4C4"></path>
															</svg>
														</span>
                                Export Report</button>
                        </div>
                    </div>
                </div>


                <div class="table-responsive table-responsive-md">
                    <table id="table-data" class="table table-row-bordered table-row-gray-300 gy-7  table-hover ">
                        <thead>
                        <tr>
                            <th scope="col">TT</th>
                            <th scope="col">Mã Môn</th>
                            <th scope="col">Môn học</th>
                            <th scope="col">Lớp</th>
{{--                            <th scope="col">Hệ số</th>--}}
{{--                            <th scope="col">Lớp</th>--}}
{{--                            <th scope="col">Ca thi</th>--}}
{{--                            <th scope="col">Môn thi</th>--}}
                            <th scope="col">Điểm</th>
                            <th scope="col">Lần Học</th>
                            <th scope="col">Trạng Thái</th>
{{--                            <th scope="col">Thời gian bắt đầu--}}
{{--                                <span role="button" data-key="date_start" data-bs-toggle="tooltip" title=""--}}
{{--                                      class=" svg-icon svg-icon-primary  svg-icon-2x format-database"--}}
{{--                                      data-bs-original-title="Lọc theo thời gian bắt đầu ">--}}
{{--                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg--}}
{{--                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"--}}
{{--                                        style="width: 14px !important ; height: 14px !important" width="24px"--}}
{{--                                        height="24px" viewBox="0 0 24 24" version="1.1">--}}
{{--                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
{{--                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>--}}
{{--                                        <rect fill="#000000" opacity="0.3"--}}
{{--                                              transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) "--}}
{{--                                              x="5" y="5" width="2" height="12" rx="1"></rect>--}}
{{--                                        <path--}}
{{--                                            d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z"--}}
{{--                                            fill="#000000" fill-rule="nonzero"></path>--}}
{{--                                        <rect fill="#000000" opacity="0.3"--}}
{{--                                              transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) "--}}
{{--                                              x="17" y="7" width="2" height="12" rx="1"></rect>--}}
{{--                                        <path--}}
{{--                                            d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z"--}}
{{--                                            fill="#000000" fill-rule="nonzero"--}}
{{--                                            transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) "></path>--}}
{{--                                    </g>--}}
{{--                                </svg>--}}
{{--                                    <!--end::Svg Icon-->--}}
{{--                            </span>--}}
{{--                            </th>--}}
{{--                            <th scope="col">Thời gian kết thúc--}}
{{--                                <span role="button" data-key="register_deadline" data-bs-toggle="tooltip" title=""--}}
{{--                                      class=" svg-icon svg-icon-primary  svg-icon-2x format-database"--}}
{{--                                      data-bs-original-title="Lọc theo thời gian kết thúc ">--}}
{{--                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg--}}
{{--                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"--}}
{{--                                        style="width: 14px !important ; height: 14px !important" width="24px"--}}
{{--                                        height="24px" viewBox="0 0 24 24" version="1.1">--}}
{{--                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
{{--                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>--}}
{{--                                        <rect fill="#000000" opacity="0.3"--}}
{{--                                              transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) "--}}
{{--                                              x="5" y="5" width="2" height="12" rx="1"></rect>--}}
{{--                                        <path--}}
{{--                                            d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z"--}}
{{--                                            fill="#000000" fill-rule="nonzero"></path>--}}
{{--                                        <rect fill="#000000" opacity="0.3"--}}
{{--                                              transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) "--}}
{{--                                              x="17" y="7" width="2" height="12" rx="1"></rect>--}}
{{--                                        <path--}}
{{--                                            d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z"--}}
{{--                                            fill="#000000" fill-rule="nonzero"--}}
{{--                                            transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) "></path>--}}
{{--                                    </g>--}}
{{--                                </svg>--}}
{{--                                    <!--end::Svg Icon-->--}}
{{--                            </span>--}}
{{--                            </th>--}}
                            <th colspan="2"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($point->count() > 0)
                            @foreach($point as $key => $value)
                                @if(isset($value->scores))
                                    <tr>
                                        <td>
                                            {{ $key+1 }}
                                        </td>
                                        <td>
                                            {{ $value->subject_code }}
                                        </td>
                                        <td>
                                            {{ $value->class_name }}
                                        </td>
                                        <td>
                                            {{ $value->subject_name }}
                                        </td>
{{--                                        <td>--}}
{{--                                            {{ $value->campus_name }}--}}
{{--                                        </td>--}}

{{--                                        <td>--}}
{{--                                            {{ $value->examination_name }}--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            {{ $value->subject_name }}--}}
{{--                                        </td>--}}

                                        <td>

                                            {{ $value->scores  }}
                                            {{--                                            <img width="50" style="border-radius: 5px" src="https://media1.giphy.com/media/e5flX9ERck2IXGdMXS/giphy.gif" alt="">--}}


                                        </td>
                                        <td>1</td>
                                        <td>       {{ $value->scores > 5 ? 'Đạt' : 'Chưa Đạt' }}</td>
{{--                                        <td>{{ $value->created_at == null ? 'Chưa có thời gian bắt đầu' :  $value->created_at 	 }}</td>--}}
{{--                                        <td>{{ $value->updated_at == null ? 'Chưa có thời gian kết thúc' : $value->updated_at }}</td>--}}
                                        {{--                                    <td>--}}
                                        {{--                                                                            <button  class="btn btn-info" onclick="location.href='#'"   type="button">--}}
                                        {{--                                                                                Chi tiết--}}
                                        {{--                                                                            </button>--}}

                                        {{--                                                                            <button  class="btn-edit btn btn-primary"  data-id="{{ $value->id }}" type="button">--}}
                                        {{--                                                                                Chỉnh sửa--}}
                                        {{--                                                                            </button>--}}

                                        {{--                                        <button  class="btn-delete btn btn-danger" data-id="{{ $value->id }}" data-semeter="{{ $id_semeter }}">--}}
                                        {{--                                            Xóa--}}
                                        {{--                                        </button>--}}
                                        {{--                                    </td>--}}
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9"><h1 class="text-center">Sinh viên này hiện chưa học</h1></td>

                            </tr>
                            <tr>
                                <td colspan="9" class="text-end">
                                    <button onclick="location.href='{{ route('manage.student.list') }}'"
                                            class="btn btn-danger ">
                                        Trở về
                                    </button>
                                </td>
                            </tr>

                        @endif

                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            {{--                            {{ $subjects->links() }}--}}
                        </ul>
                    </nav>

                </div>
            </div>

            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    {{--    form add--}}
    {{--    <div class="modal fade" tabindex="-1" id="kt_modal_1" style="display: none;" aria-hidden="true">--}}
    {{--        <div class="modal-dialog">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-header">--}}
    {{--                    <h5 class="modal-title">Thêm Môn học</h5>--}}

    {{--                    <!--begin::Close-->--}}
    {{--                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">--}}
    {{--                        <span class="svg-icon svg-icon-2x"></span>--}}
    {{--                    </div>--}}
    {{--                    <!--end::Close-->--}}
    {{--                </div>--}}
    {{--                <form id="form-submit" action="{{ route('admin.semeter.subject.create') }}" >--}}
    {{--                    @csrf--}}
    {{--                    <input type="hidden" id="id_semeter" value="{{ $id_semeter }}">--}}
    {{--                    --}}{{--                    <div class="form-group m-10">--}}
    {{--                    --}}{{--                        <label for="" class="form-label">Tên môn học</label>--}}
    {{--                    --}}{{--                        <input type="text" name="namebasis" id="namebasis" class=" form-control"--}}
    {{--                    --}}{{--                               placeholder="Nhập tên môn học...">--}}
    {{--                    --}}{{--                    </div>--}}
    {{--                    <div class="form-group m-10">--}}
    {{--                        <select class="form-select" name="subject" id="subject_id">--}}
    {{--                            <option selected value="">Môn học</option>--}}
    {{--                            @foreach($listSubject as $value)--}}
    {{--                                <option value="{{ $value->id }}">{{ $value->name }}</option>--}}
    {{--                            @endforeach--}}
    {{--                        </select>--}}
    {{--                    </div>--}}
    {{--                    <div class="modal-footer">--}}
    {{--                        <button type="button" id="upload-basis" class=" btn btn-primary">Thêm </button>--}}
    {{--                    </div>--}}
    {{--                </form>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    form sửa--}}
    {{--    <div class="modal fade" tabindex="-1" id="edit_modal" style="display: none;" aria-hidden="true">--}}
    {{--        <div class="modal-dialog">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-header">--}}
    {{--                    <h5 class="modal-title">Sửa Môn học</h5>--}}
    {{--                    <!--begin::Close-->--}}
    {{--                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">--}}
    {{--                        <span class="svg-icon svg-icon-2x"></span>--}}
    {{--                    </div>--}}
    {{--                    <!--end::Close-->--}}
    {{--                </div>--}}
    {{--                <form id="form-update"  >--}}
    {{--                    @csrf--}}
    {{--                    <input type="hidden" name="id_update" id="id_update">--}}
    {{--                    <div class="form-group m-10">--}}
    {{--                        <label for="" class="form-label">Tên Môn học</label>--}}
    {{--                        <input type="text" name="namebasis" id="nameUpdate" class=" form-control"--}}
    {{--                               placeholder="Nhập tên Môn học">--}}
    {{--                    </div>--}}
    {{--                    <div class="form-group m-10">--}}
    {{--                        <select class="form-select" name="status" id="status_update">--}}
    {{--                            <option selected value="">Trạng thái</option>--}}
    {{--                            <option value="1">Kích hoạt</option>--}}
    {{--                            <option value="0">Chưa kích hoạt</option>--}}
    {{--                        </select>--}}
    {{--                    </div>--}}
    {{--                    <div class="modal-footer">--}}
    {{--                        <button type="button" id="btn-update" class=" btn btn-primary">Tải lên </button>--}}
    {{--                    </div>--}}
    {{--                </form>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endsection

