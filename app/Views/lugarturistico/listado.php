<style>
    table.dataTable tbody td {
     vertical-align: middle;
}
</style>

                           <table id="tabla" class="table  table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Logo</th>
                                            <th>SubCategoría</th>
                                            <th>Descripción</th>
                                            <th>Whatsapp</th>
                                            <th>Maps</th>
                                            <th>Delivery</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                     <tfoot>
                                        <tr>
                                            <th>Logo</th>
                                            <th>SubCategoría</th>
                                            <th>Descripción</th>
                                            <th>Whatsapp</th>
                                            <th>Maps</th>
                                            <th>Delivery</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                </table>

                    <div class="modal fade" id="googleMapsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Google Maps</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                <div class="ratio ratio-1x1">
                                        <iframe id ="framegMap" src="" allowfullscreen="" loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>

                                </div>
                                
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="modal fade" id="remModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Lugar Turístico</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">¿Realmente desea Eliminar el  Lugar Turístico?</div>
                                <input type="hidden" name="idRegistro" id="idRegistro"/>
                                    <div class="alert alert-danger" id="delete-alert" role="alert">
                                        <div id="msgalert"></div>
                                    </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                    <a class="btn btn-danger" href="javascript:delLugarTuristico()">SI Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>  
                    
                    
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar Lugar Turístico</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body"><div id="contentDiv"></div></div>
                                
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                    <a class="btn btn-primary" href="javascript:clickEditSubCategoria()">Actualizar</a>
                                </div>
                            </div>
                        </div>
                    </div>  

                    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Lugar Turístico</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body"><div id="contentDivAdd"></div></div>
                                
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                    <a class="btn btn-primary" href="javascript:clickAddSubCategoria()">Agregar</a>
                                </div>
                            </div>
                        </div>
                    </div> 




<script type="text/javascript">
    
    var tbSubCatEdit = $('#tabla').DataTable({
 
    "ajax":  "lugar_turistico/json_getlistado",
    "rowId": "dt_rowid",
    
    "columns": [
        
        {"data": "logo"}, 
        {"data": "subcategoria"},
        {"data": "detalle_lugar"},
        {"data": "whatsapp"},
        {"data": "google_maps"},
        {"data": "delivery"},
        {"data": "id"},

    ],
     "columnDefs": [
     {
         "targets": 6,
         "data": "id",
         "className": "text-center",
         "render": function (data, type, row, meta) {
             return '<a href="javascript:callEditarLugarTuristico(' + data + ')">'
                     + '<i class="fa fa-pencil-square-o fa-2x" alt="Editar SubCategoría" aria-hidden="true"></i></a>  '
                     + '<a href="javascript:dialogrem(' + data + ')">'
                     + '<i class="fa fa-times fa-2x" style="color: red;" alt="Eliminar SubCategoría" aria-hidden="true"></i></a>  '
                     
             ;
         }
     },
     {
        "targets": 3,
        "data": "whatsapp",
        "className": "text-center",
        "render": function (data, type, row, meta) {
            var str="";
            if(data!="" && isValidUrl(data)) str='<a href="' + data + '" target="_blank">';
            str = str + '<i class="fa fa-whatsapp fa-2x" alt="Whatsapp" aria-hidden="true"></i>';
            if(data!="" && isValidUrl(data)) str = str + '</a>';
            return str;
                        
        }
    },
    {
        "targets": 4,
        "data": "google_maps",
        "className": "text-center",
        "render": function (data, type, row, meta) {
            var str="";
            if(data!="" && isValidUrl(data)) str='<a href="' + data + '" target="_blank">';
            str = str + '<i class="fa fa-globe fa-2x" alt="Google Maps" aria-hidden="true"></i>';
            if(data!="" && isValidUrl(data)) str = str + '</a>';
            return str;

        }
    },
    {
        "targets": 5,
        "data": "delivery",
        "className": "text-center",
        "render": function (data, type, row, meta) {
            var str="";
            if(data!="" && isValidUrl(data)) str='<a href="' + data + '" target="_blank">';
            str = str + '<i class="fa fa-motorcycle fa-2x" alt="Delivery" aria-hidden="true"></i>';
            if(data!="" && isValidUrl(data)) str = str + '</a>';
            return str;
        }
    },
     {
        "targets": 0,
        "data": "logo",
        "className": "text-center",
        "render": function (data, type, row, meta) {
            var img= data;
            if(img == "") img = "logogad.jpg";
                return '<img src="assets/imgs/logos_gifs/' +  img + '"  height="80" width="100" />';
        }
    }],

 
     initComplete: function () {
         this.api()
             .columns(1)
             .every(function () {
                 let column = this;
  
                
                 let select = document.createElement('select');
                 select.add(new Option('SubCategoría'));
                 column.header().replaceChildren(select);
  
                 
                 select.addEventListener('change', function () {
                    
                     if(select.selectedIndex>0){
                         var val = $.fn.dataTable.util.escapeRegex(select.value);
                         column
                         .search(val ? '^' + val + '$' : '', true, false)
                         .draw();
                     } else{
                         column
                         .search("")
                         .draw();
                     } 
                 });
  
                 
                 column
                     .data()
                     .unique()
                     .sort()
                     .each(function (d, j) {
                         select.add(new Option(d));
                     });
             });
     }
 
});

function callEditarLugarTuristico(id) {
        $.ajax({
            url: 'lugar_turistico/vista_editar/' + id
        }).done(function (data) {
            $("#MainPageContentTitle").html("Editar nuevo Lugar Turístico");
            $("#MainPageContent").html(data);
    
        });
    }

    function delLugarTuristico() {
    $.ajax({
        dataType: "json",
        url: "lugar_turistico/delete/" +  $("#idRegistro").val() ,
        type: "POST"
    }).done(function (data) {

        var tbSubCatEdit = $('#tabla').DataTable();
        tbSubCatEdit.ajax.reload( null, false ); 
        $('#remModal').modal('hide');
        
    }).fail(function (data) {

        if(data.responseJSON.error)
            $("#msgalert").html(data.responseJSON.error);

        $("#delete-alert").fadeTo(5000, 500).slideUp(500, function() {
                $("#delete-alert").slideUp(500);
        });

    });
}

</script>