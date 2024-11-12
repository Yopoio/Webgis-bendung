<?php
$id_kategori_bendung = "";
$nm_kategori_bendung = "";
$kd_kategori_bendung = "";
if ($parameter == 'ubah' && $id != '') {
    $this->db->where('id_kategori_bendung', $id);
    $row = $this->Model->get()->row_array();
    extract($row);
}

// value ketika validasi
if ($this->session->flashdata('error_value')) {
    extract($this->session->flashdata('error_value'));
}

?>
<?= content_open($title) ?>
<?php
// menampilkan error validasi
if ($this->session->flashdata('error_validation')) {
    foreach ($this->session->flashdata('error_validation') as $key => $value) {
        echo '<div class="alert alert-danger">' . $value . '</div>';
    }
}
?>
<form method="post" action="<?= site_url($url . '/simpan') ?>" enctype="multipart/form-data">
    <?= input_hidden('id_kategori_bendung', $id_kategori_bendung) ?>
    <?= input_hidden('parameter', $parameter) ?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label>Kode Kategori</label>
                        <?= input_text('kd_kategori_bendung', $kd_kategori_bendung) ?>
                    </div>
                    <div class="col-md-7">
                        <label>Kategori Struktur Air</label>
                        <?= input_text('nm_kategori_bendung', $nm_kategori_bendung) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Marker</label>
                <div class="row">
                    <div class="col-md-10">
                        <?= input_file('marker', '') ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
            <div class="form-group">
                <button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?= site_url($url) ?>" class="btn btn-danger"><i class="fa fa-reply"></i> Kembali</a>
            </div>
        </div>
    </div>

</form>
<?= content_close() ?>