<?php
session_start();
    class page2
    {
        public static function header()
        {
            #si se necesita la hora :v
            #ini_set("date.timezone","America/El_Salvador");
            
            /*Arreglo que tiene informacio del header, rutas y ubicaciones que se mandan a llamar*/
            
            $session=false;
            $filename=basename($_SERVER['PHP_SELF']);
            $header2="<!DOCTYPE html>
                        <html lang='es'>
                        <head>
                            <meta charset='UTF-8'>
                            <title>Jugos Mouyo</title>
                             <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                            <link rel='stylesheet' href='../css/materialize.min.css' media='screen,projection'>
                            <link rel='stylesheet' href='../css/ghpages-materialize.css'>
                            <link rel='stylesheet' href='../css/icons.css'>
                            <link rel='stylesheet' href='../css/prism.css'>
                            <link rel='stylesheet' href='../css/hover.css'>
                            <link rel='stylesheet' href='../css/slider.css' media='screen,projection'>
                            <link rel='stylesheet' href='../css/style.css'>
                        </head>
                        <body class='light-blue lighten-5' >
                            <div class='navbar-fixed'>
                            <nav class='teal accent-5'>
                                <div class='nav-wrapper'>"; 
            
            /*Variable de sesion que consulta si hay un usuario activo para ver las siguentes páginas*/
            
            if(isset($_SESSION['nombre_apellido_usuario']))
            {
                
                $session=true;
                $header2.="<a href='index.php' class='brand-logo left'>
		        					<img src='img/mouyo.png' alt='hey profe'>
		        				</a>
                        <a href='#' data-activates='mobile' class='button-collapse'><i class='material-icons'>menu</i></a>
	        					<ul class='right hide-on-med-and-down'>
		          					<li><a href='index.php'>Pagina Principal</a></li>
                                    <li><a href='jugos.php'>Jugos</a></li>
                                    <li><a href='ingredientes.php'>Ingredientes</a></li>
                                    <li><a href='acercade.php'>Acerca de</a></li>
                                    <li><a href='faq.php'>Preguntas Frecuentes</a></li>
		          					<li><a class='dropdown-button' href='#' data-activates='dropdown'><div class='chip'>
                                    <img id='foto_perfil imagen_video'
                                    src='data:image/*;base64,$_SESSION[img]'
                                    class='responsive-img'>
                                    $_SESSION[nombre_apellido_usuario]
                                  </div></a></li>
		        				</ul>
		        				<ul id='dropdown' class='dropdown-content'>
									<li><a href='usuarios.php?id=$_SESSION[id_usuario]'>Editar perfil</a></li>
                                    <li><a href='cotizacion.php'>Cotizacion</a></li>
									<li><a href='main/logout.php'>Salir</a></li>
								</ul>
			        			<ul class='side-nav' id='mobile'>
	        						<li><a href='index.php'>Pagina Principal</a></li>
                                    <li><a href='jugos.php'>Jugos</a></li>
                                    <li><a href='ingredientes.php'>Ingredientes</a></li>
                                    <li><a href='acercade.php'>Acerca de</a></li>
                                    <li><a href='faq.php'>Preguntas Frecuentes</a></li>
			          				<li><a class='dropdown-button' href='#' data-activates='dropdown-mobile'>$_SESSION[nombre_apellido_usuario]</a></li>
	      						</ul>
	      						<ul id='dropdown-mobile' class='dropdown-content'>
									<li><a href='../admin/usuario/save.php?id=$_SESSION[id_usuario] '>Editar perfil</a></li>
                                    <li><a href='cotizacion.php'>Cotizacion</a></li>
										<li><a href='main/logout.php'>Salir</a></li>
								</ul>" ;
            }
            else
            {
                $header2.="<a href='#' data-activates='mobile' class='button-collapse'><i class='material-icons'>menu</i></a>
	        					<ul class='right hide-on-med-and-down'>
		          					<li><a href='index.php'>Pagina Principal</a></li>
                                    <li><a href='jugos.php'>Jugos</a></li>
                                    <li><a href='ingredientes.php'>Ingredientes</a></li>
                                    <li><a href='acercade.php'>Acerca de</a></li>
                                    <li><a href='faq.php'>Preguntas Frecuentes</a></li>
                                    <li><a class='dropdown-button' href='#' data-activates='dropdown-mobile'>Sesion</a></li></ul>
                                    <ul id='dropdown-mobile' class='dropdown-content'>
									<li><a class='modal-trigger' href='#modal1'>Iniciar Sesion</a></li>
										<li><a href='register.php'>Registrarse</a></li>
								</ul>";
            }
            $header2 .= "
            </div>
		    			</nav>
	  				</div>
                    <div id='modal1' class='modal'>
                    <div class='modal-content'>
                    <form class='row center-align' method='post' action='login.php'>
                    <div class='row'>
                    <div class='input-field col m6 offset-m3 s12'>
                    <i class='material-icons prefix'>person_pin</i>
                    <input id='alias' type='text' name='alias' autocomplete='off' class='validate' required/>
                    <label for='alias'>Usuario</label>
                    </div>
                    <div class='input-field col m6 offset-m3 s12'>
                    <i class='material-icons prefix'>vpn_key</i>
                    <input id='clave' type='password' name='clave' class='validate' required/>
                    <label for='clave'>Contraseña</label>
                    </div>
                    </div>
                    <button type='submit' class='btn blue'><i class='material-icons right'>verified_user</i>Aceptar</button>
                    </form>
                    </div>
                    <div class='modal-footer'>
                      <a href='#!' class=' modal-action modal-close waves-effect waves-green btn-flat'>Cerrar</a>
                    </div>
                  </div>
	  				";
            print($header2);
        }
        
        /* se establecen funciones de nombre, valor y consulta al siguiente combobox*/
        
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
         public static function setCombo_texto($name, $value, $query)
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
            return $combo;
        }
        
public static function footer()
{
    $footer="<script src='https://www.google.com/recaptcha/api.js'></script><script src='../js/jquery-2.2.3.min.js'></script>
   <script src='../js/materialize.min.js'></script>
   <script src='../bin/materialize.js'></script>
   <script src='../jade/lunr.min.js'></script>
   <script src='../js/init.js'></script>
   <script src='../js/prism.js'></script>
    <script src='../js/app.js'></script> 
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
    print $footer;
}
    }
        ?>

