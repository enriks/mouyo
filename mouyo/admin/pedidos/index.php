<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
verificador::permiso4($_SESSION['permisos']);
Page::header("Cotizaciones");

//solo modificar params
$sql1="SELECT detalle_cotizacion.id_jugo,detalle_cotizacion.cantidad,jugos.nombre nombre_jugo,jugos.precio,tamanio.tamanio nombre_tamanio,jugos.imagen from detalle_cotizacion,jugos,tamanio where detalle_cotizacion.id_tamanio=tamanio.id_tamanio and id_cotizacion=? order by jugos.nombre";

    $sqls="SELECT cotizacion.pedido,cotizacion.id_cotizacion,cotizacion.nombre nombre_cotizacion,usuario.alias nombre_usuario,cotizacion.fecha from usuario,cotizacion where cotizacion.id_usuario = usuario.id_usuario and cotizacion.pedido=? order by cotizacion.id_usuario";
    
        $paramss=array(1);   
$tabla="";
    $datas=Database::getRows($sqls,$paramss);
if($datas != null)
{
    
        foreach($datas as $row1)
    {
        $totall=0;
        $tabla="<div class='row'>
    <div class='col s12'>
      <ul class='tabs'>
        <li class='tab col s3'><a href='#test$row1[id_cotizacion]'>$row1[nombre_cotizacion]-$row1[nombre_usuario]</a></li>
      </ul>
    </div>
    <div id='test$row1[id_cotizacion]' class='col s12'><table style='width:100%' class='bordered'>
        <thead>
          <tr>
              <th data-field='imagen'>Imagen</th>
              <th data-field='nombre'>Nombre</th>
              <th data-field='tamanio'>Tamaño</th>
              <th data-field='precio'>Precio</th>
              <th data-field='cantidad'>Cantidad</th>
              <th data-field='total'>Total</th>
          </tr>
        </thead><tbody>";
        $paramss=array($row1['id_cotizacion']);
        $datas=Database::getRows($sql1,$paramss);
        foreach($datas as $row2)
        {
            $total=$row2['cantidad']*$row2['precio'];
        $tabla.="<tr>
            <td><img class='responsive-img' height='100' width='100' src='data:image/*;base64,$row2[imagen]'></td>
            <td>$row2[nombre_jugo]</td>
            <td>$row2[nombre_tamanio]</td>
            <td>$row2[precio]</td>
            <td>$row2[cantidad]</td>
            <td>$total</td>
          </tr>";
            $totall=$total+$totall;
        }
        $tabla.="</tbody>
      </table><div class='row'>
    <div class='col s12'>
    <div class='card-panel teal '><p class='card-panel  light-blue accent-3'>Total: $$totall</p>
    <a class='waves-effect waves-light btn red' href='delete_cotizacion.php?id=".base64_encode($row1['id_cotizacion'])."&total=".base64_encode($totall)."'>Eliminar</a></div>
        
    </div>
</div></div>";
    }
}
else
{
    $tabla="<div class='card-panel teal '><p class='card-panel  light-blue accent-3'>No hay pedidos</p>";
}
    print $tabla;
page::footer();

?>