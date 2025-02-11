<?php

function getEstadoDetalleEtiqueta($estado, $fecha_tram) {
    
    $resp ='';
    if($estado=='S')
        $resp.='<span class="badge badge-primary">Solicitada</span>';
    else if($estado=='A')
        $resp.='<span class="badge badge-success">Aceptada</span>';
    else if($estado=='R')
         $resp.='<span class="badge badge-danger">Rechazada</span>';
    else  $resp.='<span class="badge badge-danger">No Registrado</span>';

    if(!is_null($fecha_tram) && $fecha_tram!='')   $resp.='<br>Tramitado: '.$fecha_tram;

    return $resp; 
}

$lat_solicitada=""; $long_solicitada=""; $logo_solicitado="img_vacia.png"; $imgs_gif_solicitado="img_vacia.gif";

$act_coordenadas = false; $act_logo = false; $act_gif = false;
$iddetalle_coord = 0; $iddetalle_logo = 0; $iddetalle_gif = 0;

$act_coordenadas_estado = ''; $act_logo_estado = ''; $act_gif_estado = '';
$act_coordenadas_fecha = ''; $act_logo_fecha = ''; $act_gif_fecha = '';

if (isset($solicitud['detalles']) && is_array($solicitud['detalles'])) {
    foreach ($solicitud['detalles'] as $detalle) {
        switch ($detalle['idcampo']) {
            case -1:
                $lat_solicitada =  floatval($detalle['lat_sol']);
                $long_solicitada = floatval($detalle['lng_sol']);
                $iddetalle_coord =  $detalle['id'];
                $act_coordenadas = true;
                $act_coordenadas_estado = $detalle['estado'];
                if (!is_null($detalle['fecha_tram'])) {
                    $dateTime = new DateTime($detalle['fecha_tram']);
                    $act_coordenadas_fecha = $dateTime->format('d/m/Y H:i:s');
                }
                break;
            case -2:
                $act_logo_estado = $detalle['estado'];
                $act_logo = true;
                $iddetalle_logo =  $detalle['id']; 
                $logo_solicitado = $detalle['valorsolic'];
                if (!is_null($detalle['fecha_tram'])) {
                    $dateTime = new DateTime($detalle['fecha_tram']);
                    $act_logo_fecha = $dateTime->format('d/m/Y H:i:s');
                }
                break;
            case -3:
                $act_gif_estado = $detalle['estado'];
                $act_gif = true;
                $iddetalle_gif =  $detalle['id'];
                $imgs_gif_solicitado = $detalle['valorsolic'];
                if (!is_null($detalle['fecha_tram'])) {
                    $dateTime = new DateTime($detalle['fecha_tram']);
                    $act_gif_fecha = $dateTime->format('d/m/Y H:i:s');
                }
                break;
        }
    }
}
?>



<h3 class="text-center"><?= esc($solicitud['nombre_lugar']) ?></h3>
<div class="text-center"  > <?= $solicitud['estado_etiqueta'] ?></div>
<input type="hidden" name="ids" id="ids" value="<?= $solicitud['id']; ?>">

