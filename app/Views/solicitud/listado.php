
                        <button  class="btn btn-primary" id="btAddSol" onclick="openAddSolicitudModal();">
                                <i class="fa fa-plus-circle"></i>
                                <b>Nueva</b>
                            </button>
                            <br/><br/>
                               <table id="tabla" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Lugar</th>    
                                            <th>Descripción</th>
                                            <th>Solicitado por</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                     <tfoot>
                                        <tr>
                                            <th>Lugar</th>    
                                            <th>Descripción</th>
                                            <th>Solicitado por</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                </table>

                <div class="modal fade" id="remModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Solicitud</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">¿Realmente desea Eliminar la Solicitud?</div>
                                <input type="hidden" name="idRegistro" id="idRegistro"/>
                                <div class="alert alert-danger" id="delete-alert" role="alert">
                                        <div id="msgalert"></div>
                                    </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                    <a class="btn btn-danger" href="javascript:delSolicitud()">SI Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>                 


                  

                    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Nueva Solicitud</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body"><div id="contentDivAdd"></div></div>
                                
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                    <a class="btn btn-primary" href="javascript:clickAddSolicitud()">Crear</a>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar Solicitud</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body"><div id="contentDiv"></div></div>
                                
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                    <a class="btn btn-primary" href="javascript:clickEditSolicitud()">Actualizar</a>
                                </div>
                            </div>
                        </div>
                    </div>  

<script type="text/javascript">
     
    $('#tabla').DataTable({
        "ajax":  "solicitud/json_listado",
        "rowId": "dt_rowid",
        "columns": [
            {"data": "nombre_lugar"},
            {"data": "descripcion"},
            {"data": "usuario_solicito"},
            {"data": "fecha_sol"},
            {"data": "estado_etiqueta"},
        ],
        "columnDefs": [{
                "targets": 5,
                "data": "id",
                "className": "text-center",
                "render": function (data, type, row, meta) {
                    var btx = "";
                    if(row.estado =='E')
                         btx = btx + '<a href="javascript:openEditSolicitudModal(' + data + ')">'
                                    + '<i class="fa fa-pencil-square-o fa-2x" alt="Editar Solicitud" aria-hidden="true"></i></a>';
                 
                    btx = btx + '<a href="javascript:openEditDetailsSolicitudModal(' + data + ')">'
                              + '<i class="fa fa-external-link fa-2x" style="color: green;" alt="Detalles de Solicitud" aria-hidden="true"></i></a> ';
                    
                    if(row.estado =='E')
                        btx = btx   + '<a href="javascript:solicitarTramite(' + data + ')">'
                                    + '<i class="fa fa-check-square-o fa-2x" style="color: blue;" alt="Solicitar Trámite" aria-hidden="true"></i></a>  '
                                    + '<a href="javascript:dialogrem(' + data + ')">'
                                    + '<i class="fa fa-times fa-2x" style="color: red;" alt="Eliminar Solicitud" aria-hidden="true"></i></a>  ';
                    
                    return btx;
                    
                }
            }]
        
    });

    

    function openEditDetailsSolicitudModal(ids) {

            $.ajax({
                url: 'solicitud/view_details/' + ids,
            }).done(function (data) {
                $("#MainPageContentTitle").html("Detalle de la Solicitud de Actualización de Datos");
                $("#MainPageContent").html(data);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                mostrarAlerta(jqXHR.status, '<?=base_url();?>login')
            });
    }

     function openAddSolicitudModal() {
   
        $.ajax({
            url: 'solicitud/view_add',
        }).done(function (data) {
            $("#contentDivAdd").html(data);
            $('#addModal').modal('show');
        }).fail(function (jqXHR, textStatus, errorThrown) {
            mostrarAlerta(jqXHR.status, '<?=base_url();?>login')
        });
    }

    function clickAddSolicitud(){
    $("#frmMainAddC").addClass("was-validated")  
    
    if ($("#frmMainAddC")[0].checkValidity()) {
          $("#frmMainAddC").addClass("was-validated")
         
          insertSolicitud();
         
    }
  }

  function openEditSolicitudModal(ids) {
   
   $.ajax({
       url: 'solicitud/vista_editar/' + ids,
   }).done(function (data) {
       $("#contentDiv").html(data);
       $('#editModal').modal('show');
   }).fail(function (jqXHR, textStatus, errorThrown) {
      mostrarAlerta(jqXHR.status, '<?=base_url();?>login')
    });
}



 function clickEditSolicitud(){
   $("#frmMainUpdC").addClass("was-validated")
   
   if ($("#frmMainUpdC")[0].checkValidity()) {
         $("#frmMainUpdC").addClass("was-validated")
         updateSolicitud();
        
   }
 }

  function insertSolicitud() {
    
    $.ajax({
        dataType: "json",
        url: "solicitud/create" ,
        type: "POST",
        data: {
            descripcion: $("#regDescripcionInsert").val()
        }
    }).done(function (data) {

        var tbSubCatEdit = $('#tabla').DataTable();
        tbSubCatEdit.ajax.reload( null, false ); 
        $('#addModal').modal('hide');
        
    }).fail(function (data) {

        if(data.status==401){
            alert("Error 401: No autorizado. Redirigiendo a la página de inicio de sesión...");
            window.location.href = '<?=base_url();?>login';
        }else{
            if(data.responseJSON.error)
                $("#msg_add_alert").html(data.responseJSON.error);
            else{
                var validaciones = data.responseJSON.validaciones;
                var msgerror="<b>Validaciones</b><br/>";
                for (var i = 0; i < validaciones.length; i++) 
                    msgerror = msgerror + validaciones[i].mensaje  + "<br/>";
                $("#msg_add_alert").html(msgerror);
            }

            $("#add-alert").fadeTo(5000, 500).slideUp(500, function() {
                    $("#add-alert").slideUp(500);
            });
        }

    });

}

