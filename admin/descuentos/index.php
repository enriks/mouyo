<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
verificador::permiso2($_SESSION['permisos']);
$id_bebida="";
Page::header("Descuentos");
?>
<form method="post" name="frmMostrarCategorias" class="center-align">
        <fieldset>
            <!--a href="save.php" class="btn waves-effect waves-light btn-large indigo darken-4">Agregar Descuento</a-->
             <a class=" right waves-effect waves-light btn modal-trigger btn-floating btn-large red tooltipped" href="#modal11" data-tooltip="Agregar descuento" data-position="top" data-delay="50"><i class="large material-icons">add</i></a>
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
        <form method='post'  action="save.php" enctype='multipart/form-data'>
    <div class='row'>
        <div class='input-field col s12 '>
          	<i class='material-icons prefix'>add</i>
          	<input id='nombre' type='text' name='nombre' class='validate' length='100' maxlenght='100' required/>
          	<label for='nombre'>Nombre</label>
        </div>
        <div class="col s12">
            <?php
    		    $sql = "SELECT id_jugo,nombre FROM jugos";
    		    Page::setCombo("id_jugo", $id_bebida, $sql);
    		    ?>
        </div>
    </div>
    <div class='row'>
        <div class='input-field col s12'>
          	<i class='material-icons prefix'>shopping_cart</i>
          	<input id='precio' type='number' name='descuento' class='validate' max='100' min='1' step='any' required/>
          	<label for='precio'>Descuento (%)</label>
        </div>
    </div>
    <div class='row'>
        <div class="input-field col s12 m6">
            <i class="material-icons prefix">date_range</i>
            <input id='fecha_inicio' name='fecha_inicio' class='validate datepicker'>
            <label for="fecha_incio" >Fecha de Inicio</label>
          </div>
        <div class="input-field col s12 m6">
            <i class="material-icons prefix">date_range</i>
            <input id='fecha_limite' name='fecha_limite' class='validate datepicker'>
            <label for="fecha_limite" >Fecha Limite</label>
          </div>
    </div>
    <a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
</div>
</div>
<?php

	$sql = "select descuentos.nombre,descuentos.id_descuento,descuentos.fecha_inicio, descuentos.fecha_limite,jugos.imagen,jugos.nombre nombre_jugo,jugos.precio, descuentos.descuento from jugos, descuentos where descuentos.id_jugo = jugos.id_jugo and descuentos.estado=0";
	$params = null;
$data=Database::getRows($sql,$params);
if($data != null)
{
    $tabla="";
    foreach($data as $row)
		{
            $tabla .="<ul class='collection'>";
                    $tabla .="<br><a class='btn waves-effect waves-light indigo darken-4' href='save.php?               id=".base64_encode($row['id_descuento'])."'>Modificar<i id='img_btn' class='material-icons'>mode_edit</i></a>";
                    $tabla .="<a class='btn waves-effect waves-light red darken-1' href='delete.php?id=".base64_encode($row['id_descuento'])."'>Eliminar<i id='img-btn' class='material-icons'>delete</i></a>";
                    $tabla .="<li class='collection-item dismissable'>";
                    $tabla .="<div>";
                    $tabla .="<div class='row'>";
                    $tabla .="<div class='col m8 offset-m2 s12'>";
                    $tabla .="<p id='texto-tabla'>";
                    $tabla .="<strong>Nombre: 
                    </strong>$row[nombre]<br>";
                    $tabla .="<strong>Nombre del jugo: 
                    </strong>$row[nombre_jugo]<br>";
                    $tabla .="<strong>Fecha inicio:
                    </strong>$row[fecha_inicio]<br>";
                    $tabla .="<strong>Fecha limite:
                    </strong>$row[fecha_limite]<br>";
                    $tabla .="<strong>Descuento:
                    </strong>$row[descuento]%<br>";
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