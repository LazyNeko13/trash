function add_layout(element, id_layout) {
    var cek_vector = $('#vector_pengganti.showin');
   
    if (cek_vector) {
        $('#vector_pengganti').removeClass('showin');
        $('#vector_pengganti').addClass('hidin');
    }
    var id = uniqid('zcwknd');
    $('html,body').animate({scrollTop: document.body.scrollHeight},"slow");
    var id_halaman = $('input[name="id_halaman"').val();
    $.ajax({
        url: BASE_URL + 'cms_function/tambah_layout',
        method: 'POST',
        data: {id_halaman : id_halaman, id_layout : id_layout},
        cache: false,
        beforeSend: function () {
            $('#loading_add').removeClass('hidin');
            $('#loading_add').addClass('showin');


        },
        success: function (msg) {
            $('#loading_add').addClass('hidin');
            $('#loading_add').removeClass('showin');
            $('html,body').animate({scrollTop: document.body.scrollHeight},"slow");
            $('select.cecep').val(1);
            $('select.cecep').trigger('change');

            const parentOfDiv = document.querySelector("#display_layout")
            parentOfDiv.insertAdjacentHTML("beforeEnd",msg)
            // $('.keterangan_layout').ckeditor();

        }
    
    });
    
}


function uniqid(prefix = "", random = false) {
    const sec = Date.now() * 1000 + Math.random() * 1000;
    const id = sec.toString(16).replace(/\./g, "").padEnd(14, "0");
    return `${prefix}${id}${random ? `.${Math.trunc(Math.random() * 100000000)}`:""}`;
};


function prev_image(element,id){
    var file = element.files[0];
    let fileType = file.type; //getting selected file type
    let validExtensions = ["image/jpeg", "image/jpg", "image/png"]; //adding some valid image extensions in array
    if(validExtensions.includes(fileType)){ //if user selected file is an image file
        let fileReader = new FileReader(); //creating new FileReader object
        fileReader.onload = ()=>{
            document.getElementById(id).style.backgroundImage = "url('"+fileReader.result+"')";
            const arr = file.name.split(".");

        }
        fileReader.readAsDataURL(file);
  }else{
    alert("This is not an Image File!");
   
  }
}



function dual_image_function(element,id) {
        if ($(element).is(':checked')) {
            $('#second_image_'+id).removeClass('hidin');
            $('#second_image_'+id).addClass('showin');
        } else {
           $('#second_image_'+id).addClass('hidin');
            $('#second_image_'+id).removeClass('showin');
        }
}

function background_function(element,id) {
    if ($(element).is(':checked')) {
        $('#background_layout_'+id).removeClass('hidin');
        $('#background_layout_'+id).addClass('showin');
        $('#base_attachement_'+id).removeClass('hidin');
        $('#base_attachement_'+id).addClass('showin');
    } else {
        $('#background_layout_'+id).addClass('hidin');
        $('#background_layout_'+id).removeClass('showin');
            $('#base_attachement_'+id).addClass('hidin');
        $('#base_attachement_'+id).removeClass('showin');
    }
}

function mirror_function(element,id) {
    if ($(element).is(':checked')) {     
        $('#disp_content_'+id).addClass('flex-row-reverse');
    }else{
        $('#disp_content_'+id).removeClass('flex-row-reverse');
    }
    
}

function running_function(element,id) {
    if ($(element).is(':checked')) {     
        $('#running_base_'+id).addClass('showin');
        $('#running_base_'+id).removeClass('hidin');
    }else{
        $('#running_base_'+id).removeClass('showin');
        $('#running_base_'+id).addClass('hidin');
    }
    
}

