<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10">
                <div class="card mb-5 mb-xl-8">
                    <div class="d-flex flex-stack flex-wrap ms-10 mt-10">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column align-items-start">
                            <!--begin::Title-->
                            <h1 class="d-flex text-dark fw-bold m-0 fs-3">Penukaran</h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">
                                    <a class="text-gray-600 text-hover-primary">Master</a>
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
                    <?php if(isset($close) && $close == true) : ?>
                        <div id="display_vector" class="d-flex justify-content-center align-items-center flex-column">
                                <img width="300px" src="<?= image_check('not_found.svg', 'vector') ?>" alt="">
                                <p width="100px" class="text-center">
                                    Anda belum tergabung daalam agent manapun! Hubungi admin jika terdapat kesalahan
                                </p>
                            </div>
                    <?php else : ?>
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <div class="d-flex align-items-center position-relative me-3 search_mekanik w-300px">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" name="search" value="<?= $search; ?>" class="form-control form-control-solid w-250px ps-13" aria-label="Cari Penukaran" aria-describedby="button-cari-penukaran" placeholder="Cari Penukaran" autocomplete="off">
                            <button type="button" onclick="search(false)" class="btn btn-primary d-none" type="button" id="button-cari-penukaran">
                                <i class="ki-duotone ki-magnifier fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </button>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-none justify-content-end" id="sistem_drag">
                               
                            </div>
                            <div class="d-flex justify-content-end" id="sistem_filter">

                                <!--end::Filter-->
                                <!--begin::Export-->
                                <!--end::Export-->

                            </div>
                            <!--end::Toolbar-->
                            <!--begin::Add penukaran-->
                            <button type="button" class="btn btn-sm btn-light" onclick="tambah_penukaran()" data-bs-toggle="modal" data-bs-target="#kt_modal_penukaran">
                                <i class="ki-duotone ki-plus fs-2"></i>Tambah Penukaran</button>
                            <!--end::Add penukaran-->
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-3" id="base_table">
                        <!--begin::Table container-->
                        <form action="<?= base_url('master_function/drag_penukaran') ?>" method="POST" class="table-responsive" id="reload_table">
                            <!--begin::Table-->
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th class="w-25px">No</th>
                                        <th class="min-w-200px">Pengirim</th>
                                        <th class="min-w-150px">Agen</th>
                                        <th class="min-w-150px">Jumlah Sampah</th>
                                        <th class="min-w-100px">Bukti</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>

                                    <?php if ($result) : ?>
                                        <?php $no = 1; foreach ($result as $row) : ?>
                                            <tr>
                                                <td><?= $no++;?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a class="text-dark fw-bold text-hover-primary fs-6"><?= ifnull($row->pengirim, 'Dalam proses...') ?></a>
                                                             <span class="text-muted fw-semibold text-muted d-block fs-7">Poin : <?= price_format($row->poin) ?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= $row->agen; ?></td>
                                                <td><?= $row->jumlah.' Kg'; ?></td>
                                                <td>
                                                    <img src="<?= image_check($row->bukti_kirim,'bukti_kirim') ?>" width="100px" alt="">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6">
                                                <center>Data penukaran hari ini tidak ditemukan</center>
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
                    </div>
                    <?php endif;?>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>

