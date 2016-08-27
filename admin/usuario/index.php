<!--llamamos los archivos necesarios-->
<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
verificador::permiso1($_SESSION['permisos']);
Page::header("Usuarios");
?>
<!--formulario agregar y buscar usuario-->
<form method="post" name="frmMostrarCategorias" class="center-align">
        <fieldset>
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
<?php
if(!empty($_POST))
{
	$search = trim($_POST['buscar']);
	$sql = "SELECT * FROM usuario WHERE alias LIKE ? ORDER BY alias";
	$params = array("%$search%");
}
else
{
	$sql = "SELECT * FROM usuario ORDER BY alias";
	$params = null;
}
$data=Database::getRows($sql,$params);
if($data != null)
{
    /*cargamos la tabla de usuarios*/
    $tabla="";
    foreach($data as $row)
		{
            $tabla .="<ul class='collection'>";
                    
                    $tabla .="<li class='collection-item dismissable'>";
                    $tabla .="<div>";
                    $tabla .="<div class='row'>";
                    $tabla .="<div class='col m4 s8'>";
                    $tabla .="<img id='foto_perfil imagen_video'
                    src='data:image/*;base64,$row[foto_perfil]'
                    class='responsive-img'>";
                    $tabla .="</div>";
                    $tabla .="<div class='col m8 s12'>";
                    $tabla .="<p id='texto-tabla'>";
                    $tabla .="<strong>Nombre: 
                    </strong>$row[nombre]<br>";
                    $tabla .="<strong>Apellido:
                    </strong>$row[apellido]<br>";
                    $tabla .="<strong>Alias:
                    </strong>$row[alias]<br>";
                    $tabla .="<strong>Correo:
                    </strong>$row[correo]<br>";
                    $tabla .="<strong>Fecha Nacimiento:
                    </strong>$row[fecha_nacimiento]<br>";
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