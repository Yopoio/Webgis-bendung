<?php
$id_bendung="";
$id_kecamatan="";
$nama="";
$struktur="";
$jumlah_pintu="";
$dimensi="";
$jenis_pintu="";
$lat="";
$lng="";
$polygon="";
$id_kategori_bendung="";
if($parameter=='ubah' && $id!=''){
    $this->db->where('id_bendung',$id);
    $row=$this->Model->get()->row_array();
    extract($row);
}

// value ketika validasi
if ($this->session->flashdata('error_value')) {
    extract($this->session->flashdata('error_value'));
}
?>
<?=content_open('Form Hotspot')?>
<?php
        // menampilkan error validasi
        if($this->session->flashdata('error_validation')){
            foreach ($this->session->flashdata('error_validation') as $key => $value) {
                echo '<div class="alert alert-danger">'.$value.'</div>';
            }
        }
    ?>
    <form method="post" action="<?=site_url($url.'/simpan')?>" enctype="multipart/form-data">
    	<?=input_hidden('id_bendung',$id_bendung)?>
        <?=input_hidden('parameter',$parameter)?>
    <div class="row">
        <div class="col-md-6">
    	<div class="form-group">
    		<label>Nama</label>
    		<div class="row">
	    		<div class="col-md-12">
	    			<?=input_text('nama',$nama)?>
		    	</div>
	    	</div>
    	</div>
    	<div class="form-group">
    		<label>Kecamatan</label>
    		<div class="row">
	    		<div class="col-md-12">
	    			<?php
	    				$op['']='Pilih Kecamatan';
                        $get=$this->KecamatanModel->get();
	    				foreach ($get->result() as $row) {
	    					$op[$row->id_kecamatan]=$row->nm_kecamatan;
	    				}
	    			?>
	    			<?=select('id_kecamatan',$op,$id_kecamatan)?>
	    		</div>
    		</div>
    	</div>
		<div class="form-group">
    		<label>Struktur</label>
    		<div class="row">
	    		<div class="col-md-12">
	    			<?=input_text('struktur',$struktur)?>
		    	</div>
	    	</div>
    	</div>
		<div class="form-group">
    		<label>Jumlah Pintu</label>
    		<div class="row">
	    		<div class="col-md-12">
	    			<?=input_text('jumlah_pintu',$jumlah_pintu)?>
		    	</div>
	    	</div>
    	</div>
    	<div class="form-group">
    		<label>Dimensi</label>
    		<div class="row">
	    		<div class="col-md-12">
    				<?=textarea('dimensi',$dimensi)?>
    			</div>
    		</div>
    	</div>
		<div class="form-group">
    		<label>Jenis</label>
    		<div class="row">
	    		<div class="col-md-12">
	    			<?=input_text('jenis_pintu',$jenis_pintu)?>
		    	</div>
	    	</div>
    	</div>
    	<div class="form-group">
    		<label>Titik Koordinat</label> 
    		<div class="row">
	    		<div class="col-md-6">
	    			<?=input_text('lat',$lat)?>
	    		</div>
	    		<div class="col-md-6">
	    			<?=input_text('lng',$lng)?>
	    		</div>
    		</div>
    	</div>
        <div class="form-group">
            <label>Kategori</label>
            <div class="row">
                <div class="col-md-10">
                    <?php
                        $op=null;
                        $op['']='Pilih Kategori';
                        $get=$this->KategorihotspotModel->get();
                        foreach ($get->result() as $row) {
                            $op[$row->id_kategori_bendung]=$row->nm_kategori_bendung;
                        }
                    ?>
                    <?=select('id_kategori_bendung',$op,$id_kategori_bendung)?>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <h3>Pilih Titik</h3>
        <div id="map" style="height: 400px"></div>
        <?=textarea('polygon',$polygon,'','style="display:none"')?>
    </div>
    <div class="col-md-12">
        <hr>
    	<div class="form-group">
    		<button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
			<a href="<?=site_url($url)?>" class="btn btn-danger" ><i class="fa fa-reply"></i> Kembali</a>
    	</div>
    </div>
    </div>

    </form>
<?=content_close()?>