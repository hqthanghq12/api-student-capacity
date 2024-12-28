@extends('layouts.main')
@section('title', 'Quản lý ca thi')
@section('page-title', 'Quản lý ca thi')
@section('content')
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css"/>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->

            <div class="card card-flush p-4">
                <div class="row">
                    <div class=" col-lg-6">

                        <h1>
                            Danh sách ca thi
                        </h1>
                    </div>
                    <div class=" col-lg-6">
                        {{--                        @if(count($playtopics) > 0)--}}
                        <div class=" d-flex flex-row-reverse bd-highlight">
                            <label data-bs-toggle="modal" data-bs-target="#kt_modal_1" type="button"
                                   class="btn btn-light-primary me-3" id="kt_file_manager_new_folder">

                                <!--end::Svg Icon-->Phát đề thi
                            </label>
                        </div>
                        {{--                            @endif--}}
                    </div>
                </div>


                <div class="table-responsive table-responsive-md">
                    <table id="table-data" class="table table-row-bordered table-row-gray-300 gy-7  table-hover ">
                        <thead>
                        <tr>
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
                            <th scope="col">Tên Môn học</th>
                            <th scope="col">Tên đề</th>
                            <th scope="col">Thời gian Phát đề
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
                            <th colspan="2"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($playtopics) > 0)
                            @foreach($playtopics as $key => $value)
                                <tr>
                                    <td>
                                        {{ $value->userStudent->name }}
                                    </td>
                                    <td>
                                        {{ $value->subjectStd->name }}
                                    </td>
                                    <td>
                                        {{ $value->examStd->name }}
                                    </td>
                                    <td>{{ $value->created_at == null ? 'Chưa có thời gian phát đề' :    date('d-m-Y', strtotime($value->created_at)) 	 }}</td>
                                    {{--                                    <td class="text-end">--}}
                                    {{--                                        <button  class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions--}}
                                    {{--                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->--}}
                                    {{--                                            <span class="svg-icon svg-icon-5 m-0">--}}
                                    {{--															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">--}}
                                    {{--																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>--}}
                                    {{--															</svg>--}}
                                    {{--														</span>--}}
                                    {{--                                            <!--end::Svg Icon--></button>--}}
                                    {{--                                        <!--begin::Menu-->--}}
                                    {{--                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true" style="">--}}
                                    {{--                                            <!--begin::Menu item-->--}}
                                    {{--                                            <div class="menu-item px-3">--}}
                                    {{--                                                <button  class="menu-link px-3 border border-0 bg-transparent btn-exam" onclick="location.href='{{ route('admin.poetry.playtopic.index',$value->id) }}'"  type="button">--}}
                                    {{--                                                    Phát đề--}}
                                    {{--                                                </button>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <div class="menu-item px-3">--}}
                                    {{--                                                <button  class="menu-link px-3 border border-0 bg-transparent" onclick="location.href='{{ route('admin.poetry.manage.index',$value->id) }}'"   type="button">--}}
                                    {{--                                                    Chi tiết--}}
                                    {{--                                                </button>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <div class="menu-item px-3">--}}
                                    {{--                                                <button  class="btn-edit menu-link px-3 border border-0 bg-transparent"  data-id="{{ $value->id }}" data-semeter="{{ $value->id_semeter }}">--}}
                                    {{--                                                    Chỉnh sửa--}}
                                    {{--                                                </button>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <!--end::Menu item-->--}}
                                    {{--                                            <!--begin::Menu item-->--}}
                                    {{--                                            <div class="menu-item px-3">--}}
                                    {{--                                                <button  class="btn-delete menu-link border border-0 bg-transparent" data-id="{{ $value->id }}" data-kt-users-table-filter="delete_row">Delete</button>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <!--end::Menu item-->--}}
                                    {{--                                        </div>--}}
                                    {{--                                        <!--end::Menu-->--}}
                                    {{--                                    </td>--}}
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">
                                    <h1 class="text-center">Không có sinh viên ở ca thi này </h1>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            {{ $playtopics->links() }}
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
                    <h5 class="modal-title">Phát đề thi</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="form-submit"
                      action="{{ $total >= 1 ? route('admin.poetry.playtopic.create.reload') : route('admin.poetry.playtopic.create') }}">
                    @csrf
                    <input type="hidden" name="id_poetry" id="id_poetry" value="{{ $id_poetry }}">

                    <div class="form-group m-10">
                        <select class="form-select" name="mixing" id="mixing">
                            <option selected value="">--Trộn câu hỏi--</option>
                            <option value="0">Không</option>
                            <option value="1">Có</option>
                        </select>
                    </div>
                    <div class="form-group m-10">
                        <select class="form-select" name="semeter" id="campuses" data-subject="{{ $id_subject }}">
                            <option selected value="">--Chọn cơ sở--</option>
                            @foreach($campusList as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-10">
                        <select class="form-select" name="subject" id="exam_id" style="display:none;">

                        </select>
                    </div>

                    <div class="modal-footer">
                        @if($total >= 1)
                            <button type="button" id="reloadPlaytopic" class=" btn btn-primary">Phát Lại</button>
                        @else
                            <button type="button" id="upload-basis" class=" btn btn-primary">Phát</button>
                        @endif
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
        let STT = parseInt(table[table.length - 1].childNodes[1].innerText) + 1;
        let btnDelete = document.querySelectorAll('.btn-delete');
        let btnEdit = document.querySelectorAll('.btn-edit');
        let btnUpdate = document.querySelector('#btn-update');
        let selectElement = document.querySelector('#campuses');
        const _token = "{{ csrf_token() }}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/system/poetry/playtopic.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    {{--    Thêm --}}
    <script>
        $('#upload-basis').click(function (e) {
            e.preventDefault();
            var url = $('#form-submit').attr("action");
            var mixing = $('#mixing').val();
            var campuses_id = $('#campuses').val();
            var id_subject = $('#campuses').attr('data-subject');
            var exam_id = $('#exam_id').val();
            var id_poetry = $('#id_poetry').val();

            var dataAll = {
                '_token': _token,
                'mixing': mixing,
                'campuses_id': campuses_id,
                'id_subject': id_subject,
                'exam_id': exam_id,
                'id_poetry': id_poetry
            }
            console.log(dataAll);
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
                    wanrning('Đang tải dữ liệu mới ...');
                    setTimeout(()=>{
                        window.location.reload();
                    },1000);
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

@endsection
