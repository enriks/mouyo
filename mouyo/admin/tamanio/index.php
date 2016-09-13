<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
verificador::permiso3($_SESSION['permisos']);
Page::header("Tamaños de Bebidas");
?>
<!-- codigo html para tamañio -->
<form method="post" name="frmMostrarCategorias" class="center-align">
        <fieldset>
            <!--a href="save.php" class="btn waves-effect waves-light btn-large indigo darken-4">Agregar Tamaño de Bebida</a-->
            <a class=" right waves-effect waves-light btn modal-trigger btn-floating btn-large red tooltipped" href="#modal11" data-tooltip="Agregar nuevo tamaño" data-position="top" data-delay="50"><i class="large material-icons">add</i></a>
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
        <form method='post' class='row' action="save.php" enctype='multipart/form-data'>
    <div class='row'>
        <h4>Ingrese el nuevo tamaño</h4>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>shopping_cart</i>
          	<input id='precio' type='number' name='precio' class='validate' max='999.99' min='0.01' step='any'  required/>
          	<label for='precio'>Precio ($)</label>
        </div>
    </div>
    <div class='row'>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>add</i>
          	<input id='tamanio' type='text' name='tamanio' class='validate' length='300' maxlenght='300' />
          	<label for='tamanio'>Tamaño</label>
        </div>
    </div>
    <a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
</div>
</div>


<?php
if(!empty($_POST))
{
	$search = trim($_POST['buscar']);
	$sql = "SELECT * FROM tamanio WHERE tamanio LIKE ? and estado=0 ORDER BY tamanio";
	$params = array("%$search%");
}
else
{
	$sql = "SELECT * FROM tamanio where estado=0 ORDER BY tamanio";
	$params = null;
}
$data=Database::getRows($sql,$params);
if($data != null)
{
    $tabla="";
    foreach($data as $row)
		{
            $tabla .="<ul class='collection'>";
                    $tabla .="<br><a class='btn waves-effect waves-light indigo darken-4' href='save.php?               id=".base64_encode($row['id_tamanio'])."'>Modificar<i id='img_btn' class='material-icons'>mode_edit</i></a>";
                    $tabla .="<a class='btn waves-effect waves-light red darken-1' href='delete.php?id=".base64_encode($row['id_tamanio'])."'>Eliminar<i id='img-btn' class='material-icons'>delete</i></a>";
                    $tabla .="<li class='collection-item dismissable'>";
                    $tabla .="<div>";
                    $tabla .="<div class='row'>";
                    $tabla .="<div class='col m8 s12'>";
                    $tabla .="<p id='texto-tabla'>";
                    $tabla .="<strong>Precio:
                    </strong>$row[precio]<br>";
                    $tabla .="<strong>Tamaño:
                    </strong>$row[tamanio]<br>";
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