<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
Page::header("Ya haz iniciado sesion rufian");
?>
<div class="row">
	<p>Hemos descubierto que tienes una sesion activa, vuelva a esa sesion y termine sus cambios.</p>
	<a href="login.php" class=" red darken-4 waves-effect waves-light btn">Volver al login</a>
</div>
<?php
Page::footer();
?>