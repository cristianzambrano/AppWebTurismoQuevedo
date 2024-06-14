<div class="text-center">
<img src="assets/imgs/banner_horizontal_verde.jpg" alt="" class="img-thumbnail" width="400" height="250">
</div>

<div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
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

              </div>  <!-- row -->

          </div><!-- bodycard enlaces -->
          </div><!-- card enlaces-->

  <div id="gridLista" name="gridLista"></div>

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

 

  <script type="text/javascript">
    
    ajaxLoadContentGrid("lugar_turistico/vista_lista/");

    fillCombo('categoria/getlistadoCB','regCategoria',0, true);  
    
    $("#regCategoria").change(function (evn) {
            $("#regSubCategoria").html("");
            fillCombo('subcategoria/getlistadoCB/' + this.value ,'regSubCategoria',0, true);

            var IDC=0;
            if(this.value>0) IDC = this.value;
            
            ajaxLoadContentGrid('lugar_turistico/vista_lista/' + IDC);

      });

      $("#regSubCategoria").change(function (evn) {
        
        var IDC=0, IDSC=0;
        if($("#regCategoria").val()>0) IDC = $("#regCategoria").val();
        if(this.value>0) IDSC = this.value;
      
        ajaxLoadContentGrid('lugar_turistico/vista_lista/' + IDC + '/' + IDSC);
                
      });



    function callEditarLugarTuristico(id) {
        ajaxLoadContentPanel('lugar_turistico/vista_editar/' + id, "Editar Lugar Turístico");
    }

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