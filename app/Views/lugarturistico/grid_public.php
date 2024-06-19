<?php 
        $categoria_id = 0; $subcategoria_id = 0; $open_cat=false; $open_subcat=false; $open_col=false;
        foreach ($data as $row) {
        
            if($categoria_id != $row['categoria_id']){

            if($open_col) {
                echo '</div></div>';
                $open_col=false;
            }

            if($open_subcat){
                echo '</div></div>';
                $open_subcat=false;
            }

            if($open_cat){
                echo '</div></div> ';
            }
            $open_cat = true;       
            echo '<div class="card mt-2 mb-3"  >
            <div class="card-header text-center"><b><h4>'.$row['categoria'].'</h4></b></div>
            <div class="tr-card-body">';
            }

            if($subcategoria_id != $row['subcategoria_id']){

            if($open_col) {
                echo '</div></div>';
                $open_col=false;
            }

            if($open_subcat){
                echo '</div>
            </div> ';
            }
            $open_subcat = true;
            echo '<div class="card mt-1 mb-2 ml-1 mr-1" >
                <div class="card-header"><b>'.$row['subcategoria'].'</b></div>
                <div class="tr-card-body">';
            
            $col=0;
            }
            
            if(!$open_col) {
                echo '<div class=" mb-1 ml-1 mr-1 text-center">
                      <div class="row mb-2">';
                $open_col=true;
            } ?>

                <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-1 mt-2 ">
                <a class="text-dark" href="javascript:ajaxShowLugarTuristicoModal(<?=$row['id']?>,'<?=$row['nombre_lugar']?>')">
                <div class="card h-100 box-shadow rounded text-center d-flex flex-column">
                 <img class="img-thumbnail" src="assets/imgs/logos_gifs/<?=$row['logo']?>" alt="Card image cap">
                    <div class="card-body">
                         <h6 class="text-small"><?=$row['nombre_lugar']?></h6>
                    </div>
                </div>
                </a>
                </div>

<?php 
           $categoria_id = $row['categoria_id']; $subcategoria_id = $row['subcategoria_id'];
        } 
        if($open_col) {
            echo '</div></div>';
          }
          
          if($open_subcat){
            echo '</div></div>';
          }
          
          if($open_cat){
               echo '</div></div> ';
          }
?>
               


   