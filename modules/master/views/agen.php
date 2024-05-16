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
                            <h1 class="d-flex text-dark fw-bold m-0 fs-3">Agen</h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">
                                    <a class="text-gray-600 text-hover-primary">Master</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">List Agen</li>
                                <!--end::Item-->
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page title-->
                    </div>
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <div class="d-flex align-items-center position-relative me-3 search_mekanik w-300px">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" name="search" value="<?= $search; ?>" class="form-control form-control-solid w-250px ps-13" aria-label="Cari Agen" aria-describedby="button-cari-agen" placeholder="Cari Agen" autocomplete="off">
                            <button type="button" onclick="search(false)" class="btn btn-primary d-none" type="button" id="button-cari-agen">
                                <i class="ki-duotone ki-magnifier fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </button>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-none justify-content-end" id="sistem_drag">
                                <button type="button" id="btn_hapus" onclick="submit_form(this,'#reload_table',0,'/deleted',true,true)" data-message="Apakah anda yakin akan menghapus data agen? data yang di hapus tidak akan bisa di kembalikan" class="btn btn-sm btn-light-danger me-3">Hapus</button>
                                <button type="button" id="btn_block" onclick="submit_form(this,'#reload_table',0,'/block',true)" class="btn btn-sm btn-light-primary me-3">Sembunyikan</button>
                                <button type="button" id="btn_unblock" onclick="submit_form(this,'#reload_table',0,'/unblock',true)" class="btn btn-sm btn-light-primary me-3">Tampilkan</button>

                            </div>
                            <div class="d-flex justify-content-end" id="sistem_filter">

                                <!--begin::Filter-->
                                <button type="button" class="btn btn-sm btn-light me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-duotone ki-filter fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Penyaringan
                                </button>
                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px filter_mekanik" data-kt-menu="true">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bold">Pilihan Penyaringan</div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Separator-->
                                    <!--begin::Content-->
                                    <div class="px-7 py-5">
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <label class="form-label fs-6 fw-semibold">Status</label>
                                            <select name="status" class="form-select form-select-solid filter-input" data-control="select2" data-placeholder="Pilih opsi status">
                                                <option value="all">Semua</option>
                                                <option value="Y" <?php if ($this->input->get('status') == 'Y') {
                                                                        echo 'selected';
                                                                    } ?>>Aktif</option>
                                                <option value="N" <?php if ($this->input->get('status') == 'N') {
                                                                        echo 'selected';
                                                                    } ?>>Tidak Aktif</option>
                                            </select>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="button" onclick="filter(['status'],false)" class="btn btn-primary fw-semibold px-6">Terapkan</button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Menu 1-->
                                <!--end::Filter-->
                                <!--begin::Export-->
                                <!--end::Export-->

                            </div>
                            <!--end::Toolbar-->
                            <!--begin::Add user-->
                            <button type="button" class="btn btn-sm btn-light" onclick="tambah_agen()" data-bs-toggle="modal" data-bs-target="#kt_modal_agen">
                                <i class="ki-duotone ki-plus fs-2"></i>Tambah Agen</button>
                            <!--end::Add user-->
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-3" id="base_table">
                        <!--begin::Table container-->
                        <form action="<?= base_url('master_function/drag_agen') ?>" method="POST" class="table-responsive" id="reload_table">
                            <!--begin::Table-->
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th class="w-25px">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input cursor-pointer" type="checkbox" onchange="checked_action(this)" <?php if (!$result) {
                                                                                                                                                    echo 'disabled';
                                                                                                                                                } ?>>
                                            </div>
                                        </th>
                                        <th class="min-w-100px">Agen</th>
                                        <th class="min-w-200px">Daftar Pengepul</th>
                                        <th class="min-w-100px text-center">Status</th>
                                        <th class="min-w-100px text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>

                                    <?php if ($result) : ?>
                                        <?php foreach ($result as $row) : ?>
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input widget-9-check cursor-pointer child_checkbox" name="id_batch[]" onchange="child_checked()" type="checkbox" value="<?= $row['id_agen'] ?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-start align-items-start flex-column">
                                                        <a class="text-dark fw-bold text-hover-primary fs-6"><?= ifnull($row['nama'], 'Dalam proses...') ?></a>
                                                        <span class="text-bold text-dark"><?= ifnull($row['alamat'], 'Tidak ada alamat tercantum'); ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if ($row['member']) : ?>
                                                        <?php foreach ($row['member'] as $key) : ?>
                                                            <span class="text-dark fw-bold text-muted d-block fs-6"><?= '- ' . $key['nama']; ?></span>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <span class="text-dark fw-bold text-muted d-block fs-6"> - </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input cursor-pointer focus-green" type="checkbox" role="switch" onchange="switch_block(this,event,<?= $row['id_agen'] ?>)" id="switch-<?= $row['id_agen'] ?>" <?php if ($row['status'] == 'Y') {
                                                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                                                    } ?>>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td>

                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <button type="button" onclick="map_agen('<?= $row['latitude']; ?>','<?= $row['longitude']; ?>')" class="btn btn-icon btn-bg-light btn-active-color-info btn-sm me-1" title="Lokasi agen" data-bs-toggle="modal" data-bs-target="#kt_modal_lokasi">
                                                            <i class="ki-outline ki-map fs-2"></i>
                                                        </button>
                                                        <button type="button" title="Tambah pengepul" onclick="tambah_pengepul(this,<?= $row['id_agen']; ?>)" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_pengepul">
                                                            <i class="ki-outline ki-user fs-2"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" title="Ubah data agen" onclick="edit_agen(this,<?= $row['id_agen']; ?>)" data-bs-toggle="modal" data-bs-target="#kt_modal_agen">
                                                            <i class="ki-outline ki-pencil fs-2"></i>
                                                        </button>
                                                        <button type="button" onclick="hapus_data(event,<?= $row['id_agen']; ?>,'master_function/hapus_agen','agen')" title="Hapus data agen" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm">
                                                            <i class="ki-outline ki-trash fs-2"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="5">
                                                <center>Data agen tidak ditemukan</center>
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
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>

<!-- Modal Tambah agen -->
<div class="modal fade" id="kt_modal_agen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal">Tambah Agen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="form_agen" class="form" action="<?= base_url('master_function/tambah_agen') ?>" method="POST" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="#" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_agen_header" data-kt-scroll-wrappers="#kt_modal_agen_scroll" data-kt-scroll-offset="300px">
                        <div id="lead"></div>
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_nama">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Nama Agen</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="nama" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan nama agen" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <input type="hidden" name="id_agen">

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_latitude">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Latitude</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="latitude" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan longitude" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_longitude">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Longitude</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="longitude" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan longitude" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_alamat">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Alamat</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="alamat" cols="30" rows="10" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan alamat" autocomplete="off"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" id="submit_agen" onclick="submit_form(this,'#form_agen',1)" class="btn btn-primary">
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


<!-- Modal Tambah lokasi -->
<div class="modal fade" id="kt_modal_lokasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal">Lokasi Agen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Scroll-->
                <div class="d-flex flex-column scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_agen_header" data-kt-scroll-wrappers="#kt_modal_agen_scroll" data-kt-scroll-offset="300px">
                    <div id="map_agen"></div>


                </div>
                <!--end::Scroll-->
            </div>
        </div>
    </div>
</div>


<!--begin::Modal - View Users-->
<div class="modal fade" id="kt_modal_pengepul" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header pb-0 border-0 justify-content-end">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div id="display_pengepul"></div>

        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - View Users-->