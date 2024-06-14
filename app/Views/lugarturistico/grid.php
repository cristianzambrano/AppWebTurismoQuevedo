  <?php
  $categoria_id = 0; $subcategoria_id = 0; $open_cat=false; $open_subcat=false; $open_col=false;
  foreach ($data as $row) {
   
    if($categoria_id != $row['categoria_id']){

      if($open_col) {
        echo '</div>';
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
      echo '<div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;" >
      <div class="card-header" style="text-align:center"><b><h4>'.$row['categoria'].'</h4></b></div>
      <div class="tr-card-body">';
    }

    if($subcategoria_id != $row['subcategoria_id']){

      if($open_col) {
        echo '</div>';
        $open_col=false;
     }

      if($open_subcat){
        echo '</div>
       </div> ';
      }
      $open_subcat = true;
      echo '<div class="card" style="margin: 0.5em 0.5em 0.5em 0.5em;">
        <div class="card-header"><b>'.$row['subcategoria'].'</b></div>
        <div class="tr-card-body">';
      
      $col=0;
    }
    
    if(!$open_col) {
        echo '<div class="row pb-3 mb-2" style="margin: 0.5em 0.5em 0.5em 0.5em;">';
        $open_col=true;
    }
              
    echo '<div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <!-- Card-->
                <div class="card rounded shadow-sm border-0 text-center">
                  <div class="card-body p-4">
                    <a class="text-dark" href="javascript:ajaxShowLugarTuristicoModal('.$row['id'].',\''.$row['nombre_lugar'].'\')">
                    <img src="assets/imgs/logos_gifs/'.$row['logo'].'" alt="" class="img-thumbnail" >
                    <p class="text-wrap "><h5>'.$row['nombre_lugar'].'</h5></p></a>
                    <ul class="list-inline small">';
              
                    for($i=1; $i<=$row['puntuacion'] && $i<=5;$i++)
                      echo '<li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>';

                    for($i=$row['puntuacion']+1; $i<=5;$i++)
                      echo '<li class="list-inline-item m-0"><i class="fa fa-star-o text-success"></i></li>';
                      
                    echo '</ul>
                   
                    <div style="text-align:center">
                    <ul class="social mb-0 list-inline mt-3">
                      <li class="list-inline-item m-1">';
                      if($row['whatsapp']!="") echo '<a href="'.$row['whatsapp'].'" target="_blank" class="social-link">';
                      echo '<i class="fa fa-whatsapp fa-2x"></i>';
                      if($row['whatsapp']!="") echo'</a>';
                      echo '</li>

                      <li class="list-inline-item m-1">';
                      if($row['google_maps']!="") echo '<a href="'.$row['google_maps'].'" target="_blank" class="social-link">';
                      echo '<i class="fa fa-globe fa-2x"></i>';
                      if($row['google_maps']!="") echo '</a>';
                      echo '</li>
                      
                      <li class="list-inline-item m-1">';
                      if($row['delivery']!="") echo '<a href="'.$row['delivery'].'" target="_blank" class="social-link">';
                      echo '<i class="fa fa-motorcycle fa-2x"></i>';
                      if($row['delivery']!="") echo '</a>';
                      echo '</li>
                   </ul>
                   </div>
                  </div>
                </div>
            </div>';

      
      

    $categoria_id = $row['categoria_id']; $subcategoria_id = $row['subcategoria_id'];
}

if($open_col) {
  echo '</div>';
}

if($open_subcat){
  echo '</div></div>';
}

if($open_cat){
     echo '</div></div> ';
}
?>

