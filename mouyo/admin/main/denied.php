<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
Page::header("No tienes poder aqui");
?>
<div class="row">
	<p>Mortal no tienes permitido estar en estos dominios vuelve por donde viniste.</p>
</div>
<?php
Page::footer();
?>