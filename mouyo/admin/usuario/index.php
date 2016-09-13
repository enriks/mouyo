<!--llamamos los archivos necesarios-->
<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
verificador::permiso1($_SESSION['permisos']);
Page::header("Usuarios");
$sql = "SELECT * FROM usuario ORDER BY id_usuario";
	$params = null;
$data=Database::getRows($sql,$params);
if(!empty($_POST))
    {
    foreach($data as $k)
    { 
        $indice="estado"."$k[id_usuario]";
    
        if(isset($_POST["$indice"]))
        {
        $estado=$_POST["$indice"];
            $slq="update usuario set estado =? where id_usuario = ?";
            $params=array($estado,$k['id_usuario']);
            Database::executeRow($slq,$params);
            header("location:index.php");
        }
    }   
    }
	
if($data != null)
{
    /*cargamos la tabla de usuarios*/
    $tabla="";
    foreach($data as $row)
		{
        
            $tabla .="<ul class='collection'>";
                    
            $tabla .="<li class='collection-item dismissable'>";
            $tabla .="<div>";
            $tabla .="<div class='row'>";
            $tabla .="<div class='col m4 s8'>";
            $tabla .="<img id='foto_perfil imagen_video'
            src='data:image/*;base64,$row[foto_perfil]'
            class='responsive-img'>";
            $tabla .="</div>";
            $tabla .="<div class='col m8 s12'><form method='post' name='frm$row[id_usuario]' class='center-align'>
<fieldset>";
            $tabla .="<p id='texto-tabla' class='center-align'>";
            $tabla .="<strong>Nombre: 
            </strong>$row[nombre]<br>";
            $tabla .="<strong>Apellido:
            </strong>$row[apellido]<br>";
            $tabla .="<strong>Alias:
            </strong>$row[alias]<br>";
            $tabla .="<strong>Correo:
            </strong>$row[correo]<br>";
            $tabla .="<strong>Fecha Nacimiento:
            </strong>$row[fecha_nacimiento]<br>";
            $tabla .="<strong>Estado:
            </strong>";
            if($row['estado']==1)
            {
                $checked="checked";
                $tabla .= "

            <input id='activo$row[id_usuario]' type='radio' name='estado$row[id_usuario]' class='with-gap' $checked value='1' />
      <label for='activo$row[id_usuario]'><i class='material-icons'>visibility</i></label>
    <input id='inactivo$row[id_usuario]' type='radio' name='estado$row[id_usuario]' class='with-gap' value='0'/>
    <label for='inactivo$row[id_usuario]'><i class='material-icons'>visibility_off</i></label>";
            }
        else
            {
                $checked="checked";
                $tabla .= "<input id='activo$row[id_usuario]' type='radio' name='estado$row[id_usuario]' class='with-gap'  value='1' />
      <label for='activo$row[id_usuario]'><i class='material-icons'>visibility</i></label>
    <input id='inactivo$row[id_usuario]' $checked type='radio' name='estado$row[id_usuario]' class='with-gap' value='0'/>
    <label for='inactivo$row[id_usuario]'><i class='material-icons'>visibility_off</i></label>";
            }
             $tabla .="<br><button name='enviar$row[id_usuario]' type='submit' class='btn blue'><i class='material-icons right'>save</i>Modificar estado</button>";
            $tabla .="</p></fieldset></form>";
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