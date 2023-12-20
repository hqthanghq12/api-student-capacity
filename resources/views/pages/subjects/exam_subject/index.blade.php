@extends('layouts.main')
@section('page-title', 'Ngân hàng đề thi môn ' . $name->name)
@section('content')
    <div class="mb-5">
        {{ Breadcrumbs::render('Management.exam',$id,$name->name ) }}
    </div>

    <div class=" card card-flush  p-5">
        <div class="row">
            <div class="col-lg-12">
                <div class=" d-flex justify-content-end">
                    <div>
                        <a class=" btn btn-primary me-2" target="_blank"
                           href="{{ route('admin.download.execel.pass') }}">
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
                            Tải mẫu bộ câu hỏi</a>
                    </div>
                    <a href="{{ route('admin.exam.create',['id' => $id,'name' => $name->name]) }}" class="btn btn-primary">Thêm mới
                        đề</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                        <thead>
                        <tr class="fw-bolder fs-6 text-gray-800">
                            <th>#</th>
                            <th>Tên đề thi</th>
{{--                            <th>Mô tả đề</th>--}}
                            <th>Cơ sở ra đề</th>
                            <th>Số câu hỏi</th>
                            <th>Tải lên bộ câu hỏi</th>
                            {{--                                <th>Đề bài</th>--}}
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $key = 1;
                        @endphp
                        @foreach ($exams as $exam)
                            <tr>
                                <td>{{ $key++ }}</td>

                                <td>{{ $exam->name }}</td>

