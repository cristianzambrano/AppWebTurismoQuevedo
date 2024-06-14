function fxValidaUpdateRegistroPonenciaFrm(TipoPonencia) {

  resp=validateWordsLenghtUpdate('Título',  CKEDITOR.instances.regTitulo.wordCount.wordCount, 1, 20);
  if(resp!="") return resp;

  resp=validateWordsLenghtUpdate('Introducción', CKEDITOR.instances.resIntro.wordCount.wordCount, 30, 40);
  if(resp!="") return resp;

  resp=validateWordsLenghtUpdate('Objetivos', CKEDITOR.instances.resObjetivo.wordCount.wordCount, 20, 30);
  if(resp!="") return resp;

  resp=validateWordsLenghtUpdate('Metodología', CKEDITOR.instances.resMetodologia.wordCount.wordCount, 60, 80);
  if(resp!="") return resp;

  resp=validateWordsLenghtUpdate('Resultados', CKEDITOR.instances.resResultados.wordCount.wordCount, 110, 130);
  if(resp!="") return resp;

  resp=validateWordsLenghtUpdate( 'Conclusiones', CKEDITOR.instances.resConclusiones.wordCount.wordCount, 30, 40);
  if(resp!="") return resp;

  if(CKEDITOR.instances.regTitulo.document.getBody().getText().trim()=="") return "Campo Título vacío";
  if(CKEDITOR.instances.resIntro.document.getBody().getText().trim()=="") return "Campo Introducción vacío";
  if(CKEDITOR.instances.resObjetivo.document.getBody().getText().trim()=="") return "Campo Objetivo vacío";
  if(CKEDITOR.instances.resMetodologia.document.getBody().getText().trim()=="") return "Campo Metodología vacío";
  if(CKEDITOR.instances.resResultados.document.getBody().getText().trim()=="") return "Campo Resultados vacío";
  if(CKEDITOR.instances.resConclusiones.document.getBody().getText().trim()=="") return "Campo Conclusiones Vacío";
  
  if($("#regkeys").val().trim()=="") return "Ingrese Palabras Claves";
  var myArr = JSON.parse($("#regkeys").val().trim());
  if(myArr.length==0) return "Debe ingresar al menos una Palabra Clave";
  if(myArr.length>5) return "Debe ingresar máximo 5 Palabras Clave";


  if(TipoPonencia==4){
      var fileInput = document.getElementById('regFile');
      var filePath = fileInput.value;
      if (fileInput.files && fileInput.files[0]) {
          var allowedExtensions = /(\.doc|\.docx)$/i;
          if (!allowedExtensions.exec(filePath)) return "Debe seleccionar un fichero de tipo MS Word (.doc o docx)";
      }
 
  }
   
  return "";
}


