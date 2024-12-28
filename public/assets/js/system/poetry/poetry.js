const cks = document.querySelectorAll('.form-check-input');
for (const ckElement of cks) {
    ckElement.addEventListener('change',(e)=>{
        let id = ckElement.getAttribute('data-id');
        let evStatus = e.target.checked ==  true ? 1 : 0;
        var dataAll = {
            '_token' : _token,
            'status' : evStatus
        }
        $.ajax({
            type:'PUT',
            url: `admin/poetry/now-status/${id}`,
            data: dataAll,
            success: (response) => {
                // console.log(response)
                // notify(response.message);
                const idup =  `data-id='${response.data.id}'`;
                // console.log(idup);
                var buttons = document.querySelector('button.btn-edit['+idup+']');
                const elembtn = buttons.parentNode.parentNode.childNodes ;
                console.log(elembtn)
                const output = response.data.status == 1 ? true : false;
                elembtn[3].childNodes[1].childNodes[1].checked= output
                btnEdit = document.querySelectorAll('.btn-edit');
                update(btnEdit)
                btnDelete = document.querySelectorAll('.btn-delete');
                dele(btnDelete)
            },
            error: function(response){
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

// var selectElement = document.getElementById("semeter_id");
// const selectSubject = document.getElementById("subject_id");
// function eventSubject(btn,htmlimport){
//     btn.addEventListener("change", function() {
//         var idSubject = btn.value;
//         wanrning('Đang Tải dữ liệu ... !')
//         console.log(idSubject);
//         if(idSubject != ""){
//             $.ajax({
//                 url: `/admin/poetry/getsubject/${idSubject}`,
//                 type: 'GET',
//                 success: function(response) {
//                     // console.log( response);
//                     let html = "";
//                     notify('Tải dữ liệu thành công !')
//                     if(response.data != ""){
//                         html = response.data.map((value)=>{
//                             return `<option value="${value.id}">${value.name}</option>`
//                         }).join(' ')
//                     }else  {
//                         html = '<option value="">Không có dữ liệu</option>'
//                     }
//
//                     htmlimport.innerHTML = html;
//                     htmlimport.style.display = "block";
//                     // console.log(html);
//                     // $('#nameUpdate').val(response.data.name);
//                     // $('#status_update').val(response.data.status);
//                     // $('#id_update').val(response.data.id)
//                     // const date_start = moment(response.data.start_time ).format("YYYY-MM-DD");
//                     // $('#start_time_update').val(date_start)
//                     // const date_end = moment(response.data.end_time).format("YYYY-MM-DD");
//                     // $('#end_time_update').val(date_end)
//                     // // Gán các giá trị dữ liệu lấy được vào các trường tương ứng trong modal
//                     // $('#edit_modal').modal('show');
//                 },
//                 error: function(response) {
//                     console.log(response);
//                     // Xử lý lỗi
//                 }
//             });
//         }else  {
//             htmlimport.style.display = "none";
//             notify('Tải dữ liệu thành công !')
//         }
//
//     });
// }
// eventSubject(selectElement,selectSubject);

