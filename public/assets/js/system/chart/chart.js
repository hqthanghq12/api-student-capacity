let selectSemeter= $("#semeter");
// let selectBlocks = $("#block");
let DataResult = {};
function eventSubject(btn,htmlimport){
    $(document.body).on("change", '#campus', function() {
        var idCampus = btn.value;
        DataResult.idcampus = idCampus;
        if(idCampus != ""){
            $.ajax({
                url: `/admin/chart/getsemeter/${idCampus}`,
                type: 'GET',
                success: function(response) {
                    // console.log( response.data);
                    let html = '<option value="">-- Chọn Kỳ--</option>';
                    // console.log(response.data)
                    //insert data vào
                    if(response.data != ""){
                        // selectBlocks.html('<option value="">Chọn Block</option>');
                        html += response.data.map((value)=>{
                            return `<option value="${value.id}">${value.name}</option>`
                        }).join(' ')
                    }else  {
                        html += '<option value="">Không có dữ liệu</option>'
                    }
                    // selectSemeter = document.getElementById("blocks");
                    htmlimport.html(html);
                    htmlimport.select2();

                },
                error: function(response) {
                    console.log(response);
                    // Xử lý lỗi
                }
            });
        }else  {

            notify('Tải dữ liệu không thành công !')
        }

    });
}
eventSubject(selectCampus,selectSemeter);
$(document.body).on("change", '#semeter', function(e) {
    var idSemeter = selectSemeter.val();
    DataResult.idsemeter = idSemeter;
    if(idSemeter != ""){
        $.ajax({
            url: `/admin/chart/getBlock/${idSemeter}`,
            type: 'GET',
            success: function(response) {
                console.log( response.data);
                DataResult.idblock = response.data[0].id;
                let html = '<option value="">Chọn Block</option>';
                // console.log(response.data)
                //insert data vào
                if(response.data != ""){
                    html += response.data.map((value)=>{
                        return `<option value="${value.id}">${value.name}</option>`
                    }).join(' ')
                }else  {
                    html += '<option value="">Không có dữ liệu</option>'
                }

                // selectBlocks.html(html);
                // selectBlocks = document.getElementById("block");
            },
            error: function(response) {

                console.log(response);
                // Xử lý lỗi
            }
        });
    }else  {
        // selectBlocks.html('<option value="">-- Chọn Block --</option><option value="">Không có dữ liệu</option>');
        notify('Tải dữ liệu không thành công !')
    }

});
// $(document.body).on("change", '#block', function() {
//     var idblock = selectBlocks.val();
//     DataResult.idblock = idblock;
// });
// var chart1 = null; // Biến lưu trữ đối tượng biểu đồ
// function chartRender(category,data){
//     var element1 = document.getElementById('kt_apexcharts_2');
//
//     var height = parseInt(KTUtil.css(element1, 'height'));
//     var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
//     var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
//     var baseColor = KTUtil.getCssVariableValue('--bs-success');
//     var secondaryColor = KTUtil.getCssVariableValue('--bs-danger');
//     var memecondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');
//     var memecondarythree = KTUtil.getCssVariableValue('--bs-info');
//     if (!element1) {
//         return;
//     }
//
//     var options1 = {
//         series:data,
//         chart: {
//             fontFamily: 'inherit',
//             type: 'bar',
//             height: height,
//             toolbar: {
//                 show: false
//             }
//         },
//         plotOptions: {
//             bar: {
//                 horizontal: true,
//                 columnWidth: ['50%'],
//                 endingShape: 'rounded'
//             },
//         },
//         legend: {
//             show: false
//         },
//         dataLabels: {
//             enabled: false
//         },
//         stroke: {
//             show: true,
//             width: 2,
//             colors: ['transparent']
//         },
//         xaxis: {
//             categories: category,
//             axisBorder: {
//                 show: false,
//             },
//             axisTicks: {
//                 show: false
//             },
//             labels: {
//                 show: true,
//                 style: {
//                     colors: labelColor,
//                     fontSize: '12px'
//                 }
//             }
//         },
//         yaxis: {
//             labels: {
//                 style: {
//                     colors: labelColor,
//                     fontSize: '12px'
//                 }
//             }
//         },
//         fill: {
//             opacity: 1
//         },
//         states: {
//             normal: {
//                 filter: {
//                     type: 'none',
//                     value: 0
//                 }
//             },
//             hover: {
//                 filter: {
//                     type: 'none',
//                     value: 0
//                 }
//             },
//             active: {
//                 allowMultipleDataPointsSelection: false,
//                 filter: {
//                     type: 'none',
//                     value: 0
//                 }
//             }
//         },
//         tooltip: {
//             style: {
//                 fontSize: '12px'
//             },
//             y: {
//                 formatter: function (val,opts) {
//                     var seriesIndex = opts.seriesIndex;
//                     if (seriesIndex === 0) {
//                         return val + ' ca thi'; // Thêm đơn vị "ca thi" cho cột "Tổng ca thi"
//                     } else {
//                         return val + ' sinh viên'; // Giữ nguyên đơn vị "sinh viên" cho các cột khác
//                     }
//                 }
//             }
//         },
//         colors: [baseColor, secondaryColor,memecondaryColor,memecondarythree],
//         grid: {
//             borderColor: borderColor,
//             strokeDashArray: 4,
//             yaxis: {
//                 lines: {
//                     show: true
//                 }
//             }
//         }
//     };
//     // Kiểm tra và hủy biểu đồ cũ nếu tồn tại
//     if (chart1) {
//         chart1.destroy();
//     }
//     chart1 = new ApexCharts(element1, options1);
//     chart1.render();
// }

