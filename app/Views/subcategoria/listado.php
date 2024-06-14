                            <button  class="btn btn-primary" id="btAddSubC" onclick="javascript:openAddSubCategoriaModal()">
                                <i class="fa fa-plus-circle"></i>
                                <b>Nueva</b>
                            </button>
                            <br/><br/>


                               <table id="tabla" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            
                                            <th>Categoría</th>
                                            <th>Descripción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                     <tfoot>
                                        <tr>
                                           
                                            <th>Categoría</th>
                                            <th>Descripción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                </table>

                <div class="modal fade" id="remModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar SubCategoría</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">¿Realmente desea Eliminar la SubCategoría?</div>
                                <input type="hidden" name="idRegistro" id="idRegistro"/>
                                    <div class="alert alert-danger" id="delete-alert" role="alert">
                                        <div id="msgalert"></div>
                                    </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                    <a class="btn btn-danger" href="javascript:delSubCategoria()">SI Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>  
                    
                    
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar SubCategoría</h5>
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
                                    <h5 class="modal-title" id="exampleModalLabel">Nueva SubCategoría</h5>
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
 
    "ajax":  "subcategoria/json_getlistado",
    "rowId": "dt_rowid",
    
    "columns": [
        
        {"data": "categoria"},
        {"data": "descripcion"},
        {"data": "id"},
    ],
    "columnDefs": [
     {
         "targets": 2,
         "data": "id",
         "className": "text-center",
         "render": function (data, type, row, meta) {
             return '<a href="javascript:openEditSubCategoriaModal(' + data + ')">'
                     + '<i class="fa fa-pencil-square-o fa-2x" alt="Editar SubCategoría" aria-hidden="true"></i></a>  '
                     + '<a href="javascript:dialogrem(' + data + ')">'
                     + '<i class="fa fa-times fa-2x" style="color: red;" alt="Eliminar SubCategoría" aria-hidden="true"></i></a>  '
                     
             ;
         }
     }],

 
     initComplete: function () {
         this.api()
             .columns(0)
             .every(function () {
                 let column = this;
  
                
                 let select = document.createElement('select');
                 select.add(new Option('Categoría'));
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

function openEditSubCategoriaModal(idsc) {
   
   $.ajax({
       url: 'subcategoria/vista_editar/' + idsc,
   }).done(function (data) {
       $("#contentDiv").html(data);
       $('#editModal').modal('show');
   });
}

function openAddSubCategoriaModal() {
  
   $.ajax({
       url: 'subcategoria/vista_agregar',
   }).done(function (data) {
       //alert(data);
       $("#contentDivAdd").html(data);
       $('#addModal').modal('show');
   });
}


function clickAddSubCategoria(){
   $("#frmMainAddSubC").addClass("was-validated")  
   
   if ($("#frmMainAddSubC")[0].checkValidity()) {
         $("#frmMainAddSubC").addClass("was-validated")
        
         insertSubCategoria();
        
   }
 }

 function clickEditSubCategoria(){
   $("#frmMainUpdSubC").addClass("was-validated")
   
   if ($("#frmMainUpdSubC")[0].checkValidity()) {
         $("#frmMainUpdSubC").addClass("was-validated")
         updateSubCategoria();
        
   }
 }

 function insertSubCategoria() {
   
         $.ajax({
             dataType: "json",
             url: "subcategoria/create" ,
             type: "POST",
             data: {
                 descripcion: $("#regDescripcion").val(),
                 categoria_id: $("#regAddCategoria").val(),
             }
         }).done(function (data) {

             var tbSubCatEdit = $('#tabla').DataTable();
             tbSubCatEdit.ajax.reload( null, false ); 
             $('#addModal').modal('hide');
             
         }).fail(function (data) {

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

         });

 }

 function updateSubCategoria() {
       $.ajax({
           dataType: "json",
           url: "subcategoria/update/" +  $("#idsc").val() ,
           type: "POST",
           data: {
               descripcion: $("#regDescripcion").val(),
               categoria_id: $("#regCategoria").val(),
           }
       }).done(function (data) {

           var tbSubCatEdit = $('#tabla').DataTable();
           tbSubCatEdit.ajax.reload( null, false ); 
           $('#editModal').modal('hide');
           
       }).fail(function (data) {

           if(data.responseJSON.error)
               $("#msgalert").html(data.responseJSON.error);
           else{
               var validaciones = data.responseJSON.validaciones;
               var msgerror="<b>Validaciones</b><br/>";
               for (var i = 0; i < validaciones.length; i++) 
                   msgerror = msgerror + validaciones[i].mensaje  + "<br/>";
               $("#msgalert").html(msgerror);
           }

           $("#error-alert").fadeTo(5000, 500).slideUp(500, function() {
                   $("#error-alert").slideUp(500);
           });

       });

 }

 function delSubCategoria() {
       $.ajax({
           dataType: "json",
           url: "subcategoria/delete/" +  $("#idRegistro").val() ,
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