<div class="container mt-5">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Datos Generales</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Ubicación geográfica</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Logo y Multimedia</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        
        <div class="alert alert-danger" id="error-alertcampos" role="alert">
            <div id="msgalertcampos"></div>
        </div>

        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <form id="frmMainDatos" name="frmMainDatos" data-aos="fade-in">

                <div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                <div class="tr-card-body">
                    <?php if ($solicitud['estado']=='E'){?>
                    <div class="row mb-2">
                            <div class="col-sm-4" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                            <label for="regCategoria"><i class="fa fa-home" aria-hidden="true"></i> Seleccione un Campo</label>
                                <select id="regCampo" name="regCampo" class="custom-select" required>
                                </select>
                                <div class="valid-feedback">Campo válida</div>
                                <div class="invalid-feedback">Campo NO válido</div>
                            </div>
                
                    </div>
            
                    <div class="row mb-2">
                        <div class="col-sm-5" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                                <label for="txtValorAntes"><i class="fa fa-building" aria-hidden="true"></i> Información Actual</label>
                                <textarea 
                                id="txtValorAntes" 
                                name="txtValorAntes" 
                                class="form-control" 
                                rows="3"
                                maxlength="1000"
                                placeholder="Información Actual"
                                readonly
                                required></textarea>
                                <div class="valid-feedback">Información actual válida</div>
                                <div class="invalid-feedback">Información actual del Lugar no válida</div>
                        </div>
                        <div class="col-sm-5" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                                <label for="txtValorACambiar"><i class="fa fa-building" aria-hidden="true"></i> Información a actualizar</label>
                                <textarea 
                                id="txtValorACambiar" 
                                name="txtValorACambiar" 
                                class="form-control" 
                                rows="3"
                                maxlength="1000"
                                placeholder="Valor a cambiar"
                                required></textarea>
                                <div class="valid-feedback">Información a actualizar válida</div>
                                <div class="invalid-feedback">Escriba la Información a Actualizar</div>
                        </div>
                    </div>  <!-- row -->

                    <div class="row mb-2">
                        <div class="col-sm-4" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                                <a id="regSubmitCampos" class="btn btn-primary" style="color:white">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i> <b>Registrar</b></a>
                            </div>
                    </div>
                <?php } ?>

                <h3 class="text-center">Lista de Cambios solicitados</h3>
                <div class="row mb-2">
                    <div class="col-sm-11" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                        <table id="tabla" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Fecha</th>    
                                <th>Campo</th>    
                                <th>Información Anterior</th>
                                <th>Información por Cambiar</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            
                        </table>
                    </div>
                </div>
                </div><!-- bodycard-->
                </div><!-- card -->
            </form> <!-- Fin de primer formulario (Participante) -->
        </div>
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
        <form id="frmMainCoordenadas" name="frmMainCoordenadas" data-aos="fade-in">
       
        <div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
         <div class="tr-card-body">
            <div class="row mb-2">
                <div class="col-sm" style="margin: 2em 0.5em 0.5em 2em;" >
                <h3 class="text-center">Especifique las nuevas coordenadas</h3>
                </div>
            </div>

            <div class="row mb-2">
               
                    <div class="col-sm-2" style="margin: 0.5em 0em 0em 0.5em;" >
                        <label for="txtlatActual"><i class="fa fa-map-marker" aria-hidden="true"></i> Latitud Actual</label>
                        <input type="text" id="txtlatActual" 
                        name="txtlatActual" 
                        class="form-control" 
                        value="<?= $solicitud['latitud']; ?>"
                        placeholder="Latitud Actual" readonly required>
                        <div class="valid-feedback">Latitud actual válida</div>
                        <div class="invalid-feedback">Latitud actual no válida</div>
                    </div>
                    <div class="col-sm-2" style="margin: 0.5em 0em 0em 0em;" >
                        <label for="txtlongActual"><i class="fa fa-map-marker" aria-hidden="true"></i> Longitud Actual</label>
                        <input type="text" id="txtlongActual"
                        value="<?= $solicitud['longitud']; ?>"
                        name="txtlongActual" class="form-control" placeholder="Longitud Actual" readonly required>
                        <div class="valid-feedback">Longitud actual válida</div>
                        <div class="invalid-feedback">Longitud actual no válida</div>
                    </div>
                    <div class="col-sm-2" style="margin: 0.5em 0em 0em 0em;">
                        <label for="txtlatSolicitada"><i class="fa fa-map-marker" aria-hidden="true"></i> Nueva Latitud</label>
                        <input type="text" id="txtlatSolicitada" value="<?= $lat_solicitada;?>" name="txtlatSolicitada" class="form-control" placeholder="Latitud Solicitada" required >
                        <div class="valid-feedback">Latitud solicitada válida</div>
                        <div class="invalid-feedback">Latitud solicitada no válida</div>
                    </div>
                    <div class="col-sm-2" style="margin: 0.5em 0em 0em 0em;">
                        <label for="txtlongSolicitada"><i class="fa fa-map-marker" aria-hidden="true"></i> Nueva Longitud</label>
                        <input type="text" id="txtlongSolicitada" value="<?= $long_solicitada;?>"  name="txtlongSolicitada" class="form-control" placeholder="Longitud Solicitada" required >
                        <div class="valid-feedback">Longitud solicitada válida</div>
                        <div class="invalid-feedback">Longitud solicitada no válida</div>
                    </div>
                    <?php if ($solicitud['estado']=='E'){ ?>
                        <div class="col-sm-2 text-center" style="margin: 0.5em 0em 0em 0em;">
                            <label for="latActual">Acciones</label>
                            <a id="regSubmitCoordenadas" class="btn btn-<?=$act_coordenadas?'success':'primary'?>" style="color:white">
                            <b><?=$act_coordenadas?'Actualizar':'Registrar'?></b></a>
                        </div>
                        <?php  if($act_coordenadas && is_numeric($iddetalle_coord)){ ?>
                            <div class="col-sm-1 text-center" style="margin: 0.5em 0em 0em 0em;">
                                <label for="latActual">Eliminar</label>
                                <a id="regDeleteCoordenadas" class="btn btn-danger" style="color:white"
                                onclick="delDetalleSolicitud_otroscampos(<?= $iddetalle_coord; ?>)">
                                <i class="fa fa-times" id="close-icon"></i></a>
                                <input type="hidden" name="idcampo_coord" id="idcampo_coord" value="<?= $iddetalle_coord ?>">
                            </div>
                        <?php }?>
                    <?php } else {  ?>
                        <div class="col-sm-3 text-center" style="margin: 0.5em 0em 0em 0em;">
                            <?= getEstadoDetalleEtiqueta($act_coordenadas_estado, $act_coordenadas_fecha) ?>
                        </div>
                    <?php } ?>


            </div>

            <div class="row mb-2">
                <div class="col-sm-5" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <div id="mapActual" style="height: 300px; width: 100%;"></div>
                </div>
                <div class="col-sm-5" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <div id="mapSolicitado" style="height: 300px; width:100%;"></div>
                </div>
            </div>
         </div>
        </div>
        </form>
        </div>
        
        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
        
        <div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
            <div class="tr-card-body">
            <div class="row mb-2">
              <div class="col-sm text-center" style="margin: 2em 0.5em 0.5em 0.5em;">
                  <h3><i class="fa fa-picture-o" aria-hidden="true"></i> Imágenes del Lugar Actuales</h3>
              </div>
              </div>  <!-- row -->

              <div class="row mb-2">
              <div class="col-sm-4" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <label for="regFileLogo"><b>Logo del Lugar</b></label>
                    <img  class="img-thumbnail" id="pimgLogoActual" src="assets/imgs/logos_gifs/<?= $solicitud['logo']; ?>" alt="">
                    
                </div>

                
                <div class="col-sm-7" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                  <label for="regFileImgs"><b>Fotos del Lugar</b></label>
                  <img class="img-thumbnail" id="pimgFotosActual" src="assets/imgs/logos_gifs/<?= $solicitud['imagenes_gif']; ?>" alt="">    
                </div>
              </div>  <!-- row -->

              <div class="row mb-2">
              <div class="col-sm text-center" style="margin: 2em 0.5em 0.5em 0.5em;">
                  <h3><i class="fa fa-picture-o" aria-hidden="true"></i> Imágenes del Lugar Nuevas</h3>
              </div>
              </div>  <!-- row -->


              <div class="row mb-2">
              <div class="col-sm-4" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <label for="regFileLogo"><b>Logo Nuevo del Lugar</b></label>
                    <form id="frmMainMultimediaLogo" name="frmMainMultimediaLogo" data-aos="fade-in">
                        <input type="file"  required="required" class="form-control-file" onchange="showPreview(event,'pimgLogoSolicitado');" id="regFileLogo" 
                            accept="image/*" name ="regFileLogo">
                        <img class="img-thumbnail" id="pimgLogoSolicitado" src="assets/imgs/logos_gifsolicitados/<?=$logo_solicitado;?>" alt=""> 
                    </form>
                </div>

                <div class="col-sm-7" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                  <label for="regFileImgs"><b>Fotos nuevas del Lugar</b></label>
                  <form id="frmMainMultimediaLogoGifs" name="frmMainMultimediaLogoGifs" data-aos="fade-in">
                    <input type="file"  required="required" class="form-control-file" onchange="showPreview(event,'pimgFotosSolicitado');" id="regFileImgs" 
                        accept="image/*" name ="regFileImgs">
                    <img class="img-thumbnail" id="pimgFotosSolicitado" src="assets/imgs/logos_gifsolicitados/<?=$imgs_gif_solicitado;?>" alt="">    
                  </form>

                </div>
              </div>  <!-- row -->

              <div class="row mb-2">
                    <?php if ($solicitud['estado']=='E'){ ?>
                        <div class="col-sm-2 text-center" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                            <a id="regSubmitImagenesLogo" class="btn btn-<?=$act_logo?'success':'primary'?>" style="color:white">
                            <b><?=$act_logo?'Actualizar':'Registrar'?></b></a>
                        </div>
                        <div class="col-sm-2" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                            <?php  if($act_logo && is_numeric($iddetalle_logo)){ ?>
                                    <a id="regDeleteLogo" class="btn btn-danger" style="color:white"
                                    onclick="delDetalleSolicitud_otroscampos(<?= $iddetalle_logo; ?>)">
                                    <i class="fa fa-times" id="close-icon"></i></a>
                                    <input type="hidden" name="idcampo_logo" id="idcampo_logo" value="<?= $iddetalle_logo; ?>">
                            <?php }?>
                        </div>
                <?php } else {  ?>
                        <div class="col-sm-4 text-center" style="margin: 0.5em 0em 0em 0em;">
                            <?= getEstadoDetalleEtiqueta($act_logo_estado, $act_logo_fecha) ?>
                        </div>
                <?php } ?>
                
                <?php if ($solicitud['estado']=='E'){ ?>
                        <div class="col-sm-4 text-center" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                            <a id="regSubmitImagenesGif" class="btn btn-<?=$act_gif?'success':'primary'?>" style="color:white">
                            <b><?=$act_gif?'Actualizar':'Registrar'?></b></a>
                        </div>
                        <div class="col-sm-3" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                             <?php  if($act_gif && is_numeric($iddetalle_gif)){ ?>
                                    <a id="regDeleteGif" class="btn btn-danger" style="color:white" 
                                    onclick="delDetalleSolicitud_otroscampos(<?= $iddetalle_gif; ?>)">
                                    <i class="fa fa-times" id="close-icon"></i></a>
                                    <input type="hidden" name="idcampo_gif" id="idcampo_gif" value="<?= $iddetalle_gif; ?>">
                            <?php }?>
                        </div>
                <?php } else {  ?>
                        <div class="col-sm-6 text-center" style="margin: 0.5em 0em 0em 0em;">
                          <?= getEstadoDetalleEtiqueta($act_gif_estado, $act_gif_fecha) ?>
                        </div>
                <?php } ?>
              </div>  <!-- row -->

          </div><!-- bodycard Multimedia -->
          </div><!-- card Multimedia-->




        </div>
    </div>
