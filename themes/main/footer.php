<!--begin::Javascript-->
<script>
    var BASE_URL = '<?= base_url(); ?>';
    var hostUrl = "<?= base_url(); ?>assets/admin/";
    var css_btn_confirm = 'btn btn-primary';
    var css_btn_cancel = 'btn btn-danger';
     addEventListener('keypress', function(e) {
        if (e.keyCode === 13 || e.which === 13) {
            e.preventDefault();
            return false;
        }
    });
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="https://kit.fontawesome.com/0b267ee3b2.js" crossorigin="anonymous"></script>
<script src="<?= base_url(); ?>assets/plugins/global/plugins.bundle.js"></script>
<script src="<?= base_url(); ?>assets/admin/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="<?= base_url(); ?>assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="<?= base_url(); ?>assets/plugins/custom/vis-timeline/vis-timeline.bundle.js"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<!--end::Vendors Javascript-->

<!--begin::Custom Javascript(used for this page only)-->
<!-- <script src="<?= base_url(); ?>assets/admin/js/custom/widgets.js"></script> -->
<script src="<?= base_url(); ?>assets/admin/js/custom/utilities/modals/upgrade-plan.js"></script>
<script src="<?= base_url(); ?>assets/admin/js/custom/utilities/modals/create-campaign.js"></script>
<script src="<?= base_url(); ?>assets/admin/js/custom/utilities/modals/users-search.js"></script>
	<script src="<?= base_url('assets/admin/') ?>js/widgets.bundle.js"></script>
    <script type="text/javascript" src="<?=base_url('assets/plugins/ckeditor5/ckeditor.js'); ?>"></script>
	<script src="<?= base_url('assets/admin/') ?>js/custom/widgets.js"></script>
<script src="<?= base_url(); ?>assets/js/function.js"></script>
<script src="<?= base_url(); ?>assets/admin/js/modul/mekanik.js"></script>
<script src="<?= base_url(); ?>assets/admin/js/custom/javascript_pribadi.js"></script>



<!--end::Custom Javascript-->
<?php

if (isset($js_add) && is_array($js_add)) {
    foreach ($js_add as $js) {
        echo $js;
    }
} else {
    echo (isset($js_add) && ($js_add != "") ? $js_add : "");
}

?>
<!--end::Javascript-->
</body>
<!--end::Body-->

</html>