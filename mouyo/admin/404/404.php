<?php
ob_start();
require("../lib/page.php");
Page::header("No hemos encontrado la pagina");
?>
<div class="row">
	<p>Esa pagina no se encuentra en Mouyo.</p>
	<a href="../../public/" class=" red darken-4 waves-effect waves-light btn">Volver a Mouyo</a>
</div>
<?php
Page::footer();
?>