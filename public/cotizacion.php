<?php
    require("main/page2.php");
    require("../lib/database.php");
    Page2::header();
    if(isset($_POST['enviar69']))
    {
        try
        {
            $nombre=$_POST['nombre'];
            $fecha=date('Y-m-d');
            if($nombre == "")
            {
                throw new Exception("Escribe un nombre para la cotizacion.");
            }
            else
            {
                $sql="insert into cotizacion(nombre,fecha,id_usuario) values(?,?,?)";
                $params=array($nombre,$fecha,$_SESSION['id_usuario']);
                Database::executeRow($sql,$params);
            }
        }
        catch (Exception $error)
        {
            print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
        }
    }
?>
    <!--formulario de carrito -->
    <div class="row">
        <div class="col s4 offset-s5">
        <a class="waves-effect waves-light btn modal-trigger" href="#modal2">Nueva cotizacion</a>
        <div id="modal2" class="modal modal-fixed-footer">
            <form method='post' name="nuevaCot" class='row center-align'>
                <div class='row'>
                    <div class='input-field col s12'>
                        <i class='material-icons prefix'>add</i>
                        <input id='nombre' type='text' name='nombre' class='validate' length='100' maxlenght='100' required/>
                        <label for='nombre'>Nombre</label>
                    </div>
                </div>
                <button type='submit' name="enviar69" class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
            </form>
          </div>
        </div>
    </div>
<!--cargamos las tabs -->
         <?php
            $tabs="<div class='col s12'>
      <ul class='tabs'>";
            $select="select * from cotizacion";
            $data=Database::getRows($select,null);
            foreach($data as $datos)
            {
                $tabs.="<li class='tab col s3'><a href='#test$datos[id_cotizacion]'>$datos[nombre]</a></li>";
            }
        $tabs.="
      </ul>
    </div>";
$contenido="";
$elselect="SELECT jugos.nombre nombre_jugo, jugos.imagen imagen_jugo,jugos.precio,tamanio.tamanio nombre_tamanio,detalle_cotizacion.id_jugo,detalle_cotizacion.cantidad from jugos,tamanio,cotizacion,detalle_cotizacion where detalle_cotizacion.id_cotizacion = ? and detalle_cotizacion.id_jugo = jugos.id_jugo and detalle_cotizacion.id_tamanio = tamanio.id_tamanio order by jugos.nombre";

foreach($data as $datas)
{
    $totaal=0;
    $params=array($datas['id_cotizacion']);
    $dats=Database::getRows($elselect,$params);
  $contenido.="<div id='test$datas[id_cotizacion]' class='col s12'><table style='width:100%' class='bordered'>
        <thead>
          <tr>
              <th data-field='imagen'>Imagen</th>
              <th data-field='nombre'>Nombre</th>
              <th data-field='tamanio'>Tamaño</th>
              <th data-field='precio'>Precio</th>
              <th data-field='cantidad'>Cantidad</th>
              <th data-field='total'>Total</th>
              <th data-field='accion'>Accion</th>
          </tr>
        </thead><tbody>";
    
    foreach($dats as $das)
    {
        $total=$das['precio']*$das['cantidad'];
        $contenido.="
          <tr>
            <td><img class='responsive-img' height='100' width='100' src='data:image/*;base64,$das[imagen_jugo]'></td>
            <td>$das[nombre_jugo]</td>
            <td>$das[nombre_tamanio]</td>
            <td>$das[precio]</td>
            <td>$das[cantidad]</td>
            <td>$total</td>
            <td><a class='waves-effect waves-light btn red' href='delete_jugocotizacion.php?id=".base64_encode($das ['id_jugo'])."'>Eliminar</a></td>
          </tr>";
        $totaal=$total+$totaal;
    }
    $contenido.="</tbody>
      </table><div class='row'>
    <div class='col s12'>
    <div class='card-panel teal '><p class='card-panel  light-blue accent-3'>Total: $$totaal</p>
    <a class='waves-effect waves-light btn red' href='delete_cotizacion.php?id=".base64_encode($datas['id_cotizacion'])."&total=".base64_encode($totaal)."'>Eliminar</a></div>
        
    </div>
</div></div>";
}

print $tabs;
print $contenido;
        ?>
 
 <?php Page2::footer();?>