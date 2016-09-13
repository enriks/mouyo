<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
verificador::permiso3($_SESSION['permisos']);
Page::header("Tipo de Ingrediente");
?>
<!--codigo hmtl de tipo ingrediente-->
       <form method="post" name="frmMostrarCategorias" class="center-align">
        <fieldset>
            <a href="save.php" class="btn waves-effect waves-light btn-large indigo darken-4">Agregar Tipo de Ingrediente</a>
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
<!--codigo php para tipo ingrediente-->
<?php
if(!empty($_POST))
{
	$search = trim($_POST['buscar']);
	$sql = "SELECT * FROM tipo_ingrediente WHERE nombre LIKE ? and estado=0 ORDER BY nombre";
	$params = array("%$search%");
}
else
{
	$sql = "SELECT * FROM tipo_ingrediente where estado=0 ORDER BY nombre";
	$params = null;
}
$data=Database::getRows($sql,$params);
if($data != null)
{
    $tabla="";
    foreach($data as $row)
		{
            $tabla .="<ul class='collection'>";
            $tabla .="<li class='collection-item dismissable'>";
            $tabla .="<div>";
            $tabla .="<p id='texto-tabla'>";
            $tabla .="<strong>Nombre: 
            </strong>$row[nombre]<br>";
            $tabla .="<strong>Precio:
            </strong> $row[precio]<br>";
            $tabla .="</p>";
            $tabla .="<a class='btn waves-effect waves-light indigo darken-4' href='save.php?id=".base64_encode($row['id_tipo'])."'>Modificar<i id='img_btn' class='material-icons'>mode_edit</i></a>";
            $tabla .="<a class='btn waves-effect waves-light red darken-1' href='delete.php?id=".base64_encode($row['id_tipo'])."'>Eliminar<i id='img-btn' class='material-icons'>delete</i></a>";
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