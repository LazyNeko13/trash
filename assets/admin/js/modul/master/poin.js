
$(function () {

    $('.hps_foto').on('click', function () {
        // console.log('hapus');
        $('input[name=nama_foto]').val("");
    });

});


function edit_poin(element, id) {
    var form = document.getElementById('form_poin');
    $('#title_modal').text('Ubah Data Poin');
    form.setAttribute('action', BASE_URL + 'master_function/ubah_poin');
    $.ajax({
        url: BASE_URL + 'master/get_single_poin',
        method: 'POST',
        data: { id: id },
        dataType: 'json',
        beforeSend: function () {
            // console.log('loading...')
        },
        success: function (data) {
            $('input[name="id_poin"]').val(data.poin.id_poin);
            $('input[name="jumlah_minimal"]').val(data.poin.jumlah_minimal);
            $('input[name="jumlah_maximal"]').val(data.poin.jumlah_maximal);
            $('input[name="poin"]').val(data.poin.poin);

            $('#display_jumlah_minimal').val(format_uang(data.poin.jumlah_minimal));
            $('#display_jumlah_maximal').val(format_uang(data.poin.jumlah_maximal));
            $('#display_poin').val(format_uang(data.poin.poin));
        }
    })
}

function tambah_poin() {
    var form = document.getElementById('form_poin');
    form.setAttribute('action', BASE_URL + 'master_function/tambah_poin');
    $('#title_modal').text('Tambah Poin');
    $('#form_poin input').val('');
    $('#form_poin select').val('');
}


function switch_block(element, e, id, two = false) {
    // console.log(two);

    e.preventDefault();
    const icon = 'question';
    if ($(element).is(':checked')) {
        var value = 'Y';
        var type = false;
        var message = 'Anda yakin akan membuka blockir pada poin ini? Selanjutnya poin akan bisa mengakses sistem';
    } else {
        var value = 'N';
        var type = "textarea";
        var message = 'Anda yakin akan melakukan blockir pada poin ini? poin tidak akan bisa mengakses sistem';
        
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
                url: BASE_URL + 'master_function/block_poin/poin',
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