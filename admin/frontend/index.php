<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
$nombre=null;
    $tipo=null;
    $archivo=null;
    $precio=null;
    $descripcion=null;
verificador::permiso3($_SESSION['permisos']);
Page::header("frontend");
?>
<!--codigo php para frontend-->
<?php

	$sql = "select * from frontend";
	$params = null;

$data=Database::getRow($sql, $params);
if($data != null)
{
    $tabla="";
      $tabla .="<ul class='collection'>
            <br><a class='btn waves-effect waves-light indigo darken-4' href='save.php?               id=".base64_encode($data['id_frontend'])."'>Modificar<i id='img_btn' class='material-icons'>mode_edit</i></a>
            <li class='collection-item dismissable'>
            <div>
            <div class='row'>
            <div class='col m6 s12'
            <strong>Imagen: 
            </strong><h4>Fondo</h4>
            <img id='foto_perfil imagen_video'
            src='data:image/*;base64,$data[fondo]'
            class='responsive-img'>
            
            </div>
            <div class='col m6 s12'
            <strong>Imagen: 
            </strong><h4>logo</h4>
            <img id='foto_perfil imagen_video'
            src='data:image/*;base64,$data[logo]'
            class='responsive-img'>
            
            </div>
            <div class='col s12'
            <strong>video: 
            </strong><h4>Vida y salud</h4>
            <video controls>
            <source type='video/mp4' src='data:video/*;base64,$data[video]'
            class='responsive-img'>
            
            </div>
            <div class='col s12'>
            <p id='texto-tabla'>
            <strong>Facebook:
            </strong><a href='$data[facebook]'>Ir($data[facebook])</a>
            <strong>Twitter:
            </strong><a href='$data[twitter]'>Ir ($data[twitter])</a><br>
            <strong>Preguntas Frequentes (Faq):
            </strong>$data[pregunta1]<br>
            <p>$data[respuesta1]</p>
            </strong>$data[pregunta2]<br>
            <p>$data[respuesta2]</p>
            </strong>$data[pregunta3]<br>
            <p>$data[respuesta3]</p>
            </strong>$data[pregunta4]<br>
            <p>$data[respuesta4]</p>
            <strong>Footer:
            </strong>Telefono: $data[numero_telefono]<br>
            </p>
                </div>
                </div>
                </div>
                </li>
                </ul>";                  
            print($tabla);
    }
else
{
    print("<div class='card-panel yellow'><i class='material-icons left'>warning</i>No hay registros.</div>");
}
Page::footer();
?>