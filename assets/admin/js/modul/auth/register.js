"use strict";
var KTSignupGeneral = function () {
    var e, t, a, r, s = function () {
        return 100 === r.getScore()
    };
    return {
        init: function () {
            e = document.querySelector("#kt_sign_up_form"), t = document.querySelector("#kt_sign_up_submit"), r = KTPasswordMeter.getInstance(e.querySelector('[data-kt-password-meter="true"]')), a = FormValidation.formValidation(e, {
                fields: {
                    "nama": {
                        validators: {
                            notEmpty: {
                                message: "Nama tidak boleh kosong"
                            }
                        }
                    },
                    email: {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: "Alamat email tidak valid"
                            },
                            notEmpty: {
                                message: "Alamat email tidak boleh kosong"
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "Password tidak boleh kosong"
                            },
                            callback: {
                                message: "Password tidak valid",
                                callback: function (e) {
                                    if (e.value.length > 0) return s()
                                }
                            }
                        }
                    },
                    "repassword": {
                        validators: {
                            notEmpty: {
                                message: "Anda harus mengkonfirmasi kata sandi"
                            },
                            identical: {
                                compare: function () {
                                    return e.querySelector('[name="password"]').value
                                },
                                message: "Konfirmasi kata sandi salah"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger({
                        event: {
                            password: !1
                        }
                    }),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }), t.addEventListener("click", (function (s) {
                s.preventDefault(), a.revalidateField("password"), a.validate().then((function (a) {
                    "Valid" == a ? regis_proses(t, e) : Swal.fire({
                        text: "Anda gagal mendaftar! cek data yang anda masukan",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                }))
            })), e.querySelector('input[name="password"]').addEventListener("input", (function () {
                this.value.length > 0 && a.updateFieldStatus("password", "NotValidated")
            }))
        }
    }
}();

function regis_proses(button, form) {
    var message, icon;
    var btn = $('#kt_sign_up_submit');
    var btn_text = btn.html();

    $.ajax({
        url: form.getAttribute('action'),
        method: form.getAttribute('method'),
        data: {
            nama: form.querySelector('[name="nama"]').value,
            email: form.querySelector('[name="email"]').value,
            password: form.querySelector('[name="password"]').value,
            repassword: form.querySelector('[name="repassword"]').value
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
                        form.querySelector('[name="email"]').value = "",
                            form.querySelector('[name="password"]').value = "",
                            form.querySelector('[name="repassword"]').value = "",
                            form.querySelector('[name="nama"]').value = "";
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
    KTSignupGeneral.init()
}));