
$(function () {

    $('.hps_foto').on('click', function () {
        // console.log('hapus');
        $('input[name=nama_foto]').val("");
    });

});


function edit_agen(element, id) {
    var form = document.getElementById('form_agen');
    $('#title_modal').text('Ubah Data Agen');
    form.setAttribute('action', BASE_URL + 'master_function/ubah_agen');
    $.ajax({
        url: BASE_URL + 'master/get_single_agen',
        method: 'POST',
        data: { id: id },
        dataType: 'json',
        beforeSend: function () {
            // console.log('loading...')
        },
        success: function (data) {
            $('input[name="id_agen"]').val(data.id_agen);
            $('input[name="nama"]').val(data.nama);
            $('input[name="latitude"]').val(data.latitude);
            $('input[name="longitude"]').val(data.longitude);
            $('textarea[name="alamat"]').val(data.alamat);
            
            
        }
    })
}

function tambah_agen() {
    var form = document.getElementById('form_agen');
    form.setAttribute('action', BASE_URL + 'master_function/tambah_agen');
    $('#title_modal').text('Tambah Agen');
    $('#form_agen input').val('');
    $('#form_agen select').val('');

    $('#form_agen select').trigger('change');
    $('#form_agen textarea').val('');
}

function switch_block(element, e, id, two = false) {
    // console.log(two);

    e.preventDefault();
    const icon = 'question';
    if ($(element).is(':checked')) {
        var value = 'Y';
        var type = false;
        var message = 'Anda yakin akan membuka blockir pada rekening ini? Selanjutnya rekening akan bisa mengakses sistem';
        
    } else {
        var value = 'N';
        var type = "textarea";
        var message = 'Anda yakin akan melakukan blockir pada rekening ini? rekening tidak akan bisa mengakses sistem';
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
                url: BASE_URL + 'master_function/switch_agen',
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


function map_agen(lat, long) {
    $('#map_agen').html('');
    $('#map_agen').html('<iframe src="https://maps.google.com/maps?q='+lat+','+long+'&hl=en;z=14&output=embed" class="h-190 w-100 rounded shadow-sm" allowfullscreen="" loading="lazy"></iframe>');
}

function tambah_pengepul(element,id_agen) {
    $.ajax({
        url: BASE_URL + 'master/get_single_pengepul',
        method: 'POST',
        data: { id: id_agen},
        cache: false,
        success: function (msg) {
            $('#display_pengepul').html(msg);
        }
    })
    
    
}