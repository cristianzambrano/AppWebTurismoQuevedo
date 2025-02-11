          <!-- Begin form -->
          <form id="frmMainUpdC" name="frmMainUpdC" data-aos="fade-in">

          <input type="hidden" name="ids" id="ids" value="<?= $id; ?>">
          
            <div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
             
           
            <div class="tr-card-body">
            <div class="row mb-2">
                <div class="col-sm-11" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <label for="regNombres">Descripción</label>
                    <input 
                      id="regDescripcionUpdate" 
                      name="regDescripcionUpdate" 
                      type="text" 
                      class="form-control" 
                      maxlength="100"
                      placeholder="Descripción"
                      value="<?= $descripcion; ?>"
                      required>
                    <div class="valid-feedback">Descripción válida</div>
                    <div class="invalid-feedback">Escriba una Descripción de la Solicitud</div>
                </div>
              </div>  <!-- row -->
            </div><!-- bodycard -->
           </div><!-- card -->

           <div class="alert alert-danger" id="error-alertupdate" role="alert">
            <div id="msgalertupdate"></div>
        </div>

        </form> <!-- Fin de primer formulario () -->


</body>

<script type="text/javascript">
     
     $("#error-alertupdate").hide();
  
            
</script>

</html>