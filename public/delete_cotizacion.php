<?php
ob_start();
require("main/page2.php");
    require("../lib/database.php");
Page2::header();

if(!empty($_GET['id']) && !empty($_GET['total'])) 
{
    $id =base64_decode( $_GET['id']);
    $total =base64_decode( $_GET['total']);
}
else
{
    header("location: index.php");
}

if(!empty($_POST))
{
	$id = $_POST['id'];
	try 
	{
		$sql = "update cotizacion set estado=1 WHERE id_cotizacion= ?";
		$sql2 = "update detalle_cotizacion set estado=1 where id_cotizacion=?";
	    $params = array($id);
	    Database::executeRow($sql2, $params);
	    Database::executeRow($sql, $params);
	    @header("location: cotizacion.php");
	} 
	catch (Exception $error) 
	{
		print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
	}
}
?>
<form method='post' class='row center-align'>
	<input type='hidden' name='id' value='<?php print($id); ?>'/>
	<?php
        $select="select * from cotizacion where id_cotizacion=?";
        $selectq="SELECT cotizacion.nombre nombre_cotizacion,jugos.nombre nombre_jugo, jugos.imagen imagen_jugo,jugos.precio nombre_tamanio,detalle_cotizacion.id_jugo,detalle_cotizacion.cantidad from jugos,cotizacion,detalle_cotizacion where detalle_cotizacion.id_cotizacion = ? and detalle_cotizacion.id_jugo = jugos.id_jugo and detalle_cotizacion.id_cotizacion=cotizacion.id_cotizacion  ";
    $paras=array($id);
    $datra=Database::getRow($select,$paras);
    $datra2=Database::getRows($selectq,$paras);
    $printo="<h4>¿Desea eliminar $datra[nombre]?</h4>
    <h5>Con los jugos</h5><table style='width:100%' class='bordered'><thead>
          <tr>
              <th data-field='nombre'>Nombre</th>
              <th data-field='tamanio'>Tamaño</th>
              <th data-field='cantidad'>Cantidad</th>
              <th data-field='total'>Total</th>
          </tr>
        </thead><tbody>";
    foreach($datra2 as $roww)
    {
        $printo.="<tr>
            <td>$roww[nombre_jugo]</td>
            <td>$roww[nombre_tamanio]</td>
            <td>$roww[cantidad]</td>
            <td>$total</td>
          </tr>";
    }
    $printo.=" </tbody>
      </table>";
    print $printo;
    ?>
	
	<button type='submit' class='btn red'><i class='material-icons right'>done</i>Si</button>
	<a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>No</a>
</form>
<?php
Page2::footer();
?>