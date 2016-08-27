<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
verificador::permiso2($_SESSION['permisos']);
Page::header("Promociones");
?>
<!-- formulario de promociones-->
<form method="post" name="frmMostrarCategorias" class="center-align">
        <fieldset>
            <a class=" right waves-effect waves-light btn modal-trigger btn-floating btn-large red tooltipped" href="#modal11" data-tooltip="Ingresar nueva promoción" data-position="top" data-delay="50"><i class="large material-icons">add</i></a>
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
        <h4>Agrege los datos de la promoción</h4>
        <div class='input-field col s12'>
          	<i class='material-icons prefix'>add</i>
          	<input id='titulo' type='text' name='titulo' class='validate' length='100' maxlenght='100' required/>
          	<label for='titulo'>Titulo</label>
        </div>
        <div class='input-field col s12'>
          	<i class='material-icons prefix'>description</i>
          	<input id='descripcion' type='text' name='descripcion' class='validate' length='600' maxlenght='600' />
          	<label for='descripcion'>Descripción</label>
        </div>
    </div>
    <div class='row'>
        <div class='input-field col s12' >
            <i class='material-icons prefix'>date_range</i>
            <input id='fecha_limite' type='date' name='fecha_limite' class='validate datepicker'required/>
            <label for='fecha_limite'>Fecha Limite</label>
        </div>
        <div class='input-field col s12'>
          	<div class='btn'>
            		<span>Imagen</span>
            		<input type='file' name='imagen'>
      		  </div>
        		<div class='file-path-wrapper'>
          		  <input class='file-path validate' type='text' placeholder='1200x1200px máx., 2MB máx., PNG/JPG/GIF'>
        		</div>
        </div>
    </div>
    <a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
</div>
</div>

<!--codigo php para promomciones-->
<?php
if(!empty($_POST))
{
	$search = trim($_POST['buscar']);
	$sql = "SELECT * FROM promociones WHERE titulo LIKE ? ORDER BY titulo";
	$params = array("%$search%");
}
else
{
	$sql = "SELECT * FROM promociones ORDER BY titulo";
	$params = null;
}
$data=Database::getRows($sql,$params);
if($data != null)
{
    $tabla="";
    foreach($data as $row)
		{
            $tabla .="<ul class='collection'>";
                    $tabla .="<br><a class='btn waves-effect waves-light indigo darken-4' href='save.php?               id=".base64_encode($row['id_promocion'])."'>Modificar<i id='img_btn' class='material-icons'>mode_edit</i></a>";
                    $tabla .="<a class='btn waves-effect waves-light red darken-1' href='delete.php?id=".base64_encode($row['id_promocion'])."'>Eliminar<i id='img-btn' class='material-icons'>delete</i></a>";
                    $tabla .="<li class='collection-item dismissable'>";
                    $tabla .="<div>";
                    $tabla .="<div class='row'>";
                    $tabla .="<div class='col m4 s8'>";
                    $tabla .="<img id='foto_perfil imagen_video'
                    src='data:image/*;base64,$row[imagen]'
                    class='responsive-img'>";
                    $tabla .="</div>";
                    $tabla .="<div class='col m8 s12'>";
                    $tabla .="<p id='texto-tabla'>";
                    $tabla .="<strong>Título: 
                    </strong>$row[titulo]<br>";
                    $tabla .="<strong>Descripción:
                    </strong>$row[descripcion]<br>";
                    $tabla .="<strong>Fecha limite:
                    </strong>$row[fecha_limite]<br>";
                    $tabla .="</p>";
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