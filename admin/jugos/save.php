<?php
ob_start();
require("../../lib/database.php");
require("../../lib/validator.php");
require("../lib/verificador.php");
require("../lib/page.php");
verificador::permiso4($_SESSION['permisos']);


/*condiciones para agregar y modificar*/

if(empty($_GET['id'])) 
{
    Page::header("Agregar Jugo");
    $id=null;
    $nombre=null;
    $tipo=null;
    $archivo=null;
    $precio=null;
    $descripcion=null;
}
else
{
    Page::header("Modificar Jugo");
    $id = base64_decode($_GET['id']);
    $sql = "SELECT * FROM jugos WHERE id_jugo = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $nombre = htmlentities($data['nombre']);
    $tipo =  htmlentities($data['id_tipojugo']);
    $archivo=$data['imagen'];
    $precio= htmlentities($data['precio']);
    $descripcion= htmlentities($data['descripcion']);
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $nombre= htmlentities($_POST['nombre']);
     $tipo= htmlentities($_POST['tipo']);
     $archivo=$_FILES['imagen'];
     $precio= htmlentities($_POST['precio']);
     $descripcion= htmlentities($_POST['descripcion']);
    
    try
    {
        if($nombre == null || $tipo == null || $precio == null)
        {
            throw new Exception("Datos incompletos");
        }
        elseif($precio < 1)
        {
            throw new Exception("El precio debe ser mayor a 1");
        }
        elseif( $archivo['name'] != null)
        {
            $base64 = Validator::validateImage($archivo);
           	if($base64 != false)
           	{
           	    $imagen = $base64;
           	}
           	else
           	{
           	    throw new Exception("La imagen seleccionada no es valida.");
           	}
        }
        
        if($id==null)
        {
            if(isset($imagen) != null)
            {
            $sql = "INSERT INTO jugos (nombre, id_tipojugo,precio,imagen,descripcion) VALUES(?,?,?,?,?)";
            $params = array($nombre, $tipo,$precio,$imagen,$descripcion);
                Database::executeRow($sql, $params);
                @header("location: index.php");
            }
            else
            {
                throw new Exception("Selecccione una imagen.");
            }
        }
        else
        {
            if(isset($imagen) != null)
            {    
                $sql = "update jugos set nombre=?, id_tipojugo=?,precio=?,imagen=?,descripcion=? where id_jugo=?";
                $params = array($nombre, $tipo,$precio,$imagen,$descripcion,$id);
                Database::executeRow($sql, $params);
                @header("location: index.php");
            }
            else
            {
                $sql = "update jugos set nombre=?, id_tipojugo=?,precio=?,descripcion=? where id_jugo=?";
                $params = array($nombre, $tipo,$precio,$descripcion,$id);
                Database::executeRow($sql, $params);
                @header("location: index.php");
            }
        }
         
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
?>
<!-- formulario de registro-->
<form method='post' class='row' enctype='multipart/form-data'>
    <div class='row'>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>add</i>
          	<input id='nombre' type='text' name='nombre' class='validate' length='100' maxlenght='100' value='<?php print($nombre); ?>' required/>
          	<label for='nombre'>Nombre</label>
        </div>
        <div class='input-field col s12 m6'>
          	<?php
    		    $sql = "SELECT id_tipojugo, nombre FROM tipo_jugo";
    		    Page::setCombo("tipo", $tipo, $sql);
    		    ?>
        </div>
    </div>
    <div class="row">
    <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>shopping_cart</i>
          	<input id='precio' type='number' name='precio' class='validate' max='999.99' min='0.01' step='any' value='<?php print($precio); ?>' required/>
          	<label for='precio'>Precio ($)</label>
        </div>
        <div class='input-field col s12 m6'>
          	<div class='btn'>
            		
            		<input type='file' name='imagen' required>
      		  </div>
        		<div class='file-path-wrapper'>
          		  <input class='file-path validate' type='text' placeholder='1200x1200px máx., 2MB máx., PNG/JPG/GIF'>
        		</div>
        </div>
    </div>
    <div class="row">
        <div class='input-field col s12'>
          	<i class='material-icons prefix'>description</i>
          	<input id='descripcion' type='text' name='descripcion' class='validate' length='600' maxlenght='600' value='<?php print($descripcion); ?>'/>
          	<label for='descripcion'>Descripción</label>
        </div>
    </div>
    <a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
<?php
Page::footer();
?>