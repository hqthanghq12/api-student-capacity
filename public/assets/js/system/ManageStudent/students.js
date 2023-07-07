let selectBlocks = document.getElementById("blocks");
let selectSubject = document.getElementById("subjects");
let classSubjectSelect = document.getElementById("classSubject");
let DataResult = {};
function eventSubject(btn,htmlimport){
    btn.addEventListener("change", function() {
        var idSemeter = btn.value;
        DataResult.semeter = idSemeter;
        wanrning('Đang Tải dữ liệu ... !')
        if(idSemeter != ""){
            $.ajax({
                url: `/admin/accountStudent/GetBlock/${idSemeter}`,
                type: 'GET',
                success: function(response) {
                    console.log( response.data);
                    let html = '<option value="">-- Chọn Block--</option>';
                    notify('Tải dữ liệu thành công !')
                    // console.log(response.data)
                    //insert data vào
                    if(response.data != ""){
                        html += response.data.map((value)=>{
                            DataResult.nameBlock = value.name
                            return `<option value="${value.id}">${value.name}</option>`
                        }).join(' ')
                    }else  {
                        html += '<option value="">Không có dữ liệu</option>'
                    }
                    selectBlocks = document.getElementById("blocks");
                    htmlimport.innerHTML = html;
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
eventSubject(selectSemeter,selectBlocks);
selectBlocks.addEventListener("change", function() {
    var idblock = selectBlocks.value;
    DataResult.block = idblock;
    var selectedOption = selectBlocks.options[selectBlocks.selectedIndex];
    DataResult.nameBlock  = selectedOption.text;
    if(idblock != ""){
        $.ajax({
            url: `/admin/accountStudent/GetSubject/${idblock}`,
            type: 'GET',
            success: function(response) {
                console.log( response.data);
                let html = '<option value="">-- Chọn Môn --</option>';
                // console.log(response.data)
                //insert data vào
                if(response.data != ""){
                    html += response.data.map((value)=>{
                        return `<option value="${value.id}">${value.name}</option>`
                    }).join(' ')
                }else  {
                    html += '<option value="">Không có dữ liệu</option>'
                }

                selectSubject.innerHTML = html;
                selectSubject = document.getElementById("subjects");
            },
            error: function(response) {

                console.log(response);
                // Xử lý lỗi
            }
        });
    }else  {
        selectSubject.innerHTML = '<option value="">-- Chọn Môn --</option><option value="">Không có dữ liệu</option>'
        notify('Tải dữ liệu không thành công !')
    }

});
selectSubject.addEventListener("change", function() {
    var idSubject = selectSubject.value;
    DataResult.subject = idSubject;
    if(idSubject != ""){
        $.ajax({
            url: `/admin/accountStudent/GetPoetry/${idSubject}`,
            type: 'GET',
            success: function(response) {
                console.log( response.data);
                let html = '<option value="">-- Lớp học --</option>';
                // console.log(response.data)
                //insert data vào
                if(response.data != ""){
                    var seenIds = [];
                    html += response.data.map((value)=>{
                        if (!seenIds.includes(value.classsubject.id)) {
                            seenIds.push(value.classsubject.id); // Thêm id vào mảng lưu trữ

                            return `<option value="${value.classsubject.id}">${value.classsubject.name}</option>`;
                        }
                        // return `<option value="${value.classsubject.id}">${value.classsubject.name}</option>`
                    }).join(' ')
                }else  {
                    html += '<option value="">Không có dữ liệu</option>'
                }

                classSubjectSelect.innerHTML = html;
                classSubjectSelect = document.getElementById("classSubject");
            },
            error: function(response) {

                console.log(response);
                // Xử lý lỗi
            }
        });
    }else  {
        classSubjectSelect.innerHTML = '<option value="">-- Lớp học --</option><option value="">Không có dữ liệu</option>'
        notify('Tải dữ liệu không thành công !')
    }
});
classSubjectSelect.addEventListener("change", function() {
    var idClass = classSubjectSelect.value;
    DataResult.class  = idClass;
    console.log(DataResult);
    const url = `admin/accountStudent/exportClass/${DataResult.semeter}/${DataResult.block}/${DataResult.subject}/${DataResult.class}`
    const btnEx = document.querySelector('#btnExport');
    if (idClass !== "") {
        btnEx.innerHTML = ` <button type="button" class="btn btn-primary er fs-6 px-8 py-4" onclick="location.href='${url}'">Xuất Điểm</button>`
    }else  {
        btnEx.innerHTML = ``
    }
});
const search = document.getElementById('searchResult');
search.addEventListener('click',() => {
    $.ajax({
        url: `/admin/accountStudent/GetPoetryDetail`,
        type: 'POST',
        data : DataResult,
        success: function(response) {
            console.log( response.data);
            console.log(response.data)
            //insert data vào
            var newRow = "";
            if(response.data != ""){
                newRow = response.data.map((value)=>{
                    return `               <tr >
                                    <td>
                                        <span href="#" class="text-dark text-hover-primary">${ value.name}</span>
                                    </td>
                                    <td>
                                        <span href="#" class="text-dark text-hover-primary">${ value.email}</span>
                                    </td>
                                    <td>
                                        <div class="badge badge-light-success" style="cursor: pointer;" onclick="location.href='admin/accountStudent/viewpoint/${value.id}'">${ value.mssv}</div>
                                    </td>
                                    <td data-order="2022-03-10T14:40:00+05:00">${ value.campus.name}</td>
                                </tr>
                    `;
                }).join(' ')
            }else  {
                notify('Không có dữ liệu!')
                html = '<tr colspan="6"> Chưa có dữ liệu</tr>'
            }

            $('#table-data tbody').html(newRow);

        },
        error: function(response) {

            console.log(response);
        }
    });
    // if (
    //     "semeter" in DataResult &&
    //     "block" in DataResult &&
    //     "subject" in DataResult &&
    //     "class" in DataResult
    // ) {
    //     // Kiểm tra giá trị của từng thuộc tính
    //     if (
    //         DataResult.semeter &&
    //         DataResult.block &&
    //         DataResult.subject &&
    //         DataResult.class
    //     ) {
    //         $.ajax({
    //             url: `/admin/accountStudent/GetPoetryDetail`,
    //             type: 'POST',
    //             data : DataResult,
    //             success: function(response) {
    //                 console.log( response.data);
    //                 // console.log(response.data)
    //                 //insert data vào
    //                 var newRow = "";
    //                 if(response.data != ""){
    //                     newRow = response.data.map((value)=>{
    //                         return `               <tr >
    //                                 <td>
    //                                     <a href="#" class="text-dark text-hover-primary">${ value.semeter.name}</a>
    //                                 </td>
    //                                 <td>
    //                                     <a href="#" class="text-dark text-hover-primary">${ DataResult.nameBlock}</a>
    //                                 </td>
    //                                 <td>
    //                                     <div class="badge badge-light-success">${ value.subject.name}</div>
    //                                 </td>
    //                                 <td data-order="2022-03-10T14:40:00+05:00">${ value.classsubject.name}</td>
    //                                 <td class="text-end pe-0">${ value.examination.name}</td>
    //                                 <td class="text-end"><button class="btn btn-primary er fs-6 px-4 py-2" onclick="location.href='admin/accountStudent/ListUser/${value.id}'">Xem Thêm</button></td>
    //                             </tr>
    //                 `;
    //                     }).join(' ')
    //                 }else  {
    //                     notify('Không có dữ liệu!')
    //                     html = '<tr colspan="6"> Chưa có dữ liệu</tr>'
    //                 }
    //
    //                 $('#table-data tbody').append(newRow);
    //
    //             },
    //             error: function(response) {
    //
    //                 console.log(response);
    //             }
    //         });
    //
    //     } else {
    //         errors("Vui lòng chọn đủ các thông tin");
    //     }
    // } else {
    //     console.log(DataResult)
    //     errors("Vui lòng chọn đủ môn và bộ môn cần tra cứu");
    // }
})
