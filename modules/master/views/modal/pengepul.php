<form method="POST" action="<?= base_url('master_function/set_pengepul') ?>" id="form_pengepul" class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
   <!--begin::Heading-->
    <input type="hidden" name="id_agen" value="<?= $id_agen; ?>">
    <div class="text-center mb-13">
        <!--begin::Title-->
        <h1 class="mb-3">TAMBAHKAN PENGEPUL</h1>
        <!--end::Title-->
    </div>
    <!--end::Heading-->
    <!--begin::Users-->
    <div class="mb-15">
        <!--begin::List-->
        <div class="mh-375px scroll-y me-n7 pe-7">
            <?php if($pengepul) : ?>
                <?php foreach($pengepul AS $row) : ?>
                <!--begin::User-->
                <label for="check-<?= $row->id_user; ?>" class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed cursor-pointer">
                    <!--begin::Details-->
                    <div class="d-flex align-items-center">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-35px symbol-circle">
                            <input type="checkbox" name="id_user[]" class="check-id" value="<?= $row->id_user; ?>" id="check-<?= $row->id_user; ?>" <?= (in_array($row->id_user,$choose)) ? 'checked' : ''; ?>>
                        </div>
                        <!--end::Avatar-->
                        <!--begin::Details-->
                        <div class="ms-6">
                            <!--begin::Name-->
                            <a class="d-flex align-items-center fs-5 fw-bold text-dark text-hover-primary"><?= $row->nama; ?> </a>
                            <!--end::Name-->
                            <!--begin::Email-->
                            <div class="fw-semibold text-muted"><?= $row->email; ?></div>
                            <!--end::Email-->
                        </div>
                        <!--end::Details-->
                    </div>
                    <!--end::Details-->
                </label>
                <!--end::User-->
                <?php endforeach;?>
            <?php else : ?>
                <div id="display_vector" class="d-flex justify-content-center align-items-center flex-column">
                    <img width="300px" src="<?= image_check('not_found.svg', 'vector') ?>" alt="">
                    <p width="100px" class="text-center">
                        Data pengepul tidak di temukan! Hubungi admin jika terjadi kesalahan
                    </p>
                </div>
            <?php endif;?>
        </div>
        <!--end::List-->
    </div>
    <!--end::Users-->             
                
</form>
<!--end::Modal body-->
<div class="modal-footer">
    <button type="button" id="btn_simpan_pengepul" onclick="submit_form(this,'#form_pengepul',2)" class="btn btn-warning w-100">Simpan</button>
</div>
