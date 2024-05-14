<div class="table-responsive" id="reload_rate">
    <span class="text-muted mb-3"><i>Nb: Tekan row tabel untuk melakukan aksi hapus / ubah</i></span>
    <table class="table table-bordered">
        <thead>
            <tr class="fw-bold fs-6 text-gray-800">
                <th colspan="2" class="text-center">Nominal</th>
                <th rowspan="2" class="text-center text-middle">Rate</th>
            </tr>
            <tr class="fw-bold fs-6 text-gray-800">
                <th class="text-center">Min</th>
                <th class="text-center">Max</th>
            </tr>
        </thead>
        <tbody id="parent_load_rate">
            <?php if($result) : ?>
                <?php foreach($result AS $row) : ?>
                <tr id="row-<?= $row->id_rate ?>" class="cursor-pointer" onclick="get_row_table(this, <?= $row->id_rate; ?>, '<?= $row->min_tf; ?>','<?= $row->max_tf; ?>','<?= $row->rate;?>')">
                    <td><?= price_format($row->min_tf,'none'); ?></td>
                    <td><?= price_format($row->max_tf,'none'); ?></td>
                    <td><?= $row->rate; ?></td>
                </tr>
                <?php endforeach;?>
            <?php else : ?>
                <tr>
                    <td colspan="4"><center>Tidak ada data rate tercantum</center></td>
                </tr>
            <?php endif;?>
        </tbody>
    </table>
    <input type="hidden" name="id_produk" value="<?= $id_produk; ?>">
</div>