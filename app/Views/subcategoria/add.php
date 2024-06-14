<!-- Begin form -->
<form id="frmMainAddSubC" name="frmMainAddSubC" data-aos="fade-in">
                   
          <div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
              <div class="card-header">
              Datos de la SubCategoría
              </div>

          <div class="tr-card-body">
          <div class="row mb-2">
              <div class="col-sm-11"  style="margin: 0.5em 0.5em 0.5em 0.5em;">
                      <label for="regAddCategoria">Categoría</label>
                      <select id="regAddCategoria" class="custom-select"></select>
                      <div class="valid-feedback">Categoría válida</div>
                      <div class="invalid-feedback">Especifique una Categoría válida</div>
              </div>
              <div class="col-sm-11" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                  <label for="regNombres">Descripción</label>
                  <input 
                      id="regDescripcion" 
                      name="regDescripcion" 
                      type="text" 
                      class="form-control" 
                      maxlength="100"
                      placeholder="Descripción"
                      value=""
                      required>
                  <div class="valid-feedback">Descripción válida</div>
                  <div class="invalid-feedback">Escriba una Descripción de la SubCategoría</div>
              </div>
              </div>  <!-- row -->
          </div><!-- bodycard -->
          </div><!-- card -->

          <div class="alert alert-danger" id="add-alert" role="alert">
              <div id="msg_add_alert"></div>
          </div>

</form> <!-- Fin de primer formulario () -->

<script type="text/javascript">
     
     $("#add-alert").hide();
     fillCombo('categoria/getlistadoCB','regAddCategoria',0);
            
</script>

</html>