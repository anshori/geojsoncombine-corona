<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Menampilkan data json menjadi peta dalam kasus data COVID-19 dengan sumber dari https://api.kawalcorona.com">
  <meta name="author" content="unsorry">

  <link href="https://unsorry.net/assets-date/images/favicon.png" rel="shortcut icon" type="image/png">
  <title>Circle Provinsi</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css">
  <link rel="stylesheet" href="assets/app.css">
</head>
<body>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#"><i class="fas fa-map-marker-alt"></i> Kasus Covid-19</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php"><i class="fas fa-map-marked-alt"></i> Centroid Provinsi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboardpolygonprovinsi.php"><i class="fas fa-map"></i> Polygon Provinsi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="modal" data-target="#infoModal"><i class="fas fa-info-circle"></i> Info</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- Modal -->
  <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark text-light">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-info-circle"></i> Info</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card alert-dark p-3">
            Peta ini menggunakan data kasus COVID-19 dari <a href="https://api.kawalcorona.com/indonesia/provinsi/" target="_blank">https://api.kawalcorona.com/indonesia/provinsi/</a> yang digabungkan dengan file <a href="data/provinsi_point.geojson" target="_blank">provinsi_point.geojson</a> menggunakan PHP menjadi geojson layer baru berupa <a href="geojson.php" target="_blank">geojson.php</a> yang secara otomatis ketika ada perubahan data dari <a href="https://api.kawalcorona.com/indonesia/provinsi/" target="_blank">https://api.kawalcorona.com/indonesia/provinsi/</a> maka info kasus positif, kasus sembuh, dan kasus meninggal akan otomatis berubah.
            <hr>
            <a href="https://github.com/anshori/geojsoncombine-corona" type="button" class="btn btn-primary btn-sm btn-block" target="_blank"><i class="fab fa-github"></i> Source Code</a>
          </div>
        </div>
        <div class="modal-footer">
            <div class="col text-left">
              <a class="btn btn-link btn-sm" type="button" href="https://unsorry.net" target="_blank">unsorry@2020</a>
            </div>
            <div class="col text-right">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row row-map">
      <div class="col-sm">
        <div id="map"></div>
      </div>
    </div>
    <div class="row row-info">
      <?php
        $dataIndonesia = file_get_contents("https://api.kawalcorona.com/indonesia/");
        $kasusIndonesia = json_decode($dataIndonesia);

        foreach($kasusIndonesia as $item){
      ?>
      <div class="col-sm-4 text-center text-warning bg-dark">
        <div class="row p-3">
          <div class="col-3">
            <i class="far fa-sad-tear fa-4x"></i>
          </div>
          <div class="col text-left">
            <h5><strong>TOTAL POSITIF</strong></h5>
            <h5><?php echo $item->positif; ?> orang</h5>
          </div>
        </div>
      </div>
      <div class="col-sm-4 text-center text-success bg-dark">
        <div class="row p-3">
          <div class="col-3">
            <i class="far fa-smile fa-4x"></i>
          </div>
          <div class="col text-left">
            <h5><strong>TOTAL SEMBUH</strong></h5>
            <h5><?php echo $item->sembuh; ?> orang</h5>
          </div>
        </div>
      </div>
      <div class="col-sm-4 text-center text-danger bg-dark">
        <div class="row p-3">
          <div class="col-3">
            <i class="far fa-frown fa-4x"></i>
          </div>
          <div class="col text-left">
            <h5><strong>TOTAL MENINGGAL</strong></h5>
            <h5><?php echo $item->meninggal; ?> orang</h5>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
  
  <script>
    /* Initial Map */
    var map = L.map('map').setView([-2.4058653,117.5021489],5);

    var _attribution = '<a href="https://unsorry.net" target="_blank">unsorry@2020</a>';
    
    /* Tile Basemap */
    var basemap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: _attribution
    });
    basemap.addTo(map);

    var kasuspositif = L.geoJson(null, {
      pointToLayer: function (feature, latlng) {
        var geojsonMarkerOptions = {
          radius: feature.properties.Kasus_Positif/10,
          fillColor: "red",
          color: "gray",
          weight: 0.7,
          opacity: 1,
          fillOpacity: 0.8
        };
        return L.circleMarker(latlng, geojsonMarkerOptions);
      },
      onEachFeature: function (feature, layer) {
        if (feature.properties) {
          var content = "<div class='card'>" +
          "<div class='card-header alert-success text-center p-1'><strong>Provinsi<br>" + feature.properties.PROV + "</strong></div>" +
          "<div class='card-body p-0'>" +
            "<table class='table table-responsive-sm m-0'>" +
              "<tr><th><i class='far fa-sad-tear'></i> Kasus Positif</th><th>" + feature.properties.Kasus_Positif + "</th></tr>" +
              "<tr class='text-success'><th><i class='far fa-smile'></i> Kasus Sembuh</th><th>" + feature.properties.Kasus_Sembuh + "</th></tr>" +
              "<tr class='text-danger'><th><i class='far fa-frown'></i> Kasus Meninggal</th><th>" + feature.properties.Kasus_Meninggal + "</th></tr>" +
            "</table>" +
          "</div>";
          layer.on({
            click: function (e) {
              kasuspositif.bindPopup(content);
            },
            mouseover: function (e) {
              kasuspositif.bindTooltip("Prov. " + feature.properties.PROV + "<br>Kasus Positif: " + feature.properties.Kasus_Positif, {sticky: true});
            }
          });
        }
      }
    });
    $.getJSON("geojson.php", function (data) {
      kasuspositif.addData(data);
      map.addLayer(kasuspositif);
      map.fitBounds(kasuspositif.getBounds());
    });   

    var legend = new L.Control({position: 'bottomleft'});
    legend.onAdd = function (map) {
      this._div = L.DomUtil.create('div', 'info');
      this.update();
      return this._div;
    };
    legend.update = function () {
      this._div.innerHTML = '<h5>Legenda</h5><table class="table table-sm"><tr><td><svg width="24" height="24"><circle cx="12" cy="12" r="10" stroke="gray" stroke-width="0.5" fill="rgb(255,0,0,0.8)" /></svg></td><td>Ukuran radius lingkaran<br>menunjukkan jumlah<br>kasus positif dalam<br>satuan pixel</td></tr></table><hr><small>Sumber data:<br><a href="https://kawalcorona.com" target="_blank">https://kawalcorona.com</a></small>'
    };
    legend.addTo(map);
  </script>
</body>
</html>