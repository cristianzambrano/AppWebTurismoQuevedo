<input type="hidden" name="idlugarturistico" id="idlugarturistico" value="<?= $id; ?>">
      
<div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
  <div class="tr-card-body">
                 
             <div class="container mt-2">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Datos Generales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Ubicación geográfica</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                    
                      <div class="row mb-1 mt-1">
                      <div class="col-sm-3 ml-2 mb-2 mr-2 mt-2 text-center" >
                        <?php 
                          if(!file_exists("assets/imgs/logos_gifs/".$logo) || $logo=="")  $logo = "logogad.jpg";
                        ?>
                        <img id="pimgLogo" src="assets/imgs/logos_gifs/<?=$logo?>" class="w-100 img-fluid">   
                      </div>
                      <div class="col-sm-8 mt-2 mb-2 mr-2">
                        <i class="fa fa-building" aria-hidden="true"></i> <b>Descripción del Lugar</b>
                        <p><?=$descripcion;?></p>  
                      </div>

                      <?php if(file_exists("assets/imgs/logos_gifs/".$imagenes_gif) && $imagenes_gif!=""){ ?>
                              <div class="col-sm-11" style="margin: 0.5em 0em 0em 0.5em;">
                                <img id="pimgLogo" src="assets/imgs/logos_gifs/<?=$imagenes_gif?>" class="img-thumbnail">   
                            </div>
                      <?php } ?>

                      <div class="col-sm-11" style="margin: 0.5em 0em 0em 0.5em;">
                        <i class="fa fa-map-marker" aria-hidden="true"></i> <b>Dirección: </b> <?=$direccion;?>
                      </div>
                      <div class="col-sm-11" style="margin: 0.5em 0em 0em 0.5em;">
                          <i class="fa fa-phone" aria-hidden="true"></i> <b>Teléfono: </b> <?=$telefono;?>
                      </div>

                       <div class="col-sm-11" style="margin: 0.5em 0em 0em 0.5em;">
                          <b>Redes Sociales</b>
                          <ul class="social mb-0 list-inline mt-1">
                            <li class="list-inline-item m-1">
                              <?php if($whatsapp!="") echo '<a href="'.$whatsapp.'" target="_blank" class="social-link">'; ?>
                              <i class="fa fa-whatsapp fa-2x"></i>
                              <?php if($whatsapp!="") echo'</a>'; ?>
                            </li>
                            <li class="list-inline-item m-1">
                              <?php if($facebook!="") echo '<a href="'.$facebook.'" target="_blank" class="social-link">'; ?>
                              <i class="fa fa-facebook fa-2x"></i>
                              <?php if($facebook!="") echo'</a>'; ?>
                            </li>

                            <li class="list-inline-item m-1">
                              <?php if($x!="") echo '<a href="'.$x.'" target="_blank" class="social-link">'; ?>
                              <i class="fa fa-xing fa-2x"></i>
                              <?php if($x!="") echo'</a>'; ?>
                            </li>

                            <li class="list-inline-item m-1">
                              <?php if($instagram!="") echo '<a href="'.$instagram.'" target="_blank" class="social-link">'; ?>
                              <i class="fa fa-instagram fa-2x"  style="margin-top: 0.2em;"></i>
                              <?php if($instagram!="") echo'</a>'; ?>
                            </li>

                            <li class="list-inline-item m-1">
                              <?php if($tiktok!="") echo '<a href="'.$tiktok.'" target="_blank" class="social-link">'; ?>
                              <img src="assets/icons/tiktok.svg" style="vertical-align: middle; margin-top: 0.0em; width: 2em; height: 2em;">
                              <?php if($tiktok!="") echo'</a>'; ?>
                            </li>
                          </ul>
                       </div>

                       <div class="col-sm-7" style="margin: 0.5em 0em 0em 0.5em;">
                        <b>Puntuación</b>
                        <ul class="list-inline">
                          <?php 
                            for($i=1; $i<=$puntuacion && $i<=5;$i++)
                                echo '<li class="list-inline-item m-0"><i class="fa fa-star text-success fa-2x"></i></li>';

                            for($i=$puntuacion+1; $i<=5;$i++)
                                echo '<li class="list-inline-item m-0"><i class="fa fa-star-o text-success fa-2x"></i></li>';
                            ?>
                        </ul>
                      </div>
                       <div class="col-sm-4" style="margin: 0.5em 0em 0em 0.5em;">
                          <b>Links</b>
                          <ul class="social mb-0 list-inline mt-1">
                           <li class="list-inline-item m-1">
                              <?php if($google_maps!="") echo '<a href="'.$google_maps.'" target="_blank" class="social-link">'; ?>
                              <i class="fa fa-globe fa-2x"></i>
                              <?php if($google_maps!="") echo'</a>'; ?>
                            </li>

                            <li class="list-inline-item m-1">
                              <?php if($delivery!="") echo '<a href="'.$delivery.'" target="_blank" class="social-link">'; ?>
                              <i class="fa fa-motorcycle fa-2x"></i>
                              <?php if($delivery!="") echo'</a>'; ?>
                            </li>
                          </ul>
                       </div>

                    </div>  <!-- Row Datos generales -->

                  </div>
                  <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">

                      <div class="row mb-1">
                        <div class="col-sm-11" style="margin: 0.5em 0em 0em 0.5em;">
                
                          <div id="map" style=" height: 400px;"></div>
                                
                        </div>
                      </div>

                    </div>
                </div>
             </div>


  </div>
</div>

          
           
       


<script type="text/javascript">
    
    var mapa;
    var marcador = null;

    $('documment').ready(function() {
       var lat = <?=  ($latitud !== null && $latitud !== "") ? $latitud : "''"; ?>;
       var lng =  <?= ($longitud !== null && $longitud !== "") ? $longitud : "''";; ?>;
       if(lat!="" && lng!="")
            if (!isNaN(lat) && !isNaN(lng))  updateMap(mapa, marcador, lat, lng);
    });

    var defaultLocationQuevedo = {lat: -1.023, lng: -79.464}; // Quevedo
    function createMap(idMapDiv) {
       let map = new google.maps.Map(document.getElementById(idMapDiv), {
            center: defaultLocationQuevedo,
            zoom: 15,
            styles: [
                {
                    "featureType": "poi",
                    "stylers": [
                        {"visibility": "off"}
                    ]
                },
                {
                    "featureType": "transit",
                    "stylers": [
                        {"visibility": "off"}
                    ]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "stylers": [
                        {"visibility": "off"}
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "labels.icon",
                    "stylers": [
                        {"visibility": "off"}
                    ]
                }
            ],
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        return map;
    }

    function initMap() {
        mapa =  createMap('map');
        marcador = new google.maps.Marker({ position: defaultLocationQuevedo, map: mapa });
    }

    initMap();

    function updateMap(map, marcador, lat, lng) {
        var latLng = new google.maps.LatLng(lat, lng);
        map.setCenter(latLng);
        marcador.setPosition(latLng);

       
    }
  </script>
    
    