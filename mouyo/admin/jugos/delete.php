<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
verificador::permiso3($_SESSION['permisos']);
Page::header("Eliminar Jugo");
$fecha=date('Y-m-d H:i:s');
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
         $data=Database::getRow("select nombre from jugos where id_jugo=?",array($id));
        $alias=$data['nombre'];
		$sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Elimino el jugo $alias",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
        $sql2="update comentarios set estado=1 where id_jugo=?";
        $params2=array($id);
		$sql3="update detalle_bebida set estado=1 where id_jugo=?";
		$sql = "update jugos set estado=1 WHERE id_jugo = ?";
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