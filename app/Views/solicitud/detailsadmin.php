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

$act_coordenadas_estado = ''; $act_logo_estado = ''; $act_gif_estado = '';
$iddetalle_coord = 0; $iddetalle_logo = 0; $iddetalle_gif = 0;
$act_coordenadas_fecha = ''; $act_logo_fecha = ''; $act_gif_fecha = '';

if (isset($solicitud['detalles']) && is_array($solicitud['detalles'])) {
    foreach ($solicitud['detalles'] as $detalle) {
        switch ($detalle['idcampo']) {
            case -1:
                $lat_solicitada =  floatval($detalle['lat_sol']);
                $long_solicitada = floatval($detalle['lng_sol']);
                $iddetalle_coord =  $detalle['id'];
                $act_coordenadas_estado = $detalle['estado'];
                if (!is_null($detalle['fecha_tram'])) {
                    $dateTime = new DateTime($detalle['fecha_tram']);
                    $act_coordenadas_fecha = $dateTime->format('d/m/Y H:i:s');
                }
                break;
            case -2:
                $act_logo_estado = $detalle['estado'];
                $iddetalle_logo =  $detalle['id']; 
                $logo_solicitado = $detalle['valorsolic'];
                if (!is_null($detalle['fecha_tram'])) {
                    $dateTime = new DateTime($detalle['fecha_tram']);
                    $act_logo_fecha = $dateTime->format('d/m/Y H:i:s');
                }
                break;
            case -3:
                $act_gif_estado = $detalle['estado'];
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



<h3 class="text-center">
    <?= esc($solicitud['nombre_lugar']) ?></h3>
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
            

                <div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                <div class="tr-card-body">
                    <div class="card-header text-center"><h4>Lista de Cambios solicitados</h4></div>
                    <div class="row mb-2" text-center>
                        <div class="col-sm-11" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                            <table id="tabla" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
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
            
        </div>
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
        
       
        <div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
         <div class="tr-card-body">
            <div class="card-header text-center"><h4>Nuevas coordenadas del Lugar</h4></div>

            <div class="row mb-2 justify-content-center text-center">
                <div class="col-sm-2" style="margin: 0.5em">
                    <label for="txtlatSolicitada"><i class="fa fa-map-marker" aria-hidden="true"></i> Nueva Latitud</label>
                    <input type="text" id="txtlatSolicitada" value="<?= $lat_solicitada;?>" name="txtlatSolicitada" class="form-control" placeholder="Latitud Solicitada" required readonly >
                </div>
                <div class="col-sm-2" style="margin: 0.5em">
                    <label for="txtlongSolicitada"><i class="fa fa-map-marker" aria-hidden="true"></i> Nueva Longitud</label>
                    <input type="text" id="txtlongSolicitada" value="<?= $long_solicitada;?>" name="txtlongSolicitada" class="form-control" placeholder="Longitud Solicitada" required readonly>
                </div>
                <div class="col-sm-3 d-flex align-items-center justify-content-center" style="margin: 0.5em">
                    <?php
                    if ($solicitud['estado']!='E'){
                        if ($iddetalle_coord>0) {
                             if($act_coordenadas_estado=='S'){ ?>
                                <a id="regSubmitCoordenadas" class="btn btn-success" style="color:white" onclick="dialogProcesa(<?= $iddetalle_coord; ?>,'C')">
                                <b>Tramitar</b></a>
                        <?php }else{ ?>
                            <p  class="text-center">
                                 <?= getEstadoDetalleEtiqueta($act_coordenadas_estado, $act_coordenadas_fecha); ?>
                            </p>
                        <?php } 
                        }
                    } ?>
                </div>
            </div>

            

            <div class="row mb-2 justify-content-center">
                <div class="col-sm-7" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <div id="mapSolicitado" style="height: 400px; width:100%;"></div>
                </div>
            </div>
         </div>
        </div>
        
        </div>
        
        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
        
        <div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
            <div class="tr-card-body">
            <div class="card-header text-center"><h3><i class="fa fa-picture-o" aria-hidden="true"></i> Imágenes del Lugar Nuevas</h3></div>

            <div class="row mb-2 justify-content-center">
              <div class="col-sm-4" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <label for="regFileLogo"><b>Logo Nuevo del Lugar</b></label>
                    <img class="img-thumbnail" id="pimgLogoSolicitado" src="assets/imgs/logos_gifsolicitados/<?=$logo_solicitado;?>" alt=""> 
                </div>

                <div class="col-sm-7" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                  <label for="regFileImgs"><b>Fotos nuevas del Lugar</b></label>
                   <img class="img-thumbnail" id="pimgFotosSolicitado" src="assets/imgs/logos_gifsolicitados/<?=$imgs_gif_solicitado;?>" alt="">    
                </div>
              </div>  <!-- row -->

              <div class="row mb-2 justify-content-center">
                <div class="col-sm-4 justify-content-center"  style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <?php 
                    if ($solicitud['estado']!='E'){
                        if ($iddetalle_logo>0) {
                                if($act_logo_estado=='S'){ ?>
                                    <a id="regSubmitLogo" class="btn btn-success" style="color:white" onclick="dialogProcesa(<?= $iddetalle_logo; ?>,'C')">
                                    <b>Tramitar</b></a>
                            <?php }else{ ?>
                                <p  class="text-center">
                                 <?= getEstadoDetalleEtiqueta($act_logo_estado, $act_logo_fecha); ?>
                                </p>
                        <?php } 
                        }
                     } ?>
                </div>

                <div class="col-sm-7 justify-content-center"  style="margin: 0.5em 0.5em 0.5em 0.5em;">
                        <?php 
                        if ($solicitud['estado']!='E'){
                            if ($iddetalle_gif >0) {
                                        if($act_gif_estado=='S'){ ?>
                                            <a id="regSubmitGif" class="btn btn-success" style="color:white" onclick="dialogProcesa(<?= $iddetalle_gif; ?>,'C')">
                                            <b>Tramitar</b></a>
                                    <?php }else{ ?>
                                        <p  class="text-center">
                                              <?= getEstadoDetalleEtiqueta($act_gif_estado, $act_gif_fecha); ?>
                                         </p>
                                <?php } 
                                }
                             } ?>
                </div>
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
                                    <h5 class="modal-title" id="exampleModalLabel">Tramitar cambio Solicitado</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    
                                <label for="txtlongSolicitada"><i class="fa fa-pencil" aria-hidden="true"></i> Observación</label>
                                <textarea id="txtObservacionDetalleCampo"  name="txtObservacionDetalleCampo"
                                class="form-control" placeholder="Ingrese un comentario" required rows="4"></textarea>
                          
                            </div>
                                <input type="hidden" name="idRegistro" id="idRegistro"/>
                                <input type="hidden" name="tipoAccion" id="tipoAccion"/>
                                <div class="alert alert-danger" id="procesa-alert" role="alert">
                                        <div id="msgalert"></div>
                                    </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>    
                                    <a class="btn btn-danger" href="javascript:procesaDetalleSolicitud('R')">Rechazar</a>
                                    <a class="btn btn-success" href="javascript:procesaDetalleSolicitud('A')">Aceptar</a>
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
    
    var mapaSolicitado;
    var markerSolicitado =null;

    $("#error-alertcampos").hide();

    $('#tabla').DataTable({
        "ajax":  "solicitud/getlistadocamposdetails/<?=$solicitud['id']?>",
        "rowId": "dt_rowid",
        "searching": false, 
        "paging": false, 
        "pageLength": -1 ,
        "columns": [
            {"data": "campo", "width": "20%"},
            {"data": "valorantes", "width": "30%"},
            {"data": "valorsolic", "width": "30%"},
            {"data": "estado_etiqueta", "width": "15%"},
        ],
        "columnDefs": [{
                "targets": 4,
                "data": "id",
                "className": "text-center",
                "render": function (data, type, row, meta) {
                    if(row.estado_solicitud != "E"){
                        if (row.estado === "Solicitada") {
                            return '<a href="javascript:dialogProcesa(' + data + ')">'
                                + '<i class="fa fa-edit fa-2x" alt="Procesar Detalle" aria-hidden="true"></i></a>';
                        } else {
                            return row.fecha_tram;
                        }
                    }else   return '';
                }
            },{
                "targets": 3,
                "className": "text-center"
            }]
        
    });

    function dialogProcesa(ID, Accion='I') {
        $('#idRegistro').val(ID);
        $('#tipoAccion').val(Accion);
        $("#procesa-alert").hide();
        $('#remModal').modal('show');
        $("#txtObservacionDetalleCampo").val("");
    }


    $('documment').ready(function() {

       var lat =  $("#txtlatSolicitada").val();
       var lng =  $("#txtlongSolicitada").val();
       if(lat!="" && lng!="")
            if (!isNaN(lat) && !isNaN(lng))  updateMap(mapaSolicitado, markerSolicitado, lat, lng);

    });

  
  
  function procesaDetalleSolicitud(estado) {
    
    $.ajax({
        dataType: "json",
        url: "solicitud/update_details" ,
        type: "POST",
        data: {
            id:            $("#idRegistro").val(),
            observaciones: $("#txtObservacionDetalleCampo").val().trim(),
            estado: estado
        }
    }).done(function (data) {
        $('#remModal').modal('hide');

        if($("#tipoAccion").val()=="I"){
            var tbSubCatEdit = $('#tabla').DataTable();
            tbSubCatEdit.ajax.reload( null, false ); 
        }else{
            alert(data.message);
            ajaxLoadContentPanel("solicitud/vista_listado_admin", "Lista de Solicitudes de Actualización de Información");
        }
        

    }).fail(function (data) {

        if(data.status==401){
            alert("Error 401: No autorizado. Redirigiendo a la página de inicio de sesión...");
            window.location.href = '<?=base_url();?>login';
        }else{
            if(data.responseJSON.error)
                $("#msgalert").html(data.responseJSON.error);
            else{
                var validaciones = data.responseJSON.validaciones;
                var msgerror="<b>Validaciones</b><br/>";
                for (var i = 0; i < validaciones.length; i++) 
                    msgerror = msgerror + validaciones[i].mensaje  + "<br/>";
                $("#msgalert").html(msgerror);
            }

            $("#procesa-alert").fadeTo(5000, 500).slideUp(500, function() {
                    $("#procesa-alert").slideUp(500);
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
        markerSolicitado = new google.maps.Marker({ position: defaultLocationQuevedo, map: mapaSolicitado });
    }

    initMap();

    function updateMap(map, marcador, lat, lng) {
        var latLng = new google.maps.LatLng(lat, lng);
        map.setCenter(latLng);
        marcador.setPosition(latLng);

       
    }

    


  </script>