{{--                                <td>--}}
{{--                                    <button class="btn  btn-primary btn-sm" type="button" data-bs-toggle="modal"--}}
{{--                                            data-bs-target="#exampleModal_{{ $exam->id }}">--}}
{{--                                        Xem Thêm--}}
{{--                                    </button>--}}
{{--                                    <!-- Modal -->--}}
{{--                                    <div style="margin: auto; display: none;" class="modal fade"--}}
{{--                                         id="exampleModal_{{ $exam->id }}" tabindex="-1"--}}
{{--                                         aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--                                        <div class="modal-dialog">--}}
{{--                                            <div class="modal-content">--}}
{{--                                                <div class="modal-header">--}}
{{--                                                    <h5 class="modal-title" id="exampleModalLabel">--}}
{{--                                                        Mô tả đề thi--}}
{{--                                                    </h5>--}}
{{--                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"--}}
{{--                                                            aria-label="Close"></button>--}}
{{--                                                </div>--}}
{{--                                                <div class="modal-body  ">--}}
{{--                                                    {{ $exam->description }}--}}
{{--                                                </div>--}}
{{--                                                <div class="modal-footer">--}}
{{--                                                    <button type="button" class="btn btn-secondary"--}}
{{--                                                            data-bs-dismiss="modal">Thoát--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </td>--}}

                                <td>{{ $exam->campus->name }}</td>
                                <td>{{ $exam->total_questions }}</td>
                                <td data-bs-toggle="tooltip"
                                    title="Tải lên bộ câu hỏi bằng excel">
                                    <button
                                        style="background: #ccc;
                                                                                                                    padding: 1vh 1vh 1vh 2vh;
                                                                                                                    border-radius: 20px;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_exc_{{ $exam->id }}"
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

                                </td>
                                {{--                                    <td>--}}
                                {{--                                        --}}{{-- <a href="{{ Storage::disk('s3')->temporaryUrl($exam->external_url, now()->addHour(), [--}}
                                {{--                                            'ResponseContentDisposition' => 'attachment',--}}
                                {{--                                        ]) }}"--}}
                                {{--                                            class=" btn btn-success btn-sm">Tải--}}
                                {{--                                            xuống</a>   --}}

                                {{--                                        <button data-id="{{ $exam->id }}"--}}
                                {{--                                            data-external_url="{{ route('dowload.file') . '?url=' . $exam->external_url }}"--}}
                                {{--                                            type="button" class="download_file btn btn-success btn-sm">Tải xuống</button>--}}
                                {{--                                    </td>--}}
                                <td>
                                    @hasanyrole('admin|super admin')
                                    <div class="form-check form-switch">
                                        <input value="{{ $exam->status }}" data-id="{{ $exam->id }}"
                                               class="form-select-status form-check-input" @checked($exam->status == 1)
                                               type="checkbox" role="switch">
                                    </div>
                                    @else
                                        <div class="form-check form-switch">
                                            <input value="{{ $exam->status }}" data-id="{{ $exam->id }}"
                                                   class="form-check-input" @checked($exam->status == 1) type="checkbox"
                                                   disabled role="switch">
                                        </div>
                                        @endhasrole

                                </td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-info btn-question"
                                                onclick="location.href='{{ route('admin.subject.question.index',['id'=> $exam->id,'id_subject'=> $id, 'name' => $name->name,]) }}'">
                                            Câu Hỏi
                                        </button>
{{--                                        <button--}}
{{--                                            data-href=""--}}
{{--                                            data-date_time="{{ $name->created_at  }}"--}}
{{--                                            class="edit_exam btn btn-primary btn-sm">--}}
{{--                                            Chỉnh sửa đề--}}
{{--                                        </button>--}}
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" tabindex="-1"
                                 id="kt_modal_exc_{{ $exam->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Tải lên
                                                excel
                                                <strong>{{ $exam->name }}</strong>
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
                                              action="{{ route('admin.question.excel.import.exam', ['exam' => $exam->id]) }}"
                                              method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body text-center">
                                                <div class="HDSD">
                                                </div>
                                                <label for="up-file{{ $exam->id }}"
                                                       class="">
                                                    <i data-bs-toggle="tooltip"
                                                       title="Click để upload file"
                                                       style="font-size: 100px;"
                                                       role="button"
                                                       class="bi bi-cloud-plus-fill"></i>
                                                </label>
                                                <input style="display: none" type="file"
                                                       name="ex_file" class="up-file"
                                                       id="up-file{{ $exam->id }}">
                                                <div style="display: none"
                                                     class="progress show-p mt-3 h-25px w-100">
                                                    <div
                                                        class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
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
                        @endforeach
                        </tbody>
                    </table>
                    <div class="modal fade" tabindex="-1" id="show_question" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Bộ Câu hỏi</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Câu Hỏi</th>
                                            <th scope="col">Độ Khó</th>
                                            <th scope="col">Đáp Án</th>
                                            <th scope="col">Tình Trạng</th>
                                        </tr>
                                        </thead>
                                        <tbody class="position-relative">
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <a data-bs-toggle="collapse" href="#multiCollapseExample0" role="button"
                                                   class="mb-3 collapsed" aria-expanded="false"
                                                   aria-controls="multiCollapseExample0">
                                                    Add a note about this part of the document <br> <span
                                                        style="background: #ccc ; color : white ; padding : 5px ; margin : 1px"> Không có skill </span>
                                                </a>

                                                <div class="multi-collapse collapse" id="multiCollapseExample0"
                                                     style="">
                                                    <div class="card card-body">

                                                        <p> Click Power Point / Tabs Review / Group Comment/ New Comment
                                                            <strong>- Đáp án đúng </strong></p>

                                                        <p> Click Power Point / Tabs View / Group Comment/ New
                                                            Comment </p>

                                                        <p> Click Power Point / Tabs Insert / Group Comment/ New
                                                            Comment </p>

                                                        <p> Click Power Point / Tabs Home / Group Comment/ New
                                                            Comment </p>

                                                    </div>
                                                </div>

                                            </td>
                                            <td>Khó</td>
                                            <td>Một đáp án</td>
                                            <td>Mở</td>
                                            <td>

                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                    </button>
                                </div>
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
        const url = " {{ request()->url() }}";
        const _token = "{{ csrf_token() }}";
    </script>
    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script src="assets/js/system/exam/exam.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

    <script>
        const btnQuestion = document.querySelectorAll('.btn-question');
        for (const btnQuestionElement of btnQuestion) {
            btnQuestionElement.addEventListener('click', (e) => {
                let id = e.target.getAttribute('data-id');

            })
        }
    </script>
    <script src="assets/js/system/capacity/main.js"></script>
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
@endsection
