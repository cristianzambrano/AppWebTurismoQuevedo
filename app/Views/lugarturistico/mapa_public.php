<?php
header("Cache-Control: no-cache, must-revalidate");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mapa con Información Turística de Quevedo - Ecuador</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>assets/js/panel/fontawesome-free/css/font-awesome.min.css" rel="stylesheet" type="text/css">
   
    <link href="<?= base_url(); ?>assets/css/icon.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/c/favicon.ico" rel="icon">
    
   <!-- Bootstrap CSS File -->
    <link href="<?=base_url();?>assets/vendor/bootstrap46/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?= base_url(); ?>assets/css/main.css" rel="stylesheet">

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEaPJ0Pr1XzIi6fHfTiDdYGhdSit7FM9c"></script>
  
    <style>
        #divMapa {
            height: 400px;
            width: 100%;
        }
    </style>


</head>

<body id="page-top">

<nav class="navbar navbar-expand-lg bg-white border-bottom box-shadow">
  <a class="navbar-brand" href="#">
    <img src="<?= base_url(); ?>assets/imgs/logo_alcaldia1.jpg" alt="Logo" style="max-height: 60px;"> 
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <a  href="#"><i class="fa fa-user-circle-o fa-2x" aria-hidden="true"></i></a>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link btn btn-primary" href="login"><b><i class="fa fa-sign-in" aria-hidden="true"></i> Login</b></a> <!-- Puedes añadir la clase '' si quieres que parezca un botón -->
      </li>
    </ul>
  </div>
</nav>


    

    <div class="text-center mb-3 mt-3">
        <p><h2 class="display-6"><b>Mapa con Lugares Turísticos de Quevedo</b></h2></p>
    </div>

<div class="container">
    <div class="card mb-3 mt-2" >
            <div class="tr-card-body">
              <div class="row mb-2">

              <div class="col-sm-3" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                  <label for="regCategoria"><b>Categoría</b></label>
                    <select id="regCategoria" name="regTipoID" class="custom-select" required>
                    </select>
                    <div class="valid-feedback">Categoría válida</div>
                    <div class="invalid-feedback">Categoría NO válida</div>
                </div>
                
                <div class="col-sm-4" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <label for="regSubCategoria"><b>SubCategoría</b></label>
                      <select id="regSubCategoria" name="regSubCategoria" class="custom-select" required>
                      </select>
                    <div class="valid-feedback">SubCategoría válida</div>
                    <div class="invalid-feedback">SubCategoría NO válida</div>
                </div>

                <div class="col-sm-2" style="margin: 0.5em;">
                    <label for="radioSlider"><b>Radio</b></label>
                    <input type="range" id="radioSlider" name="radioSlider" step="0.1" min="0.1" max="5" value="1" class="custom-range">
                    <div id="radioValue">1 km</div>
                </div>

                <div class="col-sm-1" style="">
                    <label><b>Círculo</b></label>
                    <button id="btCirculo" name="btCirculo" type="button" class="btn btn-primary">Ocultar</button>
                </div>

                <div class="col-sm-1" style="">
                    <label><b>Lista</b></label>
                    <a class="btn btn-outline-primary text-right" href="<?= base_url(); ?>"><b>
                     <i class="fa fa-list" aria-hidden="true"></i></b></a>
                </div>

                

              </div>  
            </div>

          </div>
   
   
          <div id="divMapa" name="divMapa">Mapa</div>
       
               
    </div>

    <footer class="text-muted">
      <div class="container">
      <p class="float-left">
          <a class="btn btn-outline-primary text-right" href="#"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
        </p>

     <p class="float-right">
        
        <a class="btn btn-outline-primary text-right" href="<?= base_url(); ?>"><b><i class="fa fa-list" aria-hidden="true"></i></b></a>
    </p>
     
      <div class="text-center my-auto">
            <img style="max-height: 60px;" src="<?= base_url(); ?>assets/imgs/banner_horizontal.jpg">
            <p><span>Copyright &copy;- 2024</span></p>
            </div>
      
    </div>
    </footer>

    <!-- Modal general message -->
  <div class="modal fade" id="modalVerLugar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSmsTitle"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="modalSmsBody"></div>
        </div>
    </div>
  </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/bootstrap46/js/bootstrap.bundle.min.js"></script>


    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>assets/vendor/jquery.easing/jquery.easing.min.js"></script>

    <script src="<?=base_url();?>assets/js/jsFunctions.js"></script>
    <script src="<?=base_url();?>assets/js/jsMapa.js"></script>
    
    <script type="text/javascript">
    
    fillCombo('categoria/getlistadoCB','regCategoria',0, true); 

    $("#regCategoria").change(function (evn) {
            $("#regSubCategoria").html("");

            if(this.value>0){ 
              fillCombo('subcategoria/getlistadoCB/' + this.value ,'regSubCategoria',0, true);
            }

            var center = map.getCenter();
            fetchMarkers( {lat: center.lat(), lng: center.lng()});
    
      });

      $("#regSubCategoria").change(function (evn) {
          var center = map.getCenter();
          fetchMarkers( {lat: center.lat(), lng: center.lng()});
                
      });


      $("#radioSlider").change(function (evn) {
         var radio = this.value;
         document.getElementById('radioValue').innerText = radio + ' km';
         var center = map.getCenter();
         fetchMarkers({lat: center.lat(), lng: center.lng()}); 

         if (circleActive) {
             const radius = parseFloat(this.value);
             circle.setRadius(radius * 1000); // Convertir km a metros
        }
      });

     

    function ajaxShowLugarTuristicoModal(ID, Titulo) {
     
        $.ajax({
            url: 'lugar_turistico/vista_modal/' + ID,
        }).done(function (data) {
            $('#modalSmsTitle').text(Titulo,);
            $('#modalSmsBody').html(data);
            $('#modalVerLugar').modal('show');
        });
    }
 
    let map;
    var defaultLocation = {lat: -1.023, lng: -79.464}; // Quevedo
    let circle;
    let circleActive = false;
    var markers = []; 
    initMap();
    
    
    map.addListener('idle', function() {
            var center = map.getCenter();
            if(center){
              fetchMarkers( {lat: center.lat(), lng: center.lng()});
              if (circleActive) {
                circle.setCenter({lat: center.lat(), lng: center.lng()}); 
              }
            }
    });

    if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(userLocation);
                fetchMarkers(userLocation); 
                toggleCircle();
            }, function() {
                map.setCenter(defaultLocation);
                fetchMarkers(defaultLocation); 
                toggleCircle();

            });
     } else {
            map.setCenter(defaultLocation);
            fetchMarkers(defaultLocation); 
            toggleCircle();
     }
    
     $('#btCirculo').on('click', function() {
            toggleCircle();
        });

</script>


</body>

</html>