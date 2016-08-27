<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../../lib/validator.php");

if(empty($_GET['id'])) 
{
    Page::header("Agregar Ingrediente");
    $id=null;
    $nombre=null;
    $descripcion=null;
    $archivo=null;
    $tipo=null;
}
else
{
    Page::header("Modificar Ingrediente");
    $id = base64_decode($_GET['id']);
    $sql = "SELECT * FROM ingrediente WHERE id_ingrediente = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $nombre = htmlentities($data['nombre']);
    $descripcion = htmlentities($data['descripcion']);
    $archivo=$data['imagen'];
    $tipo=htmlentities($data['tipo']);
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $nombre= htmlentities($_POST['nombre']);
     $descripcion= htmlentities($_POST['descripcion']);
     $archivo = $_FILES['imagen'];
     $tipo=$_POST['tipo'];
    
    try
    {
        if($nombre == null || $descripcion == null || $tipo == null)
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
            $sql = "INSERT INTO `ingrediente` (`nombre`, `descripcion`,tipo,imagen) VALUES(?,?,?,?)";
            $params = array($nombre, $descripcion,$tipo,$imagen);
        }
        else
        {
            $sql = "update ingrediente set nombre=?, descripcion=?,imagen=?,tipo=? where id_ingrediente=?";
            $params = array($nombre, $descripcion,$imagen,$tipo,$id);
        }
         Database::executeRow($sql, $params);
        header("location: index.php");
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
?>
<form method='post' class='row' enctype='multipart/form-data'>
    <div class='row'>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>add</i>
          	<input id='nombre' type='text' name='nombre' class='validate' length='100' maxlenght='100' value='<?php print($nombre); ?>' required/>
          	<label for='nombre'>Nombre</label>
        </div>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>description</i>
          	<input id='descripcion' type='text' name='descripcion' class='validate' length='600' maxlenght='600' value='<?php print($descripcion); ?>'/>
          	<label for='descripcion'>Descripción</label>
        </div>
    </div>
    <div class="row">
    <div class='input-field col s12 m6'>
    		    <?php
    		    $sql = "SELECT id_tipo, nombre FROM tipo_ingrediente";
    		    Page::setCombo("tipo", $tipo, $sql);
    		    ?>
    		</div>
        <div class='input-field col s12 m6'>
          	<div class='btn'>
            		<input type='file' name='imagen'>
      		  </div>
        		<div class='file-path-wrapper'>
          		  
        		</div>
        </div>
    </div>
    <a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
<?php
Page::footer();
?>