<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
verificador::permiso2($_SESSION['permisos']);
require("../../lib/validator.php");

if(empty($_GET['id'])) 
{
    Page::header("Agregar Descuento");
    $id=null;
    $nombre=null;
    $id_bebida=null;
    $descuento=null;
    $fecha_inicio=null;
    $fecha_limite=null;
    $descripcion=null;
    
}
else
{
    Page::header("Modificar Descuento");
    $id = base64_decode($_GET['id']);
    $sql = "SELECT * FROM descuentos WHERE id_descuento = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $nombre=htmlentities($data['nombre']);
    $id_bebida=htmlentities($data['id_jugo']);
    $descuento=htmlentities($data['descuento']);
    $fecha_inicio=htmlentities($data['fecha_inicio']);
    $fecha_limite=htmlentities($data['fecha_limite']);
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $nombre=$_POST['nombre'];
     $id_bebida=htmlentities($_POST['id_jugo']);
     $descuento=htmlentities($_POST['descuento']);
     $fecha_inicio=htmlentities($_POST['fecha_inicio']);
     $fecha_limite=htmlentities($_POST['fecha_limite']);
    
    try
    {
        if($nombre == null || $id_bebida == null || $descuento == null || $fecha_inicio == null || $fecha_limite == null )
        {
            throw new Exception("Datos incompletos");
        }
        
        if($id==null)
        {
                $sql = "INSERT INTO descuentos(nombre,id_jugo,descuento,fecha_inicio,fecha_limite) VALUES(?,?,?,?,?)";
                $params = array($nombre,$id_bebida,$descuento,$fecha_inicio,$fecha_limite);
        }
        else
        {
            $sql = "update descuentos set nombre=?, id_jugo=?,descuento=?,fecha_inicio=?,fecha_limite=? where id_descuento=?";
            $params = array($nombre,$id_bebida,$descuento,$fecha_inicio,$fecha_limite,$id);
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
<form method='post' class='row' enctype='multipart/form-data'>
    <div class='row'>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>add</i>
          	<input id='nombre' type='text' name='nombre' class='validate' length='100' maxlenght='100' value='<?php print($nombre); ?>' required/>
          	<label for='nombre'>Nombre</label>
        </div>
        <div class="col s12 m6">
            <?php
    		    $sql = "SELECT id_jugo,nombre FROM jugos";
    		    Page::setCombo("id_jugo", $id_bebida, $sql);
    		    ?>
        </div>
    </div>
    <div class='row'>
        <div class='input-field col s12'>
          	<i class='material-icons prefix'>shopping_cart</i>
          	<input id='precio' type='number' name='descuento' class='validate' max='100' min='1' step='any' value='<?php print($descuento); ?>' required/>
          	<label for='precio'>Descuento (%)</label>
        </div>
    </div>
    <div class='row'>
        <div class="input-field col s12 m6">
            <i class="material-icons prefix">date_range</i>
            <input id='fecha_inicio' name='fecha_inicio' class='validate datepicker'  value='<?php print $fecha_inicio;?>'>
            <label for="fecha_incio" >Fecha de Inicio</label>
          </div>
        <div class="input-field col s12 m6">
            <i class="material-icons prefix">date_range</i>
            <input id='fecha_limite' name='fecha_limite' class='validate datepicker'  value='<?php print $fecha_limite;?>'>
            <label for="fecha_limite" >Fecha Limite</label>
          </div>
    </div>
    <a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
<?php
Page::footer();
?>