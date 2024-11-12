<?=content_open($title)?>
	<div class="row">
		<div class="col-md-4">
			<?=input_text('latNow','','','placeholder="Enter latitude"')?>
		</div>
		<div class="col-md-4">
			<?=input_text('lngNow','','','placeholder="Enter longitude"')?>
		</div>
		<div class="col-md-4">
			<button class="dariSini btn btn-info"><i class="fa fa-map-marker"></i> Mulai dari Posisi Kita</button>
		</div>
	</div>
 	<div id="map"></div>
<?=content_close()?>
