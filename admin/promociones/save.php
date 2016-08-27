<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../../lib/validator.php");
require("../lib/verificador.php");
verificador::permiso2($_SESSION['permisos']);
/* codigo para guardar y modificar promociones */
if(empty($_GET['id'])) 
{
    Page::header("Agregar Promocion");
    $id=null;
    $titulo=null;
    $descripcion=null;
    $archivo=null;
    $fecha_limite=null;
}
else
{
    Page::header("Modificar Promocion");
    $id = base64_decode($_GET['id']);
    $sql = "SELECT * FROM promociones WHERE id_promocion = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $titulo =  htmlentities($data['titulo']);
    $descripcion =  htmlentities($data['descripcion']);
    $archivo= $data['imagen'];
    $fecha_limite= htmlentities($data['fecha_limite']);
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $titulo= htmlentities($_POST['titulo']);
     $descripcion= htmlentities($_POST['descripcion']);
     $archivo=$_FILES['imagen'];
     $fecha_limite= htmlentities($_POST['fecha_limite']);
    
    try
    {
        if($titulo == null || $descripcion == null || $fecha_limite == null)
        {
            throw new Exception("Datos incompletos");
        }
        elseif( $archivo['name'] != null)
        {
            $base64 = Validator::validateImage($archivo);
           	if($base64 != false)
           	{
           	    $imagen = $base64;
           	}
           	else
           	{
           	    throw new Exception("La imagen seleccionada no es valida.");
           	}
        }
        if($id==null)
        {
            $sql = "INSERT INTO promociones(titulo,descripcion,imagen,fecha_limite) VALUES(?,?,?,?)";
            $params = array($titulo, $descripcion,$imagen,$fecha_limite);
        }
        else
        {
            $sql = "update promociones set titulo=?, descripcion=?,imagen=?,fecha_limite=? where id_promocion=?";
            $params = array($titulo, $descripcion,$imagen,$fecha_limite,$id);
        }
         Database::executeRow($sql, $params);
        @header("location: index.php");
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
?>
<!--formulario promociones -->
<form method='post' class='row' enctype='multipart/form-data'>
    <div class='row'>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>add</i>
          	<input id='titulo' type='text' name='titulo' class='validate' length='100' maxlenght='100' value='<?php print($titulo); ?>' required/>
          	<label for='titulo'>Titulo</label>
        </div>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>description</i>
          	<input id='descripcion' type='text' name='descripcion' class='validate' length='600' maxlenght='600' value='<?php print($descripcion); ?>'/>
          	<label for='descripcion'>Descripción</label>
        </div>
    </div>
    <div class='row'>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>date_range</i>
            <input id='fecha_limite' type='date' name='fecha_limite' class='validate datepicker' value='<?php print $fecha_limite; ?>' required/>
            <label for='fecha_limite'>Fecha Limite</label>
        </div>
        <div class='input-field col s12 m6'>
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
<?php
Page::footer();
?>