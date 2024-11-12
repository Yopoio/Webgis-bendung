<?= content_open($title) ?>
<div class="row">
  <form>
    <div class="form-row align-items-center">
      <div class="col-auto" id="dari">
        <label class="mr-sm-2" for="from">Dari</label>
        <select id="from-starting" class="custom-select mb-2 mr-sm-2 mb-sm-0"></select>
      </div>
      <div class="col-auto" id="ke">
        <label class="mr-sm-2" for="to">Ke</label>
        <select id="to-end" class="custom-select mb-2 mr-sm-2 mb-sm-0"></select>
      </div>

      <div class="col-auto">
        <button type="button" id="clearmap" class="btn btn-danger">
          Bersihkan Map
        </button>
      </div>
      <div class="col-auto">
        <button type="button" id="getshortestroute" class="btn btn-success" title="find shortest path between nodes">
          Mulai Rute
        </button>
      </div>
    </div>
  </form>
  <div class="col-md-2">
    <label class="mr-sm-2" for="from">Lat</label>
    <?= input_text('latNow', '') ?>
  </div>
  <div class="col-md-2">
    <label class="mr-sm-2" for="from">Lng</label>
    <?= input_text('lngNow', '') ?>
  </div>
  <div class="form-row align-items-center">
    <div class="col-auto">
      <button class="dariSini btn btn-info"><i class="fa fa-map-marker"></i> Mulai dari Posisi Kita</button>
    </div>
  </div>
</div>
<div id="map"></div>
<?= content_close() ?>