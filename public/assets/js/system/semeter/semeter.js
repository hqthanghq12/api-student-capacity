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
            url: `admin/semeter/now-status/${id}`,
            data: dataAll,
            success: (response) => {
                // console.log(response)
                notify(response.message);
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

