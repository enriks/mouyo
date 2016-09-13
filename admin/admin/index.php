<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
verificador::permiso1($_SESSION['permisos']);
Page::header("Administradores");
$alias=null;
    $clave=null;
    $archivo=null;
    $correo=null;
    $fecha_nacimiento="";
$permiso="";
?>
<form method="post" name="frmMostrarCategorias" class="center-align">
        <fieldset>
            <!--a href="save.php" class="btn waves-effect waves-light btn-large indigo darken-4">Agregar Administrador</a-->
            <a class=" right waves-effect waves-light btn modal-trigger btn-large red tooltipped" href="#modal11" data-tooltip="Agregar nuevo usuario Admin" data-position="top" data-delay="50">Agregar administrador</a>
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
        <form method='post' action="save.php" class='row' enctype='multipart/form-data'>
    <div class='row'>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>perm_identity</i>
            <input id='alias' type='text' name='alias' class='validate' autocomplete="off" length='50' maxlenght='50' value='<?php print($alias); ?>' required/>
            <label for='alias'>Alias</label>
        </div>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>email</i>
            <input id='correo' type='email' name='correo' class='validate' autocomplete="off" length='100' maxlenght='100' value='<?php print($correo); ?>' required/>
            <label for='correo'>Correo</label>
        </div>
    </div>
    <div class='row'>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>lock</i>
            <input id='clave1' type='password' name='clave1' class='validate' autocomplete="off" length='25' maxlenght='25' required/>
            <label for='clave1'>Clave</label>
        </div>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>lock</i>
            <input id='clave2' type='password' name='clave2' class='validate' autocomplete="off" length='25' maxlenght='25' required/>
            <label for='clave2'>Confirmar clave</label>
        </div>
    </div>
    <div class='row'>
        <div class='input-field col s12 '>
            <i class='material-icons prefix'>date_range</i>
            <input id='fecha_nacimiento' type='date' name='fecha_nacimiento' class='validate datepicker' autocomplete="off" value='<?php print( $fecha_nacimiento);?>' required/>
            <label for='fecha_nacimiento'>Fecha de nacimiento</label>
        </div>
    </div>
    <div class="row">
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
    <div class="col s12 ">
            <?php
    		    $sql = "SELECT id_permiso,nombre FROM permisos";
    		    Page::setCombo("permiso", $permiso, $sql);
    		    ?>
        </div>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
</div>
</div>

<?php
if(!empty($_POST))
{
	$search = trim($_POST['buscar']);
	$sql = "SELECT * FROM admin WHERE nombre LIKE ? ORDER BY nombre";
	$params = array("%$search%");
}
else
{
	$sql = "SELECT * FROM admin where estado=0 ORDER BY alias";
	$params = null;
}
$data=Database::getRows($sql,$params);
if($data != null)
{
    $tabla="";
    foreach($data as $row)
		{
            $tabla .="<ul class='collection'>";
                    $tabla .="<br><a class='btn waves-effect waves-light indigo darken-4' href='save.php?               id=".base64_encode($row['id_admin'])."'>Modificar<i id='img_btn' class='material-icons'>mode_edit</i></a>";
                    $tabla .="<a class='btn waves-effect waves-light red darken-1' href='delete.php?id=".base64_encode($row['id_admin'])."'>Eliminar<i id='img-btn' class='material-icons'>delete</i></a>";
                    $tabla .="<li class='collection-item dismissable'>";
                    $tabla .="<div>";
                    $tabla .="<div class='row'>";
                    $tabla .="<div class='col m4 s8'>";
                    $tabla .="<img id='foto_perfil imagen_video'
                    src='data:image/*;base64,$row[foto]'
                    class='responsive-img'>";
                    $tabla .="</div>";
                    $tabla .="<div class='col m8 s12'>";
                    $tabla .="<p id='texto-tabla'>";
                    $tabla .="<strong>Nombre: 
                    </strong>$row[alias]<br>";
                    $tabla .="<strong>Correo:
                    </strong>$row[correo]<br>";
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