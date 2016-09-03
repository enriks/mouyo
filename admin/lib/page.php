<!--Archivo principal contiene los etiquetas index-->
<?php 
   session_start();
    class page
    {
        public static function header($title)
        {
            #si se necesita la hora :v
            ini_set("date.timezone","America/El_Salvador");
            $session=false;
            $filename=basename($_SERVER['PHP_SELF']);
            $header="<!DOCTYPE html>
                        <html lang='es'>
                        <head>
                            <meta charset='UTF-8'>
                            <title>Prueba de index</title>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                            <link type='text/css' rel='stylesheet' href='../../css/icons.css'/>
                            <link rel='stylesheet' href='../../css/materialize.min.css' media='screen,projection'>
                            <link rel='stylesheet' href='../../css/ghpages-materialize.css'>
                            <link rel='stylesheet' href='../../css/icons.css'>
                            <link rel='stylesheet' href='../../css/prism.css'>
                            <link rel='stylesheet' href='../../css/hover.css'>
                            <link rel='stylesheet' href='../../css/slider.css' media='screen,projection'>
                            <link rel='stylesheet' href='../../css/estilos.css' media='screen,projection'>
                        </head>
                        <body>
                            <div class='navbar-fixed'>
                            <nav class='blue-grey'>
                                <div class='nav-wrapper'>";
            if(isset($_SESSION['usuario_admin']))
            {
                
                $session=true;
                if($_SESSION['permisos']==1)
                {
                   $header.="<a href='../main/' class='brand-logo'>
                            <i class='material-icons left hide-on-med-and-down'>undo</i>Sitio Privado
		        		</a>
                        <a href='#' data-activates='mobile' class='button-collapse'><i class='material-icons'>menu</i></a>
                            <ul class='right hide-on-med-and-down'>
                                <li><a href='../admin/index.php'>Administradores</a></li>
                                <li><a href='../usuario/index.php'>Usuario</a></li>
                                <li><a class='dropdown-button' href='#' data-activates='dropdown'><div class='chip'>
                                <img id='foto_perfil imagen_video'
                                src='data:image/*;base64,$_SESSION[img_admin]'
                                class='responsive-img'>
                                $_SESSION[usuario_admin]
                              </div></a></li>
                            </ul>
                            <ul id='dropdown' class='dropdown-content'>
                                <li><a href='../usuario/'>Editar perfil</a></li>
                                <li><a href='../main/logout.php'>Salir</a></li>
                            </ul>
                            <ul class='side-nav' id='mobile'>
                               <li><a href='../admin/index.php'>Administradores</a></li>
                                <li><a class='dropdown-button' href='#' data-activates='dropdown-mobile'>$_SESSION[usuario_admin]</a></li>
                            </ul>
	      						<ul id='dropdown-mobile' class='dropdown-content'>
									<li><a href='../usuario/'>Editar perfil</a></li>
										<li><a href='../main/logout.php'>Salir</a></li>
								</ul>"; 
                }
                elseif($_SESSION['permisos']==2)
                {
                    $header.="<a href='../main/' class='brand-logo'>
                            <i class='material-icons left hide-on-med-and-down'>undo</i>Sitio Privado
		        		</a>
                        <a href='#' data-activates='mobile' class='button-collapse'><i class='material-icons'>menu</i></a>
	        					<ul class='right hide-on-med-and-down'>
                                    <li><a href='../promociones/index.php'>Promociones</a></li>
		          					<li><a href='../descuentos/index.php'>Descuentos</a></li>
		          					<li><a class='dropdown-button' href='#' data-activates='dropdown'>
                                    <div class='chip'>
                                    <img id='foto_perfil imagen_video'
                                    src='data:image/*;base64,$_SESSION[img_admin]'
                                    class='responsive-img'>
                                    $_SESSION[usuario_admin]
                                  </div></a></li>
		        				</ul>
		        				<ul id='dropdown' class='dropdown-content'>
									<li><a href='../usuario/'>Editar perfil</a></li>
									<li><a href='../main/logout.php'>Salir</a></li>
								</ul>
			        			<ul class='side-nav' id='mobile'>
                                 <li><a href='../promociones/index.php'>Promociones</a></li>
		          					<li><a href='../descuentos/index.php'>Descuentos</a></li>
			          				<li><a class='dropdown-button' href='#' data-activates='dropdown-mobile'>$_SESSION[usuario_admin]</a></li>
	      						</ul>
	      						<ul id='dropdown-mobile' class='dropdown-content'>
									<li><a href='../usuario/'>Editar perfil</a></li>
										<li><a href='../main/logout.php'>Salir</a></li>
								</ul>";
                }
                elseif($_SESSION['permisos']==3)
                {
                    $header.="<a href='../main/' class='brand-logo'>
                            <i class='material-icons left hide-on-med-and-down'>undo</i>Sitio Privado
		        		</a>
                        <a href='#' data-activates='mobile' class='button-collapse'><i class='material-icons'>menu</i></a>
	        					<ul class='right hide-on-med-and-down'>
		          					<li><a href='../jugos/index.php'>Jugos</a></li>
		          					<li><a href='../ingredientes/index.php'>ingredientes</a></li>
		          					<li><a href='../tamanio/index.php'>Vasos</a></li>
		          					<li><a class='dropdown-button' href='#' data-activates='dropdown'>
                                    <div class='chip'>
                                    <img id='foto_perfil imagen_video'
                                    src='data:image/*;base64,$_SESSION[img_admin]'
                                    class='responsive-img'>
                                    $_SESSION[usuario_admin]
                                  </div></a></li>
		        				</ul>
		        				<ul id='dropdown' class='dropdown-content'>
									<li><a href='../usuario/'>Editar perfil</a></li>
									<li><a href='../main/logout.php'>Salir</a></li>
								</ul>
			        			<ul class='side-nav' id='mobile'>
	        						<li><a href='../jugos/index.php'>Jugos</a></li>
		          					<li><a href='../ingredientes/index.php'>ingredientes</a></li>
		          					<li><a href='../tamanio/index.php'>Vasos</a></li>
		          					<li><a class='dropdown-button' href='#' data-activates='dropdown'>
			          				<li><a class='dropdown-button' href='#' data-activates='dropdown-mobile'>$_SESSION[usuario_admin]</a></li>
	      						</ul>
	      						<ul id='dropdown-mobile' class='dropdown-content'>
									<li><a href='../usuario/'>Editar perfil</a></li>
										<li><a href='../main/logout.php'>Salir</a></li>
								</ul>";
                }
                elseif($_SESSION['permisos']==4)
                {
                    
                $header.="<a href='../main/' class='brand-logo'>
                            <i class='material-icons left hide-on-med-and-down'>undo</i>Sitio Privado
		        		</a>
                        <a href='#' data-activates='mobile' class='button-collapse'><i class='material-icons'>menu</i></a>
	        					<ul class='right hide-on-med-and-down'>
		          					<li><a href='../jugos/index.php'>Jugos</a></li>
		          					<li><a href='../ingredientes/index.php'>ingredientes</a></li>
		          					<li><a href='../promociones/index.php'>Promociones</a></li>
		          					<li><a href='../admin/index.php'>Administradores</a></li>
		          					<li><a href='../usuario/index.php'>Usuario</a></li>
		          					<li><a href='../descuentos/index.php'>Descuentos</a></li>
		          					<li><a href='../tamanio/index.php'>Vasos</a></li>
		          					<li><a class='dropdown-button' href='#' data-activates='dropdown'><div class='chip'>
                                    <img id='foto_perfil imagen_video'
                                    src='data:image/*;base64,$_SESSION[img_admin]'
                                    class='responsive-img'>
                                    $_SESSION[usuario_admin]
                                  </div></a></li>
		        				</ul>
		        				<ul id='dropdown' class='dropdown-content'>
									<li><a href='../usuario/'>Editar perfil</a></li>
									<li><a href='../main/logout.php'>Salir</a></li>
								</ul>
			        			<ul class='side-nav' id='mobile'>
	        						<li><a href='../jugos/index.php'>Jugos</a></li>
		          					<li><a href='../ingredientes/index.php'>ingredientes</a></li>
		          					<li><a href='../promociones/index.php'>Promociones</a></li>
		          					<li><a href='../admin/index.php'>Administradores</a></li>
		          					<li><a href='../descuentos/index.php'>Descuentos</a></li>
		          					<li><a href='../tamanio/index.php'>Vasos</a></li>
			          				<li><a class='dropdown-button' href='#' data-activates='dropdown-mobile'>$_SESSION[usuario_admin]</a></li>
	      						</ul>
	      						<ul id='dropdown-mobile' class='dropdown-content'>
									<li><a href='../usuario/'>Editar perfil</a></li>
										<li><a href='../main/logout.php'>Salir</a></li>
								</ul>";
                }
            }
            else
            {
                $header.="<a href='../../' class='brand-logo'>
	        						<i class='material-icons'>web</i>
	    						</a>";
            }
            $header .= "</div>
		    			</nav>
	  				</div>
	  				<div class='container center-align'>";
            print ($header);
            if($session)
            {
                if($filename != "login.php")
                {
                    
                    print("<h2>$title</h2>");
                }
                else
                {
                    header("location: index.php");
                }
            }
            else
            {
                if($filename != "login.php" && $filename != "register.php" && $filename != "activesesion.php" && $filename != "404.php")
                {
                    print("<div class='card-panel red'><a href='../main/login.php><h5>Debe iniciar sesion.</h5></a></div>");
                }
                else
                {
                    print("<h5>$title</h5>");
                }
            }
        }
        
        public static function footer()
        {
            $footer="</div>   
                     <script src='../../js/jquery-2.2.3.min.js'></script>
                       <script src='../../js/materialize.min.js'></script>
                       <script src='../../bin/materialize.js'></script>
                       <script src='../../jade/lunr.min.js'></script>
                       <script src='../../js/init.js'></script>
                       <script src='../../js/prism.js'></script>
                        <script src='../../js/app.js'></script>
                        <script>
	    				$(document).ready(function() { $('.button-collapse').sideNav(); });
	    				$(document).ready(function() { $('.materialboxed').materialbox(); });
	    				$(document).ready(function() { $('select').material_select(); });
                        $(document).ready(function(){ $('.modal-trigger').leanModal();
                        $('.collapsible').collapsible({
                        accordion : false }); });
                        $('.datepicker').pickadate({ selectMonths: true,  selectYears: 1000, format: 'yyyy-mm-dd' });
                        var options = [ {selector: '#staggered-test', offset: 50, callback: function() { Materialize.toast('This is our ScrollFire Demo!', 1500 ); } }, {selector: '#staggered-test', offset: 205, callback: function() { Materialize.toast('Please continue scrolling!', 1500 ); } }, {selector: '#staggered-test', offset: 400, callback: function() { Materialize.showStaggeredList('#staggered-test'); } }, {selector: '#image-test', offset: 500, callback: function() { Materialize.fadeInImage('#image-test'); } } ]; Materialize.scrollFire(options); 
	    			</script>
                    </body>
                    </html>";
            print($footer);
        }
        
        public static function setCombo($name, $value, $query)
        {
            $data =Database::getRows($query,null);
            $combo="<select name='$name' requeried>";
            if($value == null)
            {
                $combo .= "<option value='' disabled selected>Selecione una opcion</option>";
            }
            foreach($data as $row)
            {
                $combo .="<option value='$row[0]'";
                if(isset($_POST[$name])==$row[0] || $value == $row[0])
                {
                    $combo.="selected";
                }
                $combo .=">$row[1]</option>";
            }
            $combo.="</select>
                    <label style='text-transform:capitalize;'>$name</label>";
            print($combo);
        }
    }
?>