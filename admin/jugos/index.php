<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
$nombre=null;
    $tipo=null;
    $archivo=null;
    $precio=null;
    $descripcion=null;
verificador::permiso3($_SESSION['permisos']);
Page::header("Jugos");
?>
<!-- formulario de jugos-->
<form method="post" name="frmMostrarCategorias" class="center-align">
        <fieldset>
            <a class=" right waves-effect waves-light btn modal-trigger btn-floating btn-large red tooltipped" href="#modal11" data-tooltip="Agregar nuevo Jugo" data-position="top" data-delay="50"><i class="large material-icons">add</i></a>
            <a href="../tipo_jugos/" class="btn waves-effect waves-light btn-large indigo darken-4">Tipos de jugos</a>
            <a href="../puente/save.php" class="btn waves-effect waves-light btn-large indigo darken-4">Agregar ingrediente a un jugo</a>
            <div class='input-field col s6 m4'>
      	<i class='material-icons prefix'>search</i>
      	<input id='buscar' type='text' name='buscar' class='validate'/>
      	<label for='buscar'>Búsqueda</label>
    </div>
    <div class='input-field col s6 m4'>
    	<button type='submit' class='btn grey left'><i class='material-icons right'>pageview</i>Aceptar</button> 	
  	</div>
    </fieldset>
</form>
<div id="modal11" class="modal">
    <div class="modal-content">
        <form method='post' class='row' action="save.php" enctype='multipart/form-data'>
    <div class='row'>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>add</i>
          	<input id='nombre' type='text' name='nombre' class='validate' length='100' maxlenght='100' value='<?php print($nombre); ?>' required/>
          	<label for='nombre'>Nombre</label>
        </div>
        <div class='input-field col s12 m6'>
          	<?php
    		    $sql = "SELECT id_tipojugo, nombre FROM tipo_jugo";
    		    Page::setCombo("tipo", $tipo, $sql);
    		    ?>
        </div>
    </div>
    <div class="row">
    <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>shopping_cart</i>
          	<input id='precio' type='number' name='precio' class='validate' max='999.99' min='0.01' step='any' value='<?php print($precio); ?>' required/>
          	<label for='precio'>Precio ($)</label>
        </div>
        <div class='input-field col s12 m6'>
          	<div class='btn'>
            		
            		<input type='file' name='imagen' required>
      		  </div>
        		<div class='file-path-wrapper'>
          		  <input class='file-path validate' type='text' placeholder='1200x1200px máx., 2MB máx., PNG/JPG/GIF'>
        		</div>
        </div>
    </div>
    <div class="row">
        <div class='input-field col s12'>
          	<i class='material-icons prefix'>description</i>
          	<input id='descripcion' type='text' name='descripcion' class='validate' length='600' maxlenght='600' value='<?php print($descripcion); ?>'/>
          	<label for='descripcion'>Descripción</label>
        </div>
    </div>
    <a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
</div>
</div>
<!--codigo php para jugos-->
<?php
if(!empty($_POST))
{
	$search = trim($_POST['buscar']);
	$sql = "SELECT jugos.id_jugo,jugos.nombre nombre_jugo,jugos.descripcion descripcion_jugo,jugos.imagen,jugos.precio, jugos.tamanio,tamanio.tamanio nombre_tamanio,tipo_jugo.nombre nombre_tipojugo FROM jugos,tipo_jugo,tamanio where jugos.id_tipojugo=tipo_jugo.id_tipojugo and jugos.tamanio=tamanio.id_tamanio AND jugos.nombre LIKE ? ORDER BY jugos.nombre";
	$params = array("%$search%");
    $ingre="SELECT ingrediente.nombre nombre_ingrediente from ingrediente,detalle_bebida,jugos WHERE jugos.id_jugo = detalle_bebida.id_jugo and ingrediente.id_ingrediente = detalle_bebida.id_ingrediente";
}
else
{
	$sql = "SELECT jugos.id_jugo,jugos.nombre nombre_jugo,jugos.descripcion descripcion_jugo,jugos.imagen,jugos.precio,tipo_jugo.nombre nombre_tipojugo FROM jugos,tipo_jugo where jugos.id_tipojugo=tipo_jugo.id_tipojugo   ORDER BY jugos.nombre";
	$params = null;
    $ingre="SELECT ingrediente.nombre nombre_ingrediente from ingrediente,detalle_bebida,jugos WHERE jugos.id_jugo = detalle_bebida.id_jugo and ingrediente.id_ingrediente = detalle_bebida.id_ingrediente";
}
$data = Database::getRows($sql, $params);
$data2 =Database::getRows($ingre, $params);
if($data != null)
{
    $tabla="";
    foreach($data as $row)
		{
            $tabla .="<ul class='collection'>";
            $tabla .="<br><a class='btn waves-effect waves-light indigo darken-4' href='save.php?               id=".base64_encode($row['id_jugo'])."'>Modificar<i id='img_btn' class='material-icons'>mode_edit</i></a>";
            $tabla .="<a class='btn waves-effect waves-light red darken-1' href='delete.php?id=".base64_encode($row['id_jugo'])."'>Eliminar<i id='img-btn' class='material-icons'>delete</i></a>";
            $tabla .="<li class='collection-item dismissable'>";
            $tabla .="<div>";
            $tabla .="<div class='row'>";
            $tabla .="<div class='col m4 s8'>";
            $tabla .="<img id='foto_perfil imagen_video'
            src='data:image/*;base64,$row[imagen]'
            class='responsive-img'>";
            $tabla .="<strong>Título: 
            </strong><h4>$row[nombre_jugo]</h4>";
            $tabla .="</div>";
            $tabla .="<div class='col m8 s12'>";
            $tabla .="<p id='texto-tabla'>";
            $tabla .="<strong>Descripción:
            </strong>$row[descripcion_jugo]<br>";
            $tabla .="<strong>Tipo:
            </strong>$row[nombre_tipojugo]<br>";
            $tabla .="<strong>Precio:
            </strong>$row[precio]<br>";
            $tabla .="</p>";
            $tabla .="<ul class='collapsible' data-collapsible='accordion'>";
            $tabla .="<li>";
            $tabla .="<div class='collapsible-header'><i class='material-icons'>local_dining</i>Ingredientes</div>";
            $tabla.="<div class='collapsible-body'>";
            foreach($data2 as $row2)
		      {
                $tabla .="
                  <p>-$row2[nombre_ingrediente]</p>
                ";
            }
            $tabla.="</div></li>
                </ul>";
            $tabla .="</div>";
            $tabla .="</div>";
            $tabla .= "</div>";
            $tabla .="</li>";
            $tabla .="</ul>";                  
        }
            print($tabla);
    }
else
{
    print("<div class='card-panel yellow'><i class='material-icons left'>warning</i>No hay registros.</div>");
}
Page::footer();
?>
