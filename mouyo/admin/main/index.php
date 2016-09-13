<!--pagina principal sitio privado-->
<?php
require("../lib/page.php");
Page::header("Bienvenid@");
date_default_timezone_set("America/El_Salvador");
?>
<div class="row">
	<h4>Hoy es <?php print(date('d/m/Y H:i:s')); ?></h4>
</div>
<?php
Page::footer();
?>