function hapus_layout(element, id,id_halaman,text) {
    var message = 'Anda yakin akan menghapus data ' + text + '? Data yang dihapus tidak akan bisa dipulihkan';
    const icon = 'question';
    var text_button = $('#'+element.id).text();
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
                url: BASE_URL + 'cms_function/hapus_layout',
                method: 'POST',
                data: { id: id,id_halaman: id_halaman },
                cache: false,
                dataType: 'json',
                beforeSend : function () {
                    $('#'+element.id).text('Tunggu sebentar...');
                    $('#'+element.id).prop('disabled',true);
                },
                success: function (data) {
                    $('#'+element.id).text(text_button);
                    $('#'+element.id).prop('disabled',false);
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
                                $('#card_layout_'+id).remove();
                                if (data.jumlah < 1) {
                                    $('#vector_pengganti').removeClass('hidin');
                                    $('#vector_pengganti').addClass('showin');
                                }
                            }));
                        }else{
                            $('#card_layout_'+id).remove();
                                if (data.jumlah < 1) {
                                    $('#vector_pengganti').removeClass('hidin');
                                    $('#vector_pengganti').addClass('showin');
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


function hps_image(element,id,name){
    document.getElementById(id).style.backgroundImage = "none";
    $('input[name="'+name+'"]').value = "";
    $('input[name="name_'+name+'"]').val('');
}

function tambah_inputan(id) {
    var total = $("#base_tambah_input_"+id+" > div.card").length;
    var html = '';
    html += '<div class="card shadow-sm mb-5">';
    html += '<div class="card-body">';
    html += '<div class="mb-10" id="req_judul_'+id+'_'+(total + 1)+'">';
    html += '<label for="judul_'+id+'_'+(total + 1)+'" class="required form-label">Judul</label>';
    html += '<input type="text" id="judul_'+id+'_'+(total + 1)+'" name="judul[]" class="form-control form-control-solid" placeholder="Masukkan judul"/>'
    html += '</div>';
    html += '<div class="mb-0" id="req_keterangan_'+id+'_'+(total + 1)+'">';
    html += '<label for="keterangan_'+id+'_'+(total + 1)+'" class="required form-label">Keterangan</label>';
    html += '<textarea id="keterangan_'+id+'_'+(total + 1)+'" name="keterangan[]" class="form-control form-control form-control-solid h-30" data-kt-autosize="true" placeholder="Masukan keterangan"></textarea>';
    html += '</div></div></div>';
    const parentOfDiv = document.querySelector("#base_tambah_input_"+id);
    parentOfDiv.insertAdjacentHTML("beforeEnd",html);
}

function tambah_inputan_text(id) {
    var total = $("#base_tambah_input_"+id+" > div.card").length;
    var html = '';
    html += '<div class="card shadow-sm mb-5"><div class="card-body">';
    html += '<div class="mb-7" id="req_judul_'+id+'_'+(total+1)+'">';
    html += '<label for="judul_'+id+'_'+(total+1)+'" class="form-label">Judul</label>';
    html += '<input id="judul_'+id+'_'+(total+1)+'" type="text" name="judul[]" class="form-control form-control-solid" placeholder="Masukkan judul" autocomplete="off"/></div>';
    html += '<div class="fv-row mb-7" id="req_running_'+id+'_'+(total+1)+'"><div class="me-5">';
    html += '<label class="fs-5 fw-semibold mx-2">Running title</label></div>';
    html += '<div class="d-flex align-items-center">';
    html += '<label class="form-check form-switch form-check-custom form-check-solid mx-3">';
    html += '<input class="form-check-input" name="running[]" type="checkbox" onchange="get_disabled(this, [`#running_title_'+id+'_'+(total+1)+'`])" value="Y"/></label>';
    html += '<input type="text" name="running_title[]" id="running_title_'+id+'_'+(total+1)+'" class="form-control form-control-solid mb-3 mb-lg-0 mx-1" placeholder="Masukkan judul running" autocomplete="off" disabled />';
    html += '</label></div></div>';
    html += '<div class="mb-7" id="req_deskripsi_'+id+'_'+(total+1)+'">';
    html += '<label for="deskripsi_'+id+'_'+(total+1)+'" class="required form-label">Deskripsi</label>';
    html += '<textarea id="deskripsi_'+id+'_'+(total+1)+'" name="deskripsi[]" cols="30" rows="10" class="form-control form-control form-control-solid h-30"  placeholder="Masukan deskripsi" data-kt-autosize="true"></textarea></div>';
    html += '<div class="fv-row mb-7" id="req_button_'+id+'_'+(total+1)+'">';
    html += '<div class="me-5"><label class="fs-5 fw-semibold mx-2">Tampilkan Button</label></div>';
    html += '<div class="d-flex align-items-center" id="button_paste_'+id+'_'+(total+1)+'">';
    html += '<label class="form-check form-switch form-check-custom form-check-solid mx-3">';
    html += '<input class="form-check-input" name="button" type="checkbox" onchange="get_disabled(this, [`#nama_button_'+id+'_'+(total + 1)+'`,`#link_button_'+id+'_'+(total + 1)+'`])" value="Y"/></label>';
    html += '<input type="text" name="nama_button[]" id="nama_button_'+id+'_'+(total + 1)+'" class="form-control form-control-solid mb-3 mb-lg-0 mx-1" placeholder="Masukkan nama button" autocomplete="off" disabled/>';
    html += '<input type="text" name="link_button[]" id="link_button_'+id+'_'+(total + 1)+'" class="form-control form-control-solid mb-3 mb-lg-0 mx-1" placeholder="Masukkan link button" autocomplete="off" disabled/></div></div>';
    html += '<div class="fv-row mb-0" id="req_alignment">';
    html += '<label class="required fw-semibold fs-6 mb-2">Alignment</label><div>';
    html += '<select name="alignment[]" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih alignment">';
    html += '<option value="1">Left</option>';
    html += '<option value="2">Center</option>';
    html += '<option value="3">Right</option>';
    html += '</select></div></div></div></div>';
    const parentOfDiv = document.querySelector("#base_tambah_input_"+id);
    parentOfDiv.insertAdjacentHTML("beforeEnd",html);
}


function tambah_inputan_complex(id) {
    var base = BASE_URL + 'data/default/notfound.jpg';
    var total = $("#base_tambah_input_"+id+" > div.cecep").length;
    var html = '';
    html += '<div class="cecep row mb-10">';
    html += '<div class="col-md-4 d-flex justify-content-center align-items-center">';
    html += '<div class="image-input image-input-outline" data-kt-image-input="true" style="min-height: 175px; background-posisiton: center center; background-repeat: no-repeat; background-size: cover; background-image: url('+base+')">';
    html += '<div class="image-input-wrapper imagethesavanna2" id="display_gambar'+(total+1)+'_'+id+'" style="min-height: 175px; background-posisiton: center center; background-repeat: no-repeat; background-size: cover; background-image: url('+base+')"></div>'
    html += '<label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change gambar '+(total +1)+'">';
    html += '<i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>';
    html += '<input type="file" onchange="prev_image(this,`display_gambar'+(total + 1)+'_'+id+'`)" name="gambar'+(total + 1)+'" accept=".png, .jpg, .jpeg" />';
    html += '<input type="hidden" name="name_'+(total + 1)+'">';
    html += '</label>';
    html += '<span onclick="hps_image(this,`display_gambar'+(total + 1)+'_'+id+'`,`gambar'+(total + 1)+'`)" class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove gambar '+(total + 1)+'">';                                
    html += '<i class="ki-outline ki-cross fs-3"></i></span></div></div>';     
    html += '<div class="col-md-8">';
    html += '<div class="mb-5" id="req_judul_'+id+'_'+(total + 1)+'">';
    html += '<label for="judul_'+id+'_'+(total + 1)+'" class="required form-label">Judul</label>';
    html += '<input id="judul_'+id+'_'+(total + 1)+'" type="text" name="judul[]" class="form-control form-control-solid" placeholder="Masukkan judul"/></div>';
    html += '<div class="mb-0" id="req_keterangan_'+id+'_'+(total + 1)+'">';
    html += '<label for="keterangan_'+id+'_'+(total + 1)+'" class="required form-label">Keterangan</label>';
    html += '<textarea id="keterangan_'+id+'_'+(total + 1)+'" name="keterangan[]" class="form-control form-control form-control-solid h-30"  placeholder="Masukan keterangan" data-kt-autosize="true"></textarea></div></div></div>';
                       
    const parentOfDiv = document.querySelector("#base_tambah_input_"+id);
    parentOfDiv.insertAdjacentHTML("beforeEnd",html);
}

function pilih_jumlah(element,id) {
    if ($(element).val() != 1) {
        $('#req_jumlah_'+id).removeClass('hidin');
         $('#req_jumlah_'+id).addClass('showin');
           $('#jumlah_'+id).val('');
    }else{
         $('#req_jumlah_'+id).addClass('hidin');
         $('#req_jumlah_'+id).removeClass('showin');
         $('#jumlah_'+id).val('411');
    }
}

function get_showin(element,target) {
    var value = $(element).val();
    if (value == 1) {
        if (target.length > 0) {
            for (let i = 0; i < target.length; i++) {
                $('#'+target[i]).addClass('showin');
                $('#'+target[i]).removeClass('hidin');
            }
        }
    }else{
        if (target.length > 0) {
            for (let i = 0; i < target.length; i++) {
                $('#'+target[i]).removeClass('showin');
                $('#'+target[i]).addClass('hidin');
            }
        }
    }
}

function get_disabled(element,target) {
     if ($(element).is(':checked')) {
        if (target.length > 0) {
            for (let i = 0; i < target.length; i++) {
                $(target[i]).prop('disabled',false);
                if (i == 0) {
                    $(target[i]).focus();
                }
            }
        }
    }else{
        if (target.length > 0) {
            for (let i = 0; i < target.length; i++) {
                $(target[i]).prop('disabled',true);
                $(target[i]).val('');
            }
        }
    }
}