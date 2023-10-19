$( document ).ready(function() {
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
});

function recalculatePayroll(id, view_create) {
    route = "/payroll/" + id + "/recalculate";
    token = $("#token").val();

    $.ajax({
        url: route,
        headers: {
            'X-CSRF-TOKEN': token
        },
        type: 'POST',
        processData: false,
        contentType: false,
        success: function(result) {
            if (result.success == true) {
                Swal.fire({
                    title: result.msg,
                    icon: "success",
                    timer: 1000,
                    showConfirmButton: false,
                });
                if(view_create == 1){
                    $("#payroll-detail-table").DataTable().ajax.reload(null, false);
                }
            } else {
                Swal.fire({
                    title: result.msg,
                    icon: "error",
                });
            }
        },
        error: function(msj) {
            Swal.fire({
                title: LANG.error_list,
                icon: "error",
            });
        }
    });
}


function payPayroll(id, view_create) {
    Swal.fire({
        title: LANG.pay_question,
        text: LANG.approve_content,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: LANG.yes,
        cancelButtonText: "No",
    }).then((willDelete) => {
        if (willDelete.value) {

            Swal.fire({
                title: LANG.pay_slips_question,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: LANG.yes,
                cancelButtonText: "No",
            }).then((result) => {
                var sendEmail = 0;
                if (result.isConfirmed) {
                    sendEmail = 1;
                    sendPay(id, sendEmail, view_create);
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    sendPay(id, sendEmail, view_create);
                }
            })
        }
    });
}

function sendPay(id, sendEmail, view_create) {
    Swal.fire({
        title: LANG.confirm_pay,
        text: LANG.message_to_confirm,
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: LANG.pay,
        cancelButtonText: LANG.cancel,
        showLoaderOnConfirm: true,
        inputValidator: (value) => {
            if (!value) {
                return LANG.password_required
            }
        },
    }).then((result) => {
        if (result.isConfirmed) {
            var route = "/payroll/" + id + "/pay";
            var type = $('#type').val();
            route = route.replace(':id', id);
            token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    'password': result.value,
                    'sendEmail': sendEmail
                },
                success: function(result) {
                    if (result.success == true) {
                        Swal.fire({
                            title: result.msg,
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false,
                        });
                        if(view_create == 1){
                            $('#btn_pay').hide();
                            $("#section_content-header").find('h1').remove();
                            $("#section_content-header").append('<h1>'+type+' <span class="badge" style="background: #367FA9">Pagada</span></h1>');
                            $("#payroll-detail-table").DataTable().ajax.reload(null, false);
                        }
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: result.msg,
                            icon: "error",
                        });
                    }
                },
                error: function(msj) {
                    Swal.fire({
                        title: LANG.error_list,
                        icon: "error",
                    });
                }
            });
        }
    })
}

function approvePayroll(id, view_create) {
    Swal.fire({
        title: LANG.approve_question,
        text: LANG.approve_content,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: LANG.yes,
        cancelButtonText: "No",
    }).then((willDelete) => {
        if (willDelete.value) {
            Swal.fire({
                title: LANG.payment_file_question,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: LANG.yes,
                cancelButtonText: "No",
            }).then((result) => {
                var sendEmail = 0;
                if (result.isConfirmed) {
                    downloadFile = 1;
                    downloadFlie(id, downloadFile, view_create);
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    downloadFlie(id, downloadFile, view_create);
                }
            })
        }
    });
}

function downloadFlie(id, downloadFile, view_create) {
    Swal.fire({
        title: LANG.confirm_approval,
        text: LANG.message_to_confirm,
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: LANG.approve,
        cancelButtonText: LANG.cancel,
        showLoaderOnConfirm: true,
        inputValidator: (value) => {
            if (!value) {
                return LANG.password_required
            }
        },
    }).then((result) => {
        if (result.isConfirmed) {
            var route = "/payroll/" + id + "/approve";
            route = route.replace(':id', id);
            token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    'password': result.value,
                    'downloadFile': downloadFile
                },
                success: function(result) {
                    if (result.success == true) {
                        $("#payroll-table").DataTable().ajax.reload(null, false);

                        if(result.download == true){
                            var a = document.createElement('a');
                            a.href = "/payroll/" + id +"/generatePaymentFiles";
                            a.download = 'your_pdf_name.pdf';
                            a.click();
                            window.URL.revokeObjectURL(url);
                        }
                        
                        Swal.fire({
                            title: result.msg,
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false,
                        });
                        
                        if(view_create == 1){
                            $('#btn_recalculate').hide();
                            $('#btn_approve').hide();
                            $("#section_content-header").find('h1').remove();
                            $("#section_content-header").append('<h1>'+type+' <span class="badge" style="background: #449D44">Aprobada</span></h1>');
                            $('#div_actions').append('@can("payroll.pay")<a href="#" class="btn btn-primary" type="button" onClick="payPayroll({{ $payroll->id }}, 1)" id="btn_pay"> <i class="fa fa-check-square"></i> @lang("payroll.pay")</a> @endcan');
                            $("#payroll-detail-table").DataTable().ajax.reload(null, false);
                        }
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: result.msg,
                            icon: "error",
                        });
                    }
                },
                error: function(msj) {
                    Swal.fire({
                        title: LANG.error_list,
                        icon: "error",
                    });
                }
            });
        }
    })
}