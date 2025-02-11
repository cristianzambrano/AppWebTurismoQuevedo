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

    <title>Administración del sistema</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>assets/js/panel/fontawesome-free/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url(); ?>assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/icon.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/c/favicon.ico" rel="icon">
    
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> -->


    <!-- DataTable style -->
    <link href="<?=base_url();?>assets/vendor/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">

      <!-- Bootstrap CSS File -->
    <link href="<?=base_url();?>assets/vendor/bootstrap46/css/bootstrap.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #199104;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=base_url();?>index.php/admin">
                  ADMIN             
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Gestión
            </div>

            <?php 
                $grouped_items = [];
                foreach (session()->get('menu_items') as $item) {
                    $grouped_items[$item['idgrupo']]['icon'] = $item['grupo_icon'];
                    $grouped_items[$item['idgrupo']]['titulo'] = $item['grupo_descripcion'];
                    $grouped_items[$item['idgrupo']]['items'][] = $item;
                }
                foreach ($grouped_items as $group => $details):
                    $groupip = "collapse".str_replace(' ', '', $group);
            ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#<?=$groupip?>" aria-expanded="true" aria-controls="<?= $groupip ?>">
                    <i class="<?= $details['icon'] ?>" aria-hidden="true"></i>
                        <span><?= $details['titulo'] ?></span>
                    </a>
                    <div id="<?= $groupip ?>" class="collapse" aria-labelledby="heading<?= str_replace(' ', '', $group) ?>" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                        <?php foreach ($details['items'] as $item): ?>
                            <a class="collapse-item" onclick="ajaxLoadContentPanel('<?= $item['ruta'] ?>', '<?= $item['titulo_item'] ?>');" href="#"><?= $item['item_descripcion'] ?></a>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </li>

            <?php endforeach; ?>

    
     
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <span class="icon"></span>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>

                    <img style="max-height: 50px;"
                    src="<?=base_url();?>assets/imgs/banner_horizontal.jpg" alt="" title="" /></img>

                    

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fa fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= session()->get('cedula') ?></span>
                                <img class="img-profile rounded-circle" src="<?= base_url(); ?>assets/imgs/usuario/<?=session()->get('foto')?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fa fa-sign-out fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Salir
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Main Area -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary" id="MainPageContentTitle" name="MainPageContentTitle">
                            </h6>
                        </div>
                        <div class="card-body" id="MainPageContent" name="MainPageContent">
                        

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <img style="max-height: 50px;" src="<?= base_url(); ?>assets/imgs/logo_alcaldia1.jpg">
                        <span>Copyright &copy;- 2024</span>
                    </div>
                    
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Seguro desea salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Presione "Salir" para cerrar la sesión del sistema</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="<?=base_url();?>logout">Salir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/bootstrap46/js/bootstrap.bundle.min.js"></script>


    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>assets/vendor/jquery.easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url(); ?>assets/js/panel/sb-admin-2.min.js"></script>

    <!-- Data table -->
    <script src="<?=base_url();?>assets/vendor/datatable/jquery.dataTables.min.js"></script>
    <script src="<?=base_url();?>assets/vendor/datatable/dataTables.bootstrap4.min.js"></script>

    <script src="<?=base_url();?>assets/js/jsFunctions.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEaPJ0Pr1XzIi6fHfTiDdYGhdSit7FM9c"></script>
    

   
    <script type="text/javascript">
       
        $(document).ready(function() {
            $("#MainPageContentTitle").html("Panel de Administración");
            $("#MainPageContent").html("Seleccione una opción del menú");

           // ajaxLoadContentPanel('lugar_turistico/vista_grid', "Lista Lugares", "<?=base_url();?>");
        });

        

        


        function ajaxLoadContentPanel(Url, Titulo) {
        $.ajax({
            url: Url,
        }).done(function (data) {
            $("#MainPageContentTitle").html(Titulo);
            $("#MainPageContent").html(data);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            mostrarAlerta(jqXHR.status, UrlPath + '<?=base_url();?>login')
        });
    }
    </script>

</body>

</html>