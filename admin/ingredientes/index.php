<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
$tipo="";
Page::header("Ingredientes");
?>
<!--formulario categorias-->
<form method="post" name="frmMostrarCategorias" class="center-align">
        <fieldset>
            
            <a href="../tipo_ingredientes/" class="btn waves-effect waves-light btn-large indigo darken-4">Tipos de Ingrediente</a>
            <a class=" right waves-effect waves-light btn modal-trigger btn-floating btn-large red tooltipped" href="#modal11" data-tooltip="Agregar Ingrediente" data-position="top" data-delay="50"><i class="large material-icons">add</i></a>
            <div class='input-field col s6 m4'>
      	<i class='material-icons prefix'>search</i>
      	<input id='buscar' type='text' name='buscar' class='validate'/>
      	<label for='buscar'>Búsqueda</label>
    </div>
    <div class='input-field col s6 m4'>
    	<button type='submit' class='btn grey left'><i class='material-icons right'>pageview</i>Aceptar</button> 	
  	</div>
    </fieldset>
</form>
<div id="modal11" class="modal">
    <div class="modal-content">
        <form method='post' class='row' action="save.php" enctype='multipart/form-data' ac>
            <div class="row">
                <h4 class="center">Agregando un nuevo Ingrendiente</h4>
                <div class="input-field col s12">
                    <i class='material-icons prefix'>add</i>
          	<input id='nombre' type='text' name='nombre' class='validate' length='100' maxlenght='100' required/>
          	<label for='nombre'>Nombre</label>
                </div>
                           
                <div class="input-field col s12">
                    <i class='material-icons prefix'>description</i>
          	<input id='descripcion' type='text' name='descripcion' class='validate' length='600' maxlenght='600'/>
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
                <div class="input-field col s12 m6">
                    <div class='btn'>
                        <input type='file' name='imagen'>
                    </div>
                    <div class='file-path-wrapper'>
                        <input class='file-path validate' type='text' placeholder='1200x1200px máx., 2MB máx.,  PNG/JPG/GIF'>
                    </div>
                </div>
            </div>
            <div class="input-field col s12 center">
                <!--input class="modal-close waves-effect waves-light btn margin-bottom-1em" type="submit"  value="Guardar"/-->
                <button type='submit' class='btn'><i class='material-icons right'>save</i>Guardar</button><br><br>
            <a class="modal-action modal-close waves-effect waves-light btn margin-bottom-1em"><i class="material-icons right">close</i>Salir</a>
            </div>
        </form>
</div>
</div>
<?php
if(!empty($_POST))
{
	$search = trim($_POST['buscar']);
	$sql = "SELECT ingrediente.id_ingrediente,ingrediente.nombre nombre_ingrediente,ingrediente.imagen,ingrediente.descripcion,tipo_ingrediente.id_tipo,tipo_ingrediente.nombre nombre_tipo,tipo_ingrediente.precio from ingrediente,tipo_ingrediente where ingrediente.tipo=tipo_ingrediente.id_tipo  AND ingrediente.nombre LIKE ? and ingrediente.estado=0 ORDER BY ingrediente.nombre";
	$params = array("%$search%");
}
else
{
	$sql = "SELECT ingrediente.id_ingrediente,ingrediente.nombre nombre_ingrediente,ingrediente.imagen,ingrediente.descripcion,tipo_ingrediente.id_tipo,tipo_ingrediente.nombre nombre_tipo,tipo_ingrediente.precio from ingrediente,tipo_ingrediente where ingrediente.tipo=tipo_ingrediente.id_tipo and ingrediente.estado=0  ORDER BY ingrediente.nombre";
	$params = null;
}
$data = Database::getRows($sql, $params);
if($data != null)
{
    $tabla="";
    foreach($data as $row)
		{
            $tabla .="<ul class='collection'>";
            $tabla .="<br><a class='btn waves-effect waves-light indigo darken-4' href='save.php?               id=".base64_encode($row['id_ingrediente'])."'>Modificar<i id='img_btn' class='material-icons'>mode_edit</i></a>";
            $tabla .="<a class='btn waves-effect waves-light red darken-1' href='delete.php?id=".base64_encode($row['id_ingrediente'])."'>Eliminar<i id='img-btn' class='material-icons'>delete</i></a>";
            $tabla .="<li class='collection-item dismissable'>";
            $tabla .="<div>";
            $tabla .="<div class='row'>";
            $tabla .="<div class='col m4 s8'>";
            $tabla .="<img id='foto_perfil imagen_video'
            src='data:image/*;base64,$row[imagen]'
            class='responsive-img'>";
            $tabla .="</div>";
            $tabla .="<div class='col m8 s12'>";
            $tabla .="<p id='texto-tabla'>";
            $tabla .="<strong>Título: 
            </strong>$row[nombre_ingrediente]<br>";
            $tabla .="<strong>Descripción:
            </strong>$row[descripcion]<br>";
            $tabla .="<strong>Tipo:
            </strong>$row[nombre_tipo]<br>";
            $tabla .="<strong>Precio:
            </strong>$row[precio]<br>";
            $tabla .="</p>";
            $tabla .="</div>";
            $tabla .="</div>";
            $tabla .= "</div>";
            $tabla .="</li>";
            $tabla .="</ul>";                  
        }
            print($tabla);
    }
else
{
    print("<div class='card-panel yellow'><i class='material-icons left'>warning</i>No hay registros.</div>");
}
Page::footer();
?>