</div>

<div class="modal fade" id="remModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Cambio Solicitado</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">¿Realmente desea Eliminar el Cambio Solicitado?</div>
                                <input type="hidden" name="idRegistro" id="idRegistro"/>
                                <div class="alert alert-danger" id="delete-alert" role="alert">
                                        <div id="msgalert"></div>
                                    </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                    <a class="btn btn-danger" href="javascript:delDetalleSolicitud()">SI Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div> 


<!-- Modal general message -->
<div class="modal fade" id="modalSms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSmsTitle"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="modalSmsBody" style="text-align: justify;"></div>
            <div class="modal-footer">
                <a class="btn btn-primary" data-dismiss="modal" href="#" onclick="$('#modalSms').modal('hide')">Aceptar</a>
            </div>
        </div>
    </div>
  </div>

<script type="text/javascript">
    
    var mapaActual;
    var mapaSolicitado;
    var markerActual = null;
    var markerSolicitado =null;
    $("#error-alertcampos").hide();
    fillCombo('solicitud/getlistadocamposactcb','regCampo',0, true);   

    $('#tabla').DataTable({
        "ajax":  "solicitud/getlistadocamposdetails/<?=$solicitud['id']?>",
        "rowId": "dt_rowid",
        "searching": false, 
        "paging": false, 
        "pageLength": -1 ,
        "columns": [
            {"data": "fecha_sol", "width": "20%"},
            {"data": "campo", "width": "20%"},
            {"data": "valorantes", "width": "25%"},
            {"data": "valorsolic", "width": "25%"},
            {"data": "estado_etiqueta", "width": "10%"},
        ],
        "columnDefs": [{
                "targets": 5,
                "data": "id",
                "className": "text-center",
                "render": function (data, type, row, meta) {
                    if(row.estado_solicitud == "E"){
                        if (row.estado == "Solicitada") {
                            return '<a href="javascript:dialogrem(' + data + ')">'
                                + '<i class="fa fa-times fa-2x" style="color: red;" alt="Eliminar Detalle" aria-hidden="true"></i></a> ';
                        }else{
                            return row.fecha_tram;
                        }
                    }else  {
                        if (row.estado != "Solicitada")  return row.fecha_tram; else return '';
                       }
                }
            }]
        
    });

    $('documment').ready(function() {

    
       updateMap(mapaActual, markerActual, $("#txtlatActual").val(), $("#txtlongActual").val());
       
       var lat =  $("#txtlatSolicitada").val();
       var lng =  $("#txtlongSolicitada").val();
       if(lat!="" && lng!="")
            if (!isNaN(lat) && !isNaN(lng))  updateMap(mapaSolicitado, markerSolicitado, lat, lng);

     

      $("#regCampo").change(function (evn) {
        $("#txtValorAntes").text("");
        $("#txtValorACambiar").text("");

        var campoId = $(this).val(); 
        if(parseInt(campoId) <= 0) return;

        var url = "lugar_turistico/campo/" + campoId; 
        
        if (isNaN(campoId)) {  alert("El campo seleccionado no es válido.");      return;     }

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
               var campo = Object.keys(response)[0];
               var valor = response[campo];
               $("#txtValorAntes").text(valor);
            },
            error: function(data, status, error) {
                
                if(data.status==401){
                    alert("Error 401: No autorizado. Redirigiendo a la página de inicio de sesión...");
                    window.location.href = '<?=base_url();?>login';
                }else{
                    if(data.responseJSON.error)
                       alert('Error al registrar Cambios \n' + data.responseJSON.error) ;
                        
                }
            }
        });  
        
      });

    });


    $("#regSubmitCampos").click(function (e) {
      $("#frmMainDatos").addClass("was-validated");
      
      var resp=fxValidaFrm();
      if(resp==""){
        callRegistrarDetalle();
      }else{
        showErrorModalMsg('Error al registrar Detalle', resp) ;
      }
       
    
      
    });

    function fxValidaFrm() {

      if(!$("#regCampo").val()) return "Selecione un Campo";
      var campoid = $("#regCampo").val();
      if(parseInt(campoid) <= 0) return "Selecione un Campo Válido";

      return "";
    }


    $("#regSubmitCoordenadas").click(function (e) {
      $("#frmMainCoordenadas").addClass("was-validated");
      
      var resp=fxValidaCoordenadas();
      if(resp==""){
        callRegistrarDetalleCoordenadas();
      }else{
        showErrorModalMsg('Error al registrar Nuevas Coordenadas', resp) ;
      }
       
    
      
    });

    function fxValidaCoordenadas() {

        var txtLongSolicitada = document.getElementById('txtlongSolicitada').value;
        var txtLatSolicitada = document.getElementById('txtlatSolicitada').value;

        if (!txtLongSolicitada || txtLongSolicitada.trim() === "") return "Ingrese la longitud solicitada";
    
        var longSolicitada = parseFloat(txtLongSolicitada.trim());
        if (isNaN(longSolicitada) || longSolicitada < -180 || longSolicitada > 180) return "Ingrese una longitud solicitada válida entre -180 y 180";
    
        if (!txtLatSolicitada || txtLatSolicitada.trim() === "") return "Ingrese la latitud solicitada";
        var latSolicitada = parseFloat(txtLatSolicitada.trim());
        if (isNaN(latSolicitada) || latSolicitada < -90 || latSolicitada > 90) return "Ingrese una latitud solicitada válida entre -90 y 90";

        return "";
    }

    $("#regSubmitImagenesLogo").click(function (e) {
      $("#frmMainMultimediaLogo").addClass("was-validated");
      
      var resp=fxValidaLogo();
      if(resp==""){
            callRegistrarDetalleLogo("regFileLogo", "regFileLogo", "solicitud/create_details_logo", "#regSubmitImagenesLogo");
      }else{
        showErrorModalMsg('Error al registrar Detalle', resp) ;
      }
      
    });

    $("#regSubmitImagenesGif").click(function (e) {
      $("#frmMainMultimediaLogoGifs").addClass("was-validated");
      
      var resp=fxValidaImgsGif();
      if(resp==""){
        callRegistrarDetalleLogo("regFileImgs", "regFileImgs", "solicitud/create_details_gif", "#regSubmitImagenesGif");
      }else{
        showErrorModalMsg('Error al registrar Detalle', resp) ;
      }
      
    });

    function fxValidaImgsGif() {

      var fileInput = document.getElementById('regFileImgs');
      if (fileInput.files && fileInput.files[0]) {
          var filePath = fileInput.value;
          var allowedExtensions = /(\.gif)$/i;
          if (!allowedExtensions.exec(filePath)) return "Las imágenes del Lugar debe ser un fichero de tipo Gif (.gif)";
      }else return "Debe seleccionar un fichero Gif para las Imágenes del Lugar";
      
      return "";
    }

    function fxValidaLogo() {

        var fileInput = document.getElementById('regFileLogo');
        if (fileInput.files && fileInput.files[0]) {
          var filePath = fileInput.value;
          var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
          if (!allowedExtensions.exec(filePath)) return "Logo debe un fichero de tipo Imagen (.jpg, .jpeg o .png)";
        }else return "Debe seleccionar una imagen del Logo";
       
       return "";
    }

  function callRegistrarDetalle() {
    
    $.ajax({
        dataType: "json",
        url: "solicitud/create_details_campos" ,
        type: "POST",
        data: {
            idsolicitud: $("#ids").val(),
            idcampo: $("#regCampo").val(),
            valorantes: $("#txtValorAntes").val().trim(),
            valorsolic: $("#txtValorACambiar").val().trim()
        }
    }).done(function (data) {

        alert(data.message);
        var tbdetails = $('#tabla').DataTable();
        tbdetails.ajax.reload( null, false ); 
        $('#addModal').modal('hide');
        
    }).fail(function (data) {

        
        if(data.status==401){
            alert("Error 401: No autorizado. Redirigiendo a la página de inicio de sesión...");
            window.location.href = '<?=base_url();?>login';
        }else{
            if(data.responseJSON.error)
                $("#msgalertcampos").html(data.responseJSON.error);
            else{
                var validaciones = data.responseJSON.validaciones;
                var msgerror="<b>Validaciones</b><br/>";
                for (var i = 0; i < validaciones.length; i++) 
                    msgerror = msgerror + validaciones[i].mensaje  + "<br/>";
                $("#msgalertcampos").html(msgerror);
            }

            $("#error-alertcampos").fadeTo(5000, 500).slideUp(500, function() {
                    $("#error-alertcampos").slideUp(500);
            });
        }

    });

  }
  
  function callRegistrarDetalleCoordenadas() {
    
    $.ajax({
        dataType: "json",
        url: "solicitud/create_details_coordenadas" ,
        type: "POST",
        data: {
            idsolicitud: $("#ids").val(),
            lat_antes: $("#txtlatActual").val().trim(),
            lng_antes: $("#txtlongActual").val().trim(),
            lat_sol: $("#txtlatSolicitada").val().trim(),
            lng_sol: $("#txtlongSolicitada").val().trim(),
        }
    }).done(function (data) {
        alert(data.message);
        $("#regSubmitCoordenadas").removeClass('btn-primary').addClass('btn-success').html('<b>Actualizar</b>');
    }).fail(function (data) {

        if(data.status==401){
            alert("Error 401: No autorizado. Redirigiendo a la página de inicio de sesión...");
            window.location.href = '<?=base_url();?>login';
        }else{
            if(data.responseJSON.error)
                $("#msgalertcampos").html(data.responseJSON.error);
            else{
                var validaciones = data.responseJSON.validaciones;
                var msgerror="<b>Validaciones</b><br/>";
                for (var i = 0; i < validaciones.length; i++) 
                    msgerror = msgerror + validaciones[i].mensaje  + "<br/>";
                $("#msgalertcampos").html(msgerror);
            }

            $("#error-alertcampos").fadeTo(5000, 500).slideUp(500, function() {
                    $("#error-alertcampos").slideUp(500);
            });
        }

    });

  }

  
  

  function callRegistrarDetalleLogo(inputFileID, campoFile, Url, btID) {
    
    var inputImgLogo = document.getElementById(inputFileID);
    var formData = new FormData();
    formData.append(campoFile, inputImgLogo.files[0]);
    formData.append("idsolicitud",  $("#ids").val());
  
    $.ajax({
        url:  Url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        async: false
      }).done(function(data) {
        
        alert(data.message);
        $(btID).removeClass('btn-primary').addClass('btn-success').html('<b>Actualizar</b>');

      }).fail(function (data) {

        if(data.status==401){
            alert("Error 401: No autorizado. Redirigiendo a la página de inicio de sesión...");
            window.location.href = '<?=base_url();?>login';
        }else{
            if(data.responseJSON.error)
                $("#msgalertcampos").html(data.responseJSON.error);
            else{
                var validaciones = data.responseJSON.validaciones;
                var msgerror="<b>Validaciones</b><br/>";
                for (var i = 0; i < validaciones.length; i++) 
                    msgerror = msgerror + validaciones[i].mensaje  + "<br/>";
                $("#msgalertcampos").html(msgerror);
            }

            $("#error-alertcampos").fadeTo(5000, 500).slideUp(500, function() {
                    $("#error-alertcampos").slideUp(500);
            });
        }

    });

  }

  function delDetalleSolicitud() {

        $.ajax({
            dataType: "json",
            url: "solicitud/delete_details/" +  $("#idRegistro").val() ,
            type: "POST"
        }).done(function (data) {

            var tbSubCatEdit = $('#tabla').DataTable();
            tbSubCatEdit.ajax.reload( null, false ); 
            $('#remModal').modal('hide');
            
        }).fail(function (data) {

        if(data.status==401){
            alert("Error 401: No autorizado. Redirigiendo a la página de inicio de sesión...");
            window.location.href = '<?=base_url();?>login';
        }else{
            if(data.responseJSON.error)
                $("#msgalert").html(data.responseJSON.error);

            $("#delete-alert").fadeTo(5000, 500).slideUp(500, function() {
                    $("#delete-alert").slideUp(500);
            });
        }

        });
}
  