function solicitarTramite(ids) {
  $.ajax({
      dataType: "json",
      url: "solicitud/solicitarTramite/" +  ids ,
      type: "POST"
  }).done(function (data) {

      alert(data.message);
      var tbSubCatEdit = $('#tabla').DataTable();
      tbSubCatEdit.ajax.reload( null, false ); 
      
  }).fail(function (data) {

    if(data.status==401){
            alert("Error 401: No autorizado. Redirigiendo a la página de inicio de sesión...");
            window.location.href = '<?=base_url();?>login';
    }else{
        if(data.responseJSON.error)
            $("#msgalertupdate").html(data.responseJSON.error);

        $("#error-alertupdate").fadeTo(5000, 500).slideUp(500, function() {
                $("#error-alertupdate").slideUp(500);
        });
    }

  });

}



function updateSolicitud() {
  $.ajax({
      dataType: "json",
      url: "solicitud/update/" +  $("#ids").val() ,
      type: "POST",
      data: {
          descripcion: $("#regDescripcionUpdate").val(),
          estado: 'E'
      }
  }).done(function (data) {

      var tbSubCatEdit = $('#tabla').DataTable();
      tbSubCatEdit.ajax.reload( null, false ); 
      $('#editModal').modal('hide');
      
  }).fail(function (data) {

    if(data.status==401){
            alert("Error 401: No autorizado. Redirigiendo a la página de inicio de sesión...");
            window.location.href = '<?=base_url();?>login';
    }else{
        if(data.responseJSON.error)
            $("#msgalertupdate").html(data.responseJSON.error);
        else{
            var validaciones = data.responseJSON.validaciones;
            alert(validaciones[0].mensaje);
            var msgerror="<b>Validaciones</b><br/>";
            for (var i = 0; i < validaciones.length; i++) 
                msgerror = msgerror + validaciones[i].mensaje  + "<br/>";
            
            alert(msgerror);

            $("#msgalertupdate").html(msgerror);
        }

        $("#error-alertupdate").fadeTo(5000, 500).slideUp(500, function() {
                $("#error-alertupdate").slideUp(500);
        });
    }

  });

}

function delSolicitud() {

  $.ajax({
      dataType: "json",
      url: "solicitud/delete/" +  $("#idRegistro").val() ,
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
    
</script>