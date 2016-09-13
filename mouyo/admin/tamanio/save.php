<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../../lib/validator.php");
require("../lib/verificador.php");
verificador::permiso3($_SESSION['permisos']);

/*operaciones para tamañio*/

if(empty($_GET['id'])) 
{
    Page::header("Agregar Tamaño de Bebida");
    $id=null;
    $precio=null;
    $tamanio=null;
}
else
{
    Page::header("Modificar Tamaño de Bebida");
    $id = $_GET['id'];
    $sql = "SELECT * FROM tamanio WHERE id_tamanio = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $precio = htmlentities($data['precio']);
    $tamanio= htmlentities($data['tamanio']);
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $precio=htmlentities($_POST['precio']);
     $tamanio=htmlentities($_POST['tamanio']);
    
    try
    {
        if($precio == null || $tamanio == null)
        {
            throw new Exception("Datos incompletos");
        }
        elseif($id==null)
        {
            $sql = "INSERT INTO tamanio(precio,tamanio) VALUES(?,?)";
            $params = array($precio, $tamanio);
        }
        else
        {
            $sql = "update tamanio set precio=?, tamanio=? where id_tamanio=?";
            $params = array($precio, $tamanio, $id);
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
<!--formulario de registro-->
<form method='post' class='row' enctype='multipart/form-data'>
    <div class='row'>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>shopping_cart</i>
          	<input id='precio' type='number' name='precio' class='validate' max='999.99' min='0.01' step='any' value='<?php print($precio); ?>' required/>
          	<label for='precio'>Precio ($)</label>
        </div>
    </div>
    <div class='row'>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>add</i>
          	<input id='tamanio' type='text' name='tamanio' class='validate' length='300' maxlenght='300'value='<?php print($tamanio); ?>'/>
          	<label for='tamanio'>Tamaño</label>
        </div>
    </div>
    <a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
<?php
Page::footer();
?>