function fxValidaFrm() {

  resp=validateWordsLenght('regTitulo', 'Título',  CKEDITOR.instances.regTitulo.wordCount.wordCount, 1, 20);
  if(resp!="") return resp;

  resp=validateWordsLenght('resIntro', 'Introducción', CKEDITOR.instances.resIntro.wordCount.wordCount, 30, 40);
  if(resp!="") return resp;

  
  resp=validateWordsLenght('resObjetivo', 'Objetivos', CKEDITOR.instances.resObjetivo.wordCount.wordCount, 20, 30);
  if(resp!="") return resp;

  resp=validateWordsLenght('resMetodologia', 'Metodología', CKEDITOR.instances.resMetodologia.wordCount.wordCount, 60, 80);
  if(resp!="") return resp;

  resp=validateWordsLenght('resResultados', 'Resultados', CKEDITOR.instances.resResultados.wordCount.wordCount, 110, 130);
  if(resp!="") return resp;

  resp=validateWordsLenght('resConclusiones', 'Conclusiones', CKEDITOR.instances.resConclusiones.wordCount.wordCount, 30, 40);
  if(resp!="") return resp;

  if(CKEDITOR.instances.regTitulo.document.getBody().getText().trim()=="") return "Campo Título vacío";
  if(CKEDITOR.instances.resIntro.document.getBody().getText().trim()=="") return "Campo Introducción vacío";
  if(CKEDITOR.instances.resObjetivo.document.getBody().getText().trim()=="") return "Campo Objetivo vacío";
  if(CKEDITOR.instances.resMetodologia.document.getBody().getText().trim()=="") return "Campo Metodología vacío";
  if(CKEDITOR.instances.resResultados.document.getBody().getText().trim()=="") return "Campo Resultados vacío";
  if(CKEDITOR.instances.resConclusiones.document.getBody().getText().trim()=="") return "Campo Conclusiones Vacío";
  
  if($("#regkeys").val().trim()=="") return "Ingrese Palabras Claves";
  var myArr = JSON.parse($("#regkeys").val().trim());
  if(myArr.length==0) return "Debe ingresar al menos una Palabra Clave";
  if(myArr.length>5) return "Debe ingresar máximo 5 Palabras Clave";


  var items = document.getElementsByClassName("list-group-item active");
  if(items[0].id==4){
      var fileInput = document.getElementById('regFile');
      var filePath = fileInput.value;
      if (!fileInput.files && !fileInput.files[0]) return "Debe seleccionar un fichero";
      var allowedExtensions = /(\.doc|\.docx)$/i;
      if (!allowedExtensions.exec(filePath)) return "Debe seleccionar un fichero de tipo MS Word (.doc o docx)";
 
  }
   
  return "";
}

function validateRegNombres() {
      
      if ($("#frmMainReg").prop("class") != "was-validated") {
        return 0
      }

      element = $("#regNombres")[0] 
      value = element.value
      valid = /^[A-Za-zÁÉÍÑÓÚáé íñó]*$/.test(value)

      if (valid)
        element.setCustomValidity("")
      else
        element.setCustomValidity("Nombre incorrecto")
      element.reportValidity()
}

function validateRegPassword() {

      if ($("#frmMainReg").prop("class") != "was-validated") {
        return 0
      }

      element1 = $("#regPassword1")[0] 
      element2 = $("#regPassword2")[0] 
      value1 = element1.value
      value2 = element2.value
      valid = value1 == value2
      valid = valid && value1.length > 5

      if (valid) {
        element1.setCustomValidity("")
        element2.setCustomValidity("")
      } else {
        element2.setCustomValidity("Las contraseñas no coinciden")
      }
      element2.reportValidity()
  }


function getWordscount(s) {
      if(s!=""){
          s = s.replace(/(^\s*)|(\s*$)/gi,"");//exclude  start and end white-space
          s = s.replace(/[ ]{2,}/gi," ");//2 or more space to 1
          s = s.replace(/\n /,"\n"); // exclude newline with a start spacing
          return s.split(' ').filter(function(str){return str!="";}).length;
      }else
         return 0;
}

function validateWordsLenght(idElement, nombreCampo, numberOfWord, minWords, maxWords) {
      
      if ($("#frmMainRegPon").prop("class") != "was-validated") {
        return "Error en Formulario";
      }

      var msg="";
      element = $("#"+idElement).get(0);
      if ( numberOfWord < minWords ||  numberOfWord > maxWords){
        msg="Rango de Palabras en " + nombreCampo + " debe ser entre " + minWords + " y " + maxWords;
      }

      element.setCustomValidity(msg);
      element.reportValidity();
      //return msg;

      if(!element.checkValidity()){
        return msg;
      }else
        return "";
     
}

function validateWordsLenghtUpdate(nombreCampo, numberOfWord, minWords, maxWords) {
      
 
  if ( numberOfWord < minWords ||  numberOfWord > maxWords){
     return "Rango de Palabras en " + nombreCampo + " debe ser entre " + minWords + " y " + maxWords;
  }else
    return "";

}


