const cks = document.querySelectorAll('.form-change-status');
const receiveExamEvent = () => {
    const receiveModeInput = $('#receive_mode');
    const sepecificExamEle = $('#specific_exam_form');
    const randomExamEle = $('#random_exam_form');
    const timeEle = $('#time_form');
    const examIdInput = $('#exam_id');
    const timeInput = $('#time');
    const examNameInput = $('#exam_name');
    receiveModeInput.change(e => {
        let mode = receiveModeInput.val();
        switch (mode) {
            case "":
                sepecificExamEle.css('display', 'none');
                randomExamEle.css('display', 'none');
                // timeInput.val('');
                examNameInput.val('');
                break;
            case "0":
                sepecificExamEle.css('display', 'block');
                randomExamEle.css('display', 'none');
                break;
            case "1":
                sepecificExamEle.css('display', 'none');
                randomExamEle.css('display', 'none');
                break;
            case "2":
                randomExamEle.css('display', 'block');
                sepecificExamEle.css('display', 'none');
                // timeInput.val('');
                examNameInput.val('');
                break;

        }
    });
    examIdInput.change(e => {
        let exam_id = examIdInput.val();
        if (exam_id.trim() === "") {
            timeInput.val('');
            examNameInput.val('');
        } else {
            const exam = examList.find(exam => exam.id == exam_id);
            timeInput.val(exam.time);
            examNameInput.val(exam.name);
        }
    })
}
receiveExamEvent();
for (const ckElement of cks) {
    ckElement.addEventListener('change', (e) => {
        let id = ckElement.getAttribute('data-id');
        let evStatus = e.target.checked == true ? 1 : 0;
        var dataAll = {
            '_token': _token,
            'status': evStatus
        }
        $.ajax({
            type: 'PUT',
            url: `admin/poetry/manage/now-status/${id}`,
            data: dataAll,
            success: (response) => {
                // console.log(response)
                notify(response.message);
                const idup = `data-id='${response.data.id}'`;
                // console.log(idup);
                var buttons = document.querySelector('button.btn-edit[' + idup + ']');
                const elembtn = buttons.parentNode.parentNode.childNodes;
                console.log(elembtn)
                const output = response.data.status == 1 ? true : false;
                elembtn[3].childNodes[1].childNodes[1].checked = output
                btnEdit = document.querySelectorAll('.btn-edit');
                update(btnEdit)
                btnDelete = document.querySelectorAll('.btn-delete');
                dele(btnDelete)
            },
            error: function (response) {
                // console.log(response)
                errors(response.responseJSON.message);
                setTimeout(() => {
                    window.location.reload();
                }, 3500);
                // $('#ajax-form').find(".print-error-msg").find("ul").html('');
                // $('#ajax-form').find(".print-error-msg").css('display','block');
                // $.each( response.responseJSON.errors, function( key, value ) {
                //     $('#ajax-form').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                // });

            }
        });
    })
}


