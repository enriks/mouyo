<?php
   require("main/page2.php");
require("../lib/database.php");
   Page2::header("");
?><br>
<!--Contenido principal de jugos-->
    <div class="container">
        <form method="post" name="JUGOS" enctype='multipart/form-data'>
       <div class="row ">
          <div class="col s10">
             
              <?php
                  $tipo=null;
           $sql="select * from tipo_jugo ";
           Page2::setCombo("tipo",$tipo,$sql);
              
           ?>
          </div>
        <div class="input-field col s2">
            <button type='submit' class='btn blue'><i class="material-icons">search</i></button>
        </div>
       </div>
    </form>
    </div>
    <div class="container">
        
        <!-- Cargamos los datos de la pagina -->
       <?php
        if(empty($_POST))
        {
            $jugo="<div class='row'>
             <div class='parallax'>
                 <!--img src='img/parallax/zumo_de_fruta.jpeg'-->
           </div>";
            $sql='select * from jugos order by nombre';
            $data2=Database::getRows($sql,null);
            foreach($data2 as $row)
            {
                $jugo.="<div class='col s4'>
          <div class='card'>
    <div class='card-image waves-effect waves-block waves-light'>
      <img class='hovereffect activator' src='data:image/*;base64,$row[imagen]'>
    </div>
    <div class='card-content'>
      <span class='card-title activator grey-text text-darken-4'>$row[nombre]<i class='material-icons right'>more_vert</i></span>
      <p><a href='jugo.php?id=".base64_encode($row['id_jugo'])."'>Ver jugo</a></p>
    </div>
    <div class='card-reveal'>
      <span class='card-title grey-text text-darken-4'>$row[nombre]<i class='material-icons right'>close</i></span>
      <p>$row[descripcion]</p>
    </div>
  </div></div>";
            }
        $jugo.="</div>";
        print($jugo);
        }
        else
        {
            $jugo="<div class='row'>
             ";
            $tipo=$_POST['tipo'];
            $sql='select * from jugos where id_tipojugo=? order by nombre';
            $params=array($tipo);
            $data2=Database::getRows($sql,$params);
            foreach($data2 as $row)
            {
                $jugo.="<div class='col s4'>
          <div class='card'>
    <div class='card-image waves-effect waves-block waves-light'>
      <img class='hovereffect activator' src='data:image/*;base64,$row[imagen]'>
    </div>
    <div class='card-content'>
      <span class='card-title activator grey-text text-darken-4'>$row[nombre]<i class='material-icons right'>more_vert</i></span>
      <p><a href='jugo.php?id=".base64_encode($row['id_jugo'])."'>Ver jugo</a></p>
    </div>
    <div class='card-reveal'>
      <span class='card-title grey-text text-darken-4'>$row[nombre]<i class='material-icons right'>close</i></span>
      <p>$row[descripcion]</p>
    </div>
  </div></div>";
            }
        $jugo.="</div>";
        print($jugo);
        }
        ?>
    </div>
    <br>
    <?php  
Page2::footer();?>
    