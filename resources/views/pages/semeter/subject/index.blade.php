@extends('layouts.main')
@section('title', 'Quản lý Môn học')
@section('page-title', 'Quản lý Môn học')
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
                {{ Breadcrumbs::render('Management.subject',$id_semeter ) }}
            </div>
            <div class="card card-flush p-4">

                <form action="" class="my-5 p-3">
                    <div class="row align-items-end">
                        <div class="form-group col-3">
                            <label for="t" class="form-label">Tìm kiếm theo</label>
                            <select name="t" id="t" class="form-select">
                                <option value="code">Mã môn</option>
                                <option value="name" @selected(request('t') == 'name')>Tên môn</option>
                            </select>
                        </div>
                        <div class="col-7">
                            <input type="search" name="s" id="" class="form-control col-9"
                                   value="{{ request('s') ?? '' }}" placeholder="Nhập giá trị muốn tìm">
                        </div>
                        <div class="col-2">
                            <button class="btn btn-secondary">Tìm kiếm</button>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class=" col-lg-6">

                        <h1>
                            Danh sách môn học
                        </h1>
                    </div>
                    <div class=" col-lg-6">
                        <div class=" d-flex flex-row-reverse bd-highlight">
                            <label data-bs-toggle="modal" data-bs-target="#kt_modal_1" type="button"
                                   class="btn btn-light-primary me-3" id="kt_file_manager_new_folder">

                                <!--end::Svg Icon-->Thêm Môn học
                            </label>
                        </div>
                    </div>
                </div>


                <div class="table-responsive table-responsive-md">
                    <table id="table-data" class="table table-row-bordered table-row-gray-300 gy-7  table-hover ">
                        <thead>
                        <tr>
                            <th scope="col">Mã môn</th>
                            <th scope="col">Tên môn học</th>
                            {{--                            <th scope="col">Thuộc block</th>--}}
                            <th scope="col">Trạng thái</th>
                            <th colspan="2"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($subjects) > 0)
                            @foreach($subjects as $key => $value)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.exam.index', $value->id) }}">{{ $value->code_subject }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.exam.index', $value->id) }}">{{ $value->name }}</a>
                                    </td>
                                    {{--                                <td>--}}
                                    {{--                                    {{ $value->block_subject->where('id_subject',$value->id) }}--}}
                                    {{--                                </td>--}}
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input"
                                                   data-id-subject-semeter="{{ $value->id_subject_semeter }}"
                                                   type="checkbox"
                                                   {{ $value->statusSubject == 1 ? 'checked' : '' }} role="switch"
                                                   id="flexSwitchCheckDefault">
                                        </div>
                                    </td>
                                    <td>
                                        {{--                                    <button  class="btn btn-info" onclick="location.href='{{ route('admin.semeter.subject.index',$value->id) }}'"   type="button">--}}
                                        {{--                                        Chi tiết--}}
                                        {{--                                    </button>--}}

                                        {{--                                    <button  class="btn-edit btn btn-primary"  data-id="{{ $value->id }}" type="button">--}}
                                        {{--                                        Chỉnh sửa--}}
                                        {{--                                    </button>--}}

                                        {{--                                    <button  class="btn-delete btn btn-danger" data-id="{{ $value->id }}" data-semeter="{{ $id_semeter }}">--}}
                                        {{--                                        Xóa--}}
                                        {{--                                    </button>--}}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4"><h1 class="text-center">Không có bản ghi nào</h1></td>

                            </tr>
                            <tr>
                                <td colspan="4" class="text-end">
                                    <button onclick="location.href='{{ route('admin.semeter.index') }}'"
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
                            {{ $subjects->links() }}
                        </ul>
                    </nav>

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
                    <h5 class="modal-title">Thêm Môn học</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="form-submit" action="{{ route('admin.semeter.subject.create') }}">
                    @csrf
                    <input type="hidden" id="id_semeter" value="{{ $id_semeter }}">
                    {{--                    <div class="form-group m-10">--}}
                    {{--                        <label for="" class="form-label">Tên môn học</label>--}}
                    {{--                        <input type="text" name="namebasis" id="namebasis" class=" form-control"--}}
                    {{--                               placeholder="Nhập tên môn học...">--}}
                    {{--                    </div>--}}
                    <div class="form-group m-10">
                        <select class="form-select" name="subject" id="subject_id">
                            <option selected value="">Môn học</option>
                            @foreach($listSubject as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="subject" id="block_id"
                           value="{{ $listBlock->pluck('id')->implode('|') }}">
                    {{--                    <div class="form-group m-10">--}}
                    {{--                        <select class="form-select" name="subject" id="block_id">--}}
                    {{--                            <option selected value="">Block</option>--}}
                    {{--                            @foreach($listBlock as $value)--}}
                    {{--                                <option value="{{ $value->id }}">{{ $value->name }}</option>--}}
                    {{--                            @endforeach--}}
                    {{--                        </select>--}}
                    {{--                    </div>--}}
                    <div class="modal-footer">
                        <button type="button" id="upload-basis" class=" btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

        const table = document.querySelectorAll('#table-data tbody tr');
        let STT = parseInt(table[table.length - 1].childNodes[1].innerText) + 1;
        let btnDelete = document.querySelectorAll('.btn-delete');
        let btnEdit = document.querySelectorAll('.btn-edit');
        // let btnUpdate = document.querySelector('#btn-update');
        let cks = document.querySelectorAll('.form-check-input');

        const _token = "{{ csrf_token() }}";
        const start_time =
            '{{ request()->has('start_time') ? \Carbon\Carbon::parse(request('start_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
        const end_time =
            '{{ request()->has('end_time') ? \Carbon\Carbon::parse(request('end_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    {{--    <script src="{{ asset('assets/js/system/question/index.js') }}"></script>--}}
    <script src="{{ asset('assets/js/system/semeter/subject.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{--    <button  class="btn btn-info" onclick="location.href='admin/subject/exam/${response.data.id}'"   type="button">--}}
    {{--        Chi tiết--}}
    {{--    </button>--}}
    {{--    <button  class="btn-edit btn btn-primary"  data-id="${response.data.id}" type="button">--}}
    {{--        Chỉnh sửa--}}
    {{--    </button>--}}
    {{--    Thêm --}}
    <script>
        $('#upload-basis').click(function (e) {
            e.preventDefault();
            var url = $('#form-submit').attr("action");
            var subject_id = $('#subject_id').val();
            const id_semeter = $('#id_semeter').val();
            const block_id = $('#block_id').val();
            var dataAll = {
                '_token': _token,
                'subject_id': subject_id,
                'id_semeter': id_semeter,
                'block_id': block_id,
                'start_time': start_time,
                'end_time': end_time
            }

            $.ajax({
                type: 'POST',
                url: url,
                data: dataAll,
                success: (response) => {
                    console.log(response)
                    // $('#form-submit')[0].reset();
                    notify(response.message);
                    $('#kt_modal_1').modal('hide');
                    wanrning('Đữ liệu mới đang được tải vui lòng đợi...');
                    setTimeout(function () {
                        notify('Tải hoàn tất ');
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

        })
    </script>
    {{--    Sửa --}}
    {{--    <script>--}}
    {{--        update(btnEdit)--}}
    {{--        function update(btns){--}}
    {{--            for (const btnupdate of btns) {--}}
    {{--                btnupdate.addEventListener('click',() => {--}}
    {{--                    const id = btnupdate.getAttribute("data-id");--}}

    {{--                    $.ajax({--}}
    {{--                        url: `/admin/subject/edit/${id}`,--}}
    {{--                        type: 'GET',--}}
    {{--                        success: function(response) {--}}
    {{--                            console.log(response);--}}
    {{--                            notify('Tải dữ liệu thành công !')--}}
    {{--                            $('#nameUpdate').val(response.data.name);--}}
    {{--                            $('#status_update').val(response.data.status);--}}
    {{--                            $('#id_update').val(response.data.id)--}}
    {{--                            // Gán các giá trị dữ liệu lấy được vào các trường tương ứng trong modal--}}
    {{--                            $('#edit_modal').modal('show');--}}
    {{--                        },--}}
    {{--                        error: function(response) {--}}
    {{--                            console.log(response);--}}
    {{--                            // Xử lý lỗi--}}
    {{--                        }--}}
    {{--                    });--}}
    {{--                })--}}
    {{--            }--}}
    {{--        }--}}
    {{--        onupdate(btnUpdate)--}}
    {{--        function onupdate(btn){--}}
    {{--            btn.addEventListener('click', (e) => {--}}
    {{--                e.preventDefault();--}}
    {{--                var nameupdate = $('#nameUpdate').val();--}}
    {{--                var status = $('#status_update').val();--}}
    {{--                var id = $('#id_update').val();--}}
    {{--                var dataAll = {--}}
    {{--                    '_token' : _token,--}}
    {{--                    'namebasis' : nameupdate,--}}
    {{--                    'status' : status,--}}
    {{--                    'start_time' : start_time,--}}
    {{--                    'end_time' : end_time--}}
    {{--                }--}}
    {{--                $.ajax({--}}
    {{--                    type:'PUT',--}}
    {{--                    url: `admin/subject/update/${id}`,--}}
    {{--                    data: dataAll,--}}
    {{--                    success: (response) => {--}}
    {{--                        // console.log(response)--}}
    {{--                        $('#form-submit')[0].reset();--}}
    {{--                        notify(response.message);--}}
    {{--                        const idup =  `data-id='${response.data.id}'`;--}}
    {{--                        // console.log(idup);--}}
    {{--                        var buttons = document.querySelector('button.btn-edit['+idup+']');--}}
    {{--                        const elembtn = buttons.parentNode.parentNode.childNodes ;--}}
    {{--                        console.log(elembtn)--}}
    {{--                        elembtn[1].innerText = response.data.namebasis;--}}
    {{--                        const output = response.data.status == 1 ? true : false;--}}
    {{--                        elembtn[3].childNodes[1].childNodes[1].checked= output--}}
    {{--                        elembtn[5].innerText = response.data.start_time.replace(/\//g, '-').replace(" PM", "");--}}
    {{--                        elembtn[7].innerText = response.data.end_time.replace(/\//g, '-').replace(" PM", "");--}}

    {{--                        btnEdit = document.querySelectorAll('.btn-edit');--}}
    {{--                        update(btnEdit)--}}
    {{--                        btnDelete = document.querySelectorAll('.btn-delete');--}}
    {{--                        dele(btnDelete)--}}
    {{--                        $('#edit_modal').modal('hide');--}}
    {{--                    },--}}
    {{--                    error: function(response){--}}
    {{--                        // console.log(response.responseText)--}}
    {{--                        errors(response.responseText);--}}
    {{--                        // $('#ajax-form').find(".print-error-msg").find("ul").html('');--}}
    {{--                        // $('#ajax-form').find(".print-error-msg").css('display','block');--}}
    {{--                        // $.each( response.responseJSON.errors, function( key, value ) {--}}
    {{--                        //     $('#ajax-form').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');--}}
    {{--                        // });--}}

    {{--                    }--}}
    {{--                });--}}
    {{--            })--}}
    {{--        }--}}
    {{--    </script>--}}
    {{--    Xóa --}}
    <script>
        dele(btnDelete);

        function dele(btns) {
            for (const btnDeleteElement of btns) {
                btnDeleteElement.addEventListener("click", () => {
                    const id = btnDeleteElement.getAttribute("data-id");
                    const id_semeter = btnDeleteElement.getAttribute("data-semeter");
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
                                url: `admin/semeter/subject/delete/${id}/${id_semeter}`,
                                data: data,
                                success: (response) => {
                                    console.log(response)
                                    Swal.fire(
                                        'Deleted!',
                                        `${response.message}`,
                                        'success'
                                    )
                                    const elm = btnDeleteElement.parentNode.parentNode;
                                    var seconds = 2000 / 1000;
                                    elm.style.transition = "opacity " + seconds + "s ease";
                                    elm.style.opacity = 0;
                                    setTimeout(function () {
                                        elm.remove()
                                    }, 2000);
                                    wanrning('Đữ liệu mới đang được tải vui lòng đợi...');
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

    </script>

    {{--    Cập nhật trang thái nhanh--}}

@endsection

