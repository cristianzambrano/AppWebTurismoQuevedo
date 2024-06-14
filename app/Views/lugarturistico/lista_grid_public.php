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

    <title>Información Turística de Quevedo - Ecuador</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>assets/js/panel/fontawesome-free/css/font-awesome.min.css" rel="stylesheet" type="text/css">
   
    <link href="<?= base_url(); ?>assets/css/icon.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/c/favicon.ico" rel="icon">
    
   <!-- Bootstrap CSS File -->
    <link href="<?=base_url();?>assets/vendor/bootstrap46/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?= base_url(); ?>assets/css/main.css" rel="stylesheet">

</head>

<body id="page-top">

<nav class="navbar navbar-expand-lg bg-white border-bottom box-shadow">
  <a class="navbar-brand" href="#">
    <img src="assets/imgs/logo_alcaldia1.jpg" alt="Logo" style="max-height: 60px;"> 
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
        <img src="assets/imgs/banner_horizontal_verde.jpg" alt="" class="img-thumbnail" width="400" height="250">
        <p><h2 class="display-6"><b>Lugares Turísticos de Quevedo</b></h2></p>
    </div>

<div class="container">
    <div class="card mb-3 mt-2" >
            <div class="tr-card-body">
              <div class="row mb-2">

              <div class="col-sm-4" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                  <label for="regCategoria"><b>Categoría</b></label>
                    <select id="regCategoria" name="regTipoID" class="custom-select" required>
                    </select>
                    <div class="valid-feedback">Categoría válida</div>
                    <div class="invalid-feedback">Categoría NO válida</div>
                </div>
                
                <div class="col-sm-7" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <label for="regSubCategoria"><b>SubCategoría</b></label>
                      <select id="regSubCategoria" name="regSubCategoria" class="custom-select" required>
                      </select>
                    <div class="valid-feedback">SubCategoría válida</div>
                    <div class="invalid-feedback">SubCategoría NO válida</div>
                </div>

              </div>  
            </div>

          </div>
   
   
          <div id="gridLista" name="gridLista"></div>
       
               
    </div>

    <footer class="text-muted">
      <div class="container">
      <p class="float-left">
          <a class="btn btn-outline-primary text-right" href="#"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
        </p>

     <p class="float-right">
        
        <a class="btn btn-outline-primary text-right" href="login"><b><i class="fa fa-sign-in" aria-hidden="true"></i></b></a>
    </p>
     
      <div class="text-center my-auto">
            <img style="max-height: 60px;" src="<?= base_url(); ?>assets/imgs/banner_horizontal.jpg">
            <p><span>Copyright &copy;- 2023</span></p>
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
    
    <script type="text/javascript">
    
    ajaxLoadContentGrid("lugar_turistico/vista_lista_public/");

    fillCombo('categoria/getlistadoCB','regCategoria',0, true);  
    
    $("#regCategoria").change(function (evn) {
            $("#regSubCategoria").html("");
            fillCombo('subcategoria/getlistadoCB/' + this.value ,'regSubCategoria',0, true);

            var IDC=0;
            if(this.value>0) IDC = this.value;
            
            ajaxLoadContentGrid('lugar_turistico/vista_lista_public/' + IDC);

      });

      $("#regSubCategoria").change(function (evn) {
        
        var IDC=0, IDSC=0;
        if($("#regCategoria").val()>0) IDC = $("#regCategoria").val();
        if(this.value>0) IDSC = this.value;
      
        ajaxLoadContentGrid('lugar_turistico/vista_lista_public/' + IDC + '/' + IDSC);
                
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

   

    function ajaxLoadContentGrid(Url) {
     
        $.ajax({
            url: Url,
        }).done(function (data) {
            $("#gridLista").html(data);
        });
    }


  </script>

</body>

</html>