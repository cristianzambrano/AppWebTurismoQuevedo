
                       
                               <table id="tabla" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Lugar</th>    
                                            <th>Descripción</th>
                                            <th>Solicitado por</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Detalles</th>
                                        </tr>
                                    </thead>
                                     <tfoot>
                                        <tr>
                                            <th>Lugar</th>    
                                            <th>Descripción</th>
                                            <th>Solicitado por</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Detalles</th>
                                        </tr>
                                    </tfoot>
                                </table>


                    

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
                    return '<a href="javascript:openEditDetailsSolicitudModal(' + data + ')">'
                            + '<i class="fa fa-external-link fa-2x" style="color: green;" alt="Detalles de Solicitud" aria-hidden="true"></i></a>  '
                    ;
                }
            }]
        
    });

    

    function openEditDetailsSolicitudModal(ids) {

            $.ajax({
                url: 'solicitud/view_detailsadmin/' + ids,
            }).done(function (data) {
                $("#MainPageContentTitle").html("Detalle de la Solicitud de Actualización de Datos");
                $("#MainPageContent").html(data);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                mostrarAlerta(jqXHR.status, '<?=base_url();?>login')
            });
    }

    
    
</script>