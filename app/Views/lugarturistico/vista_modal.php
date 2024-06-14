

           <input type="hidden" name="idlugarturistico" id="idlugarturistico" value="<?= $id; ?>">
      
            <div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
             <div class="tr-card-body">
                 
              <div class="row mb-1">

              <div class="col-sm-3 ml-2 mb-2 mr-2 mt-2 text-center" >
                 <?php 
                   if(!file_exists("assets/imgs/logos_gifs/".$logo) || $logo=="")  $logo = "logogad.jpg";
                 ?>
                 <img id="pimgLogo" src="assets/imgs/logos_gifs/<?=$logo?>" class="w-100 img-fluid">   
              </div>

              <div class="col-sm-8 mt-2 mb-2 mr-2">
                 <i class="fa fa-building" aria-hidden="true"></i> <b>Descripción del Lugar</b>
                 <p><?=$descripcion;?></p>  
              </div>

            

              <?php if(file_exists("assets/imgs/logos_gifs/".$imagenes_gif) && $imagenes_gif!=""){ ?>
                      <div class="col-sm-11" style="margin: 0.5em 0em 0em 0.5em;">
                        <img id="pimgLogo" src="assets/imgs/logos_gifs/<?=$imagenes_gif?>" class="img-thumbnail">   
                    </div>
              <?php } ?>

              <div class="col-sm-11" style="margin: 0.5em 0em 0em 0.5em;">
                 <i class="fa fa-map-marker" aria-hidden="true"></i> <b>Dirección: </b> <?=$direccion;?>
      
              </div>
              <div class="col-sm-11" style="margin: 0.5em 0em 0em 0.5em;">
                  <i class="fa fa-phone" aria-hidden="true"></i> <b>Teléfono: </b> <?=$telefono;?>
                  
              </div>
              
              
              <div class="col-sm-5" style="margin: 0.5em 0em 0em 0.5em;">
                <b>Puntuación</b>
                 <ul class="list-inline">
                   <?php 
                     for($i=1; $i<=$puntuacion && $i<=5;$i++)
                         echo '<li class="list-inline-item m-0"><i class="fa fa-star text-success fa-2x"></i></li>';

                     for($i=$puntuacion+1; $i<=5;$i++)
                        echo '<li class="list-inline-item m-0"><i class="fa fa-star-o text-success fa-2x"></i></li>';
                     ?>
                 </ul>
                
             </div>


             <div class="col-sm-6" style="margin: 0.5em 0em 0em 0.5em;">
                  <b>Links</b>
                   <ul class="social mb-0 list-inline mt-1">
                     <li class="list-inline-item m-1">
                       <?php if($whatsapp!="") echo '<a href="'.$whatsapp.'" target="_blank" class="social-link">'; ?>
                       <i class="fa fa-whatsapp fa-2x"></i>
                       <?php if($whatsapp!="") echo'</a>'; ?>
                     </li>

                     <li class="list-inline-item m-1">
                       <?php if($google_maps!="") echo '<a href="'.$google_maps.'" target="_blank" class="social-link">'; ?>
                       <i class="fa fa-globe fa-2x"></i>
                       <?php if($google_maps!="") echo'</a>'; ?>
                     </li>

                     <li class="list-inline-item m-1">
                       <?php if($delivery!="") echo '<a href="'.$delivery.'" target="_blank" class="social-link">'; ?>
                       <i class="fa fa-motorcycle fa-2x"></i>
                       <?php if($delivery!="") echo'</a>'; ?>
                     </li>
                  </ul>
             </div>
              

                

                

                

                
              </div>  <!-- row -->

            </div>
           </div>

          
           
       


       
    
    