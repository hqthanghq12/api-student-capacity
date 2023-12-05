@extends('layouts.main')
@section('title', 'Quản lý bộ câu hỏi')
@section('page-title', 'Quản lý bộ câu hỏi')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css"/>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>

    <div class="mb-5">
        {{ Breadcrumbs::render('Management.exam.question',$id_subject,$name,$id ) }}
    </div>
    <div class="card card-flush p-4">
        <div class="row mb-4">
            <div class=" col-lg-6">

                <h1>Danh sách bộ câu hỏi</h1>
            </div>
        </div>
        {{--  --}}

        <div class="row card-format">

            <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                <div class="form-group">
                    <label class="form-label">Level</label>
                    <select id="select-level" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                            data-hide-search="true" tabindex="-1" aria-hidden="true">
                        {{-- <option @selected(request()->has('status') && request('status') == 0) value="0">Không kích hoạt
                        </option>
                        <option @selected(request('status') == 1) value="1">Kích họat
                        </option> --}}
                        <option value="3" @selected(!request()->has('level'))>Chọn level</option>
                        <option @selected(request()->has('level') && request('level') == 0) value="0">Dễ</option>
                        <option @selected(request()->has('level') && request('level') == 1) value="1">Trung bình
                        </option>
                        <option @selected(request()->has('level') && request('level') == 2) value="2">Khó</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                <div class="form-group">
                    <label class="form-label">Loại</label>
                    <select id="select-type" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                            data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option value="3" @selected(!request()->has('type'))>Chọn loại</option>
                        <option @selected(request()->has('type') && request('type') == 0) value="0">Một đáp án</option>
                        <option @selected(request()->has('type') && request('type') == 1) value="1">Nhiều đáp án
                        </option>

                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                <div class="form-group">
                    <label class="form-label">Trạng thái</label>
                    <select id="select-status" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                            data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option value="3" @selected(!request()->has('status'))>Chọn trạng thái</option>
                        <option @selected(request()->has('status') && request('status') == 0) value="0">Không kích hoạt
                        </option>
                        <option @selected(request('status') == 1) value="1">Kích họat
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

        {{--  --}}
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
            @if (count($questions) > 0)
                <table class="table table-row-bordered  table-row-gray-100 gy-1 table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Nội dung câu hỏi
                            <a>
                                    <span role="button" data-key="name" data-bs-toggle="tooltip"
                                          title="Lọc theo nội dung câu hỏi "
                                          class=" svg-icon svg-icon-primary  svg-icon-2x format-database">
                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            style="width: 14px !important ; height: 14px !important" width="24px"
                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <rect fill="#000000" opacity="0.3"
                                                      transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) "
                                                      x="5" y="5" width="2" height="12"
                                                      rx="1"/>
                                                <path
                                                    d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z"
                                                    fill="#000000" fill-rule="nonzero"/>
                                                <rect fill="#000000" opacity="0.3"
                                                      transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) "
                                                      x="17" y="7" width="2" height="12"
                                                      rx="1"/>
                                                <path
                                                    d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z"
                                                    fill="#000000" fill-rule="nonzero"
                                                    transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) "/>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                            </a>

                        </th>
                        <th scope="col">Phiên bản</th>
                        <th scope="col">Level câu hỏi</th>
                        <th scope="col">Loại</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Chỉnh sửa bởi</th>
                        <th scope="col">Thời gian chỉnh sửa
                            <a
                                href="{{ route('admin.question.index', [
                                        'sortBy' => request()->has('sortBy') ? (request('sortBy') == 'desc' ? 'asc' : 'desc') : 'asc',
                                        'orderBy' => 'created_at',
                                    ]) }}">
                                    <span role="button" data-key="end_time" data-bs-toggle="tooltip"
                                          title="Lọc theo ngày tạo "
                                          class=" svg-icon svg-icon-primary  svg-icon-2x format-database">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                             style="width: 14px !important ; height: 14px !important" width="24px"
                                             height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <rect fill="#000000" opacity="0.3"
                                                      transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) "
                                                      x="5" y="5" width="2" height="12"
                                                      rx="1"/>
                                                <path
                                                    d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z"
                                                    fill="#000000" fill-rule="nonzero"/>
                                                <rect fill="#000000" opacity="0.3"
                                                      transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) "
                                                      x="17" y="7" width="2" height="12"
                                                      rx="1"/>
                                                <path
                                                    d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z"
                                                    fill="#000000" fill-rule="nonzero"
                                                    transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) "/>
                                            </g>
                                        </svg>
                                    </span>
                            </a>

                        </th>
                        <th class="text-center" colspan="2">
                            Thao tác
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $total = $questions->total();
                    @endphp
                    @forelse ($questions as $key => $question)
                        @php
                            $token = uniqid(15);
                            $images = $question->images->toArray();
                        @endphp
                        <tr>

                            <td style="width:30%">
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default mb-5">
                                        <div class="panel-heading" role="tab" id="heading{{ $token }}">
                                            <h6 class="panel-title">
                                                <div role="button" data-toggle="collapse" data-parent="#accordion"
                                                     aria-expanded="true" aria-controls="collapse{{ $token }}">
                                                    {!! renderQuesAndAns($question->content, $images) !!}
                                                </div>
                                            </h6>
                                        </div>
                                        <div id="collapse{{ $token }}" class="panel-collapse collapse"
                                             role="tabpanel" aria-labelledby="heading{{ $token }}">
                                            <div class="panel-body">
                                                <ul class="list-group list-group-flush">
                                                    @if (count($question->answers) > 0)
                                                        <li
                                                            class="list-group-item fw-bold">
                                                            Đáp án
                                                        </li>
                                                        @foreach ($question->answers as $answer)
                                                            <li
                                                                class="list-group-item {{ $answer->is_correct == config('util.ANSWER_TRUE') ? 'active' : '' }}">
                                                                {!! renderQuesAndAns($answer->content, $images) !!}
                                                            </li>
                                                        @endforeach
                                                    @endif

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>

                            <td>
                                {{ $question->version }}
                            </td>
                            <td style="width:10%">
                                <button class="btn btn-info btn-sm">
                                    @if ($question->rank == config('util.RANK_QUESTION_EASY'))
                                        Dễ
                                    @elseif ($question->rank == config('util.RANK_QUESTION_MEDIUM'))
                                        Trung bình
                                    @elseif ($question->rank == config('util.RANK_QUESTION_DIFFICULT'))
                                        Khó
                                    @endif
                                </button>
                            </td>
                            <td>
                                @if ($question->type == config('util.INACTIVE_STATUS'))
                                    Một đáp án
                                @else
                                    Nhiều đáp án
                                @endif
                            </td>
                            <td>
                                <div data-bs-toggle="tooltip" title="Cập nhật trạng thái "
                                     class="form-check form-switch">
                                    <input value="{{ $question->status }}" data-id="{{ $question->id }}"
                                           class="form-select-status form-check-input " @checked($question->status == 1)
                                           type="checkbox" role="switch">
                                </div>
                            </td>
                            <td>
                                {{ $question->user?->name ?? "Chưa có" }}
                            </td>
                            <td>{{ $question->created_at }}</td>
                            <td>
                                @hasanyrole(config('util.ROLE_ADMINS'))

                                <div data-bs-toggle="tooltip" title="Thao tác " class="btn-group dropstart">
                                    <button type="button" class="btn   btn-sm dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="svg-icon svg-icon-success svg-icon-2x">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                         height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24"
                                                                  height="24"/>
                                                            <path
                                                                d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                                                fill="#000000"/>
                                                        </g>
                                                    </svg>
                                                </span>
                                    </button>
                                    <ul class="dropdown-menu  px-4 ">

                                        <li class="my-3">

                                            <button
                                                data-question="{{ $question->id }}" data-id="{{ $id }}"
                                                data-subject="{{ $id_subject }}" data-name="{{ $name }}"
                                                style=" background: none ; border: none ; list-style : none"
                                                type="button" class=""
                                                data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_exc_{{ $question->id }}"
                                                type="button"
                                                class="btn me-3"
                                                id="kt_file_manager_new_folder"
                                            >
                                                            <span
                                                                class="svg-icon svg-icon-2 me-2">
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
                                                Sửa
                                            </button>
                                            <button
                                                data-question="{{ $question->id }}" data-id="{{ $id }}"
                                                data-subject="{{ $id_subject }}" data-name="{{ $name }}"
                                                style=" background: none ; border: none ; list-style : none"
                                                type="button" class="history-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_round_"
                                                type="button"
                                                class="btn me-3"
                                                data-base-id="{{ $question->base_id ?? $question->id }}"
                                            >
                                                                <span
                                                                    class="svg-icon svg-icon-2 me-2">
                                                                    <svg width="24" height="24" viewBox="0 0 15 15"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            fill-rule="evenodd"
                                                                            clip-rule="evenodd"
                                                                            d="M13.15 7.49998C13.15 4.66458 10.9402 1.84998 7.50002 1.84998C4.72167 1.84998 3.34849 3.9064 2.76335 5H4.5C4.77614 5 5 5.22386 5 5.5C5 5.77614 4.77614 6 4.5 6H1.5C1.22386 6 1 5.77614 1 5.5V2.5C1 2.22386 1.22386 2 1.5 2C1.77614 2 2 2.22386 2 2.5V4.31318C2.70453 3.07126 4.33406 0.849976 7.50002 0.849976C11.5628 0.849976 14.15 4.18537 14.15 7.49998C14.15 10.8146 11.5628 14.15 7.50002 14.15C5.55618 14.15 3.93778 13.3808 2.78548 12.2084C2.16852 11.5806 1.68668 10.839 1.35816 10.0407C1.25306 9.78536 1.37488 9.49315 1.63024 9.38806C1.8856 9.28296 2.17781 9.40478 2.2829 9.66014C2.56374 10.3425 2.97495 10.9745 3.4987 11.5074C4.47052 12.4963 5.83496 13.15 7.50002 13.15C10.9402 13.15 13.15 10.3354 13.15 7.49998ZM7.5 4.00001C7.77614 4.00001 8 4.22387 8 4.50001V7.29291L9.85355 9.14646C10.0488 9.34172 10.0488 9.65831 9.85355 9.85357C9.65829 10.0488 9.34171 10.0488 9.14645 9.85357L7.14645 7.85357C7.05268 7.7598 7 7.63262 7 7.50001V4.50001C7 4.22387 7.22386 4.00001 7.5 4.00001Z"
                                                                            fill="#000000"
                                                                        />
                                                                    </svg>
                                                                </span>
                                                Lịch sử
                                            </button>
                                        </li>
                                    </ul>
                                </div>

                                @endhasrole
                            </td>

                        </tr>
                        <div class="modal fade" tabindex="-1"
                             id="kt_modal_exc_{{ $question->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Tải lên file excel sửa câu hỏi số
                                            <strong>{{ $question->id }}</strong>
                                        </h5>

                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                             data-bs-dismiss="modal" aria-label="Close">
                                            <span class="svg-icon svg-icon-2x"></span>
                                            Thoát
                                        </div>
                                        <!--begin::Close-->
                                        <!--end::Close-->
                                    </div>
                                    <form class="form-submit"
                                          action="{{ route('admin.subject.question.excel.import', ['exam_id' => $id, 'base_id' => $question->base_id ?? $question->id]) }}"
                                          method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body text-center">
                                            <div class="HDSD">
                                            </div>
                                            <label for="up-file{{ $question->id }}"
                                                   class="">
                                                <i data-bs-toggle="tooltip"
                                                   title="Click để upload file"
                                                   style="font-size: 100px;"
                                                   role="button"
                                                   class="bi bi-cloud-plus-fill"></i>
                                            </label>
                                            <input style="display: none" type="file"
                                                   name="ex_file" class="up-file"
                                                   id="up-file{{ $question->id }}">
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
                                            <a
                                                class="btn btn-success"
                                                href="{{ route('admin.subject.question.excel.export', $question->id) }}"
                                            >
                                                Tải file câu hỏi số <strong>{{ $question->id }}</strong>
                                            </a>
                                            <button type="submit"
                                                    class="upload-file btn btn-primary">Tải
                                                lên
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                    @endforelse
                    </tbody>
                </table>
                {{ $questions->appends(request()->all())->links('pagination::bootstrap-4') }}
            @else
                <h2>Câu hỏi chưa cập nhập !!!</h2>
            @endif
        </div>


        <div class="modal fade" tabindex="-1"
             id="kt_modal_round_">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Lịch sử chỉnh sửa của câu hỏi số <span id="modal-title__base-id"></span>
                        </h5>

                        <form method="post" id="form-set-current-version"
                              action="{{ route('admin.subject.question.current') }}">
                            @csrf
                            <input type="hidden" name="question_set_current_id" id="question_set_current_id">
                            <button class="btn btn-sm btn-primary ms-2 disabled btn-set-current-id">
                                Chọn phiên bản này
                            </button>
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                 data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-2x"></span>
                                Thoát
                            </div>
                        </form>
                    </div>
                    <div class="card card-plush p-2">
                        <style>
                            .tab-content {
                                width: 100%;
                            }
                        </style>
                        <div id="modal-loading-content" class="w-100 text-center">
                            <div class="spinner-grow text-primary" role="status"></div>
                            <h3 class="text-primary mt-3">Đang tải lịch sử</h3>
                        </div>
                        <div id="modal-container" class="h-500px" style="overflow-y: auto">
                            <div class="d-flex justify-content-between flex-column flex-md-row">
                                <ul class="nav nav-tabs nav-pills flex-row border-0 flex-md-column me-5 mb-3 mb-md-0 fs-6"
                                    id="listTabs">

                                </ul>
                                <div class="modal-body">
                                    <div class="tab-content" id="myTabContent">
                                        <!--end::Content-->

                                    </div>
                                </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')

    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
{{--    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>--}}
    <script id="MathJax-script" async src="assets/js/custom/apps/mathjax/tex-mml-chtml.js"></script>
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

        window.MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']]
            }
        };

        let url = "/admin/subject/question/{{$id}}/{{ $id_subject }}/{{ $name }}?";
        const _token = "{{ csrf_token() }}";
        let btnHistory = document.querySelectorAll('.history-btn');
        const sort = '{{ request()->has('sort') ? (request('sort') == 'desc' ? 'asc' : 'desc') : 'asc' }}';
        const start_time =
            '{{ request()->has('start_time') ? \Carbon\Carbon::parse(request('start_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
        const end_time =
            '{{ request()->has('end_time') ? \Carbon\Carbon::parse(request('end_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
    </script>

    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script src="{{ asset('assets/js/system/question/subjectQuestions.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        question.selectChangeStatus(
            ".form-select-status"
        );
        question.selectLevelList('#select-level');
        question.selectTypeList('#select-type');
    </script>
    <script>
        $(document).ready(function () {
            $('#up-file').on("change", function () {
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
                    notify("Tải lên thành công !");
                    $('.up-file').val('');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                    setTimeout(() => {
                        $('.modal').modal('hide');
                    }, 500);
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

            $(".panel-heading").parent('.panel').hover(
                function () {
                    $(this).children('.collapse').collapse('show');
                },
                function () {
                    $(this).children('.collapse').collapse('hide');
                }
            );


        })


    </script>

    <script>

        const questionSetCurrentIdInput = $('#question_set_current_id');
        const formSetCurrentVersion = $('#form-set-current-version');
        const btnSetCurrent = $('.btn-set-current-id').get(0);
        const modalContainer = $('#modal-container');
        const listTabs = $('#listTabs');
        const listContent = $('#myTabContent');
        const modalLoadingContent = $('#modal-loading-content');
        const ranks = @json(config('util.EXCEL_QESTIONS.RANKS'));

        formSetCurrentVersion.get(0).onsubmit = e => {
            e.preventDefault();
            const data = new FormData(e.target);
            $.ajax({
                type: 'POST',
                url: formSetCurrentVersion.attr('action'),
                data: data,
                processData: false,
                contentType: false,
                success: (response) => {
                    notify(response.payload);
                    $('#kt_modal_round_').modal('hide', 1000);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                },
                error: (response) => {
                    errors(response.responseJSON.message);
                }
            })
        }

        const setQuestionId = id => {
            questionSetCurrentIdInput.val(id);
        }

        const getDate = date => {
            const newDate = new Date(date);
            const yyyy = newDate.getFullYear();
            let mm = newDate.getMonth() + 1; // Months start at 0!
            let dd = newDate.getDate();

            if (dd < 10) dd = '0' + dd;
            if (mm < 10) mm = '0' + mm;

            return dd + '/' + mm + '/' + yyyy;
        }

        function renderQuesAndAns(text, imageCodeArr = []) {
            const regImageCode = /\[anh\d+\]/g;

            let matches = text.match(regImageCode);
            let imgCodeColArr = imageCodeArr.map(item => item.img_code);
            if (matches) {
                matches.forEach(item => {
                    let imgCode = item.replace(/[\[\]]/g, '');

                    let key = imgCodeColArr.indexOf(imgCode);
                    if (key === -1) return;
                    let img = imageCodeArr[key];
                    text = text.replace(item, `<div class='p-2 text-center'><img class='w-25' src='${img.path}' /></div>`);
                });
            }
            return text;
        }


        for (const item of btnHistory) {
            item.addEventListener("click", () => {
                btnSetCurrent.classList.add('disabled');
                modalContainer.hide();
                modalLoadingContent.show();
                const id = item.getAttribute("data-id");
                const id_question = item.getAttribute("data-question");
                const id_subject = item.getAttribute("data-subject");
                const name = item.getAttribute("data-name");
                const base_id = item.getAttribute("data-base-id");
                setQuestionId(id_question);
                $('#modal-title__base-id').html(base_id);
                $.ajax({
                    type: 'GET',
                    url: `admin/subject/question/${base_id}/versions`,
                    data: {},
                    success: (response) => {
                        modalLoadingContent.hide(500);
                        let listTabsHtml = '';
                        let listContentHtml = '';
                        const versions = response.payload;
                        for (const item of versions) {
                            const listAnsHtml = item.answers.map(ans => {
                                return `
                                        <div class="p-3 border-2 border-bottom border-secondary ${ans.is_correct ? 'bg-primary text-white' : ''}">
                                            ${renderQuesAndAns(ans.content, item.images)}
                                        </div>
                                    `;
                            }).join('');
                            listTabsHtml += `
                                <li class="nav-item me-0 mb-md-2">
                                    <a style="width: 100%" class="nav-link btn btn-flex btn-active-primary ${item.is_current_version ? 'active' : ''}" data-bs-toggle="tab" onclick="setQuestionId(${item.id})"
                                       href="#kt_vtab_pane_${item.id}">
                                        <span class="d-flex flex-column align-items-start">
                                            <span class="fs-4 fw-bolder">${item.version}</span>
                                        </span>
                                    </a>
                                </li>
                            `;
                            listContentHtml += `
                                <div class="tab-pane fade tab-list ${item.is_current_version ? 'active show' : ''}" id="kt_vtab_pane_${item.id}" role="tabpanel">
                                    <div class="d-flex justify-content-between pb-3 border-2 border-bottom border-primary">
                                        <div>
                                            <h1>
                                                Phiên bản ${item.version}
                                            </h1>
                                            <span class="text-dark">${item?.user?.name ?? 'Chưa có'} - ${getDate(item.created_at)}</span>
                                        </div>
                                        <div>
                                            <table border="0">
                                                <tr>
                                                    <td>Loại câu hỏi:</td>
                                                    <td><strong class="text-primary">${item.type == 0 ? 'Một đáp án' : 'Nhiều đáp án'}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Mức độ:</td>
                                                    <td><strong class="text-primary">${ranks[item.rank]}</strong></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row pt-3">
                                        <div class="col-7">
                                            <div class="sticky-top">
                                                <h3 class="border-1 border-bottom border-secondary pb-2">Câu hỏi</h3>
                                                <div class="fw-bold pt-2">
                                                    ${renderQuesAndAns(item.content, item.images)}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <h3 class="border-1 border-bottom border-secondary pb-2">Đáp án</h3>
                                            <div class="pt-2">
                                                ${listAnsHtml}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                        listTabs.html(listTabsHtml);
                        listContent.html(listContentHtml);
                        MathJax.typesetPromise([modalContainer.get(0)]).catch((err) => {
                            console.log('MathJax error', err);
                        });
                        btnSetCurrent.classList.remove('disabled');
                        modalContainer.show(700);
                    },
                    error: function (response) {
                        errors(response.responseText);
                    }
                });
            })
        }
    </script>

@endsection
