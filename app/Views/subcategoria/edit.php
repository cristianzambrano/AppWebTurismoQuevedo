          <!-- Begin form -->
          <form id="frmMainUpdSubC" name="frmMainUpdSubC" data-aos="fade-in">

          <input type="hidden" name="idsc" id="idsc" value="<?= $id; ?>">
          

            <div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
              <div class="card-header">
                Datos de la SubCategoría
              </div>
           
            <div class="tr-card-body">
            <div class="row mb-2">
                <div class="col-sm-11"  style="margin: 0.5em 0.5em 0.5em 0.5em;">
                      <label for="regCategoria">Categoría</label>
                      <select id="regCategoria" class="custom-select"></select>
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
                      value="<?= $descripcion; ?>"
                      required>
                    <div class="valid-feedback">Descripción válida</div>
                    <div class="invalid-feedback">Escriba una Descripción de la SubCategoría</div>
                </div>
              </div>  <!-- row -->
            </div><!-- bodycard -->
           </div><!-- card -->

           <div class="alert alert-danger" id="error-alert" role="alert">
            <div id="msgalert"></div>
        </div>

        </form> <!-- Fin de primer formulario () -->


</body>

<script type="text/javascript">
     
     $("#error-alert").hide();
     fillCombo('categoria/getlistadoCB','regCategoria',<?=$categoria_id?>);
            
</script>

</html>