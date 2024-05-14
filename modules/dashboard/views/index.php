
<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar pt-7 pt-lg-10">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
                <!--begin::Toolbar wrapper-->
                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                        <!--begin::Title-->
                        <h1
                            class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">
                            Dashboard</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="<?= base_url('dashboard') ?>"
                                    class="text-muted text-hover-warning">Dashboard</a>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">Riwayat</li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Row-->
                <div class="row mb-5 mb-xl-10">
                    
                    <?php if($this->session->userdata('trash_id_role') == 1): ?>
                    <!--begin::Col-->
                    <div class="col-xl-12">
                        <!--begin::Card widget 19-->
                        <div class="card card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body pt-5">
                                <!--begin::Heading-->
                                <div class="d-flex flex-stack flex-column" style="width : 6.035">
                                    <!--begin::Title-->
                                    <h4 class="fw-bold text-warning m-0 my-5" style="font-size : 45px"><?= month_from_number(date('m')).' '.date('Y') ?></h4>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Heading-->
                                <div class="d-flex align-items-center justify-content-between">
                                    <!--begin::Col-->
                                <div class="col-xl-4">
                                    <!--begin::Card widget 19-->
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <!--begin::Body-->
                                        <div class="card-body pt-5">
                                            <!--begin::Heading-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Title-->
                                                <h4 class="fw-bold text-gray-800 m-0">Total admin</h4>
                                                <!--end::Title-->
                                                <!--end::Menu-->
                                            </div>
                                            <!--end::Heading-->
                                            <!--begin::Chart-->
                                            <div class="d-flex flex-center w-100 flex-column" style="height : 170px;">
                                                <span class="text-warning " style="font-size : 60px;"><?= simple_number($jumlah['admin']) ?></span>
                                                <span class="text-muted"><?= $jumlah['admin'] ?> admin</span>
                                            </div>
                                            <!--end::Chart-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Card widget 19-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-xl-4">
                                    <!--begin::Card widget 19-->
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <!--begin::Body-->
                                        <div class="card-body pt-5">
                                            <!--begin::Heading-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Title-->
                                                <h4 class="fw-bold text-gray-800 m-0">Total user</h4>
                                                <!--end::Title-->
                                                <!--end::Menu-->
                                            </div>
                                            <!--end::Heading-->
                                            <!--begin::Chart-->
                                            <div class="d-flex flex-center w-100 flex-column" style="height : 170px;">
                                                <span class="text-warning " style="font-size : 60px;"><?= simple_number($jumlah['user']) ?></span>
                                                <span class="text-muted"><?= $jumlah['user']; ?> customer</span>
                                            </div>
                                            <!--end::Chart-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Card widget 19-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-xl-4">
                                    <!--begin::Card widget 19-->
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <!--begin::Body-->
                                        <div class="card-body pt-5">
                                            <!--begin::Heading-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Title-->
                                                <h4 class="fw-bold text-gray-800 m-0">Total Pengepul</h4>
                                                <!--end::Title-->
                                                <!--end::Menu-->
                                            </div>
                                            <!--end::Heading-->
                                            <!--begin::Chart-->
                                            <div class="d-flex flex-center w-100 flex-column" style="height : 170px;">
                                                <span class="text-warning " style="font-size : 60px;"><?= simple_number($jumlah['pengepul']) ?></span>
                                                <span class="text-muted"><?= $jumlah['pengepul'] ?> Pengepul</span>
                                            </div>
                                            <!--end::Chart-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Card widget 19-->
                                </div>
                                <!--end::Col-->
                                </div>
                                
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 19-->
                    </div>
                    <!--end::Col-->
                    <?php endif;?>

                    <?php if($this->session->userdata('trash_id_role') == 2): ?>
                    <!--begin::Col-->
                    <div class="col-xl-12">
                        <!--begin::Card widget 19-->
                        <div class="card card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body pt-5">
                                <!--begin::Heading-->
                                <div class="d-flex flex-stack flex-column" style="width : 6.035">
                                    <!--begin::Title-->
                                    <h4 class="fw-bold text-warning m-0 my-5" style="font-size : 45px"><?= month_from_number(date('m')).' '.date('Y') ?></h4>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Heading-->
                                <div class="d-flex align-items-center justify-content-center">
                                    <!--begin::Col-->
                                <div class="col-xl-4">
                                    <!--begin::Card widget 19-->
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <!--begin::Body-->
                                        <div class="card-body pt-5">
                                            <!--begin::Heading-->
                                            <div class="d-flex justify-content-center align-items-center">
                                                <!--begin::Title-->
                                                <h4 class="fw-bold text-gray-800 m-0">Total poin anda</h4>
                                                <!--end::Title-->
                                                <!--end::Menu-->
                                            </div>
                                            <!--end::Heading-->
                                            <!--begin::Chart-->
                                            <div class="d-flex flex-center w-100 flex-column" style="height : 170px;">
                                                <span class="text-warning " style="font-size : 60px;"><?= simple_number($pribadi->poin) ?></span>
                                                <span class="text-muted"><?= $pribadi->poin ?> Poin</span>
                                            </div>
                                            <!--end::Chart-->
                                            <button class="btn btn-warning w-100" onclick="tukar_poin(<?= $pribadi->poin ?>)"  data-bs-toggle="modal" data-bs-target="#kt_modal_voucher">Tukar Poin</button>
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Card widget 19-->
                                </div>
                                <!--end::Col-->
                                </div>
                                
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 19-->
                    </div>
                    <!--end::Col-->
                    

                    <div class="col-xl-12">
                        <div class="card card-xl-stretch mb-xl-8">
                            <div class="card-body py-3" id="base_table">
                                <!--begin::Table container-->
                                <div class="table-responsive" id="reload_table">
                                    <!--begin::Table-->
                                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr class="fw-bold text-muted">
                                                <th class="w-25px">No</th>
                                                <th class="min-w-100px">Agen</th>
                                                <th class="min-w-100px text-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>

                                            <?php if ($agen) : ?>
                                                <?php $no=1; foreach ($agen as $row) : ?>
                                                    <tr> 
                                                        <td><?= $no++;?></td>
                                                        <td>
                                                            <div class="d-flex justify-content-start align-items-start flex-column">
                                                                <a class="text-dark fw-bold text-hover-primary fs-6"><?= ifnull($row->nama, 'Dalam proses...') ?></a>
                                                                <span class="text-bold text-dark"><?= ifnull($row->alamat,'Tidak ada alamat tercantum'); ?></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justify-content-end flex-shrink-0">
                                                                <button type="button" onclick="map_agen('<?= $row->latitude; ?>','<?= $row->longitude; ?>')" class="btn btn-icon btn-bg-light btn-active-color-info btn-sm me-1" title="Lokasi agen" data-bs-toggle="modal" data-bs-target="#kt_modal_lokasi">
                                                                    <i class="ki-outline ki-map fs-2"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="3">
                                                        <center>Data agen tidak ditemukan</center>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                    <?= $this->pagination->create_links(); ?>
                                </div>
                                <!--end::Table container-->
                            </div>
                        </div>
                    </div>



                    <div class="col-xl-12">
                        <div class="card card-xl-stretch mb-xl-8">
                            <div class="card-body py-3" id="base_table">
                                <!--begin::Table container-->
                                <div class="table-responsive" id="reload_table">
                                    <!--begin::Table-->
                                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr class="fw-bold text-muted">
                                                <th class="w-25px">No</th>
                                                <th class="min-w-100px">Voucher anda</th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>

                                            <?php if ($voucher) : ?>
                                                <?php $no=1; foreach ($voucher as $row) : ?>
                                                    <tr> 
                                                        <td><?= $no++;?></td>
                                                        <td>
                                                            <div class="d-flex justify-content-start align-items-start flex-column">
                                                                <a class="text-dark fw-bold text-hover-primary fs-6"><?= ifnull($row->nama, 'Dalam proses...') ?></a>
                                                                <span class="text-bold text-dark"><?= ifnull($row->keterangan,'Tidak ada keterangan tercantum'); ?></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="3">
                                                        <center>Data agen tidak ditemukan</center>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                    <?= $this->pagination->create_links(); ?>
                                </div>
                                <!--end::Table container-->
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
                <!--end::Row-->

                
            </div>
            <!--end::Content container-->

            
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>
<!--end:::Main-->

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
<div class="modal fade" id="kt_modal_voucher" tabindex="-1" aria-hidden="true">
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
            <div id="display_voucher"></div>
            
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - View Users-->