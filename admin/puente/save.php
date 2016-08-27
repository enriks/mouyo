<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../../lib/validator.php");

if(empty($_GET['id'])) 
{
    Page::header("Agregar Ingrediente a un jugo");
    $id=null;
    $jugo=null;
    $ingrediente=null;
}
else
{
    Page::header("Modificar Ingrediente de un jugo");
    $id = $_GET['id'];
    $sql = "SELECT * FROM detalle_bebida WHERE id_detalle = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $titulo =  htmlentities($data['titulo']);
    $descripcion =  htmlentities($data['descripcion']);
    $archivo= $data['imagen'];
    $fecha_limite= htmlentities($data['fecha_limite']);
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $jugo= htmlentities($_POST['jugo']);
     $ingrediente= htmlentities($_POST['ingrediente']);
    
    try
    {
        if($jugo == null || $ingrediente == null)
        {
            throw new Exception("Datos incompletos");
        }
        if($id==null)
        {
            $sql = "INSERT INTO detalle_bebida(id_jugo,id_ingrediente) VALUES(?,?)";
            $params = array($jugo,$ingrediente);
        }
        else
        {
            $sql = "update detalle_bebida set id_jugo=?, id_ingrediente=? where id_detalle=?";
            $params = array($juog,$ingrediente,$id);
        }
         Database::executeRow($sql, $params);
        @header("location: ../jugos/");
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
?>
<form method='post' class='row' enctype='multipart/form-data'>
    <div class='row'>
        <div class="col s12 m6">
            <?php
    		    $sql = "SELECT id_jugo, nombre FROM jugos";
    		    Page::setCombo("jugo", $jugo, $sql);
    		    ?>
        </div>
        <div class="col s12 m6">
            <?php
    		    $sql = "SELECT id_ingrediente, nombre FROM ingrediente";
    		    Page::setCombo("ingrediente", $ingrediente, $sql);
    		    ?>
        </div>
    </div>
    <a href='../jugos/' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
<?php
Page::footer();
?>