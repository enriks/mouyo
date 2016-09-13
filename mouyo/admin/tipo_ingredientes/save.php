<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../../lib/validator.php");
require("../lib/verificador.php");
verificador::permiso3($_SESSION['permisos']);
/*operaciones para tipo ingredientes*/
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
    $precio = htmlentities($data['precio']);
}

if(!empty($_POST))
{
    $_POST = Validator::validateForm($_POST);
  	$nombre = htmlentities($_POST['nombre']);
  	$precio = htmlentities($_POST['precio']);

    try 
    {
      	if($nombre == "")
        {
            throw new Exception("Datos incompletos.");
        }

        if($id == null)
        {
        	$sql = "INSERT INTO tipo_ingrediente(nombre, precio) VALUES(?, ?)";
            $params = array($nombre, $precio);
        }
        else
        {
            $sql = "UPDATE categorias SET nombre = ?, precio = ? WHERE id_tipo = ?";
            $params = array($nombre, $precio, $id);
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
<!--formulario tipo ingredientes-->
<form method='post' class='row' enctype='multipart/form-data'>
    <div class='row'>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>add</i>
          	<input id='nombre' type='text' name='nombre' class='validate' length='300' maxlenght='300' value='<?php print($nombre); ?>' required/>
          	<label for='nombre'>Nombre</label>
        </div>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>shopping_cart</i>
          	<input id='precio' type='number' name='precio' class='validate' max='999.99' min='0.01' step='any' value='<?php print($precio); ?>' required/>
          	<label for='precio'>Precio ($)</label>
        </div>
    </div>
    <a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
<?php
Page::footer();
?>