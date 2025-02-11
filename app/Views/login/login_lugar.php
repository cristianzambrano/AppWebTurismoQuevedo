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

    <title>Login - Seleccione su Lugar Turístico </title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>assets/js/panel/fontawesome-free/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url(); ?>assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/icon.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/c/favicon.ico" rel="icon">
    
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> -->

     <link href="<?= base_url(); ?>assets/css/signin.css" rel="stylesheet">
   

</head>

<body class="text-center">
    
<form class="form-signin" action="<?= base_url('login/seleccionarlugar'); ?>" method="post">
 
      <img class="mb-4" src="assets/imgs/banner_horizontal.jpg" alt="" width="300" height="100">
      <h3 class="h3 mb-2 font-weight-bold">Propietario de Local</h3>
      <h4 class="h4 mb-2 font-weight-bold"><?= $user['nombres']." ".$user['apellidos']; ?></h4>
      <div class="h4 mb-2 font-weight-normal">Seleccione un lugar</div>
        <select class="form-control" id="lugar_id" name="lugar_id" required>
            <option value="">Seleccione un lugar</option>
            <?php foreach ($lugares as $lugar): ?>
                <option value="<?= $lugar['id']; ?>"><?= $lugar['nombre_lugar']; ?></option>
            <?php endforeach; ?>
        </select>

      <div class="row mt-3">
        <div class="col">
          <a  href="<?=base_url()?>" class="btn w-100  btn-secondary"><b>
          <i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Cancelar</b></a> 
        </div>
        <div class="col">
          <button  type="submit" class="btn w-100  btn-primary" >
              <b><i class="fa fa-sign-in" aria-hidden="true" ></i> Ingresar</b></button>
        </div>
      </div>
       
      <p class="mt-5 mb-3 text-muted">
      <img class="mb-4" src="assets/imgs/logo_alcaldia1.jpg" alt="" width="150" height="50">
      &copy; 2024-2027</p>

  </form>
      
      
        
  



    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/bootstrap46/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>assets/vendor/jquery.easing/jquery.easing.min.js"></script>

   
    <script type="text/javascript">
      

  
       
    </script>

</body>

</html>