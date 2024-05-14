function new_user(element) {
    var value = $(element).val();
    if (value == 'new') {
         $('#form_user').removeClass('hidin');
        $('#form_user').addClass('showin');
        $('#size').removeClass('mw-650px');
        $('#size').addClass('mw-1000px');
        $('#form_awal').removeClass('col-12');
        $('#form_awal').addClass('col-6');
         $('#batas').removeClass('hidin');
    }else{
         $('#form_user').addClass('hidin');
        $('#form_user').removeClass('showin');
        $('#size').addClass('mw-650px');
        $('#size').removeClass('mw-1000px');
        $('#form_awal').addClass('col-12');
        $('#form_awal').removeClass('col-6');
         $('#batas').addClass('hidin');
    }
 }

 function get_pengepul_agen(element){
    var value = $(element).val();
    $.ajax({
        url: BASE_URL + 'dashboard/get_all_pengepul',
        method: 'POST',
        data: { id: value },
        dataType: 'json',
        success: function (data) {
            $('select[name="id_penerima"]').html(data.opsi);
            $('select[name="id_penerima"]').prop('data-placeholder','Pilih pengepul');
            $('select[name="id_penerima"]').trigger('change');
        }
    })
 }

 function tambah_penukaran() {
    var form = document.getElementById('form_penukaran');
    form.setAttribute('action', BASE_URL + 'dashboard_function/tambah_penukaran');
    $('#title_modal').text('Tambah penukaran');
}