<!-- Modal Tambah penukaran -->
<!-- Modal Tambah unit -->
<div class="modal fade" id="kt_modal_penukaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div id="size" class="modal-dialog modal-dialog-centered mw-650px">
        <!-- mw-650px -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="form_penukaran" class="form" action="<?= base_url('dashboard_function/tambah_penukaran') ?>" method="POST" enctype="multipart/form-data">
                    <div class="d-flex">
                        <!--begin::Scroll-->
                        <div id="form_awal" class="d-flex flex-column scroll-y me-n7 pe-7 col-12" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_penukaran_header" data-kt-scroll-wrappers="#kt_modal_penukaran_scroll" data-kt-scroll-offset="300px">
                            <div class="mb-3"><b class="fs-1">Data Penukaran Sampah</b></div>
                            
                            <div class="d-flex justify-content-center align-items-center mb-4">
                                <img class="hidin" id="display_file" src="<?= base_url('data/default/notfound.jpg') ?>" alt="" style="width : 300px;height : 200px">
                            </div>
                            <input type="hidden" name="id_news">
                            <div class="fv-row mb-7" id="req_bukti_kirim">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Bukti Kirim</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="file" name="bukti_kirim" onchange="showFile(this)" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan bukti pengiriman" autocomplete="off" accept="image/*" />
                                <!--end::Input-->
                                <input type="hidden" name="nama_bukti_kirim">
                            </div>
                            <!--begin::Input group-->
                            <?php if($this->session->userdata('trash_id_role') == 1) : ?>
                            <!--begin::Input group-->
                            <div class="fv-row mb-7" id="req_id_agen">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Agen Penerima</label>
                                <!--end::Label-->
                                <div>
                                    <select onchange="get_pengepul_agen(this)" name="id_agen" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih agen penerima">
                                        <option value="" selected>Pilih agen</option>
                                        <?php if(isset($agen)) : ?>
                                            <?php foreach($agen AS $row) : ?>
                                                <option value="<?= $row->id_agen;?>">
                                                    <?= $row->nama; ?>
                                                </option>
                                            <?php endforeach;?>
                                        <?php else : ?>
                                            <option value="">Tidak ada agen tersedia</option>
                                        <?php endif;?>
                                    </select>
                                </div>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7" id="req_id_penerima">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Pengepul Penerima</label>
                                <!--end::Label-->
                                <div>
                                    <select name="id_penerima" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih agen penerima terlebih dahulu">

                                            <option value="">Pilih agen terlebih dahulu</option>
                                    </select>
                                </div>
                            </div>
                            <!--end::Input group-->
                            <?php endif;?>

                            <?php if($this->session->userdata('trash_id_role') == 3) : ?>
                                <input type="hidden" name="id_agen" value="<?= (isset($id_agen)) ? $id_agen : ''; ?>">
                                <input type="hidden" name="id_penerima" value="<?= $this->session->userdata('trash_id_user'); ?>">
                            <?php endif;?>
                            <!--begin::Input group-->
                            <div class="fv-row mb-7" id="req_id_pengirim">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Pengirim</label>
                                <!--end::Label-->
                                <div>
                                    <select onchange="new_user(this)" name="id_pengirim" class="form-select form-select-solid cekcek" data-control="select2" data-placeholder="Pilih pengirim">
                                        <option value="">Pilih user</option>
                                        <option value="new">Tambah Baru</option>
                                        <?php if($user) : ?>
                                           
                                            <?php foreach($user AS $row) : ?>
                                                <option value="<?= $row->id_user;?>">
                                                    <?= $row->nama; ?>
                                                    <?php if($row->status == 'N') : ?>
                                                        (Di Blockir)
                                                    <?php endif;?>
                                                </option>
                                            <?php endforeach;?>
                                        <?php else : ?>
                                            <option value="">Tidak ada pengirim tersedia</option>
                                        <?php endif;?>
                                    </select>
                                </div>
                            </div>
                            <!--end::Input group-->
                            <div class="fv-row mb-7" id="req_jumlah">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2 semi_required">Jumlah Sampah (Kg)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" id="tampilan_jumlah" onkeyup="matauang(this,'#jumlah')" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan jumlah sampah (Kg)" autocomplete="off" />
                                <input type="hidden" id="jumlah" name="jumlah" class="form-control form-control-solid mb-3 mb-lg-0" autocomplete="off" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            

                        </div>
                        <div class="col-1 hidin" id="batas"></div>
                        <!--end::Scroll-->
                        <div id="form_user" class="d-flex flex-column scroll-y me-n7 pe-7 col-5 hidin" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_penukaran_header" data-kt-scroll-wrappers="#kt_modal_penukaran_scroll" data-kt-scroll-offset="300px">
                            <div class="mb-3"><b class="fs-1">Data Pengirim</b></div>
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
                        </div>
                        <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" id="submit_penukaran" onclick="submit_form(this,'#form_penukaran',1)" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>