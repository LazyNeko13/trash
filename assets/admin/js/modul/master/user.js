
$(function () {

    $('.hps_foto').on('click', function () {
        // console.log('hapus');
        $('input[name=nama_foto]').val("");
    });

});


function edit_user(element, id) {
    var form = document.getElementById('form_user');
    var label_password = document.getElementById('label_password');
    var label_repassword = document.getElementById('label_repassword');
    $('#title_modal').text('Ubah Data User');
    label_password.classList.remove('required');
    label_repassword.classList.remove('required');
    form.setAttribute('action', BASE_URL + 'master_function/ubah_user');
    $.ajax({
        url: BASE_URL + 'master/get_single_user',
        method: 'POST',
        data: { id: id },
        dataType: 'json',
        beforeSend: function () {
            // console.log('loading...')
        },
        success: function (data) {
            var reason = '';
            if (data.user.block_reason) {
                reason = '</br>Alasan : ' + data.user.block_reason;
            }
            if (data.user.block == 'Y') {
                $('#lead').html('<div class="alert alert-danger d-flex justify-content-between" role="alert"><div class="col-6">\
                    user telah di block!'+ reason + '</div><div class="col-6 d-flex justify-content-end"><div class="form-check form-switch">\
                    <input class="form-check-input cursor-pointer" type="checkbox" role="switch" onchange ="switch_block(this,event,'+ id + ',true)" id="switch-on-' + id + '" checked ></div></div>\
                        </div>');
            } else {
                $('#lead').html('');
            }
            $('input[name="id_user"]').val(data.user.id_user);
            $('input[name="nama"]').val(data.user.nama);
            $('input[name="email"]').val(data.user.email);
            $('input[name="notelp"]').val(data.user.notelp);

            $('select[name="role"]').val(data.user.role);
            $('select[name="role"]').trigger('change');
        }
    })
}

function tambah_user() {
    var form = document.getElementById('form_user');
    var label_password = document.getElementById('label_password');
    var label_repassword = document.getElementById('label_repassword');
    label_password.classList.add('required');
    label_repassword.classList.add('required');
    form.setAttribute('action', BASE_URL + 'master_function/tambah_user');
    $('#title_modal').text('Tambah User');
    $('#form_user input').val('');
    $('#form_user select').val('');
    $('#form_user select').trigger('change');
}


function switch_block(element, e, id, two = false) {
    // console.log(two);

    e.preventDefault();
    const icon = 'question';
    if ($(element).is(':checked')) {
        var value = 'Y';
        var type = false;
        var message = 'Anda yakin akan membuka blockir pada user ini? Selanjutnya user akan bisa mengakses sistem';
    } else {
        var value = 'N';
        var type = "textarea";
        var message = 'Anda yakin akan melakukan blockir pada user ini? user tidak akan bisa mengakses sistem';
        
    }
    Swal.fire({
        text: message,
        icon: icon,
        input: type,
        inputAttributes: {
            autocapitalize: 'off',
            name: 'block_reason'
        },
        inputPlaceholder: 'Cantumkan alasan blockir',
        showCancelButton: true,
        buttonsStyling: !1,
        confirmButtonText: "Lanjutkan",
        customClass: {
            confirmButton: css_btn_confirm,
            cancelButton: css_btn_cancel
        },
        reverseButtons: true
    }).then((function (t) {
        if (t.isConfirmed) {
            var reason = $('textarea[name=block_reason]').val();
            $.ajax({
                url: BASE_URL + 'master_function/block_user/user',
                method: 'POST',
                data: { id: id, action: value, reason: reason },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    if (data.status == 200 || data.status == true) {

                        if (value == 'Y') {
                            $('#switch-' + id).prop('checked', true);
                        } else {
                            $('#switch-' + id).prop('checked', false);
                        }
                        if (two == true) {
                            if (value == 'Y') {
                                $('#switch-on-' + id).prop('checked', true);
                            } else {
                                $('#lead').html('');
                                $('#switch-on-' + id).prop('checked', false);
                            }
                        }

                        if (data.alert) {
                            Swal.fire({
                                html: data.alert.message,
                                icon: data.alert.icon,
                                buttonsStyling: !1,
                                confirmButtonText: 'Ok',
                                customClass: { confirmButton: css_btn_confirm }
                            });
                        }
                    } else {

                        if (value == 'Y') {
                            $('#switch-' + id).prop('checked', true);
                        } else {
                            $('#switch-' + id).prop('checked', false);
                        }
                        if (two == true) {
                            if (value == 'Y') {
                                $('#switch-on-' + id).prop('checked', true);
                            } else {
                                $('#lead').html('');
                                $('#switch-on-' + id).prop('checked', false);
                            }
                        }
                        Swal.fire({
                            html: data.alert.message,
                            icon: data.alert.icon,
                            buttonsStyling: !1,
                            confirmButtonText: 'Ok',
                            customClass: { confirmButton: css_btn_confirm }
                        });
                    }
                }
            })
        } else {

            if (value == 'Y') {
                $('#switch-' + id).prop('checked', false);
            } else {
                $('#switch-' + id).prop('checked', true);
            }
            if (two == true) {
                if (value == 'Y') {
                    $('#lead').html('');
                    $('#switch-' + id).prop('checked', false);
                } else {
                    $('#switch-' + id).prop('checked', true);
                }
            }

        }
    }));

}