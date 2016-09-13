<!--Se llama el archivo que contiene la estructura básica HTML y sus links -->
<?php
require("../lib/database.php");
    require("main/page2.php");
Page2::header();
?>
<!--menu principal-->
<ul id='menu' class='center'>
	<div class='row'>
		<div class='col l1 s2'>
			<a><img width='150' class='col offset-l12' src='img/mouyo.png'></a>
		</div>
		<div class='col l10 s10'>
			<a href='#' data-tooltip='Ir al Menu' data-position='bottom' data-delay='50' data-activates='slide-out' class='button-collapse btn-floating btn-large  tooltipped'><i class='material-icons'>menu</i></a>
			<li data-menuanchor='firstPage' class='active'><a href='#firstPage'>Inicio </a></li>
			<li data-menuanchor='secondPage'><a href='#secondPage'>Ofertas Destacadas</a></li>
			<li data-menuanchor='3rdPage'><a href='#3rdPage'>Ingredientes</a></li>
			<li data-menuanchor='4thPage'><a href='#4thPage'>Jugos</a></li>
			<li data-menuanchor='5thPage'><a href='#5thPage'>Belleza y salud</a></li>
		</div>
	</div>
</ul>
<!-- Inicia el contenido del body, slider de imagenes-->
	<div id="fullpage" class="row">
       <div class="section col l12 s12 center" id="section0">
		     <img class="responsive-img " src="img/parallax/bienvenida.png">
       </div>
       <div class="section col l12 s12" id="section1">
		  <div class="row">
			  <div class="col l4">
			  <pre>
			  
			  </pre>
                   <?php
               $sql="select descuentos.fecha_inicio, descuentos.fecha_limite,jugos.imagen,jugos.nombre,jugos.precio, descuentos.descuento from jugos, descuentos where descuentos.id_jugo = jugos.id_jugo";
               $params=null;
               $data=Database::getRows($sql,$params);
               if($data != null)
               {
                   $slider="<div class='slider z-depth-3 teal lighten-3'>
                <ul class='slides'>";
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
               
               <div class="col l4  ">
				  <pre>
				  
				  </pre>
                   <?php
               $sql="select * from promociones";
               $params=null;
               $data=Database::getRows($sql,$params);
               if($data != null)
               {
                   $slider2="<div class='slider z-depth-3 red lighten-3'>
                <ul class='slides '>";
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
               
               <div class="col l4  ">
				   <pre>
				   
				   </pre>
                   <?php
               $sql="select * from jugos";
               $params=null;
               $data=Database::getRows($sql,$params);
               if($data != null)
               {
                   $slider2="<div class='slider z-depth-3 yellow lighten-4 '>
                <ul class='slides '>";
                   foreach($data as $dato)
                   {    
                   $slider2.="<li>
                    <img src='data:image/*;base64,$dato[imagen]' class=''> <!-- random image -->
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
       </div>
		<div class="breadcrumb yellow lighten-5"></div>
       <div class="section col l12 s12 center"  id="section2">
		   <pre>
		   
		   
		   
		   
		   </pre>
           <span><h1 class="white-text">Jugos preparados con los mejores ingredientes</h1></span>
		   <pre>
		   
		   
		   </pre>
		   <a class="waves-effect waves-light btn" href="ingredientes.php">Ver más</a>
		   <pre>
		   
		   
		   </pre>
		  
       </div>
       <div class="section col l12 s12" id="section3">
		   
    <pre>
	
	
	</pre>
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
             $jugo.="<div class='col m4 s4 center '>
         <img src='data:image/*;base64,$row[imagen]' class='responsive-img z-depth-3' alt='file not found'>
         <p class='black-text flow-text'>
             $row[descripcion]
         </p>
     </div>";
         }
         $jugo.="
		 </div>
		 ";
         print($jugo);
		  
     }
     ?>
		   
    
	   </div> 
	   <div class="section col l12 s12" id="section4">
		   <pre>
		   
		   
		   
		   
		   
		   
		   
		    Contenido no disponible
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   </pre>
		   <?php require 'inc/footer.php'; ?>
	   </div>
   </div>

<style>
    
    #section0,
	#section1,
	#section2,
	#section3,
	#section4{
		background-size: cover;
		background-attachment: fixed;
	}
        
    /* Defining each sectino background and styles
	* --------------------------------------- */
	
	#section0{
		background-image: url(img/parallax/zumo-naranja.png);
		padding: 0 0 0 0;
	}
    #section1{
		padding: 0 0 0 0;
    }
	#section2{
        background-image: url(img/parallax/frutas.jpg);
		padding: 0 0 0 0;
	}
	#section3{
        
		padding: 0 0 0 0;
	}
		
	#section4{
		background-image: url(img/parallax/zumos-3.jpg);
		padding: 0 0 0 0;
	}
	
</style> 
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../js/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="../js/jquery.fullPage.js"></script>
    <!--script type="text/javascript" src="../js/jquery.min.js"></script-->
    <!--script type="text/javascript" src="../js/jquery-ui.min.js"></script-->
    <!--script type="text/javascript" src="../js/jquery-3.1.0.js"></script>
    <!--script type="text/javascript" src="../js/jquery-3.1.0.min.js"></script-->
    <script src="../js/materialize.min.js"></script>
    <script src="../bin/materialize.js"></script>
    <script src="../js/parallax1.js"></script>
    <script src="../jade/lunr.min.js"></script>
    <script src="../js/init.js"></script>
    <script src="../js/prism.js"></script>
    <script src="../js/app.js"></script> 
    
</body>
</html>