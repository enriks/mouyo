<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../../lib/validator.php");
require("../lib/verificador.php");
verificador::permiso3($_SESSION['permisos']);
/*Condiciones para relizar operaciones en jugos.php*/
if(empty($_GET['id'])) 
{
    Page::header("Agregar Tipo de Jugo");
    $id = null;
    $nombre = null;
    $descripcion = null;
}
else
{
    Page::header("Modificar Tipo de Jugo");
    $id = $_GET['id'];
    $sql = "SELECT * FROM tipo_jugo WHERE id_tipojugo = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $nombre = htmlentities($data['nombre']);
    $descripcion = htmlentities($data['descripcion']);
}

if(!empty($_POST))
{
    $_POST = Validator::validateForm($_POST);
  	$nombre = htmlentities($_POST['nombre']);
  	$descripcion = htmlentities($_POST['descripcion']);
    if($descripcion == "")
    {
        $descripcion = null;
    }

    try 
    {
      	if($nombre == "")
        {
            throw new Exception("Datos incompletos.");
        }

        if($id == null)
        {
        	$sql = "INSERT INTO tipo_jugo(nombre, descripcion) VALUES(?, ?)";
            $params = array($nombre, $descripcion);
        }
        else
        {
            $sql = "UPDATE categorias SET nombre = ?, descripcion = ? WHERE id_tipojugo = ?";
            $params = array($nombre, $descripcion, $id);
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
<!--formulario principal-->
<form method='post' class='row' enctype='multipart/form-data'>
    <div class='row'>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>add</i>
          	<input id='nombre' type='text' name='nombre' class='validate' length='300' maxlenght='300' value='<?php print($nombre); ?>' required/>
          	<label for='nombre'>Nombre</label>
        </div>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>description</i>
          	<input id='descripcion' type='text' name='descripcion' class='validate' length='500' maxlenght='500' value='<?php print($descripcion); ?>'/>
          	<label for='descripcion'>Descripción</label>
        </div>
    </div>
    <a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
<?php
Page::footer();
?>