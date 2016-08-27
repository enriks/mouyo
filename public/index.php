<!--Se llama el archivo que contiene la estructura básica HTML y sus links -->
<?php
require("../lib/database.php");
    require("main/page2.php");
Page2::header();
?>
<!-- Inicia el contenido del body, slider de imagenes-->
<br>
   <div class="center-align">
       <div class="row">
           <div class="col m4 ">
           <?php
               $sql="select descuentos.fecha_inicio, descuentos.fecha_limite,jugos.imagen,jugos.nombre,jugos.precio, descuentos.descuento from jugos, descuentos where descuentos.id_jugo = jugos.id_jugo";
               $params=null;
               $data=Database::getRows($sql,$params);
               if($data != null)
               {
                   $slider="<div class='slider'>
                <ul class='slides z-depth-3 card-panel'>";
                   foreach($data as $dato)
                   {    
                   $slider.="<li>
                    <img src='data:image/*;base64,$dato[imagen]'> <!-- random image -->
                    <div class='caption center-align'>
                      <h3 class='stroke2'>$dato[nombre]</h3>
                      <h5 class='stroke light grey-text text-lighten-3'>A $dato[descuento]% de descuento desde $dato[fecha_inicio] hasta $dato[fecha_limite]</h5>
                    </div>
                  </li>";
                   }
                   $slider.=" </ul>
  </div>";
               }
               else
               {
                   $slider="";
               }
               print $slider;
               ?> 
       </div>
       <div class="col m4">
           <?php
               $sql="select * from promociones";
               $params=null;
               $data=Database::getRows($sql,$params);
               if($data != null)
               {
                   $slider2="<div class='slider'>
                <ul class='slides z-depth-3 card-panel'>";
                   foreach($data as $dato)
                   {    
                   $slider2.="<li>
                    <img src='data:image/*;base64,$dato[imagen]'> <!-- random image -->
                    <div class='caption center-align'>
                      <h3 class='stroke2'>$dato[titulo]</h3>
                      <h5 class='stroke light grey-text text-lighten-3'>$dato[descripcion], Valido hasta $dato[fecha_limite]</h5>
                    </div>
                  </li>";
                   }
                   $slider2.=" </ul>
  </div>";
               }
               else
               {
                   $slider2="";
               }
               print $slider2;
               ?> 
       </div>
       <div class="col m4">
       <?php
               $sql="select * from jugos";
               $params=null;
               $data=Database::getRows($sql,$params);
               if($data != null)
               {
                   $slider2="<div class='slider'>
                <ul class='slides z-depth-3 card-panel'>";
                   foreach($data as $dato)
                   {    
                   $slider2.="<li>
                    <img src='data:image/*;base64,$dato[imagen]'> <!-- random image -->
                    <div class='caption center-align'>
                      <h3 class='stroke2'>$dato[nombre]</h3>
                    </div>
                  </li>";
                   }
                   $slider2.=" </ul>
                </div>";
               }
               else
               {
                   $slider2="";
               }
               print $slider2;
               ?>
       </div>
       </div>
   </div><br>
 <div class="container">
   <?php
     
     /*Se manda a llamar el archivo de conexion a la base de datos y se ejecutan las consultas de la informacion de jugos*/ 
     $sql="select * from jugos order by nombre";
     $data=Database::getRows($sql,null);
     if($data != null)
     {
         $jugo="";
         $jugo.="<div class='row'>
            <div class=''><img></div>";
         foreach($data as $row)
         {
             $jugo.="<div class='col m4 s4'>
         <img src='data:image/*;base64,$row[imagen]' class='responsive-img z-depth-5' alt='te la kreiste we xd'>
         <p class='black-text'>
             $row[descripcion]
         </p>
     </div>";
         }
         $jugo.="</div>";
         print($jugo);
     }
     ?>
 </div>

        <?php require'inc/footer.php'; ?>

    <script src="../js/jquery-2.2.3.min.js"></script>
    <script src="../js/materialize.min.js"></script>
    <script src="../bin/materialize.js"></script>
    <script src="../js/parallax1.js"></script>
    <script src="../jade/lunr.min.js"></script>
    <script src="../js/init.js"></script>
    <script src="../js/prism.js"></script>
    <script src="../js/app.js"></script> 
    
</body>
</html>