function delDetalleSolicitud_otroscampos(id) {

        $.ajax({
            dataType: "json",
            url: "solicitud/delete_details/" +  id,
            type: "POST"
        }).done(function (data) {
            alert(data.message);
            ajaxLoadContentPanel("solicitud/vista_listado", "Lista de Solicitudes de Actualización de Información");
        }).fail(function (data) {

        if(data.status==401){
            alert("Error 401: No autorizado. Redirigiendo a la página de inicio de sesión...");
            window.location.href = '<?=base_url();?>login';
        }else{
            if(data.responseJSON.error)
                $("#msgalert").html(data.responseJSON.error);
                $("#delete-alert").fadeTo(5000, 500).slideUp(500, function() {
                    $("#delete-alert").slideUp(500);
                });
        }

        });
    }

    var defaultLocationQuevedo = {lat: -1.023, lng: -79.464}; // Quevedo
    function createMap(idMapDiv) {
       let map = new google.maps.Map(document.getElementById(idMapDiv), {
            center: defaultLocationQuevedo,
            zoom: 14,
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

       /* new google.maps.Marker({
            position: defaultLocationQuevedo,
            map: map
        });*/

        return map;
    }

    function initMap() {
       
        mapaSolicitado =  createMap('mapSolicitado');
        mapaActual =  createMap('mapActual');
        markerActual = new google.maps.Marker({ position: defaultLocationQuevedo, map: mapaActual });
        markerSolicitado = new google.maps.Marker({ position: defaultLocationQuevedo, map: mapaSolicitado });
    }

    initMap();

    function updateMap(map, marcador, lat, lng) {
        var latLng = new google.maps.LatLng(lat, lng);
        map.setCenter(latLng);
        marcador.setPosition(latLng);

       
    }

    document.getElementById('txtlatActual').addEventListener('input', function() {
        var lat = parseFloat(this.value);
        var lng = parseFloat(document.getElementById('txtlongActual').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            if(marcador)
            marcador.setMap(null);
            updateMap(mapaActual,markerActual, lat, lng);
        }
    });

    document.getElementById('txtlongActual').addEventListener('input', function() {
        var lat = parseFloat(document.getElementById('txtlatActual').value);
        var lng = parseFloat(this.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            updateMap(mapaActual, markerActual, lat, lng);
        }
    });

    document.getElementById('txtlatSolicitada').addEventListener('input', function() {
        var lat = parseFloat(this.value);
        var lng = parseFloat(document.getElementById('txtlongSolicitada').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            updateMap(mapaSolicitado,  markerSolicitado, lat, lng);
        }
    });

    document.getElementById('txtlongSolicitada').addEventListener('input', function() {
        var lat = parseFloat(document.getElementById('txtlatSolicitada').value);
        var lng = parseFloat(this.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            updateMap(mapaSolicitado, markerSolicitado, lat, lng);
        }
    });


  </script>