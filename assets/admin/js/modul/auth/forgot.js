var KTForgotGeneral = function () {
    var e, t, i;
    return {
        init: function () {
            e = document.querySelector("#kt_forgot_form"), t = document.querySelector("#kt_forgot_submit"), i = FormValidation.formValidation(e, {
                fields: {
                    email: {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: "Alamat email tidak valid"
                            },
                            notEmpty: {
                                message: "Alamat email wajib di isi"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }), t.addEventListener("click", (function (n) {
                n.preventDefault(), i.validate().then((function (i) {
                    "Valid" == i ? forgot_proses(t, e) : Swal.fire({
                        text: "Email tidak terkirim! terdapat kesalahan pada data yang anda masukan mohon periksa dan coba kembali",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "ok",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                }))
            }))
        }
    }
}();


function forgot_proses(button, form) {
    var message, icon;
    var btn = $('#kt_forgot_submit');
    var btn_text = btn.html();

    $.ajax({
        url: form.getAttribute('action'),
        method: form.getAttribute('method'),
        data: {
            email: form.querySelector('[name="email"]').value
        },
        dataType: 'json',
        beforeSend: function () {
            btn.html('Tunggu Sebentar...');
            btn.attr('disabled', true);
        },
        success: function (data) {
            // console.log(data);
            btn.html(btn_text);
            btn.attr('disabled', false);
            if (data.status == 200) {
                icon = 'success';
            } else if (data.status == 700) {
                icon = 'error';
            } else {
                icon = 'warning';
            }
            if (data.status == 200) {
                Swal.fire({
                    html: data.message,
                    icon: icon,
                    buttonsStyling: !1,
                    confirmButtonText: "Lanjutkan",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then((function (t) {
                    if (t.isConfirmed) {
                        form.querySelector('[name="email"]').value = "", form.querySelector('[name="password"]').value = "";
                        if (data.redirect) {
                            location.href = data.redirect;
                        }

                    }
                }))
            } else {
                Swal.fire({
                    html: data.message,
                    icon: icon,
                    buttonsStyling: !1,
                    confirmButtonText: "Lanjutkan",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                })
            }
        }
    });
}
KTUtil.onDOMContentLoaded((function () {
    KTForgotGeneral.init()
}));