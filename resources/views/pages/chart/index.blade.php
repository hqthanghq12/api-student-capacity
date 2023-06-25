@extends('layouts.main')
@section('title', 'Thống kê')
@section('page-title', 'Thống kê')
@section('content')
{{--<script src="https://cdn.amcharts.com/lib/5/index.js"></script>--}}
{{--<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>--}}
{{--<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>--}}
{{--<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>--}}
{{--<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>--}}
{{--    <!-- CSS -->--}}
<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
<script src="assets/plugins/global/plugins.bundle.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css"/>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">

            <div class="card card-flush p-4">
                <div class="row py-4">
                    <div class="col-4">
                        <select class="form-select"  id="campus">
                            <option value="0">--Chọn Cơ sở--</option>
                            @foreach($listcampus as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <select class="form-select" id="semeter">
                            <option>-- Chọn Kỳ --</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <select class="form-select" id="block">
                            <option>-- Chọn Block --</option>
                        </select>
                    </div>
{{--                    <div class="col-3">--}}
{{--                        <select class="form-select" id="classSubject">--}}
{{--                            <option>Lớp học</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
                </div>
                <div class="row">
                    <div class="col-2 my-4 mx-auto">
                        <button type="button" class="btn btn-primary er fs-6 px-8 py-4" id="searchResult">Xem Thống kê</button>
                    </div>
                </div>
{{--                <div class="row">--}}
{{--                   <div class="col-12">--}}
{{--                       <div class="card-header">--}}
{{--                           <h3 class="card-title">Thống kê sinh viên </h3>--}}
{{--                       </div>--}}
{{--                   </div>--}}

{{--                </div>--}}
                <div class="row " id="data-chart">
                    <div class="col-4 my-4">
                        <!--begin::Alert-->
{{--                        <div class="alert alert-danger d-flex align-items-center p-5 mb-10">--}}
{{--                            <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->--}}
{{--                            <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">--}}
{{--														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">--}}
{{--															<path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"></path>--}}
{{--															<path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor"></path>--}}
{{--														</svg>--}}
{{--													</span>--}}
{{--                            <!--end::Svg Icon-->--}}
{{--                            <div class="d-flex flex-column">--}}
{{--                                <h4 class="mb-1 text-danger">Tổng ca thi</h4>--}}
{{--                                <span>{{ $data['totalPoetry'] }}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <!--end::Alert-->
                        <div class="card shadow-sm bg-danger">
                            <div class="card-header">
                                <h3 class="card-title text-light">Tổng ca thi</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">Tổng ca thi : {{ $data['totalPoetry'] }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 my-4">
                        <div class="card shadow-sm   bg-info">
                            <div class="card-header">
                                <h3 class="card-title text-light">Tổng sinh viên</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">Tổng sinh viên : {{ $data['totalStudentPoetry'] }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 my-4">
                        <div class="card shadow-sm  bg-warning">
                            <div class="card-header">
                                <h3 class="card-title text-light">Sinh Viên chưa phát đề</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">Sinh viên chưa được phát đề : {{ $data['totalPlaytopic'] }} </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 my-4 ">
                        <div class="card shadow-sm bg-primary">
                            <div class="card-header">
                                <h3 class="card-title text-light">Sinh viên đã làm bài</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">Sinh viên đã làm bài :  {{ $data['total_succes_capacity'] }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 my-4">
                        <div class="card shadow-sm bg-success">
                            <div class="card-header">
                                <h3 class="card-title text-light">Tổng sinh viên theo kỳ</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">Tổng sinh viên : {{ $data['totalNoResultCapacity'] }} </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
{{--                <div class="row">--}}
{{--                    <div class="col-12">--}}
{{--                        <div class="card card-p-0 card-flush">--}}
{{--                            <div class="card-body">--}}
{{--                                <table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="table-data">--}}
{{--                                    <thead>--}}
{{--                                    <!--begin::Table row-->--}}
{{--                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase">--}}
{{--                                        <th class="min-w-100px">Kỳ học</th>--}}
{{--                                        <th class="min-w-100px">Block</th>--}}
{{--                                        <th class="min-w-100px">Môn</th>--}}
{{--                                        <th class="min-w-100px">Lớp</th>--}}
{{--                                        <th class="text-end min-w-75px">Ca Học</th>--}}
{{--                                        <th class="text-end min-w-100px pe-5">Action</th>--}}
{{--                                    </tr>--}}
{{--                                    <!--end::Table row-->--}}
{{--                                    </thead>--}}
{{--                                    <tbody class="fw-bold text-gray-600">--}}
{{--                                                                    <tr >--}}
{{--                                                                        <td>--}}
{{--                                                                            <a href="#" class="text-dark text-hover-primary">Summer 2023</a>--}}
{{--                                                                        </td>--}}
{{--                                                                        <td>--}}
{{--                                                                            <a href="#" class="text-dark text-hover-primary">Block 1</a>--}}
{{--                                                                        </td>--}}
{{--                                                                        <td>--}}
{{--                                                                            <div class="badge badge-light-success">Môn Toán</div>--}}
{{--                                                                        </td>--}}
{{--                                                                        <td data-order="2022-03-10T14:40:00+05:00">VIE1026.06</td>--}}
{{--                                                                        <td class="text-end pe-0">Ca 3</td>--}}
{{--                                                                        <td class="text-end"><button class="btn btn-primary er fs-6 px-4 py-2">Xem Thêm</button></td>--}}
{{--                                                                    </tr>--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}


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
        const _token = "{{ csrf_token() }}";
        let selectCampus = document.querySelector('#campus');
    </script>
    <script src="{{ asset('assets/js/system/chart/chart.js') }}"></script>
{{--        $dataChart = json_encode($dataChart);--}}
{{--    <script>--}}
{{--        let datachart = {!! $dataChart !!};--}}
{{--        // console.log(datachart);--}}
{{--        var element = document.getElementById('kt_apexcharts_1');--}}

{{--        var height = parseInt(KTUtil.css(element, 'height'));--}}
{{--        var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');--}}
{{--        var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');--}}
{{--        var baseColor = KTUtil.getCssVariableValue('--bs-warning');--}}
{{--        var secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');--}}

{{--        // if (!element) {--}}
{{--        //     return;--}}
{{--        // }--}}

{{--        var options = {--}}
{{--            series: [{--}}
{{--                name: 'Số ca thi',--}}
{{--                data: datachart.total_poetry--}}
{{--            }],--}}
{{--            chart: {--}}
{{--                fontFamily: 'inherit',--}}
{{--                type: 'bar',--}}
{{--                height: height,--}}
{{--                toolbar: {--}}
{{--                    show: false--}}
{{--                }--}}
{{--            },--}}
{{--            plotOptions: {--}}
{{--                bar: {--}}
{{--                    horizontal: true,--}}
{{--                    columnWidth: ['30%'],--}}
{{--                    endingShape: 'rounded'--}}
{{--                },--}}
{{--            },--}}
{{--            legend: {--}}
{{--                show: false--}}
{{--            },--}}
{{--            dataLabels: {--}}
{{--                enabled: false--}}
{{--            },--}}
{{--            stroke: {--}}
{{--                show: true,--}}
{{--                width: 2,--}}
{{--                colors: ['transparent']--}}
{{--            },--}}
{{--            xaxis: {--}}
{{--                categories: datachart.nameBlock,--}}
{{--                axisBorder: {--}}
{{--                    show: false,--}}
{{--                },--}}
{{--                axisTicks: {--}}
{{--                    show: false--}}
{{--                },--}}
{{--                labels: {--}}
{{--                    style: {--}}
{{--                        colors: labelColor,--}}
{{--                        fontSize: '12px'--}}
{{--                    }--}}
{{--                }--}}
{{--            },--}}
{{--            yaxis: {--}}
{{--                labels: {--}}
{{--                    style: {--}}
{{--                        colors: labelColor,--}}
{{--                        fontSize: '12px'--}}
{{--                    }--}}
{{--                }--}}
{{--            },--}}
{{--            fill: {--}}
{{--                opacity: 1--}}
{{--            },--}}
{{--            states: {--}}
{{--                normal: {--}}
{{--                    filter: {--}}
{{--                        type: 'none',--}}
{{--                        value: 0--}}
{{--                    }--}}
{{--                },--}}
{{--                hover: {--}}
{{--                    filter: {--}}
{{--                        type: 'none',--}}
{{--                        value: 0--}}
{{--                    }--}}
{{--                },--}}
{{--                active: {--}}
{{--                    allowMultipleDataPointsSelection: false,--}}
{{--                    filter: {--}}
{{--                        type: 'none',--}}
{{--                        value: 0--}}
{{--                    }--}}
{{--                }--}}
{{--            },--}}
{{--            tooltip: {--}}
{{--                style: {--}}
{{--                    fontSize: '12px'--}}
{{--                },--}}
{{--                y: {--}}
{{--                    formatter: function (val) {--}}
{{--                        return val + ' ca thi'--}}
{{--                    }--}}
{{--                }--}}
{{--            },--}}
{{--            colors: [baseColor, secondaryColor],--}}
{{--            grid: {--}}
{{--                borderColor: borderColor,--}}
{{--                strokeDashArray: 4,--}}
{{--                yaxis: {--}}
{{--                    lines: {--}}
{{--                        show: true--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}
{{--        };--}}

{{--        var chart = new ApexCharts(element, options);--}}
{{--        chart.render();--}}
{{--    </script>--}}
@endsection

