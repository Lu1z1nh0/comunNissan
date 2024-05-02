<?php
	date_default_timezone_set ('America/El_Salvador');

	/* Permite acceder a la clase Usuario */
	//require_once('class/usuario.php');

	/* Conforma el inicio de sesion del sistema */
	require_once("config/sesion.php"); 

	/* Conforma la conexion con la BD */
	require_once("config/conexion-config.php");

	/* Header de la plantilla */
	require_once("template/header-admin.php");  

	/* Titulo de la página */
	require_once("template/titulo.php");

	/* Menu del administrador */   
	require_once("template/menu.php"); 

?>  

<!-- Inicio Contenido -->
<section> 
	<div class="container-excelautomotriz" style="background-color:#d13239;">
		<div class="row">
		  <div class="col-12 col-sm-12 col-md-12 col-lg-12">
		  	<div class="welcome-div-img">
		  		<img src="assets/img/bg-excel-talleres.png" class="welcome-div-img">
		  		<p id="welcome" <?php if(!isset($_GET['msjcls10'])){ echo 'style="display: none;"'; } ?> class="<?php if(isset($_GET['msjcls10'])){ echo $_GET['msjcls10']; } ?>"><?php if(isset($_GET['mensaje10'])){ echo $_GET['mensaje10']; } ?></p>	
		  	</div>
		  </div>
		</div>
	</div>
</section>
<!-- Fin Contenido -->
    
<?php  

	/* Footer de la plantilla */
	require_once("template/footer-admin.php"); 

?>
 