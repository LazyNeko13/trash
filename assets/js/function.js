$(function () {
   
    $('.hps_foto').on('click', function () {
        // console.log('hapus');
        $('input[name=nama_foto]').val("");
    });

    $('.edt_foto').on('click', function () {
        $('input[name=nama_foto]').val("");
    })

    $('.hps_foto_dinamis').on('click', function () {
        // console.log('hapus');
        var name = $(this).data('name');
        $('input[name='+name+']').val("");
    });

    $('.edt_foto_dinamis').on('click', function () {
        var name = $(this).data('name');
        $('input[name='+name+']').val("");
    })

    $('#cetak_excel').on('click', function () {
        $('#cetak_excel').data('click');
        var href = $(this).attr('href');
        console.log(href);
    })


});


function submit_form(element, id_form, num = 0, urlplus = '', draging = false, confirm = false) {

    if (confirm == true) {
        var message = $(element).data('message');
        if (!message) {
            $message = 'Yakin akan melanjutkan aksi?';
        }

        Swal.fire({
            text: message,
            icon: 'question',
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
                proses_form(element, id_form, num, urlplus, draging)
            }
        }));
    } else {
        proses_form(element, id_form, num, urlplus, draging)
    }
}

function proses_form(element, id_form, num, urlplus = '', draging = false,loader = '',other_url ='') {
    if (draging == true) {
        var drag = document.getElementById('sistem_drag');
        var filter = document.getElementById('sistem_filter');
    }
    // console.log('ok');
    var text_button = document.getElementById(element.id).innerHTML;
    if (other_url != '') {
        var url = other_url;
    }else{
        var url = $(id_form).attr('action') + urlplus;
    }
    
    var method = $(id_form).attr('method');
    // console.log(url);
    var form = $('form')[num];
    var form_data = new FormData(form);
    var editor = $(element).data('editor');
    var method_editor = $(element).data('method_editor');
    if (editor) {
        let array = editor.split(",");
        for (var a = 0; a < array.length; a++) {
            form_data.append(array[a], myEditor.getData($("#"+array[a]).val()));
            // console.log(array[a]);
        }
       
    }

    // console.log(url, method, form, form_data);
    $.ajax({
        url: url,
        method: method,
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        beforeSend: function () {
            if (loader == '') {
                 $('#' + element.id).prop('disabled', true);
                $('#' + element.id).html('Tunggu Sebentar...');
            }else{
                 $('#' + element.id).prop('disabled', true);
                $('#' + element.id).html(loader);
            }
           


        },
        success: function (data) {
            // console.log(data);
            $('.fadedin').remove();
            if (data.etc != null) {
                for (var a = 0; a < data.etc.length; a++) {
                    data.etc[a]
                }
            }
            if (data.load != null) {
                for (var a = 0; a < data.load.length; a++) {
                    $(data.load[a].parent).load(data.load[a].reload);
                }
                window.history.pushState('', '', BASE_URL + page);
            }
            $('#' + element.id).prop('disabled', false);
            $('#' + element.id).html(text_button);

            if (data.status == 200 || data.status == true) {
                if (draging == true) {
                    drag.classList.add('d-none');
                    filter.classList.remove('d-none');
                }
                if (data.input) {
                    if (data.input.password) {
                        $(id_form).find("input[type=password]").val("");
                    }
                    if (data.input.text) {
                        $(id_form).find("input[type=text]").val("");
                    }
                    if (data.input.number) {
                        $(id_form).find("input[type=number]").val("");
                    }
                    if (data.input.textarea) {
                        $(id_form).find("textarea").val("");
                    }

                    if (data.input.all) {
                        $(id_form + ' input[type=text]').val("");
                        $(id_form + ' input[type=password]').val("");
                        $(id_form + ' input[type=number]').val("");
                        $(id_form + ' select').val("");
                        $(id_form + ' textarea').val("");
                    }

                }

                var icon = 'success';
            } else {
                var icon = 'warning';
            }
            if (data.alert) {
                Swal.fire({
                    html: data.alert.message,
                    icon: icon,
                    buttonsStyling: !1,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: css_btn_confirm
                    }
                }).then(function () {
                    if (data.redirect) {
                        location.href = data.redirect;
                    }
                    if (data.reload == true) {
                        location.reload();
                    }
                    if (data.modal != null) {
                        $(data.modal.id).modal(data.modal.action);
                    }
                    if (data.element != null) {
                        const row = data.element.length;
                        for (var i = 0; i < row; i++) {
                            $(data.element[i].row).html(data.element[i].value);
                        }
                    }
                });
            } else {
                if (data.required) {
                    // console.log(data.required);
                    const array = data.required.length;
                    for (var i = 0; i < array; i++) {
                        $('#' + data.required[i][0]).append('<span class="text-danger size-12 fadedin">' + data.required[i][1] + '</span>');
                        // console.log(data.required[i][0]);
                    }

                }

                if (data.redirect) {
                    location.href = data.redirect;
                }
                if (data.modal != null) {
                    $(data.modal.id).modal(data.modal.action);
                }

                if (data.reload == true) {
                    location.reload();
                }
            }
        }
    });
}

