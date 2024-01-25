@extends('layouts.main')
@section('title', "Ca {$poetry->start_examination_id} - {$poetry->block_subject->subject->name} - {$poetry->classsubject->name}")
@section('page-title', 'Quản lý ca thi số ' .$id)
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
                {{ Breadcrumbs::render('manageSemeter',['id' => $id,'id_poetry' => $id_poetry,'id_block' => $idBlock]) }}
            </div>
            {{--            <div class="card card-flush p-4">--}}
            {{--            </div>--}}
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
                    <div class=" col-lg-3">

                        <h1>
                            Danh sách ca thi số {{ $id }}
                        </h1>
                    </div>
                    <div class="col-lg-9 btn-group justify-content-end">
                        @if(!$has_started && $is_allow)
                            <div class="">
                                @if($student->count() > 0)
                                    <div class=" d-flex flex-row-reverse bd-highlight">
                                        <label data-bs-toggle="modal" data-bs-target="#kt_modal_2" type="button"
                                               class="btn btn-primary me-3">

                                            <!--end::Svg Icon-->Phát đề thi
                                        </label>
                                    </div>
                                @endif
                            </div>
                            <div class="">
                                <div class=" d-flex flex-row-reverse bd-highlight">
                                    <label data-bs-toggle="modal" data-bs-target="#kt_modal_1" type="button"
                                           class="btn btn-light-primary me-3" id="kt_file_manager_new_folder">

                                        <!--end::Svg Icon-->Thêm sinh viên
                                    </label>
                                </div>
                            </div>
                        @elseif($has_started && !$is_allow && $student->where('status', 0)->count() > 0)
                            <div class="">
                                <div class=" d-flex flex-row-reverse bd-highlight">
                                    <label data-bs-toggle="modal" data-bs-target="#kt_modal_status_request"
                                           type="button"
                                           class="btn btn-light-primary me-3" id="kt_file_manager_new_folder">

                                        <!--end::Svg Icon-->Gửi yêu cầu mở trạng thái
                                    </label>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="kt_modal_status_request" style="display: none;"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Chọn sinh viên cần yêu cầu mở
                                            </h5>

                                            <!--begin::Close-->
                                            <button class="btn btn-sm btn-primary ms-2" id="btn_send_request">
                                                Gửi yêu cầu
                                            </button>
                                            <!--end::Close-->
                                        </div>
                                        <div class="modal-body">
                                            <div class="p-3">
                                                <input type="text" class="form-control" placeholder="Ghi chú chung"
                                                       id="note">
                                            </div>
                                            <table id="table-data"
                                                   class="table table-row-bordered table-row-gray-300 gy-7 table-hover">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Tên</th>
                                                    <th>Email</th>
                                                    <th>Mã sinh viên</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($student as $value)
                                                    @if($value->status == 0)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" checked
                                                                       class="form-check-input checkbox-student-request"
                                                                       data-id="{{ $value->id }}" name="" id="">
                                                            </td>
                                                            <td>
                                                                {{ $value->nameStudent }}
                                                            </td>
                                                            <td>
                                                                {{ $value->emailStudent }}
                                                            </td>
                                                            <td>
                                                                {{ $value->mssv }}
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control student-note"
                                                                       placeholder="Ghi chú riêng">
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="">
                            <div class=" d-flex flex-row-reverse bd-highlight">
                                <a class="btn btn-light-success me-3" id=""
                                   href="{{ route('admin.poetry.manage.export', ['id' => $id, 'id_poetry' => $id_poetry, 'id_block' => $idBlock,]) }}">
                                    Xuất điểm
                                </a>
                            </div>
                        </div>
                        {{--                        <div class="">--}}
                        {{--                            <div class=" d-flex flex-row-reverse bd-highlight">--}}
                        {{--                                <a class="btn btn-light-info me-3" id=""--}}
                        {{--                                   href="{{ route('admin.poetry.manage.export', ['id' => $id, 'id_poetry' => $id_poetry, 'id_block' => $idBlock, 'byDay' => 'true']) }}">--}}
                        {{--                                    Xuất điểm trong ngày--}}
                        {{--                                </a>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                </div>


                <div class="table-responsive table-responsive">
                    <table id="table-data" class="table table-row-bordered table-row-gray-300 gy-7  table-hover">
                        <thead>
                        <tr>
                            @if ($is_allow)
                                <th></th>
                            @endif
                            <th scope="col">Tên sinh viên
                                <span role="button" data-key="name" data-bs-toggle="tooltip" title=""
                                      class=" svg-icon svg-icon-primary  svg-icon-2x format-database"
                                      data-bs-original-title="Lọc theo tên đánh giá năng lực">
                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
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
                            </th>
                            <th scope="col">Email</th>
                            <th scope="col">Mã</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Trạng thái phát đề</th>
                            <th scope="col">Tên đề thi</th>
                            <th scope="col">Điểm</th>
                            <th scope="col">Thời gian nộp</th>
                            <th scope="col">Thời gian thi</th>
                            <th colspan="2"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($student->count() > 0)
                            @foreach($student as $key => $value)
                                <tr>
                                    @if ($is_allow)
                                        <td><input type="checkbox" class="form-check-input checkbox-student"
                                                   data-id="{{ $value->id }}" name="" id=""></td>
                                    @endif
                                    <td>
                                        {{ $value->nameStudent }}
                                    </td>
                                    <td>
                                        {{ $value->emailStudent }}
                                    </td>
                                    <td>
                                        {{ $value->mssv }}
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input form-change-status"
                                                   data-id="{{ $value->id }}" type="checkbox"
                                                   {{ $value->status == 1 ? 'checked' : '' }} role="switch"
                                                   id="flexSwitchCheckDefault"
                                                @disabled($can_active)
                                            >
                                        </div>
                                    </td>
                                    <td>
                                        {{ $value->has_received_exam == 1 ? "Đã phát đề" : "Chưa phát đề" }}
                                    </td>
                                    <td>
                                        {{ trim($value->exam_name) === "" ? "Chưa có đề thi" : $value->exam_name }}
                                    </td>
                                    <td>{{ trim($value->scores) === "" ? "Chưa thi" : $value->scores }}</td>
                                    <td>{{ !empty($value->updated_at) ? date('H:i d-m-Y', strtotime($value->updated_at)) : "Chưa thi" }}</td>
                                    <td>
                                        {{ trim($value->exam_time) === "" ? "Chưa có thời gian" : $value->exam_time . " phút" }}
                                    </td>
                                    {{--                                    @if ($value->has_received_exam == 1  && (auth()->user()->hasAnyRole(config('util.ROLE_ADMINS')) || (auth()->user()->hasRole('teacher') && $value->rejoined_at === null)))--}}

                                    @if($value->has_received_exam == 1 && (auth()->user()->hasAnyRole(config('util.ROLE_ADMINS'))))
                                        <td class="text-end">
                                            <button href="#"
                                                    class="btn-rejoin menu-link border border-0 bg-transparent px-3 btn btn-sm btn-outline-primary"
                                                    data-id="{{ $value->id }}"
                                                    data-kt-users-table-filter="delete_row">Thi lại
                                            </button>
                                        </td>
                                    @endif
                                    @if(isset($value->scores))
                                        <td class="text-end">
                                            <a href="{{ route('admin.poetry.result.index', $value->playtopic_id) }}"
                                               target="_blank">Lịch sử làm bài</a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr id="error_null">
                                <td colspan="10">
                                    <h1 class="text-center">Không có sinh viên nào trong ca thi</h1>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    @if($student->count() > 0)
                        <nav>
                            <ul class="pagination">
                                {{ $student->links() }}
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>

            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    {{--    form add--}}
    <div class="modal fade" tabindex="-1" id="kt_modal_1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm mới sinh viên</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="form-add" action="{{ route('admin.poetry.manage.create') }}">
                    @csrf
                    <input type="hidden" id="id_poetry" value="{{ $id }}">
                    <div class="form-group m-10">
                        <label for="" class="form-label">Nhập Email</label>
                        {{--                        <input type="email" id="emailStudent" class="form-control">--}}
                        <div class="tag-container">
                            <input type="text" id="emailStudent" class="form-control"
                                   placeholder="<< Mỗi Email cách nhau 1 dấu cách >> Bấm enter để thêm "
                                   onkeydown="handleKeyDown(event)">
                        </div>

                    </div>
                    <div class="form-group m-10">
                        <select class="form-select" name="status" id="status">
                            <option selected value="">Trạng thái</option>
                            <option value="1">Kích hoạt</option>
                            <option value="0">Chưa kích hoạt</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        {{--                        <button type="button" onclick="getData()" class=" btn btn-primary">Lấy dữ liệu</button>--}}
                        <button type="button" id="upload-add" class=" btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="kt_modal_2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Phát đề thi</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="form-submit"
                      action="{{route('admin.poetry.playtopic.create') }}">
                    @csrf
                    <input type="hidden" name="id_poetry" id="id_poetry" value="{{ $id }}">

                    <div class="form-group m-10">
                        <select class="form-select" name="receive_mode" id="receive_mode">
                            <option selected value="">--Cách thức phát đề--</option>
                            <option value="0">Chọn đề cụ thể</option>
                            {{--                            <option value="1">Trộn đề ngẫu nhiên</option>--}}
                            <option value="1">Đề ngẫu nhiên</option>
                            <option value="2">Trộn câu hỏi ngẫu nhiên</option>
                        </select>
                    </div>
                    <div class="form-group m-10" id="specific_exam_form" style="display: none;">
                        <select class="form-select" name="exam_id" id="exam_id">
                            <option value="">--Chọn đề--</option>
                            @foreach($exams_list as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="exam_name" id="exam_name">
                        <input type="hidden" name="id_subject" id="id_subject" value="{{ $id_subject }}">
                    </div>
                    <div id="random_exam_form" style="display: none;">
                        <div class="form-group m-10 d-flex flex-column align-items-start">
                            <label for="" class="form-label">Số lượng câu hỏi</label>
                            <input type="text" class="form-control" name="questions_quantity" id="questions_quantity"
                                   placeholder="Số lượng câu hỏi">
                        </div>
                        <div class="form-group m-10 row">
                            <div class="form-group col-lg-4 d-flex flex-column align-items-start">
                                <label for="" class="form-label">% câu mức độ dễ</label>
                                <input type="text" class="form-control" name="ez_per_ques" id="ez_per_ques"
                                       placeholder="0 - 100">
                            </div>
                            <div class="form-group col-lg-4 d-flex flex-column align-items-start">
                                <label for="" class="form-label">% câu mức độ tb</label>
                                <input type="text" class="form-control" name="me_per_ques" id="me_per_ques"
                                       placeholder="0 - 100">
                            </div>
                            <div class="form-group col-lg-4 d-flex flex-column align-items-start">
                                <label for="" class="form-label">% câu mức độ khó</label>
                                <input type="text" class="form-control" name="diff_per_ques" id="diff_per_ques"
                                       placeholder="0 - 100">
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-10 d-flex flex-column align-items-start" id="time_form">
                        <label for="" class="form-label">Thời gian thi</label>
                        <select name="" id="time-select" class="form-select">
                            <option value="15">15 phút</option>
                            <option value="20">20 phút</option>
                            <option value="30">30 phút</option>
                            <option value="50">50 phút</option>
                            <option value="60">60 phút</option>
                            <option value="90">90 phút</option>
                        </select>
                        <input type="text" class="form-control" name="time" id="time-text"
                               placeholder="Thời gian thi" style="display: none">
                        <div class="form-group my-5">
                            <input type="checkbox" name="custom-time-checkbox" id="custom-time-checkbox"
                                   class="form-check-input me-3">
                            <label for="custom-time-checkbox" class="form-label" style="user-select: none;">Tùy chỉnh
                                thời gian</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="upload-basis" class=" btn btn-primary">Phát</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        const examList = @json($exams_list);

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

        const table = document.querySelectorAll('#table-data tbody tr');
        let STT = parseInt(table[table.length - 1].childNodes[1].innerText) + 1;
        let btnDelete = document.querySelectorAll('.btn-delete');
        let btnRejoin = document.querySelectorAll('.btn-rejoin');
        let btnEdit = document.querySelectorAll('.btn-edit');
        let btnUpdate = document.querySelector('#btn-update');
        const _token = "{{ csrf_token() }}";

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/system/poetry/student.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script>
        var emailList = [];

        function handleKeyDown(event) {
            if (event.key === "Enter" || event.keyCode === 13) {
                event.preventDefault();
                var tagInput = document.getElementById("emailStudent");
                var tagString = tagInput.value.trim();
                if (tagString !== "") {
                    var emailArray = tagString.split(" ").filter(function (email) {
                        return email !== "";
                    });
                    emailArray.forEach(function (email) {
                        addTag(email);
                        emailList.push(email);
                    });
                }
                tagInput.value = "";
            }
        }

        function addTag(tagName) {
            var tagContainer = document.getElementsByClassName("tag-container")[0];
            var tag = document.createElement("div");
            tag.className = "tag";
            tag.innerHTML = '<span class="tag-label">' + tagName + '</span><span class="tag-close" onclick="removeTag(this)">&#10006;</span>';
            tagContainer.appendChild(tag);
        }

        function removeTag(tagClose) {
            var tag = tagClose.parentNode;
            var tagContainer = tag.parentNode;
            tagContainer.removeChild(tag);
            var index = emailList.indexOf(tagName);
            if (index !== -1) {
                emailList.splice(index, 1);
            }
        }

        function getData() {
            console.log(emailList);
        }

        $('#upload-add').click(function (e) {
            e.preventDefault();
            var url = $('#form-add').attr("action");
            const valueEamil = emailList;
            var id_poetry = $('#id_poetry').val();
            var status = $('#status').val();
            var dataAll = {
                '_token': _token,
                'emailStudent': valueEamil,
                'id_poetry': id_poetry,
                'status': status
            }
            $.ajax({
                type: 'POST',
                url: url,
                data: dataAll,
                success: (response) => {
                    console.log(response)
                    // $('#form-submit')[0].reset();
                    // emailList = [];
                    notify(response.message);
                    $('#kt_modal_1').modal('hide');
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                },
                error: function (response) {
                    // console.log(response.responseText)
                    errors(response.responseText);

                }
            });

        })
    </script>
    {{--    Xóa --}}
    <script>
        // dele(btnDelete);
        const students = @json($student).data;
        rejoin(btnRejoin);

        function rejoin(btns) {
            for (const btnDeleteElement of btns) {
                btnDeleteElement.addEventListener("click", () => {
                    const id = btnDeleteElement.getAttribute("data-id");
                    const student = students.find(student => student.id == id);
                    Swal.fire({
                        title: 'Xác nhận thi lại',
                        text: `Xác nhận cho sinh viên ${student.nameStudent} thi lại!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Xác nhận'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var data = {
                                '_token': _token
                            }
                            $.ajax({
                                type: 'POST',
                                url: `admin/poetry/manage/rejoin/${id}`,
                                data: data,
                                success: (response) => {
                                    console.log(response)
                                    Swal.fire(
                                        'Cập nhật thành công',
                                        `${response.message}`,
                                        'success'
                                    )

                                    setTimeout(function () {
                                        window.location.reload();
                                    }, 1000);

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

                        }
                    })
                })
            }
        }

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
                                url: `admin/poetry/manage/delete/${id}`,
                                data: data,
                                success: (response) => {
                                    console.log(response)
                                    Swal.fire(
                                        'Deleted!',
                                        `${response.message}`,
                                        'success'
                                    )
                                    const elm = btnDeleteElement.parentNode.parentNode.parentNode.parentNode;
                                    console.log([elm])
                                    var seconds = 2000 / 1000;
                                    elm.style.transition = "opacity " + seconds + "s ease";
                                    elm.style.opacity = 0;
                                    setTimeout(function () {
                                        elm.remove()
                                    }, 2000);

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

                        }
                    })
                })
            }
        }

    </script>

    {{--    Cập nhật trang thái nhanh--}}

    {{--  Phát đề  --}}
    <script>
        const custom_time_checkbox = $('#custom-time-checkbox');
        const time_select_element = $('#time-select');
        const time_text_element = $('#time-text');
        custom_time_checkbox.change(function () {
            if ($(this).is(":checked")) {
                time_select_element.css('display', 'none');
                time_text_element.css('display', 'block');
            } else {
                time_select_element.css('display', 'block');
                time_text_element.css('display', 'none');
            }
        });

        let btnSendRequest = $('#btn_send_request');

        if (btnSendRequest) {
            btnSendRequest.click(function (e) {
                e.preventDefault();
                let note = $('#note').val();
                let url = "{{ route('admin.status-requests.create') }}";
                let statusRequestDetail = $('.checkbox-student-request:checked').map(function () {
                    return {
                        student_poetry_id: $(this).attr('data-id'),
                        note: $(this).parent().parent().find('.student-note').val()
                    };
                }).get();

                if (statusRequestDetail.length === 0) {
                    errors("Vui lòng chọn sinh viên");
                    return;
                }

                if (note === "") {
                    errors("Vui lòng nhập ghi chú chung");
                    return;
                }

                let dataAll = {
                    '_token': _token,
                    'statusRequestDetail': statusRequestDetail,
                    'semester_id': {{ $poetry->id_semeter }},
                    'campus_id': {{ $poetry->id_campus }},
                    'poetry_id': {{ $poetry->id }},
                    'note': note,
                    'created_by': {{ auth()->user()->id }},
                }
                // console.log(dataAll);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataAll,
                    success: (response) => {
                        console.log(response)
                        // $('#form-submit')[0].reset();
                        notify(response.payload);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                        $('#kt_modal_status_request').modal('hide');
                    },
                    error: function (response) {
                        let res = JSON.parse(response.responseText);
                        errors(res.message);

                    }
                });

            });
        }

        $('#upload-basis').click(function (e) {
            e.preventDefault();
            let url = $('#form-submit').attr("action");
            let id_poetry = $('#id_poetry').val();
            let receive_mode = $('#receive_mode').val();
            let exam_id = $('#exam_id').val();
            let questions_quantity = $('#questions_quantity').val();
            let ez_per_ques = $('#ez_per_ques').val();
            let me_per_ques = $('#me_per_ques').val();
            let diff_per_ques = $('#diff_per_ques').val();
            let id_subject = $('#id_subject').val();
            let time = custom_time_checkbox.is(":checked") ? time_text_element.val() : time_select_element.val();
            // let time = 90;
            let exam_name = $('#exam_name').val();
            let poetryStudentId = $('.checkbox-student:checked').map(function () {
                return $(this).attr('data-id');
            }).get();
            let dataAll = {
                '_token': _token,
                'id_poetry': id_poetry,
                'receive_mode': receive_mode,
                'exam_id': exam_id,
                'questions_quantity': questions_quantity,
                'ez_per_ques': ez_per_ques,
                'me_per_ques': me_per_ques,
                'diff_per_ques': diff_per_ques,
                'id_subject': id_subject,
                'time': time,
                'exam_name': exam_name,
                'poetry_student_id': poetryStudentId,
            }
            $.ajax({
                type: 'POST',
                url: url,
                data: dataAll,
                success: (response) => {
                    console.log(response)
                    // $('#form-submit')[0].reset();
                    notify(response.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                    $('#kt_modal_2').modal('hide');
                },
                error: function (response) {
                    errors(response.responseText);

                }
            });

        })
    </script>
@endsection

