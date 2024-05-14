<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10">
                
                <div class="card mb-5 mb-xl-8 py-5">
                    <div class="d-flex justify-content-center flex-wrap ms-10 mt-10 mb-8">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column align-items-center justify-content-center">
                            <!--begin::Title-->
                            <h1 class="d-flex text-dark fw-bold m-0 fs-2">Laporan</h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">
                                    <a class="text-gray-600 text-hover-primary">Laporan</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">Penukaran</li>
                                <!--end::Item-->
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page title-->
                    </div>
                    <form method="GET" class="form-inline">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-md-3 col-xl-3" style="padding:5px;">
                                <label class="filter-title mb-2">Tahun</label>
                                <select id="tahun" name="tahun" data-control="select2" class="form-select form-select-sm form-select-solid" data-placeholder="Pilih" required>
                                    <?php for($year = 2023;$year <= date('Y'); $year++) { ?>
                                        <option value="<?= $year ?>" <?= ($year == $tahun) ? "selected" : "" ?>><?= $year ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-xl-3" style="padding:5px;">
                                <label class="filter-title mb-2">Bulan</label>
                                <select id="bulan" name="bulan" data-control="select2" class="form-select form-select-sm form-select-solid">
                                    <?php if (month_from_number()) : ?>
                                        <?php foreach (month_from_number() as $id => $val) : ?>
                                            <option value="<?= $id; ?>" <?= ($id == $bulan) ? "selected" : "" ?>><?= $val ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>

                            </div>
                            
                        </div>
                        <div class="col-md-12 col-xl-12 d-flex justify-content-center align-items-center mt-5">
                                <button type="submit" class="btn btn-primary btn-sm mx-4"><i class="bi bi-arrow-repeat"></i> Tampil</button>
                            </div>
                    </form>
                </div>

                <div class="card mb-5 mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            
                            <div class="d-flex justify-content-end">

                            </div>
                            <!--end::Toolbar-->
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-3" id="base_table">

                        <?php if(isset($close) && $close == true) : ?>
                            <div id="display_vector" class="d-flex justify-content-center align-items-center flex-column">
                                <img width="300px" src="<?= image_check('not_found.svg', 'vector') ?>" alt="">
                                <p width="100px" class="text-center">
                                    Anda belum tergabung daalam agent manapun! Hubungi admin jika terdapat kesalahan
                                </p>
                            </div>
                        <?php else : ?>
                        <!--begin::Table container-->
                        <form action="<?= base_url('master_function/drag_karyawan') ?>" method="POST" class="table-responsive" id="reload_table">
                            <!--begin::Table-->
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th class="w-25px">No</th>
                                        <th class="min-w-80px">Tanggal</th>
                                        <th class="min-w-80px">Bukti</th>
                                        <th class="min-w-50px">Pengirim</th>
                                        <th class="min-w-50px">Penerima</th>
                                        <th class="min-w-50px">Jumlah Sampah</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>

                                    <?php if ($result) : ?>
                                        <?php $no=$offset; foreach ($result as $row) : $num = $no++;?>
                                            <tr>
                                                <td>
                                                    <span class="text-muted fw-semibold text-muted d-block fs-7 mb-1">
                                                        <?= $num; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fw-semibold text-muted d-block fs-7 mb-1">
                                                        <?= date('d F Y',strtotime($row->create_date)); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <img src="<?= image_check($row->bukti_kirim,'bukti_kirim') ?>" width="100px" alt="" srcset="">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <span class="text-muted fw-semibold text-muted d-block fs-7 mb-1">Pengirim  : <?= $row->pengirim; ?></span>
                                                            <span class="text-muted fw-semibold text-muted d-block fs-7">Poin : <?= $row->poin; ?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <span class="text-muted fw-semibold text-muted d-block fs-7 mb-1">Penerima  : <?= $row->penerima; ?></span>
                                                            <span class="text-muted fw-semibold text-muted d-block fs-7">Agen : <?= $row->agen; ?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                 <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <span class="text-muted fw-semibold text-muted d-block fs-7"><?= $row->jumlah.' Kg'; ?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="7">
                                                <center>Tidak ada data pemesanan ditemukan</center>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                            <?= $this->pagination->create_links(); ?>
                        </form>
                        <!--end::Table container-->
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>

<!-- Modal Tambah karyawan -->
<div class="modal fade" id="kt_modal_karyawan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal">Tambah Karyawan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="form_karyawan" class="form" action="<?= base_url('master_function/tambah_karyawan') ?>" method="POST" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="#" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_karyawan_header" data-kt-scroll-wrappers="#kt_modal_karyawan_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7 d-flex justify-content-center align-items-center flex-column">
                            <!--begin::Label-->
                            <label class="d-block fw-semibold fs-6 mb-5">Foto Profil</label>
                            <!--end::Label-->
                            <!--begin::Image input-->
                            <div class="image-input image-input-circle" data-kt-image-input="true" style="background-image: url('<?= base_url(); ?>/data/default/user.jpg')">
                                <!--begin::Image preview wrapper-->
                                <div id="display_foto" class="image-input-wrapper w-125px h-125px" style="background-image: url('<?= base_url(); ?>/data/default/user.jpg')"></div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Ubah Foto">
                                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                                    <!--begin::Inputs-->
                                    <input type="file" name="foto" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow hps_foto" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Batalkan Foto">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Cancel button-->

                                <!--begin::Remove button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow hps_foto" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Hapus Foto">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Remove button-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">Tipe: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group-->
                        <div id="lead"></div>
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_nama">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Nama Lengkap</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="nama" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan nama lengkap" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <input type="hidden" name="nama_foto">
                        <input type="hidden" name="id_user">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_email">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Alamat Email</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan alamat email" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_notelp">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Nomor Telepon</label>
                            <!--end::Label-->
                             <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input type="number" name="notelp" id="nomor" class="form-control  mb-3 mb-lg-0"  placeholder="Masukkan nomor telepon" autocomplete="off" >
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_role">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Peran</label>
                            <!--end::Label-->
                            <div>
                                <select name="role" class="form-select form-select-solid cekcek" data-control="select2" data-placeholder="Pilih peran user">
                                    <option value="1">Admin</option>
                                    <option value="2">Resepsionis</option>
                                </select>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_password">
                            <!--begin::Label-->
                            <label id="label_password" class="required fw-semibold fs-6 mb-2">Kata Sandi</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="password" name="password" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan kata sandi" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_repassword">
                            <!--begin::Label-->
                            <label id="label_repassword" class="required fw-semibold fs-6 mb-2">Konfirmasi Kata Sandi</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="password" name="repassword" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Konfirmasi kata sandi" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" id="submit_karyawan" onclick="submit_form(this,'#form_karyawan',1)" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>