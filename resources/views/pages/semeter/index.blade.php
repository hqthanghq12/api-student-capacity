@extends('layouts.main')
@section('title', 'Quản lý Kỳ học')
@section('page-title', 'Quản lý Kỳ học')
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
                {{ Breadcrumbs::render('Semeter' ) }}
            </div>
            <div class="card card-flush p-4">
                <div class="row">
                    <div class=" col-lg-6">

                        <h1>
                            Danh sách kỳ học
                        </h1>
                    </div>
                    <div class=" col-lg-6">
                        <div class=" d-flex flex-row-reverse bd-highlight">
                            <label data-bs-toggle="modal" data-bs-target="#kt_modal_1" type="button"
                                   class="btn btn-light-primary me-3" id="kt_file_manager_new_folder">

                                <!--end::Svg Icon-->Thêm kỳ học
                            </label>
                        </div>
                    </div>
                </div>


                <div class="table-responsive table-responsive-md">
                    <table id="table-data" class="table table-row-bordered table-row-gray-300 gy-7  table-hover ">
                        <thead>
                        <tr>
                            <th scope="col">Tên học kỳ
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
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Cơ sở</th>
                            <th scope="col">Thời gian bắt đầu
                                <span role="button" data-key="date_start" data-bs-toggle="tooltip" title=""
                                      class=" svg-icon svg-icon-primary  svg-icon-2x format-database"
                                      data-bs-original-title="Lọc theo thời gian bắt đầu ">
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
                            <th scope="col">Thời gian kết thúc
                                <span role="button" data-key="register_deadline" data-bs-toggle="tooltip" title=""
                                      class=" svg-icon svg-icon-primary  svg-icon-2x format-database"
                                      data-bs-original-title="Lọc theo thời gian kết thúc ">
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
                            <th colspan="2"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <p style="display: none">{{ $i=0 }}</p>
                        @foreach($setemer as $key => $value)
                            <tr>
                                <td>
                                    {{ $value->name }}
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" data-id="{{ $value->id }}" type="checkbox"
                                               {{ $value->status == 1 ? 'checked' : '' }} role="switch"
                                               id="flexSwitchCheckDefault">
                                    </div>
                                </td>
                                <td>
                                    {{ $value->campus->name == 0 ? 'Chưa có cơ sở' :  $value->campus->name}}
                                </td>
                                <td>{{ $value->start_time == null ? 'Chưa có thời gian bắt đầu' :    date('d-m-Y', strtotime($value->start_time)) 	 }}</td>
                                <td>{{ $value->end_time == null ? 'Chưa có thời gian kết thúc' :   date('d-m-Y', strtotime($value->end_time)) }}</td>
                                <td>
                                    <button class="btn btn-info"
                                            onclick="location.href='{{ route('admin.poetry.index',[$value->id,$id[$value->id]]) }}'"
                                            type="button">
                                        Quản lí ca thi
                                    </button>
                                    @if (auth()->user()->hasRole([config('util.SUPER_ADMIN_ROLE'),config('util.ADMIN_ROLE')]))
                                        <button class="btn btn-info"
                                                onclick="location.href='{{ route('admin.semeter.subject.index',$value->id) }}'"
                                                type="button">
                                            Chi tiết
                                        </button>

                                        <button class="btn-edit btn btn-primary" data-id="{{ $value->id }}"
                                                type="button">
                                            Chỉnh sửa
                                        </button>
                                    @endif

                                    {{--                                    <button  class="btn-delete btn btn-danger" data-id="{{ $value->id }}">--}}
                                    {{--                                        Xóa--}}
                                    {{--                                    </button>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            {{ $setemer->links() }}
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
                    <h5 class="modal-title">Thêm mới kỳ học</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="form-submit" action="{{ route('admin.semeter.create') }}">
                    @csrf
                    <div class="form-group m-10">
                        <label for="" class="form-label">Tên kỳ học</label>
                        <input type="text" name="namebasis" id="namebasis" class=" form-control"
                               placeholder="Nhập tên kỳ học">
                    </div>
                    <div class="form-group m-10">
                        <select class="form-select" name="status" id="campus_id">
                            <option selected value="">Cơ sở</option>
                            @foreach($campusList as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
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
                        <label for="" class="form-label">Thời gian bắt đầu</label>
                        <input type="date" name="start_time" id="start_time" class=" form-control"
                        >
                    </div>
                    <div class="form-group m-10">
                        <label for="" class="form-label">Thời gian kết thúc</label>
                        <input type="date" name="end_time" id="end_time" class=" form-control"
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
                    <h5 class="modal-title">Sửa Kỳ học</h5>
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
                        <label for="" class="form-label">Tên Kỳ học</label>
                        <input type="text" name="namebasis" id="nameUpdate" class=" form-control"
                               placeholder="Nhập tên Môn học">
                    </div>
                    <div class="form-group m-10">
                        <select class="form-select" name="status" id="campus_id_update">
                            <option selected value="">Cơ sở</option>
                            @foreach($campusList as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
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
                        <label for="" class="form-label">Thời gian bắt đầu</label>
                        <input type="date" name="start_time" id="start_time_update" class=" form-control"
                        >
                    </div>
                    <div class="form-group m-10">
                        <label for="" class="form-label">Thời gian kết thúc</label>
                        <input type="date" name="end_time" id="end_time_update" class=" form-control"
                        >
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

        function formatDate(DateValue) {

            var date = new Date(DateValue);

            var day = date.getDate();
            var month = date.getMonth() + 1; // Ghi chú: Tháng bắt đầu từ 0 (0 = tháng 1)
            var year = date.getFullYear();

            const formattedDate = day + "-" + month + "-" + year;
            return formattedDate;
        }

        const table = document.querySelectorAll('#table-data tbody tr');
        let btnDelete = document.querySelectorAll('.btn-delete');
        let btnEdit = document.querySelectorAll('.btn-edit');
        let btnUpdate = document.querySelector('#btn-update');
        const _token = "{{ csrf_token() }}";
        const start_time =
            '{{ request()->has('start_time') ? \Carbon\Carbon::parse(request('start_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
        const end_time =
            '{{ request()->has('end_time') ? \Carbon\Carbon::parse(request('end_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/system/semeter/semeter.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    {{--    Thêm --}}
    <script>
        $('#upload-basis').click(function (e) {
            e.preventDefault();
            var url = $('#form-submit').attr("action");
            var name = $('#namebasis').val();
            var campus_id = $('#campus_id').val();
            var name_campus = $('#campus_id').find('option:selected').text();
            var status = $('#status_add').val();
            var start_time_semeter = $('#start_time').val();
            var end_time_semeter = $('#end_time').val();
            var dataAll = {
                '_token': _token,
                'namebasis': name,
                'campus_id': campus_id,
                'status': status,
                'start_time_semeter': start_time_semeter,
                'end_time_semeter': end_time_semeter,
                'start_time': start_time,
                'end_time': end_time
            }
            $.ajax({
                type: 'POST',
                url: url,
                data: dataAll,
                success: (response) => {
                    console.log(response)
                    $('#form-submit')[0].reset();
                    notify(response.message);
                    //                  var newRow = `          <tr>
                    //                              <td>
                    //                                  ${response.data.namebasis}
                    //                  </td>
                    //                  <td>
                    //                      <div class="form-check form-switch">
                    //                          <input class="form-check-input" data-id="${response.data.id}" type="checkbox" ${response.data.status == 1 ? 'checked' : ''} role="switch" id="flexSwitchCheckDefault">
                    //                                  </div>
                    //                              </td>
                    // <td>
                    //
                    //                  </td>
                    //                              <td>${  formatDate(start_time_semeter) }</td>
                    //                              <td>${ formatDate(end_time_semeter)}</td>
                    //                              <td>
                    //                             <button  class="btn btn-info" onclick="location.href='admin/semeter/block/${response.data.id}'"   type="button">
                    //                                                                           Block
                    //                                                              </button>
                    //                                <button  class="btn btn-info" onclick="location.href='admin/subject/exam/${response.data.id}'"   type="button">
                    //                                      Chi tiết
                    //                                  </button>
                    //
                    //                                  <button  class="btn-edit btn btn-primary"  data-id="${response.data.id}" type="button">
                    //                                      Chỉnh sửa
                    //                                  </button>
                    //
                    //
                    //                              </td>
                    //                          </tr>
                    //                  `;
                    //
                    //                  $('#table-data tbody').append(newRow);
                    //                  btnEdit = document.querySelectorAll('.btn-edit');
                    //                  update(btnEdit)
                    //                  btnDelete = document.querySelectorAll('.btn-delete');
                    //                  dele(btnDelete)
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
    <script>
        update(btnEdit)

        function update(btns) {
            for (const btnupdate of btns) {
                btnupdate.addEventListener('click', () => {
                    const id = btnupdate.getAttribute("data-id");

                    $.ajax({
                        url: `/admin/semeter/edit/${id}`,
                        type: 'GET',
                        success: function (response) {
                            console.log(response);
                            notify('Tải dữ liệu thành công !')
                            $('#nameUpdate').val(response.data.name);
                            $('#status_update').val(response.data.status);
                            $('#id_update').val(response.data.id)
                            $('#campus_id_update').val(response.data.id_campus)
                            const date_start = moment(response.data.start_time).format("YYYY-MM-DD");
                            $('#start_time_update').val(date_start)
                            const date_end = moment(response.data.end_time).format("YYYY-MM-DD");
                            $('#end_time_update').val(date_end)
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
                var nameupdate = $('#nameUpdate').val();
                var campus_id_update = $('#campus_id_update').val();
                var name_campus = $('#campus_id_update').find('option:selected').text();
                var status = $('#status_update').val();
                var id = $('#id_update').val();
                const date_start = $('#start_time_update').val();
                const date_end = $('#end_time_update').val();
                var dataAll = {
                    '_token': _token,
                    'namebasis': nameupdate,
                    'campus_id_update': campus_id_update,
                    'status': status,
                    'start_time_semeter': date_start,
                    'end_time_semeter': date_end,
                    'start_time': start_time,
                    'end_time': end_time
                }
                $.ajax({
                    type: 'PUT',
                    url: `admin/semeter/update/${id}`,
                    data: dataAll,
                    success: (response) => {
                        console.log(response)
                        $('#form-submit')[0].reset();
                        notify(response.message);
                        const idup = `data-id='${response.data.id}'`;
                        // console.log(idup);
                        var buttons = document.querySelector('button.btn-edit[' + idup + ']');
                        const elembtn = buttons.parentNode.parentNode.childNodes;
                        console.log(elembtn)
                        elembtn[1].innerText = response.data.namebasis;
                        const output = response.data.status == 1 ? true : false;
                        elembtn[3].childNodes[1].childNodes[1].checked = output
                        elembtn[5].innerText = name_campus;
                        elembtn[7].innerText = response.data.start_time_semeter;
                        elembtn[9].innerText = response.data.end_time_semeter;

                        btnEdit = document.querySelectorAll('.btn-edit');
                        update(btnEdit)
                        btnDelete = document.querySelectorAll('.btn-delete');
                        dele(btnDelete)
                        $('#edit_modal').modal('hide');
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
                                url: `admin/semeter/delete/${id}`,
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
