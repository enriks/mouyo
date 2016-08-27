<!-- codigo php para regitro de usuario -->
<?php
ob_start();
require("../../lib/database.php");
$sql = "SELECT * FROM admin";
$data = Database::getRows($sql, null);
if($data != null)
{
    @header("location: login.php");
}

require("../lib/page.php");
require("../../lib/validator.php");
Page::header("Registrar usuario");

function validar_clave($clave,&$error_clave){
   if(strlen($clave) < 6){
      $error_clave = "La clave debe tener al menos 6 caracteres";
      return false;
   }
   if(strlen($clave) > 25){
      $error_clave = "La clave no puede tener más de 25 caracteres";
      return false;
   }
   if (!preg_match('`[a-z]`',$clave)){
      $error_clave = "La clave debe tener al menos una letra minúscula";
      return false;
   }
   if (!preg_match('`[A-Z]`',$clave)){
      $error_clave = "La clave debe tener al menos una letra mayúscula";
      return false;
   }
   if (!preg_match('`[0-9]`',$clave)){
      $error_clave = "La clave debe tener al menos un caracter numérico";
      return false;
   }
   $error_clave = "";
   return true;
}
$fecha_nacimiento="";
$permiso="";
if(!empty($_POST))
{
    $_POST = Validator::validateForm($_POST);
  	$alias = htmlentities($_POST['alias']);
    $correo = htmlentities($_POST['correo']);
    $permiso=$_POST['permiso'];
    $archivo=$_FILES['imagen'];

    try 
    {
      	if($alias != "" || $correo != "")
        {
            $clave1 = htmlentities($_POST['clave1']);
            $clave2 = htmlentities($_POST['clave2']);
            if($alias != "" && $clave1 != "" && $clave2 != "")
            {
                if($archivo['name'] != null)
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
                    if( $alias != $clave1 )
                    {
                        $error_encontrado="";
                        
                        if (validar_clave($clave1, $error_encontrado)){
                                    
                            if($clave1 == $clave2)
                            {
                                $clave = password_hash($clave1, PASSWORD_DEFAULT);
                                $sql = "INSERT INTO `admin` (`alias`, `clave`, `correo`,foto,permiso) VALUES(?, ?, ?,?,?)";
                                $param = array($alias,$clave,$correo,$imagen,$permiso);
                                Database::executeRow($sql, $param);
                                @header("location: login.php");
                            }
                            else
                            {
                                throw new Exception("Las claves ingresadas no coinciden.");
                            }
                        }
                        else
                        {
                            throw new Exception("Clave no valida. " . $error_encontrado);
                        }
                    }
                    else
                    {
                        throw new Exception("El Alias no puede ser igual a la contraseña ");
                    }
                }
            }
            else
            {
                throw new Exception("Debe ingresar todos los datos de autenticación.");
            }
        }
        else
        {
            throw new Exception("Debe ingresar el nombre o el correo.");
        }
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
else
{
    $nombres = null;
    $apellidos = null;
    $correo = null;
    $alias = null;
}
?>
<!-- formulario para nuevo registro-->
<form method='post' class='row' enctype='multipart/form-data'>
    <div class='row'>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>perm_identity</i>
            <input id='alias' type='text' name='alias' class='validate' autocomplete="off" length='50' maxlenght='50' value='<?php print($alias); ?>' required/>
            <label for='alias'>Alias</label>
        </div>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>email</i>
            <input id='correo' type='email' name='correo' class='validate' autocomplete="off" length='100' maxlenght='100' value='<?php print($correo); ?>' required/>
            <label for='correo'>Correo</label>
        </div>
    </div>
    <div class='row'>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>lock</i>
            <input id='clave1' type='password' name='clave1' class='validate' autocomplete="off" length='25' maxlenght='25' required/>
            <label for='clave1'>Clave</label>
        </div>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>lock</i>
            <input id='clave2' type='password' name='clave2' class='validate' autocomplete="off" length='25' maxlenght='25' required/>
            <label for='clave2'>Confirmar clave</label>
        </div>
    </div>
    <div class="row">
        <div class='input-field col s12'>
          	<div class='btn'>
            		<span>Imagen</span>
            		<input type='file' name='imagen'>
      		  </div>
        		<div class='file-path-wrapper'>
          		  <input class='file-path validate' type='text' placeholder='1200x1200px máx., 2MB máx., PNG/JPG/GIF'>
        		</div>
        </div>
    </div>
    <div class="col s12 ">
            <?php
    		    $sql = "SELECT id_permiso,nombre FROM permisos";
    		    Page::setCombo("permiso", $permiso, $sql);
    		    ?>
        </div>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
<?php
Page::footer();
?>