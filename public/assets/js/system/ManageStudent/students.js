// let selectBlocks = document.getElementById("blocks");
let selectSubject = document.getElementById("subjects");
let classSubjectSelect = document.getElementById("classSubject");
let blockId;
let DataResult = {};

const btnEx = document.querySelector('#btnExport');

function eventSubject(btn, htmlimport = undefined) {
    btn.addEventListener("change", function () {
        var idSemeter = btn.value;
        DataResult.semeter = idSemeter;
        // wanrning('Đang Tải dữ liệu ... !');
        if (idSemeter) {
            $.ajax({
                url: `/admin/accountStudent/GetBlock/${idSemeter}`,
                type: 'GET',
                success: function (response) {
                    let html = '<option value="">-- Chọn Môn --</option>';
                    // console.log(response.data)
                    //insert data vào
                    if (response.block_id !== "") {
                        blockId = response.block_id;
                        DataResult.block = blockId;
                    }
                    if (response.data != "") {
                        html += response.data.map((value) => {
                            return `<option value="${value.id}">${value.name}</option>`
                        }).join(' ')
                    } else {
                        html += '<option value="">Không có dữ liệu</option>'
                    }

                    selectSubject.innerHTML = html;
                },
                error: function (response) {
                    console.log(response);
                    // Xử lý lỗi
                }
            });
        } else {
            selectSubject.value = '';
            classSubjectSelect.value = '';
            btnEx.innerHTML = ``;
            // notify('Tải dữ liệu không thành công !')
        }

    });
}

eventSubject(selectSemeter);
selectSubject.addEventListener("change", function () {
    var idSubject = selectSubject.value;
    DataResult.subject = idSubject;
    if (idSubject != "") {
        $.ajax({
            url: `/admin/accountStudent/GetPoetry/${idSubject}`,
            type: 'GET',
            success: function (response) {
                // console.log(response.data);
                let html = '<option value="">-- Lớp học --</option>';
                // console.log(response.data)
                //insert data vào
                if (response.data != "") {
                    var seenIds = [];
                    html += response.data.map((value) => {
                        if (!seenIds.includes(value.classsubject.id)) {
                            seenIds.push(value.classsubject.id); // Thêm id vào mảng lưu trữ

                            return `<option value="${value.classsubject.id}">${value.classsubject.name}</option>`;
                        }
                        // return `<option value="${value.classsubject.id}">${value.classsubject.name}</option>`
                    }).join(' ');
                } else {
                    html += '<option value="">Không có dữ liệu</option>'
                }

                classSubjectSelect.innerHTML = html;
                classSubjectSelect = document.getElementById("classSubject");
            },
            error: function (response) {

                console.log(response);
                // Xử lý lỗi
            }
        });
    } else {
        classSubjectSelect.innerHTML = '<option value="">-- Lớp học --</option><option value="">Không có dữ liệu</option>'
        // notify('Tải dữ liệu không thành công !')
    }

    const url = `admin/accountStudent/exportClass/${selectSemeter.value}/${blockId}/${selectSubject.value}/`;
    if (selectSemeter.value && selectSubject.value) {
        btnEx.innerHTML = `<button type="button" class="btn btn-primary er fs-6 px-8 py-4" onclick="location.href='${url}'">Xuất Điểm</button>`
    } else {
        btnEx.innerHTML = ``
    }
});
classSubjectSelect.addEventListener("change", function () {
    var idClass = classSubjectSelect.value;
    DataResult.class = idClass;
    // console.log(DataResult);
    const url = `admin/accountStudent/exportClass/${DataResult.semeter}/${DataResult.block}/${DataResult.subject}/${DataResult.class}`;
    if (idClass !== "") {
        btnEx.innerHTML = `<button type="button" class="btn btn-primary er fs-6 px-8 py-4" onclick="location.href='${url}'">Xuất Điểm</button>`
    } else {
        btnEx.innerHTML = ``
    }
});
const search = document.getElementById('searchResult');
search.addEventListener('click', () => {
    $.ajax({
        url: `/admin/accountStudent/GetPoetryDetail`,
        type: 'POST',
        data: DataResult,
        success: function (response) {
            // console.log(response.data);
            //insert data vào
            var newRow = "";
            if (response.data != "") {
                newRow = response.data.map((value) => {
                    return `               <tr >
                                    <td>
                                        <span href="#" class="text-dark text-hover-primary">${value.name}</span>
                                    </td>
                                    <td>
                                        <span href="#" class="text-dark text-hover-primary">${value.email}</span>
                                    </td>
                                    <td>
                                        <div class="badge badge-light-success" style="cursor: pointer;" onclick="location.href='admin/accountStudent/viewpoint/${value.id}'">${value.mssv}</div>
                                    </td>
                                    <td data-order="2022-03-10T14:40:00+05:00">${value.campus.name}</td>
                                </tr>
                    `;
                }).join(' ')
            } else {
                // notify('Không có dữ liệu!')
                html = '<tr colspan="6"> Chưa có dữ liệu</tr>'
            }

            $('#table-data tbody').html(newRow);

        },
        error: function (response) {

            console.log(response);
        }
    });
})
