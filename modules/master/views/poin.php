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
                            <h1 class="d-flex text-dark fw-bold m-0 fs-3">Poin</h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">
                                    <a class="text-gray-600 text-hover-primary">Master</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">Poin</li>
                                <!--end::Item-->
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page title-->
                    </div>
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <div class="d-flex align-items-center position-relative me-3 search_mekanik w-300px">
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-none justify-content-end" id="sistem_drag">
                                <button type="button" id="btn_hapus" onclick="submit_form(this,'#reload_table',0,'/deleted',true,true)" data-message="Apakah anda yakin akan menghapus data poin? data yang di hapus tidak akan bisa di kembalikan" class="btn btn-sm btn-light-danger me-3">Hapus</button>
                            </div>
                            <div class="d-flex justify-content-end" id="sistem_filter">

                            </div>
                            <!--end::Toolbar-->
                            <!--begin::Add poin-->
                            <button type="button" class="btn btn-sm btn-light" onclick="tambah_poin()" data-bs-toggle="modal" data-bs-target="#kt_modal_poin">
                                <i class="ki-duotone ki-plus fs-2"></i>Tambah Poin</button>
                            <!--end::Add poin-->
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-3" id="base_table">
                        <!--begin::Table container-->
                        <form action="<?= base_url('master_function/drag_poin') ?>" method="POST" class="table-responsive" id="reload_table">
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
                                        <th class="min-w-150px">Jumlah Minimal (Kg)</th>
                                        <th class="min-w-150px">Jumlah Maximal (Kg)</th>
                                        <th class="min-w-150px">Poin</th>
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
                                                        <input class="form-check-input widget-9-check cursor-pointer child_checkbox" name="id_batch[]" onchange="child_checked()" type="checkbox" value="<?= $row->id_poin ?>">
                                                    </div>
                                                </td>
                                                <td><?= $row->jumlah_minimal.' Kg'; ?></td>
                                                <td><?= $row->jumlah_maximal.' Kg'; ?></td>
                                                <td><?= $row->poin.' Poin'; ?></td>
                                                <td>

                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" title="Ubah data poin" onclick="edit_poin(this,<?= $row->id_poin; ?>)" data-bs-toggle="modal" data-bs-target="#kt_modal_poin">
                                                            <i class="ki-outline ki-pencil fs-2"></i>
                                                        </button>
                                                        <button type="button" onclick="hapus_data(event,<?= $row->id_poin; ?>,'master_function/hapus_poin','poin')" title="Hapus data poin" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm">
                                                            <i class="ki-outline ki-trash fs-2"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="5">
                                                <center>Data poin tidak ditemukan</center>
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

<!-- Modal Tambah poin -->
<div class="modal fade" id="kt_modal_poin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal">Tambah Poin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="form_poin" class="form" action="<?= base_url('master_function/tambah_poin') ?>" method="POST" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="#" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_poin_header" data-kt-scroll-wrappers="#kt_modal_Poin_scroll" data-kt-scroll-offset="300px">
                        
                        <div id="lead"></div>
                        <input type="hidden" name="id_poin">
                        <div class="mb-4" id="req_jumlah_minimal">
                            <label for="jumlah_minimal" class="required form-label">Jumlah Minimal (Kg)</label>
                            <input id="display_jumlah_minimal" onkeyup="matauang(this,'#jumlah_minimal')" type="text" class="not_important form-control form-control-solid" placeholder="Masukkan minimal"/>
                            <input type="hidden" id="jumlah_minimal" name="jumlah_minimal" class="not_important form-control form-control-solid mb-3 mb-lg-0" autocomplete="off" />
                        </div>

                        <div class="mb-4" id="req_jumlah_maximal">
                            <label for="jumlah_maximal" class="required form-label">Jumlah Maximal (Kg)</label>
                            <input id="display_jumlah_maximal" onkeyup="matauang(this,'#jumlah_maximal')" type="text" class="not_important form-control form-control-solid" placeholder="Masukkan maximal"/>
                            <input type="hidden" id="jumlah_maximal" name="jumlah_maximal" class="not_important form-control form-control-solid mb-3 mb-lg-0" autocomplete="off" />
                        </div>

                        <div class="mb-4" id="req_poin">
                            <label for="poin" class="required form-label">Poin</label>
                            <input id="display_poin" onkeyup="matauang(this,'#poin')" type="text" class="not_important form-control form-control-solid" placeholder="Masukkan poin"/>
                            <input type="hidden" id="poin" name="poin" class="not_important form-control form-control-solid mb-3 mb-lg-0" autocomplete="off" />
                        </div>
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" id="submit_poin" onclick="submit_form(this,'#form_poin',1)" class="btn btn-primary">
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