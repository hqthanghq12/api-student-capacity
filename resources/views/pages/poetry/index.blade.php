@extends('layouts.main')
@section('page-title', 'Quản lý ca thi kỳ ' .$name)
@section('content')
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css"/>
    <link rel="stylesheet" href="assets/plugins/global/plugins.bundle.css">
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="mb-5">
                {{ Breadcrumbs::render('Management.poetry',$id_poetry,$idBlock ) }}
            </div>
            <div class="my-5">

            </div>
            <div class="card card-flush p-4">
                <div class="row">
                    <div class=" col-lg-6">
                        <h1>
                            Danh sách ca thi {{ $name }}
                        </h1>
                    </div>
                    @if(!auth()->user()->hasRole('teacher'))
                        <div class=" col-lg-6">
                            <div class=" d-flex flex-row-reverse bd-highlight">
                                <div>
                                    <a class=" btn btn-primary me-2" target="_blank"
                                       href="{{ route('admin.download.execel.poetry') }}">
                            <span class="svg-icon svg-icon-x svg-icon-primary   ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path opacity="0.3"
                                          d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                                          fill="black"></path>
                                    <path
                                        d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                                        fill="black"></path>
                                </svg>
                            </span>
                                        Tải
                                        xuống mẫu</a>
                                </div>
                                <label data-bs-toggle="modal" data-bs-target="#kt_modal_1" type="button"
                                       class="btn btn-light-primary me-3" id="kt_file_manager_new_folder">

                                    <!--end::Svg Icon-->Thêm ca thi
                                </label>
                                <button
                                    style="background: #ccc;
                                                                                                                    padding: 1vh 1vh 1vh 2vh;
                                                                                                                    border-radius: 20px;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_exc_poetry"
                                    type="button"
                                    class="btn   me-3"
                                    id="kt_file_manager_new_folder">
                                                                                            <span
                                                                                                class="svg-icon svg-icon-2">
                                                                                                <svg
                                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                                    width="24"
                                                                                                    height="24"
                                                                                                    viewBox="0 0 24 24"
                                                                                                    fill="none">
                                                                                                    <path opacity="0.3"
                                                                                                          d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z"
                                                                                                          fill="black">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.2C9.7 3 10.2 3.20001 10.4 3.60001ZM16 12H13V9C13 8.4 12.6 8 12 8C11.4 8 11 8.4 11 9V12H8C7.4 12 7 12.4 7 13C7 13.6 7.4 14 8 14H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z"
                                                                                                        fill="black">
                                                                                                    </path>
                                                                                                    <path opacity="0.3"
                                                                                                          d="M11 14H8C7.4 14 7 13.6 7 13C7 12.4 7.4 12 8 12H11V14ZM16 12H13V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z"
                                                                                                          fill="black">
                                                                                                    </path>
                                                                                                </svg>
                                                                                            </span>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <form method="get" class="row my-5">
                    <div class="col-3">
                        <select class="form-select" data-control="select2" data-placeholder="Select an option"
                                name="gv">
                            <option value="">--Chọn giảng viên--</option>
                            @foreach($teachers as $teacher)
                                <option
                                    value="{{ $teacher->id }}"
                                    @if($teacher->id == request('gv'))
                                        selected
                                    @endif
                                >{{ rtrim($teacher->email, config('util.END_EMAIL_FPT')) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <select class="form-select" name="ct">
                            <option value="">-- Ca thi --</option>
                            @foreach($listExamination as $examination)
                                <option
                                    value="{{ $examination->id }}"
                                    @if($examination->id == request('ct'))
                                        selected
                                    @endif
                                >{{ $examination->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <select class="form-select" name="s" id="">
                            <option value="">-- Chọn Môn --</option>
                            @foreach($blockSubjectIdToName as $id => $name)
                                <option
                                    value="{{ $id }}"
                                    @if($id == request('s'))
                                        selected
                                    @endif
                                >{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <select class="form-select" name="c" id="">
                            <option value="">Lớp học</option>
                            @foreach($listClass as $class)
                                <option
                                    value="{{ $class->id }}"
                                    @if($class->id == request('c'))
                                        selected
                                    @endif
                                >{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </form>

                <div class="table-responsive table-responsive-md">
                    <table id="table-data" class="table table-row-bordered table-row-gray-300 gy-7  table-hover ">
                        <thead>
                        <tr>
                            <th scope="col">Ngày thi</th>
                            <th scope="col">Môn thi</th>
                            <th scope="col">Lớp thi</th>
                            <th scope="col">Phòng</th>
                            <th scope="col">Ca thi</th>
                            <th scope="col">Giảng viên</th>
                            <th scope="col">Cơ sở</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">
                                <a href="{{ request()->getPathInfo() }}?{{ collect(request()->except('sort'))->map(function ($item, $key) {return $key . '=' . $item;})->implode('&') . '&sort=' . $sort }}">
                                    Số sinh viên
                                    <span role="button" data-key="name" data-bs-toggle="tooltip" title=""
                                          class=" svg-icon svg-icon-primary  svg-icon-2x format-database"
                                          data-bs-original-title="Lọc số sinh viên">
                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            style="width: 14px !important ; height: 14px !important" width="24px"
                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                <rect fill="#000000" opacity="0.3"
                                                      transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) "
                                                      x="5" y="5" width="2" height="12" rx="1"></rect>
                                                <path
                                                    d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z"
                                                    fill="#000000" fill-rule="nonzero"></path>
                                                <rect fill="#000000" opacity="0.3"
                                                      transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) "
                                                      x="17" y="7" width="2" height="12" rx="1"></rect>
                                                <path
                                                    d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z"
                                                    fill="#000000" fill-rule="nonzero"
                                                    transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) "></path>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </a>
                            </th>
                            <th colspan="2"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($poetry) > 0)
                            @foreach($poetry as $key => $value)
                                <tr>
                                    <td>
                                        {{ $value->exam_date }}
                                    </td>
                                    <td>
                                        {{ $blockSubjectIdToName[$value->id_block_subject] }}
                                    </td>
                                    <td>
                                        {{ $value->classsubject->name }}
                                    </td>
                                    <td>
                                        {{ $value->room }}
                                    </td>
                                    <td>
                                        {{ $value->examination }}
                                    </td>
                                    <td>
                                        {{ $value->user->getUserName() }}
                                    </td>
                                    <td>
                                        {{ $value->campus->name }}
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" data-id="{{ $value->id }}" type="checkbox"
                                                   {{ $value->status == 1 ? 'checked' : '' }} role="switch"
                                                   id="flexSwitchCheckDefault"
                                                   @if(auth()->user()->hasRole('teacher')) disabled @endif>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $value->student_count }}
                                    </td>
                                    <td class="text-end">
                                        @if ($value->status == 1)
                                            <div class="menu-item px-3 d-inline-block">
                                                <button
                                                    class="text-decoration-none px-3 border border-0 bg-transparent btn btn-sm btn-outline-primary"
                                                    onclick="location.href='{{ route('admin.poetry.manage.index',['id' => $value->id,'id_poetry' =>$id_poetry,'id_block' => $idBlock ]) }}'"
                                                    type="button">
                                                    Phát đề thi
                                                </button>
                                                @role('super admin')
                                                @if(!checkTime($value, $listExamination))
                                                    <button
                                                        class="btn-edit px-3 border border-0 bg-transparent btn btn-sm btn-outline-primary"
                                                        data-id="{{ $value->id }}"
                                                        data-semeter="{{ $value->id_semeter }}">
                                                        Chỉnh sửa
                                                    </button>
                                                @endif
                                                @endrole
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="11">
                                    <h1 class="text-center">Không có ca thi nào</h1>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            {{ $poetry->links() }}
                        </ul>
                    </nav>

                </div>
            </div>

            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    @if(!auth()->user()->hasRole('teacher'))
        <div class="modal fade" tabindex="-1"
             id="kt_modal_exc_poetry">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Tải lên
                            excel
                        </h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                             data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
                            Thoát
                        </div>
                        <!--end::Close-->
                    </div>
                    <form class="form-submit"
                          action="{{ route('admin.semeter.excel.import', ['semeter' => $id_poetry,'idBlock' => $idBlock]) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body text-center">
                            <div class="form-group d-none">
                                <select name="campus_id" id="campus_id_excel" class="form-select">
                                    <option value="{{ $campus->id }}"> Cơ sở {{ $campus->name }}</option>
                                    {{--                                        @foreach($listcampus as $campus)--}}
                                    {{--                                            <option value="{{ $campus->id }}">{{ $campus->name }}</option>--}}
                                    {{--                                        @endforeach--}}
                                </select>
                            </div>
                            <div class="HDSD">
                            </div>
                            <label for="up-file{{ $id_poetry }}"
                                   class="">
                                <i data-bs-toggle="tooltip"
                                   title="Click để upload file"
                                   style="font-size: 100px;"
                                   role="button"
                                   class="bi bi-cloud-plus-fill"></i>
                            </label>
                            <input style="display: none" type="file"
                                   name="ex_file" class="up-file"
                                   id="up-file{{ $id_poetry }}">
                            <div style="display: none"
                                 class="progress show-p mt-3 h-25px w-100">
                                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                     role="progressbar" style="width: 0%"
                                     aria-valuenow="0" aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                            </div>
                            <p class="show-name">
                            </p>
                            <p class="text-danger error_ex_file">
                            </p>
                        </div>

                        <div class="modal-footer">
                            <button type="submit"
                                    class="upload-file btn btn-primary">Tải
                                lên
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{--    form add--}}

        <div class="modal fade" tabindex="-1" id="kt_modal_1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm mới ca thi</h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                             aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
                        </div>
                        <!--end::Close-->
                    </div>
                    <form id="form-submit" action="{{ route('admin.poetry.create') }}">
                        @csrf
                        <input type="hidden" id="semeter_id" value="{{ $id_poetry }}">
                        <input type="hidden" id="id_block" value="{{ $idBlock }}">
                        <div class="form-group m-10">
                            <select class="form-select" name="subject" id="block_subject_id">
                                <option selected value="">--Chọn môn học--</option>
                                @foreach($listSubject as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-10">
                            <input type="text" class="form-control" placeholder="Phòng thi" name="room" id="room">
                        </div>
                        <div class="form-group m-10">
                            <select class="form-select" name="subject" id="campus_id">
                                <option selected value="{{ $campus->id }}">Cơ sở {{ $campus->name }}</option>
                                {{--                                @foreach($listcampus as $campus)--}}
                                {{--                                    <option value="{{ $campus->id }}">{{ $campus->name }}</option>--}}
                                {{--                                @endforeach--}}
                            </select>
                        </div>
                        <div class="form-group m-10">
                            <select class="form-select" name="start_examination_id" id="start_examination_id">
                                <option selected value="">--Chọn ca bắt đầu thi--</option>
                                @foreach($listExamination as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-10">
                            <select class="form-select" name="finish_examination_id" id="finish_examination_id">
                                <option selected value="">--Chọn ca kết thúc thi--</option>
                                @foreach($listExamination as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-10">
                            <select class="form-select" name="class_id" id="class_id">
                                <option selected value="">--Chọn lớp thi--</option>
                                @foreach($listClass as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-10">
                            <select class="form-select" name="assigned_user" id="assigned_user">
                                <option selected value="">--Giảng viên--</option>
                                @foreach($teachers as $teacher)
                                    <option
                                        value="{{ $teacher->id }}|{{ $teacher->campus_id }}">{{ $teacher->name }} - Cơ
                                        sở {{ $teacher->campus->name }}</option>
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
                        <div class="form-group m-10">
                            <label for="" class="form-label">Ngày thi</label>
                            <input type="date" name="exam_date" id="exam_date" class=" form-control"
                            >
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
                        <h5 class="modal-title">Sửa ca thi </h5>
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
                        <input type="hidden" id="semeter_id_update" value="{{ $id_poetry }}">
                        <input type="hidden" id="id_block_update" value="{{ $idBlock }}">
                        <div class="form-group m-10">
                            <select class="form-select" name="subject" id="block_subject_id_update">
                                @foreach($listSubject as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-10">
                            <input type="text" class="form-control" placeholder="Phòng thi" name="room"
                                   id="room_update">
                        </div>
                        <div class="form-group m-10">
                            <select class="form-select" name="subject" id="campus_id_update">
                                <option selected value="{{ $campus->id }}">Cơ sở {{ $campus->name }}</option>
                                {{--                                @foreach($listcampus as $campus)--}}
                                {{--                                    <option value="{{ $campus->id }}">{{ $campus->name }}</option>--}}
                                {{--                                @endforeach--}}
                            </select>
                        </div>
                        <div class="form-group m-10">
                            <select class="form-select" name="start_examination_id" id="start_examination_id_update">
                                <option selected value="">--Chọn ca bắt đầu thi--</option>
                                @foreach($listExamination as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-10">
                            <select class="form-select" name="finish_examination_id" id="finish_examination_id_update">
                                <option selected value="">--Chọn ca kết thúc thi--</option>
                                @foreach($listExamination as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-10">
                            <select class="form-select" name="class_id" id="class_id_update">
                                <option selected value="">--Chọn lớp thi--</option>
                                @foreach($listClass as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-10">
                            <select class="form-select" name="assigned_user" id="assigned_user_update">
                                <option selected value="">--Giảng viên--</option>
                                @foreach($teachers as $teacher)
                                    <option
                                        value="{{ $teacher->id }}|{{ $teacher->campus_id }}">{{ $teacher->name }} - Cơ
                                        sở {{ $teacher->campus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-10">
                            <select class="form-select" name="status" id="status_update">
                                <option selected value="">Trạng thái</option>
                                <option value="1">Kích hoạt</option>
                                <option value="0">Chưa kích hoạt</option>
                            </select>
                        </div>
                        <div class="form-group m-10">
                            <label for="" class="form-label">Ngày thi</label>
                            <input type="date" name="exam_date" id="exam_date_update" class=" form-control"
                            >
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-update" class=" btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
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

        function formatDate(DateValue) {

            var date = new Date(DateValue);

            var day = date.getDate();
            var month = date.getMonth() + 1; // Ghi chú: Tháng bắt đầu từ 0 (0 = tháng 1)
            var year = date.getFullYear();

            const formattedDate = day + "-" + month + "-" + year;
            return formattedDate;
        }

        const table = document.querySelectorAll('#table-data tbody tr');
        let STT = parseInt(table[table.length - 1].childNodes[1].innerText) + 1;
        let btnDelete = document.querySelectorAll('.btn-delete');
        let btnEdit = document.querySelectorAll('.btn-edit');
        let btnUpdate = document.querySelector('#btn-update');
        const _token = "{{ csrf_token() }}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/system/poetry/poetry.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    {{--    Thêm --}}
    <script>
        $('#upload-basis').click(function (e) {
            e.preventDefault();
            console.log($('#campus_id').val());
            var url = $('#form-submit').attr("action");
            var id_block = $('#id_block').val();
            var semeter_id = $('#semeter_id').val();
            var block_subject_id = $('#block_subject_id').val();
            var room = $('#room').val();
            var campus_id = $('#campus_id').val();
            var start_examination_id = $('#start_examination_id').val();
            var finish_examination_id = $('#finish_examination_id').val();
            var class_id = $('#class_id').val();
            var assigned_user = $('#assigned_user').val();
            var status = $('#status_add').val();
            var exam_date = $('#exam_date').val();
            var dataAll = {
                '_token': _token,
                'id_block': id_block,
                'semeter_id': semeter_id,
                'block_subject_id': block_subject_id,
                'room': room,
                'campus_id': campus_id,
                'start_examination_id': start_examination_id,
                'finish_examination_id': finish_examination_id,
                'class_id': class_id,
                'assigned_user': assigned_user,
                'status': status,
                'exam_date': exam_date,
            }
            $.ajax({
                type: 'POST',
                url: url,
                data: dataAll,
                success: (response) => {
                    $('#form-submit')[0].reset();
                    notify(response.message);
                    wanrning('Đang tải dữ liệu mới ...');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                    $('#kt_modal_1').modal('hide');
                },
                error: function (response) {
                    errors(response.responseText);

                }
            });

        })
    </script>
    {{--    Sửa --}}
    <script>
        update(btnEdit);

        let subject;

        let newSubject;

        let isChangeSubject = false;

        $('#block_subject_id_update').change(function (e) {
            newSubject = $(this).val();
            isChangeSubject = newSubject != subject;
        })

        function update(btns) {
            for (const btnupdate of btns) {
                btnupdate.addEventListener('click', () => {
                    const id = btnupdate.getAttribute("data-id");
                    const id_semeter = btnupdate.getAttribute("data-semeter");
                    $.ajax({
                        url: `/admin/poetry/edit/${id_semeter}/${id}`,
                        type: 'GET',
                        success: function (response) {
                            subject = response.data.poetry.id_block_subject;
                            newSubject = subject;
                            isChangeSubject = false;
                            // notify('Tải dữ liệu thành công !')
                            $('#semeter_id_update').val(response.data.poetry.id_semeter);
                            $('#block_subject_id_update').val(subject);
                            $('#class_id_update').val(response.data.poetry.id_class);
                            $('#start_examination_id_update').val(response.data.poetry.start_examination_id);
                            $('#finish_examination_id_update').val(response.data.poetry.finish_examination_id);
                            $('#room_update').val(response.data.poetry.room);
                            $('#campus_id_update').val(response.data.poetry.id_campus);
                            $('#assigned_user_update').val(response.data.poetry.user.id + '|' + response.data.poetry.user.campus_id);
                            $('#status_update').val(response.data.poetry.status);
                            $('#exam_date_update').val(response.data.poetry.exam_date);

                            $('#id_update').val(response.data.poetry.id);

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

        function updatePoetry() {
            var id = $('#id_update').val();
            var semeter_id_update = $('#semeter_id_update').val();
            var id_block_update = $('#id_block_update').val();
            var block_subject_id_update = $('#block_subject_id_update').val();
            var room_update = $('#room_update').val();
            var campus_id_update = $('#campus_id_update').val();
            var start_examination_id_update = $('#start_examination_id_update').val();
            var finish_examination_id_update = $('#finish_examination_id_update').val();
            var class_id_update = $('#class_id_update').val();
            var assigned_user_update = $('#assigned_user_update').val();
            var status_update = $('#status_update').val();
            var exam_date_update = $('#exam_date_update').val();

            var dataAll = {
                '_token': _token,
                'semeter_id_update': semeter_id_update,
                'id_block_update': id_block_update,
                'block_subject_id_update': block_subject_id_update,
                'room_update': room_update,
                'campus_id_update': campus_id_update,
                'start_examination_id_update': start_examination_id_update,
                'finish_examination_id_update': finish_examination_id_update,
                'class_id_update': class_id_update,
                'assigned_user_update': assigned_user_update,
                'status_update': status_update,
                'exam_date_update': exam_date_update,
                'isChangeSubject': isChangeSubject,
            }

            $.ajax({
                type: 'PUT',
                url: `admin/poetry/update/${id}`,
                data: dataAll,
                success: (response) => {
                    console.log(response)
                    $('#form-submit')[0].reset();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                    notify(response.message);
                },
                error: function (response) {
                    errors(response.responseText);

                }
            });
        }

        function onupdate(btn) {
            btn.addEventListener('click', (e) => {
                e.preventDefault();

                let isContinue = true;

                if (isChangeSubject) {
                    isContinue = false;
                    Swal.fire({
                        title: 'Xác nhận thay đổi môn thi',
                        text: `Nếu thay đổi môn thi, đề thi đã phát cho sinh viên cùng kết quả thi sẽ bị hủy`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Xác nhận'
                    })
                        .then((result) => {
                            isContinue = result.isConfirmed;
                            if (result.isConfirmed) {
                                updatePoetry();
                            }
                        })
                }

                if (!isContinue) {
                    return;
                }

                updatePoetry();

            })
        }
    </script>
    {{--    Xóa --}}
    <script>
        dele(btnDelete);

        function dele(btns) {
            for (const btnDeleteElement of btns) {
                btnDeleteElement.addEventListener("click", () => {
                    const id = btnDeleteElement.getAttribute("data-id");
                    console.log(id)
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Bạn có chắc chắn muốn xóa không!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var data = {
                                '_token': _token
                            }
                            $.ajax({
                                type: 'DELETE',
                                url: `admin/poetry/delete/${id}`,
                                data: data,
                                success: (response) => {
                                    console.log(response)
                                    Swal.fire(
                                        'Deleted!',
                                        `${response.message}`,
                                        'success'
                                    )
                                    const elm = btnDeleteElement.parentNode.parentNode.parentNode.parentNode;
                                    var seconds = 2000 / 1000;
                                    elm.style.transition = "opacity " + seconds + "s ease";
                                    elm.style.opacity = 0;
                                    setTimeout(function () {
                                        elm.remove()
                                    }, 2000);
                                },
                                error: function (response) {
                                    errors(response.responseText);
                                }
                            });

                        }
                    })
                })
            }
        }

    </script>
    {{--    <script src="assets/js/system/formatlist/formatlis.js"></script>--}}
    <script src="assets/js/system/capacity/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.up-file').on("change", function () {
                $('.show-name').html($(this)[0].files[0].name);
            })
            $('.form-submit').ajaxForm({
                beforeSend: function () {
                    $(".error_ex_file").html("");
                    $(".upload-file").html("Đang tải dữ liệu ..")
                    $(".progress").show();
                    var percentage = '0';
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentage = percentComplete;
                    $('.progress .progress-bar').css("width", percentage + '%', function () {
                        return $(this).attr("aria-valuenow", percentage) + "%";
                    })
                },
                success: function () {
                    $(".progress").hide();
                    $(".upload-file").html("Tải lên")
                    toastr.success("Tải lên thành công !");
                    $('.up-file').val('');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                    setTimeout(() => {
                        $('.modal').modal('hide');
                    }, 500);
                    // window.location.reload();
                },
                error: function (xhr, status, error) {
                    $(".upload-file").html("Tải lên")
                    $('.progress .progress-bar').css("width", 0 + '%', function () {
                        return $(this).attr("aria-valuenow", 0) + "%";
                    })
                    $(".progress").hide();
                    var err = JSON.parse(xhr.responseText);
                    if (err.errors) $(".error_ex_file").html(err.errors.ex_file);
                }
            });
        })
    </script>
    {{--    Cập nhật trang thái nhanh--}}

@endsection
