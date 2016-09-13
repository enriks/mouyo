<?php
ob_start();
require("../../lib/database.php");
require("../../lib/validator.php");
require("../lib/verificador.php");
require("../lib/page.php");
verificador::permiso4($_SESSION['permisos']);
$fecha=date('Y-m-d H:i:s');
/*condiciones para agregar y modificar*/

if(empty($_GET['id'])) 
{
    Page::header("Frontend");
    $id=null;
    $fondo=null;
    $logo=null;
    $archivo=null;
    $telefono=null;
    $twitter=null;
    $facebook=null;
    $pregunta1=null;
    $respuesta1=null;
    $pregunta2=null;
    $respuesta2=null;
    $pregunta3=null;
    $respuesta3=null;
    $pregunta4=null;
    $respuesta4=null;
}
else
{
    Page::header("Frontend");
    $id = base64_decode($_GET['id']);
    $sql = "SELECT * FROM frontend WHERE id_frontend = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $fondo = $data['fondo'];
    $logo=$data['logo'];
    $archivo=$data['video'];
    $telefono=htmlentities($data['numero_telefono']);
    $twitter=$data['twitter'];
    $facebook=$data['facebook'];
    $pregunta1=htmlentities($data['pregunta1']);
    $respuesta1=htmlentities($data['respuesta1']);
    $pregunta2=htmlentities($data['pregunta2']);
    $respuesta2=htmlentities($data['respuesta2']);
    $pregunta3=htmlentities($data['pregunta3']);
    $respuesta3=htmlentities($data['respuesta3']);
    $pregunta4=htmlentities($data['pregunta4']);
    $respuesta4=htmlentities($data['respuesta4']);
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $fondo=$_FILES['fondo'];
     $logo=$_FILES['logo'];
     $archivo=$_FILES['archivo'];
     $telefono=$_POST['telefono'];
     $twitter=$_POST['twitter'];
     $facebook=$_POST['facebook'];
     $pregunta1=htmlentities($_POST['pregunta1']);
     $respuesta1=htmlentities($_POST['respuesta1']);
     $pregunta2=htmlentities($_POST['pregunta2']);
     $respuesta2=htmlentities($_POST['respuesta2']);
     $pregunta3=htmlentities($_POST['pregunta3']);
     $respuesta3=htmlentities($_POST['respuesta3']);
     $pregunta4=htmlentities($_POST['pregunta4']);
     $respuesta4=htmlentities($_POST['respuesta4']);

    try
    {
        if($telefono == null || $twitter == null || $facebook == null || $pregunta1 == null || $pregunta2 == null || $pregunta3 == null || $pregunta4 == null || $respuesta1 == null || $respuesta2 == null || $respuesta3 == null || $respuesta4 == null)
        {
            throw new Exception("Datos incompletos");
        }
        elseif( $fondo['name'] != null)
        {
            $base64 = Validator::validateImage($fondo);
           	if($base64 != false)
           	{
           	    $imagen1 = $base64;
           	}
           	else
           	{
           	    throw new Exception("La imagen seleccionada no es valida.");
           	}
        }
        if( $logo['name'] != null)
        {
            $base64 = Validator::validateImage($logo);
           	if($base64 != false)
           	{
           	    $imagen2 = $base64;
           	}
           	else
           	{
           	    throw new Exception("La imagen seleccionada no es valida.");
           	}
        }
        if( $archivo['name'] != null)
        {
            $base64 = Validator::validateVideo($archivo);
           	if($base64 != false)
           	{
           	    $video = $base64;
           	}
           	else
           	{
           	    throw new Exception("El video seleccionado no es valido.");
           	}
        }
        
        if($id==null)
        {
            if(isset($imagen1) != null || isset($imagen2) != null)
            {
            $sql = "INSERT INTO frontend (fondo, logo, video, numero_telefono, twitter, facebook, pregunta1, respuesta1, pregunta2, respuesta2, pregunta3, respuesta3, pregunta4, respuesta4) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $params = array($imagen1,$imagen2,$video,$telefono,$twitter, $facebook,$pregunta1,$respuesta1,$pregunta2,$respuesta2,$pregunta3,$respuesta3,$pregunta4,$respuesta4);
                Database::executeRow($sql, $params);
                $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Inserto el frontend",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
                @header("location: index.php");
            }
            else
            {
                throw new Exception("Selecccione una imagen.");
            }
        }
        else
        {
            if(isset($imagen1) != null && isset($imagen2) == null && isset($video) == null)
            {    
                $sql = "update frontend set fondo=?, numero_telefono=?, twitter=?, facebook=?, pregunta1=?, respuesta1=?, pregunta2=?, respuesta2=?, pregunta3=?, respuesta3=?, pregunta4=?, respuesta4=? where id_frontend=?";
                $params = array($imagen1,$telefono,$twitter,$facebook,$pregunta1,$respuesta1,$pregunta2,$respuesta2,$pregunta3,$respuesta3,$pregunta4,$respuesta4,$id);
                Database::executeRow($sql, $params);
                 $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Modifico el frontend",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
                @header("location: index.php");
            }
            elseif(isset($imagen1) != null && isset($imagen2) != null && isset($video) == null)
            {
                $sql = "update frontend set fondo=?, logo=?, numero_telefono=?, twitter=?, facebook=?,pregunta1=?, respuesta1=?, pregunta2=?, respuesta2=?, pregunta3=?, respuesta3=?, pregunta4=?, respuesta4=? where id_frontend=?";
                $params = array($imagen1,$imagen2,$telefono,$twitter,$facebook,$pregunta1,$respuesta1,$pregunta2,$respuesta2,$pregunta3,$respuesta3,$pregunta4,$respuesta4,$id);
                Database::executeRow($sql, $params);
                 $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Modifico el frontend",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
                @header("location: index.php");
            }
            elseif(isset($imagen1) != null && isset($imagen2) != null && isset($video) != null)
            {
                $sql = "update frontend set fondo=?, logo=?, video=?, numero_telefono=?,twitter=?, facebook=?, pregunta1=?, respuesta1=?, pregunta2=?, respuesta2=?, pregunta3=?, respuesta3=?, pregunta4=?, respuesta4=? where id_frontend=?";
                $params = array($imagen1,$imagen2,$video,$telefono,$twitter,$facebook,$pregunta1,$respuesta1,$pregunta2,$respuesta2,$pregunta3,$respuesta3,$pregunta4,$respuesta4,$id);
                Database::executeRow($sql, $params);
                 $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Modifico el frontend",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
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
          	<div class='btn'>
            		
            		<input type='file' name='fondo' required>
      		  </div>
        		<div class='file-path-wrapper'>
          		  <input class='file-path validate' type='text' placeholder='Imagen de fondo tipo: PNG/JPG/GIF'>
        		</div>
        </div>
        <div class='input-field col s12 m6'>
          	<div class='btn'>
            		
            		<input type='file' name='logo' required>
      		  </div>
        		<div class='file-path-wrapper'>
          		  <input class='file-path validate' type='text' placeholder='Imagen de logo tipo: PNG/JPG/GIF'>
        		</div>
        </div>
    </div>
    <div class="row">
        <div class='input-field col s12 m6'>
          	<div class='btn'>
            		
            		<input type='file' name='archivo' required>
      		  </div>
        		<div class='file-path-wrapper'>
          		  <input class='file-path validate' type='text' placeholder='Video para la seccion de salud'>
        		</div>
        </div>
    <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>phone</i>
          	<input id='telefono' type='text' name='telefono' class='validate' max='999.99' min='0.01' value='<?php print($telefono); ?>' required/>
          	<label for='telefono'>Numero de telefono</label>
        </div>
    </div>
    <div class="row">
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>thumb_up</i>
          	<input id='facebook' type='text' name='facebook' class='validate' length='600' maxlenght='600' value='<?php print($facebook); ?>'/>
          	<label for='facebook'>Link de la pagina de Facebook</label>
        </div>
    <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>adb</i>
          	<input id='twitter' type='text' name='twitter' class='validate' length='600' maxlenght='600' value='<?php print($twitter); ?>'/>
          	<label for='twitter'>Link de la cuenta de Twitter</label>
        </div>
    </div> <div class="row">
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>filter_1</i>
          	<input id='pregunta1' type='text' name='pregunta1' class='validate' length='600' maxlenght='600' value='<?php print($pregunta1); ?>'/>
          	<label for='pregunta1'>Pregunta 1 para "Preguntas frecuentes"</label>
        </div>
    <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>looks_one</i>
          	<input id='respuesta1' type='text' name='respuesta1' class='validate' length='600' maxlenght='600' value='<?php print($respuesta1); ?>'/>
          	<label for='respuesta1'>Respuesta para la pegunta 1 para "Preguntas frecuentes"</label>
        </div>
    </div>
     <div class="row">
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>filter_2</i>
          	<input id='pregunta2' type='text' name='pregunta2' class='validate' length='600' maxlenght='600' value='<?php print($pregunta2); ?>'/>
          	<label for='pregunta2'>Pregunta 2 para "Preguntas frecuentes"</label>
        </div>
    <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>looks_two</i>
          	<input id='respuesta2' type='text' name='respuesta2' class='validate' length='600' maxlenght='600' value='<?php print($respuesta2); ?>'/>
          	<label for='respuesta2'>Respuesta para la pegunta 2 para "Preguntas frecuentes"</label>
        </div>
    </div>
     <div class="row">
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>filter_3</i>
          	<input id='pregunta3' type='text' name='pregunta3' class='validate' length='600' maxlenght='600' value='<?php print($pregunta3); ?>'/>
          	<label for='pregunta3'>Pregunta 3 para "Preguntas frecuentes"</label>
        </div>
    <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>looks_3</i>
          	<input id='respuesta3' type='text' name='respuesta3' class='validate' length='600' maxlenght='600' value='<?php print($respuesta3); ?>'/>
          	<label for='respuesta3'>Respuesta para la pegunta 3 para "Preguntas frecuentes"</label>
        </div>
    </div>
     <div class="row">
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>filter_4</i>
          	<input id='pregunta4' type='text' name='pregunta4' class='validate' length='600' maxlenght='600' value='<?php print($pregunta4); ?>'/>
          	<label for='pregunta4'>Pregunta 4 para "Preguntas frecuentes"</label>
        </div>
    <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>looks_4</i>
          	<input id='respuesta4' type='text' name='respuesta4' class='validate' length='600' maxlenght='600' value='<?php print($respuesta4); ?>'/>
          	<label for='respuesta4'>Respuesta para la pegunta 4 para "Preguntas frecuentes"</label>
        </div>
    </div>
    <a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
<?php
Page::footer();
?>