// var chart = null;
// function charnew(dataChart){
//     am5.ready(function() {
// // Create root element
// // https://www.amcharts.com/docs/v5/getting-started/#Root_element
//         var root = am5.Root.new("kt_amcharts_1");
//
//         if (chart) {
//             console.log(chart);
//             return;
//         }
// // Set themes
// // https://www.amcharts.com/docs/v5/concepts/themes/
//         root.setThemes([
//             am5themes_Animated.new(root)
//         ]);
//
// // Reset biểu đồ nếu tồn tại và không phải lần đầu tiên
// // Create chart
// // https://www.amcharts.com/docs/v5/charts/xy-chart/
//
//
//         chart = root.container.children.push(am5xy.XYChart.new(root, {
//             panX: false,
//             panY: false,
//             wheelX: "panX",
//             wheelY: "zoomX",
//             layout: root.verticalLayout
//         }));
//
// // Add legend
// // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
//         var legend = chart.children.push(
//             am5.Legend.new(root, {
//                 centerX: am5.p50,
//                 x: am5.p50
//             })
//         );
//
//         var data = dataChart;
//
//
// // Create axes
// // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
//         var xRenderer = am5xy.AxisRendererX.new(root, {
//             cellStartLocation: 0.1,
//             cellEndLocation: 0.9
//         })
//
//         var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
//             categoryField: "name", // Thay "year" bằng "name"
//             renderer: xRenderer,
//             tooltip: am5.Tooltip.new(root, {})
//         }));
//
//         xRenderer.grid.template.setAll({
//             location: 1
//         })
//
//         xAxis.data.setAll(data);
//
//         var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
//             renderer: am5xy.AxisRendererY.new(root, {
//                 strokeOpacity: 0.1
//             })
//         }));
//
//
// // Add series
// // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
//         function makeSeries(name, fieldName) {
//             var series = chart.series.push(am5xy.ColumnSeries.new(root, {
//                 name: name,
//                 xAxis: xAxis,
//                 yAxis: yAxis,
//                 valueYField: fieldName,
//                 categoryXField: "name" // Thay "year" bằng "name"
//             }));
//
//             series.columns.template.setAll({
//                 tooltipText: "{name}: {valueY}", // Cập nhật định dạng tooltip
//                 width: am5.percent(90),
//                 tooltipY: 0,
//                 strokeOpacity: 0
//             });
//
//             series.data.setAll(data);
//
//             // Make stuff animate on load
//             // https://www.amcharts.com/docs/v5/concepts/animations/
//             series.appear();
//
//             series.bullets.push(function() {
//                 return am5.Bullet.new(root, {
//                     locationY: 0,
//                     sprite: am5.Label.new(root, {
//                         text: "{valueY}",
//                         fill: root.interfaceColors.get("alternativeText"),
//                         centerY: 0,
//                         centerX: am5.p50,
//                         populateText: true
//                     })
//                 });
//             });
//
//             legend.data.push(series);
//         }
//
//
//         makeSeries("Ca thi", "totalPoetry"); // Thay "Europe" bằng "Total Poetry"
//         makeSeries("Sinh viên chưa làm bài", "total_no_resultCapacity"); // Thay "North America" bằng "Total No Result Capacity"
//         makeSeries("Sinh viên chưa được phát đề", "total_playtopic"); // Thay "Asia" bằng "Total Play Topic"
//         makeSeries("Tổng sinh viên", "total_student_poetry"); // Thay "Latin America" bằng "Total Student Poetry"
//         makeSeries("Sinh viên đã làm bài", "total_succes_capacity"); // Thay "Middle East" bằng "Total Success Capacity"
//
//
//
// // Make stuff animate on load
// // https://www.amcharts.com/docs/v5/concepts/animations/
//         chart.appear(1000, 100);
//
//     }); // end am5.ready()
// }

const search = document.getElementById('searchResult');
const dataSearch = document.getElementById('data-chart');
search.addEventListener('click',() => {
    console.log(DataResult);
    if (
        "idcampus" in DataResult
    ) {
        // Kiểm tra giá trị của từng thuộc tính
        if (
            DataResult.idcampus
        ) {
            $.ajax({
                url: `/admin/chart/GetPoetryDetail`,
                type: 'POST',
                data : DataResult,
                success: function(response) {
                    console.log( response.data);
                    wanrning('Vui lòng chờ ...')

                    var newRow = `  <div class="col-4 my-4">
                        <div class="card shadow-sm bg-danger">
                            <div class="card-header">
                                <h3 class="card-title text-light">Tổng ca thi</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">Tổng ca thi : ${response.data.totalPoetry}</li>
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
                                    <li class="list-group-item">Tổng sinh viên : ${response.data.totalStudentPoetry}</li>
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
                                    <li class="list-group-item">Sinh viên chưa được phát đề : ${response.data.totalPlaytopic} </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 my-4">
                        <div class="card shadow-sm bg-primary">
                            <div class="card-header">
                                <h3 class="card-title text-light">Sinh viên đã làm bài</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">Sinh viên đã làm bài :  ${response.data.total_succes_capacity}</li>
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
                                    <li class="list-group-item">Tổng sinh viên của ca thi : ${response.data.totalNoResultCapacity} </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    `;

                    dataSearch.innerHTML = newRow;

                },
                error: function(response) {

                    console.log(response);
                }
            });

        } else {
            errors("Vui lòng chọn cơ sở");
        }
    } else {
        console.log(DataResult)
        errors("Vui lòng chọn cơ sở");
    }
})
