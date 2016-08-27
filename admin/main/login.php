<!-- codigo para inicio de sesion-->
<?php
ob_start();
require("../lib/page.php");
require('../../lib/validator.php');
require("../../lib/database.php");
$sql="select * from admin";
$data=Database::getRows($sql,null);
if($data==null)
{
    @header("location:register.php");
}

Page::header("Iniciar sesion");

if(!empty($_POST))
{
    $_POST=validator::validateForm($_POST);
    $alias=$_POST['alias'];
    $clave=$_POST['clave'];
    try
    {
        if($alias != "" && $clave!="")
        {
            $sql="select * from admin where alias=?";
            $param = array($alias);
            $data=Database::getRow($sql,$param);
            if($data != null)
            {
                $hash=$data['clave'];
                if(password_verify($clave,$hash))
                
                    $sql2="select sesion from admin where id_admin=?";
                    $params2=array($data['id_admin']);
                    $dat=Database::getRow($sql2,$params2);
                    if($dat != null)
                    {
                        if($dat['sesion']==1)
                        {    
                        @header("location: activesesion.php");
                        }
                        else
                        {
                            $_SESSION['id_admin'] = $data['id_admin'];
                            $_SESSION['usuario_admin'] = $data['alias'];
                            $_SESSION['permisos']=$data['permiso'];
                            $sql="update admin set sesion=1 where id_admin=?";
                            $params=array($data['id_admin']);
                            Database::executeRow($sql,$params);
                            $_SESSION['img_admin']=$data['foto'];
                            @header("location: index.php");
                        }
                    
                   }
                else
                {
                    throw new Exception("Laclave ingresada es incorrecata wey.");
                }
            }
            else
            {
                throw new Exception("El alias ingresado no existe wey.");
            }
        }
        else
        {
            throw new Exception("Debes ingresar un alias y una clave we");
        }
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
?>
<div class="center">
      <div class="card bordered z-depth-2" style="margin:0% auto; max-width:400px;">
        <div class="card-header">
           <i class="material-icons medium white-text">verified_user</i>
        </div>
        <div class="card-content">
          <form method="post" name="pene2" enctype="multipart/form-data">
            <div class="input-field col s12">
              <input name="alias" id="alias" autocomplete="off" type="text" class="validate">
              <label for="alias">Nombre de Usuario</label>
           </div>
            <div class="input-field col s12">
              <input name="clave" id="clave" autocomplete="off" type="password" class="validate">
              <label for="clave">Contraseña</label>
            </div>
            <br>
              <button type='submit' class='btn blue'><i class='material-icons right'>verified_user</i>Iniciar Sesion</button>
          </form> 
        </div>
        <div class="card-action clearfix">
          <div class="row">
            <div class="col s12 right-align text-p">
              <a href="registro.php" class="orange-text tooltipped" data-position="top" data-delay="50" data-tooltip="Registrate ahora">REGÍSTRATE AHORA</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php Page::footer(); ?>