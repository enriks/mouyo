<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
Page::header("Historial");
?>
<!-- codigo html para historial -->
<?php

	$sql = "SELECT admin.alias nombre_admin, historial.accion,historial.fecha FROM historial,admin WHERE historial.id_admin=admin.id_admin order by historial.fecha";
	$params = null;

$data=Database::getRows($sql,$params);
if($data != null)
{
    $tabla="<table>
        <thead>
          <tr>
              <th data-field='administrador'>Administrador</th>
              <th data-field='accion'>Accion</th>
              <th data-field='fecha'>Fecha</th>
          </tr>
        </thead>

        <tbody>";
    foreach($data as $row)
		{
            $tabla .="<tr>
            <td>$row[nombre_admin]</td>
            <td>$row[accion]</td>
            <td>$row[fecha]</td>
          </tr>";
        }
    $tabla.="</tbody>
      </table>";
    print($tabla);
}
else
{
    print("<div class='card-panel yellow'><i class='material-icons left'>warning</i>No hay registros.</div>");
}
Page::footer();
?>