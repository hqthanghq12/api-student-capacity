const selectSubject = document.getElementById("exam_id");
function eventSubject(btn, htmlimport) {
    btn.addEventListener("change", function () {
        var idCampus = btn.value;
        var idSubject = btn.getAttribute("data-subject");
        wanrning('Đang Tải dữ liệu ... !')
        console.log(idCampus);
        if (idSubject != "") {
            $.ajax({
                url: `/admin/poetry/playTopic/getExam/${idCampus}/${idSubject}`,
                type: 'GET',
                success: function (response) {
                    console.log(response.data);
                    let html = "";
                    notify('Tải dữ liệu thành công !')
                    if (response.data != "") {
                        html = response.data.map((value) => {
                            return `<option value="${value.id}">${value.name}</option>`
                        }).join(' ')
                    } else {
                        html = '<option value="">Không có dữ liệu</option>'
                    }

                    htmlimport.innerHTML = html;
                    htmlimport.style.display = "block";
                    // console.log(html);
                    // $('#nameUpdate').val(response.data.name);
                    // $('#status_update').val(response.data.status);
                    // $('#id_update').val(response.data.id)
                    // const date_start = moment(response.data.start_time ).format("YYYY-MM-DD");
                    // $('#start_time_update').val(date_start)
                    // const date_end = moment(response.data.end_time).format("YYYY-MM-DD");
                    // $('#end_time_update').val(date_end)
                    // // Gán các giá trị dữ liệu lấy được vào các trường tương ứng trong modal
                    // $('#edit_modal').modal('show');
                },
                error: function (response) {
                    console.log(response);
                    // Xử lý lỗi
                }
            });
        } else {
            htmlimport.style.display = "none";
            notify('Tải dữ liệu thành công !')
        }

    });
}

eventSubject(selectElement, selectSubject);

const btnReloadtopic = document.querySelector('#reloadPlaytopic');
btnReloadtopic.addEventListener('click', (e) => {
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "Bạn có chắc chắn muốn phát lại đề!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            var url = $('#form-submit').attr("action");
            var campuses_id = $('#campuses').val();
            var mixing = $('#mixing').val();
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
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
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

        }
    })
})
