          <!-- Begin form -->
          <form id="frmMainAddReg" name="frmMainAddReg" data-aos="fade-in">

        
      
            <div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
              <div class="card-header">
                Datos del Lugar
              </div>
           
            <div class="tr-card-body">
                 
              <div class="row mb-2">

                <div class="col-sm-4" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                  <label for="regCategoria"><i class="fa fa-home" aria-hidden="true"></i> Categoría</label>
                    <select id="regCategoria" name="regTipoID" class="custom-select" required>
                    </select>
                    <div class="valid-feedback">Categoría válida</div>
                    <div class="invalid-feedback">Categoría NO válida</div>
                </div>
                
                <div class="col-sm-7" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <label for="regSubCategoria"><i class="fa fa-home" aria-hidden="true"></i>SubCategoría</label>
                      <select id="regSubCategoria" name="regSubCategoria" class="custom-select" required>
                      </select>
                    <div class="valid-feedback">SubCategoría válida</div>
                    <div class="invalid-feedback">SubCategoría NO válida</div>
                </div>


                <div class="col-sm-11" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <label for="regTitulo"><i class="fa fa-building" aria-hidden="true"></i> Nombre del Lugar</label>
                    <input 
                      id="regTitulo" 
                      name="regTitulo" 
                      type="text" 
                      class="form-control" 
                      style="text-transform:uppercase"
                      maxlength="100"
                      placeholder="Nombre del Lugar"
                      required>
                    <div class="valid-feedback">Nombre válido</div>
                    <div class="invalid-feedback">Escriba el Nombre del Lugar</div>
                </div>

                

                <div class="col-sm-11" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <label for="regDescripcion"><i class="fa fa-building" aria-hidden="true"></i> Descripción del lugar</label>
                    <textarea 
                      id="regDescripcion" 
                      name="regDescripcion" 
                      class="form-control" 
                      rows="3"
                      maxlength="1000"
                      placeholder="Descripción del Lugar"
                      required></textarea>
                    <div class="valid-feedback">Descripción válida</div>
                    <div class="invalid-feedback">Escriba la Descripción del Lugar</div>
                </div>
                
                <div class="col-sm-11" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <label for="regDireccion"><i class="fa fa-globe" aria-hidden="true"></i> Dirección del Lugar</label>
                    <input 
                      id="regDireccion" 
                      name="regDireccion" 
                      type="text" 
                      class="form-control" 
                     
                      maxlength="300"
                      placeholder="Dirección del Lugar"
                      required>
                    <div class="valid-feedback">Dirección válida</div>
                    <div class="invalid-feedback">Escriba la Dirección del Lugar</div>
                </div>


                <div class="col-sm-4"  style="margin: 0.5em 0.5em 0.5em 0.5em;">
                  <label for="regTelef"><i class="fa fa-phone" aria-hidden="true"></i> Teléfono</label>
                   <input  
                    class="form-control"
                    type="tel" 
                    maxlength="100"
                    id="regTelef" 
                    name="regTelef"
                    placeholder="Teléfono del Lugar"
                   required>
                  <div class="valid-feedback">Teléfono válido</div>
                  <div class="invalid-feedback">Especifique un número válido</div>
                </div>

                <div class="col-sm-4"  style="margin: 0.5em 0.5em 0.5em 0.5em;">
                  <label for="regAnio"><i class="fa fa-calendar" aria-hidden="true"></i> Año</label>
                   <input  
                    class="form-control"
                    type="number" 
                    min="1990"
                    placeholder="Año Inicio"
                    id="regAnio" 
                    name="regAnio"
                   required>
                  <div class="valid-feedback">Año válido</div>
                  <div class="invalid-feedback">Especifique un Año válido</div>
                </div>

                <div class="col-sm-3"  style="margin: 0.5em 0.5em 0.5em 0.5em;">
                  <label for="regPuntuacion"><i class="fa fa-star-half-o" aria-hidden="true"></i> Puntuación</label>
                   <input  
                    class="form-control"
                    min="1" max="5" type="number"
                    placeholder="Puntuación"
                    id="regPuntuacion" 
                    name="regPuntuacion"
                   required>
                  <div class="valid-feedback">Puntuación válida</div>
                  <div class="invalid-feedback">Especifique una Puntuación válida de 1 a 5</div>
                </div>
              

                <div class="col-sm-4"  style="margin: 0.5em 0.5em 0.5em 0.5em;">
                  <label for="regLatitud"><i class="fa fa-map-marker" aria-hidden="true"></i> Latitud</label>
                   <input 
                    class="form-control"
                    type="number" 
                    step="0.000001"
                    min="-90" max="90"
                    id="regLatitud" 
                    name="regLatitud"
                    placeholder="Latitud"
                   required>
                  <div class="valid-feedback">Latitud válida</div>
                  <div class="invalid-feedback">Especifique una Latitud (-90° y +90°) válida</div>
                </div>

                <div class="col-sm-4"  style="margin: 0.5em 0.5em 0.5em 0.5em;">
                  <label for="regLongitud"><i class="fa fa-map-marker" aria-hidden="true"></i> Longitud</label>
                   <input  
                    class="form-control"
                    type="number" 
                    step="0.000001"
                    min="-180" max="180"
                    placeholder="Longitud"
                    id="regLongitud" 
                    name="regLongitud"
                   required>
                  <div class="valid-feedback">Longitud válida</div>
                  <div class="invalid-feedback">Especifique una Latitud  (-180° y +180°)  válida</div>
                </div>
                
              </div>  <!-- row -->

            </div><!-- bodycard datos personales-->
           </div><!-- card datos personales-->

           <div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
              <div class="card-header">
                Multimedia del Lugar
              </div>
           
            <div class="tr-card-body">
              <div class="row mb-2">
              <div class="col-sm-4" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <label for="regFileLogo"><i class="fa fa-picture-o" aria-hidden="true"></i> Logo del Lugar</label>
                    
                    <table>
                     <tr><td style="text-align:center">
                        <input type="file"  required="required" class="form-control-file" onchange="showPreview(event,'pimgLogo');" id="regFileLogo" 
                        accept="image/*" name ="regFileLogo">
                      </td></tr>
                      <tr><td style="text-align:center">
                        <img id="pimgLogo" src="assets/imgs/logos_gifs/logogad.jpg" width="150" height="150" alt="">    
                      
                      </td></tr>
                    </table>
                </div>

                <div class="col-sm-7" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                  <label for="regFileImgs"><i class="fa fa-file-image-o" aria-hidden="true"></i> Fotos del Lugar</label>
                    
                    <table>
                     <tr><td style="text-align:center">
                        <input type="file"  required="required" class="form-control-file" onchange="showPreview(event,'pimgFotos');" id="regFileImgs" 
                        accept="image/*" name ="regFileImgs">
                      </td></tr>
                      <tr><td style="text-align:center">
                        <img id="pimgFotos" src="assets/imgs/logos_gifs/lshopping_center.gif" width="300" height="150" alt="">    
                      
                      </td></tr>
                    </table>
                </div>
              </div>  <!-- row -->

          </div><!-- bodycard Multimedia -->
          </div><!-- card Multimedia-->

           <div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
              <div class="card-header">
                Links del Lugar
              </div>
           
            <div class="tr-card-body">
              <div class="row mb-2">
              <div class="col-sm-11" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <label for="regWS"><i class="fa fa-whatsapp" alt="Whatsapp" aria-hidden="true"></i> Link Whatsapp</label>
                    <input 
                      id="regWS" 
                      name="regWS" 
                      type="url" 
                      class="form-control" 
                      
                      maxlength="300"
                      placeholder="Link de Whatsapp"
                      >
                    <div class="valid-feedback">Link válido</div>
                    <div class="invalid-feedback">Escriba el Link de Whatsapp</div>
                </div>

                <div class="col-sm-11" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <label for="regGM"><i class="fa fa-globe" alt="Google Maps" aria-hidden="true"></i> Link Google Maps</label>
                    <input 
                      id="regGM" 
                      name="regGM" 
                      type="url" 
                      class="form-control" 
                      
                      maxlength="300"
                      placeholder="Link de Google Maps"
                      >
                    <div class="valid-feedback">Link válido</div>
                    <div class="invalid-feedback">Escriba el Link de Google Maps</div>
                </div>

                <div class="col-sm-11" style="margin: 0.5em 0.5em 0.5em 0.5em;">
                    <label for="regDel"><i class="fa fa-motorcycle" alt="Delivery" aria-hidden="true"></i> Link Delivery</label>
                    <input 
                      id="regDel" 
                      name="regDel" 
                      type="url" 
                      class="form-control" 
                      
                      maxlength="300"
                      placeholder="Link de Delivery"
                      >
                    <div class="valid-feedback">Link válido</div>
                    <div class="invalid-feedback">Escriba el Link de Delivery</div>
                </div>

              </div>  <!-- row -->

          </div><!-- bodycard enlaces -->
          </div><!-- card enlaces-->
          
          <br/>
          <div class="col-11" style="text-align: center;">
            <a class="btn btn-secondary" data-dismiss="modal" href="#" onclick="callListaLugaresTuristicos();">
            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Cancelar</a>
            <a id="regSubmit" class="btn btn-primary" style="color:white"><i class="fa fa-plus-circle" aria-hidden="true"></i> <b>Registrar</b></a>
          </div>

        </form> <!-- Fin de primer formulario (Participante) -->

       

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
    
    $('documment').ready(function() {
      fillCombo('categoria/getlistadoCB','regCategoria',0, true);   

      $("#regCategoria").change(function (evn) {
            $("#regSubCategoria").html("");
               fillCombo('subcategoria/getlistadoCB/' + this.value ,'regSubCategoria',0);
                
      });

    });



   $("#regSubmit").click(function (e) {
      $("#frmMainAddReg").addClass("was-validated");
      
      var resp=fxValidaFrm();
      if(resp==""){
        callRegistrarLugarTuristico();
      }else{
        showErrorModalMsg('Error al registrar Lugar Turístico', resp) ;
      }
       
    
      
    });

    function fxValidaFrm() {

      if(!$("#regSubCategoria").val()) return "Selecione una SubCategoría";
      if($("#regTitulo").val().trim()=="") return "Ingrese Nombre del Lugar";
      if($("#regDescripcion").val().trim()=="") return "Ingrese Descripción del Lugar";
      if($("#regDireccion").val().trim()=="") return "Ingrese Dirección del Lugar";
      if($("#regTelef").val().trim()=="") return "Ingrese Teléfono del Lugar";

      if($("#regAnio").val().trim()=="") return "Ingrese Año Funcionamiento del Lugar";
      if($("#regPuntuacion").val().trim()=="") return "Ingrese Puntuación del Lugar";

      if($("#regLatitud").val().trim()=="") return "Ingrese Coordenada Geográfica Latitud";
      if($("#regLongitud").val().trim()=="") return "Ingrese Coordenada Geográfica Longitud";

      var fileInput = document.getElementById('regFileLogo');
      if (fileInput.files && fileInput.files[0]) {
          var filePath = fileInput.value;
          var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
          if (!allowedExtensions.exec(filePath)) return "Logo debe un fichero de tipo Imagen (.jpg, .jpeg o .png)";
      }else return "Debe seleccionar una imagen del Logo";

      var fileInput = document.getElementById('regFileImgs');
      if (fileInput.files && fileInput.files[0]) {
          var filePath = fileInput.value;
          var allowedExtensions = /(\.gif)$/i;
          if (!allowedExtensions.exec(filePath)) return "Las imágenes del Lugar debe ser un fichero de tipo Gif (.gif)";
      }else return "Debe seleccionar un fichero Gif para las Imágenes del Lugar";

      if($("#regWS").val().trim()!="") 
          if(!isValidUrl($("#regWS").val().trim())) return "Ingrese un Link de Whatsapp válido";

      if($("#regGM").val().trim()!="") 
          if(!isValidUrl($("#regGM").val().trim())) return "Ingrese un Link de Google Maps válido";

      if($("#regDel").val().trim()!="") 
          if(!isValidUrl($("#regDel").val().trim())) return "Ingrese un Link de Whatsapp Delivery válido";

      return "";
    }

    function callRegistrarLugarTuristico() {
    
    var inputImgLogo = document.getElementById('regFileLogo');
    var inputImgs = document.getElementById('regFileImgs');
    
    var formData = new FormData();
    formData.append("regFileLogo", inputImgLogo.files[0]);
    formData.append("regFileImgs", inputImgs.files[0]);

    formData.append("subcategoria_id", $("#regSubCategoria").val());
    formData.append("nombre_lugar", $("#regTitulo").val().trim());
    formData.append("descripcion", $("#regDescripcion").val().trim());
    formData.append("direccion", $("#regDireccion").val().trim());
    formData.append("telefono", $("#regTelef").val().trim());
    formData.append("anio", $("#regAnio").val());
    formData.append("puntuacion", $("#regPuntuacion").val());
    formData.append("delivery", $("#regDel").val().trim());
    formData.append("whatsapp", $("#regWS").val().trim());
    formData.append("google_maps", $("#regGM").val().trim());
    formData.append("latitud", $("#regLatitud").val());
    formData.append("longitud", $("#regLongitud").val());
  
    $.ajax({
        url:  'lugar_turistico/create',
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        async: false
      }).done(function(data) {
        
        alert("El Lugar Turístico '"  + $("#regTitulo").val().trim() + "' se registró correctamente") ;
        callListaLugaresTuristicos();

      }).fail(function (data) {

        if(data.responseJSON.error)
            showErrorModalMsg('Error al registrar Lugar Turístico', data.responseJSON.error) ;
        else{
            var validaciones = data.responseJSON.validaciones;
            var msgerror="<b>Validaciones</b><br/>";
            for (var i = 0; i < validaciones.length; i++) 
                msgerror = msgerror + validaciones[i].mensaje  + "<br/>";
            showErrorModalMsg('Error al registrar Lugar Turístico', msgerror) ;   
        }

    });

  }


  </script>

</body>

</html>