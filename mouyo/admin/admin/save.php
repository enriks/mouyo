<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../../lib/validator.php");
require("../lib/verificador.php");
verificador::permiso1($_SESSION['permisos']);
$fecha=date('Y-m-d H:i:s');
if(empty($_GET['id'])) 
{
    Page::header("Agregar Administrador");
    $id=null;
    $alias=null;
    $clave=null;
    $archivo=null;
    $correo=null;
$permiso="";
  $estado=null;  
}
else
{
    Page::header("Modificar Administrador");
    $id = base64_decode($_GET['id']);
    $sql = "SELECT * FROM admin WHERE id_admin = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $alias = $data['alias'];
    $clave = $data['clave'];
    $archivo=$data['foto'];
    $correo=$data['correo'];
$permiso=$data['permiso'];
    $estado=$data['estado'];
     if($estado==0)
     {
         $checkestado="<p>Estado:
            <input id='activo' type='radio' checked name='estado' class='with-gap'  value='1' />
      <label for='activo'><i class='material-icons'>visibility</i></label>
    <input id='inactivo' type='radio' name='estado' class='with-gap' value='0'/>
    <label for='inactivo'><i class='material-icons'>visibility_off</i></label></p>";
     }
    else
    {
        $checkestado="<p>Estado:
            <input id='activo' type='radio' name='estado' class='with-gap'  value='1' />
      <label for='activo'><i class='material-icons'>visibility</i></label>
    <input id='inactivo' checked type='radio' name='estado' class='with-gap' value='0'/>
    <label for='inactivo'><i class='material-icons'>visibility_off</i></label></p>";
    }
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $alias = htmlentities($_POST['alias']);
    $correo = htmlentities($_POST['correo']);
    $permiso=htmlentities($_POST['permiso']);
    $estado=htmlentities($_POST['estado']);
    $archivo=$_FILES['imagen'];
    
    try
    {
        $clave1 = htmlentities($_POST['clave1']);
            $clave2 = htmlentities($_POST['clave2']);
        if($alias == "" || $correo == "")
        {
            throw new Exception("Datos incompletos");
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
        elseif( $alias != $clave1 )
        {
            if($id==null)
            {
                if( $archivo['name'] != null)
                {
                $clave = password_hash($clave1, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `admin` (`alias`, `clave`, `correo`,foto,permiso,estado) VALUES(?, ?,?, ?,?,?)";
                $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
                $params=array($alias,$clave,$correo,$imagen,$permiso,$estado);
                $params2=array($fecha,"Inserto el administrador $alias",$_SESSION['id_admin']);
                    Database::executeRow($sql, $params);
                    Database::executeRow($sql2, $params2);
            @header("location: index.php");
                }
                else
                {
                 throw new Exception("Seleccione una imagen");   
                }
            }
            else
            {
                if( $archivo['name'] != null)
                {
                    $clave = password_hash($clave1, PASSWORD_DEFAULT);
                    $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
                    $params2=array($fecha,"Modifico el administrador $alias",$_SESSION['id_admin']);
                    Database::executeRow($sql2, $params2);
                    $sql = "update admin set alias=?, clave=?,foto=?,correo=?,permiso=?,estado=? where id_admin=?";
                    $params = array($alias, $clave,$imagen,$correo,$permiso,$estado,$id);
                    Database::executeRow($sql, $params);
            @header("location: index.php");
                }
                else
                {
                    $clave = password_hash($clave1, PASSWORD_DEFAULT);
                    $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
                    $params2=array($fecha,"Modifico el administrador $alias",$_SESSION['id_admin']);
                    Database::executeRow($sql2, $params2);
                    $sql = "update admin set alias=?, clave=?,correo=?,permiso=?,estado=? where id_admin=?";
                    $params = array($alias, $clave,$correo,$permiso,$estado,$id);
                    Database::executeRow($sql, $params);
            @header("location: index.php");
                }

            }
             
        }
        else
        {
            throw new Exception("El Alias no puede ser igual a la contraseña ");
        }
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
            		<input type='file' name='archivo'>
      		  </div>
        		<div class='file-path-wrapper'>
          		  <input class='file-path validate' type='text' placeholder='1200x1200px máx., 2MB máx., PNG/JPG/GIF'>
        		</div>
        </div>
    </div>
    <div class="row">  
    <div class="col s12 m6">
            <?php
    		    $sql = "SELECT id_permiso,nombre FROM permisos";
    		    Page::setCombo("permiso", $permiso, $sql);
    		    ?>
        </div> 
           <div class="col s12 m6">
           <?php print $checkestado;?>
        </div>
    </div>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
<?php
Page::footer();
?>