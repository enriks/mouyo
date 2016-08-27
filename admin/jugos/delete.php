<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
verificador::permiso3($_SESSION['permisos']);
Page::header("Eliminar Jugo");

if(!empty($_GET['id'])) 
{
    $id = base64_decode($_GET['id']);
}
else
{
    @header("location: index.php");
}

if(!empty($_POST))
{
	$id = $_POST['id'];
	try 
	{
        $sql2="delete from comentarios where id_jugo=?";
        $params2=array($id);
		$sql3="delete from detalle_bebida where id_jugo=?";
		$sql = "DELETE FROM jugos WHERE id_jugo = ?";
	    $params = array($id);
        Database::executeRow($sql2,$params);
	    Database::executeRow($sql3,$params);
	    Database::executeRow($sql, $params);
	    @header("location: index.php");
	} 
	catch (Exception $error) 
	{
		print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
	}
}
?>
<form method='post' class='row'>
	<input type='hidden' name='id' value='<?php print($id); ?>'/>
	<button type='submit' class='btn red'><i class='material-icons right'>done</i>Si</button>
	<a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>No</a>
</form>
<?php
Page::footer();
?>