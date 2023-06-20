@extends('layouts.main')
@section('title', 'Quản lý ca thi' )
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
                {{ Breadcrumbs::render('manageSemeter',['id' => $id,'id_poetry' => $id_poetry]) }}
            </div>
            <div class="card card-flush p-4">
                <div class="row">
                    <div class=" col-lg-6">

                        <h1>
                            Danh sách ca thi số {{ $id }}
                        </h1>
                    </div>
                    <div class="col-lg-6 btn-group justify-content-end">
                        <div class="">
                            @if(!empty($student))
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
                    </div>
                </div>


                <div class="table-responsive table-responsive-md">
                    <table id="table-data" class="table table-row-bordered table-row-gray-300 gy-7  table-hover ">
                        <thead>
                        <tr>
                            <th></th>
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
                            <th scope="col">Thời gian thi</th>
                            <th colspan="2"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($student))
                            @foreach($student as $key => $value)
                                <tr>
                                    <td><input type="checkbox" class="form-check-input checkbox-student" data-id="{{ $value->id }}" name="" id=""></td>
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
                                            <input class="form-check-input form-change-status" data-id="{{ $value->id }}" type="checkbox"
                                                   {{ $value->status == 1 ? 'checked' : '' }} role="switch"
                                                   id="flexSwitchCheckDefault">
                                        </div>
                                    </td>
                                    <td>
                                        {{ $value->has_received_exam == 1 ? "Đã phát đề" : "Chưa phát đề" }}
                                    </td>
                                    <td>
                                        {{ trim($value->exam_name) === "" ? "Chưa có đề thi" : $value->exam_name }}
                                    </td>
                                    <td>
                                        {{ trim($value->exam_time) === "" ? "Chưa có thời gian" : $value->exam_time . " phút" }}
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                           data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                            <span class="svg-icon svg-icon-5 m-0">
															<svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24" viewBox="0 0 24 24" fill="none">
																<path
                                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                                    fill="currentColor"></path>
															</svg>
														</span>
                                            <!--end::Svg Icon--></a>
                                        <!--begin::Menu-->
                                        <div
                                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                            data-kt-menu="true" style="">
                                            <!--begin::Menu item-->
                                            {{--                                            <div class="menu-item px-3">--}}
                                            {{--                                                <button  class="menu-link px-3 border border-0 bg-transparent" onclick="location.href='{{ route('admin.poetry.manage.index',$value->id) }}'"   type="button">--}}
                                            {{--                                                    Chi tiết--}}
                                            {{--                                                </button>--}}
                                            {{--                                            </div>--}}
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <button href="#"
                                                        class="btn-delete menu-link border border-0 bg-transparent"
                                                        data-id="{{ $value->id }}"
                                                        data-kt-users-table-filter="delete_row">Delete
                                                </button>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr id="error_null">
                                <td colspan="7">
                                    <h1 class="text-center">Không có học sinh nào trong ca thi</h1>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    @if(!empty($student))
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
                            <input type="text" id="emailStudent" class="form-control" placeholder="Nhâp email"
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
                        <button type="button" onclick="getData()" class=" btn btn-primary">Lấy dữ liệu</button>
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
                            <option value="1">Trộn đề ngẫu nhiên</option>
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
                    </div>
                    <div id="random_exam_form" style="display: none;">
                        <input type="hidden" name="id_subject" id="id_subject" value="{{ $id_subject }}">
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
                        <input type="text" class="form-control" name="time" id="time"
                               placeholder="Thời gian thi">
                    </div>
                    <div class="modal-footer">
                        {{--                        @if($total >= 1)--}}
                        {{--                            <button type="button" id="reloadPlaytopic" class=" btn btn-primary">Phát Lại</button>--}}
                        {{--                        @else--}}
                        <button type="button" id="upload-basis" class=" btn btn-primary">Phát</button>
                        {{--                        @endif--}}
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
                    $('#form-submit')[0].reset();
                    emailList = [];
                    notify(response.message);
                    $('#kt_modal_1').modal('hide');
                    setTimeout(function () {
                        window.location.reload();
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

        })
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
            let time = $('#time').val();
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
                    $('#form-submit')[0].reset();
                    notify(response.message);
                    //                  var newRow = ` <tr>
                    //                              <td>
                    //                                  ${response.data.name_semeter}
                    //                  </td>
                    // <td>
                    //                                  ${response.data.name_subject}
                    //                  </td>
                    //                  <td>
                    //                      <div class="form-check form-switch">
                    //                          <input class="form-check-input" data-id="${response.data.id}" type="checkbox" ${response.data.status == 1 ? 'checked' : ''} role="switch" id="flexSwitchCheckDefault">
                    //                                  </div>
                    //                              </td>
                    //                              <td>${  formatDate(response.data.start_time) }</td>
                    //                              <td>${ formatDate(response.data.end_time)}</td>
                    //           <td class="text-end">
                    //                                  <button href="!##" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    //                                      <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                    //                                      <span class="svg-icon svg-icon-5 m-0">
                    // 														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    // 															<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
                    // 														</svg>
                    // 													</span>
                    //                                      <!--end::Svg Icon--></button>
                    //                                  <!--begin::Menu-->
                    //                                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true" style="">
                    //                                      <!--begin::Menu item-->
                    //                                      <div class="menu-item px-3">
                    //                                          <button  class="menu-link px-3 border border-0 bg-transparent" onclick="location.href='poetry/manage/${response.data.id}'"   type="button">
                    //                                              Chi tiết
                    //                                          </button>
                    //                                      </div>
                    //                                      <div class="menu-item px-3">
                    //                                          <button  class="btn-edit menu-link px-3 border border-0 bg-transparent"  data-id="${response.data.id}" data-semeter="${response.data.id_semeter}">
                    //                                              Chỉnh sửa
                    //                                          </button>
                    //                                      </div>
                    //                                      <!--end::Menu item-->
                    //                                      <!--begin::Menu item-->
                    //                                      <div class="menu-item px-3">
                    //                                          <button  class="btn-delete menu-link border border-0 bg-transparent" data-id="${response.data.id}" data-kt-users-table-filter="delete_row">Delete</button>
                    //                                      </div>
                    //                                      <!--end::Menu item-->
                    //                                  </div>
                    //                                  <!--end::Menu-->
                    //                              </td>
                    //
                    //                          </tr>
                    //                  `;
                    //
                    //                  $('#table-data tbody').append(newRow);
                    //                  btnEdit = document.querySelectorAll('.btn-edit');
                    //                  update(btnEdit)
                    //                  btnDelete = document.querySelectorAll('.btn-delete');
                    //                  dele(btnDelete)
                    // wanrning('Đang tải dữ liệu mới ...');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                    $('#kt_modal_2').modal('hide');
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
@endsection