function hapus_data(e, id, url = '', text = '',reload = false) {
    e.preventDefault();
    var message = 'Anda yakin akan menghapus data ' + text + '? Data yang dihapus tidak akan bisa dipulihkan';
    const icon = 'question';
    Swal.fire({
        text: message,
        icon: icon,
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
            $.ajax({
                url: BASE_URL + url,
                method: 'POST',
                data: { id: id },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    if (data.status == 200 || data.status == true) {
                        if (data.alert) {
                            Swal.fire({
                                html: data.alert.message,
                                icon: data.alert.icon,
                                buttonsStyling: !1,
                                confirmButtonText: 'Ok',
                                customClass: { confirmButton: css_btn_confirm }
                            }).then((function (t) {
                                if (t.isConfirmed) {
                                    var uri = window.location.search;
                                    if (reload == true) {
                                        location.reload();
                                    }else{
                                        $('#base_table').load(BASE_URL + page + uri + ' #reload_table');
                                         
                                        window.history.pushState('', '', BASE_URL + page + uri);
                                        if (text == 'banner') {
                                            $('#posisi').select2({
                                                dropdownParent: $('#req_frame')
                                            });
                                        }
                                        
                                    }
                                }
                            }));
                        }else{
                            var uri = window.location.search;
                            if (reload == true) {
                                location.reload();
                            }else{
                                $('#base_table').load(BASE_URL + page + uri + ' #reload_table');
                                window.history.pushState('', '', BASE_URL + page + uri);
                            }
                        }
                        
                        
                    } else {
                        Swal.fire({
                            html: data.alert.message,
                            icon: 'warning',
                            buttonsStyling: !1,
                            confirmButtonText: 'Ok'
                        });
                    }
                }
            })
        }
    }))
}

function preview_image(img) {
    // console.log(img);
    $('#preview_preview_image').attr('src', img);
    $('#modal_preview_all').modal('show');
}

function switch_modal(id, id2) {
    // var scrollBarWidth = window.innerWidth - document.body.offsetWidth;
    // $('body').css({
    //     marginRight: scrollBarWidth,
    //     overflow: 'hidden'
    // });

    $('#' + id).modal('hide');
    $('#' + id2).modal('show');

    document.getElementById("main_body").style.paddingRight = "0px";
}


function confirm_alert(element, e, message = 'Konfirmasi', url = null, method = 'POST', data, checkbox = false) {
    var data_param = $(element).data();
    // console.log(data_param.id);
    var href = $(element).attr('href');
    e.preventDefault();
    const icon = 'question';
    Swal.fire({
        text: message,
        icon: icon,
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
            if (url != null) {
                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        // console.log(data);
                        if (data.status == 200 || data.status == true) {
                            if (checkbox == true) {
                                $(this).prop('checked', true);
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
                            if (data.reload) {
                                location.reload();
                            }
                            if (data.redirect) {
                                location.href = data.redirect;
                            }
                        } else {
                            Swal.fire({
                                html: data.alert.message,
                                icon: 'warning',
                                buttonsStyling: !1,
                                confirmButtonText: 'Ok'
                            });
                        }
                    }
                })
            } else {
                var param = '';
                if (data_param) {
                    var i = 0;
                    Object.keys(data_param).forEach(key => {
                        i++;
                        if (i == 1) {
                            param += '?' + key + '=' + data_param[key];
                        } else {
                            param += '&' + key + '=' + data_param[key];
                        }
                    });
                }
                document.location.href = href + param;
            }
        }
    }))
}

function redirect(halaman) {
    location.href = BASE_URL + halaman;
}






function alert_sukses() {
    Swal.fire({
        html: 'Berhasil mendaftarkan pesanan',
        icon: 'success',
        buttonsStyling: !1,
        confirmButtonText: "Ok",
        customClass: {
            confirmButton: css_btn_confirm
        }
    })
    location.reload();
}



function selisih_hari(tgl1,tgl2) {
    var tanggal1 = new Date(tgl1); // new Date() saja akan menghasilkan tanggal sekarang
    var tanggal2 = new Date(tgl2); // format tanggal YYYY-MM-DD, tahun-bulan-hari
    
    // set jam menjadi jam 12 malam, atau 00
    tanggal1.setHours(0, 0, 0, 0);
    tanggal2.setHours(0, 0, 0, 0);
    
    var selisih = Math.abs(tanggal1 - tanggal2);
    // Selisih akan dalam millisecond atau mili detik
    
    var hariDalamMillisecond = 1000 * 60 * 60 * 24; // 1000 * 1 menit * 1 jam * 1 hari
    
    var selisihTanggal = Math.round(selisih / hariDalamMillisecond);

    return selisihTanggal;
}


function get_tab(property, filter_tab,vector="",filter = "data-tab",id_prefix = false) {
    const base = document.querySelector(".base_tab");
    if (id_prefix != false) {
        target_div = document.querySelectorAll("#display_tab_"+id_prefix+" .zoom_filter");
    }else{
        target_div = document.querySelectorAll("#display_tab .zoom_filter");
    }
    
    base.querySelector(".active").classList.remove("active");
    $(property).addClass("active");

    target_div.forEach((div) => {
        let display_value = div.getAttribute(filter);
        if ((display_value == 'tab_'+filter_tab) || (filter_tab == "all")) {
            div.classList.remove("hidin");
            div.classList.add("showin");
        } else {
            div.classList.add("hidin");
            div.classList.remove("showin");
        }
    });
    if (vector != "") {
        const vector_bantuan = document.querySelector("#vector_bantuan");
        const tampil = document.querySelectorAll(".showin");
        if (tampil.length == 0) {
            vector_bantuan.classList.remove("hiding");
            vector_bantuan.classList.add("showin");
        } else {
            vector_bantuan.classList.add("hiding");
            vector_bantuan.classList.remove("showin");
        }
    }
    
}

function status_payment(status = 99)
{
    var data = [];
    data[0] = 'menunggu pembayaran';
    data[1] = 'menunggu konfirmasi';
    data[2] = 'sukses';
    data[3] = 'batal';
    data[4] = 'gagal';
    if (data[status]) {
        return data[status];
    } else {
        return data;
    }
}

function updateDisplay(base, value) {
    // Display the CKEditor value in a separate div
    document.querySelector(base).innerText = value;
}