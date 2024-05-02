<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta content="IE=edge" http-equiv="X-UA-Compatible">    
		<meta content="width=device-width, initial-scale=1" name="viewport">
		<meta content="MarkCoWeb" name="author">
		<meta content="Excel-Talleres-Recall-SV" name="description">
		
		<title>Excel Talleres Recall SV</title>

		<!-- Favicon -->
		<link rel="shortcut icon" href="/assets/img/excel-favico.ico">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="/assets/css/bootstrap.min.css" type="text/css">    
		<link rel="stylesheet" href="/assets/css/general.css" type="text/css">
		<link rel="stylesheet" href="/assets/css/animate.css" type="text/css">

		<!-- Font-Awesome Icons -->
		<link href="/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<!-- Para usar jQuery -->
		<script src="/assets/js/jquery-3.3.1.min.js"></script>

		<!-- jQuery UI -->			
		<link rel="stylesheet" href="/assets/js/jquery-ui-1.12.1/jquery-ui.min.css">
		<script src="/assets/js/jquery-ui-1.12.1/jquery-ui.min.js"></script>

		<!-- Glide -->
		<!-- Required Core Stylesheet -->
		<link rel="stylesheet" href="/assets/css/glide.core.min.css">
		<!-- Optional Theme Stylesheet -->
		<link rel="stylesheet" href="/assets/css/glide.theme.min.css">

		<!-- Tooltip -->
		<script>
			$( function() {
				$( document ).tooltip();
			} );
		</script>
	</head>
	
	<body>
		<!-- Inicio Header -->
		<header>
			<div class="logo-admin"><a href="/" title="Ir a Inicio"><img alt="excel-logo" src="/assets/img/excel-logo-white.png"></a></div>
			<!-- Global site tag (gtag.js) - Google Analytics -->
			<!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-133187744-1"></script>-->
			<script>
			/*
			 window.dataLayer = window.dataLayer || [];
			 function gtag(){dataLayer.push(arguments);}
			 gtag('js', new Date());

			 gtag('config', 'UA-133187744-1');
			 */
			</script>
		</header>
		<!-- Fin Header -->

		<!-- Inicio Contenido -->
		<section> 
			<!-- Seccion superior -->
			<div class="container-excelautomotriz" style="background-color: #d13239; border-top-left-radius: 10px; border-top-right-radius: 10px">
			  <div class="row">
				<div class="col-md-12 col-sm-12 col-12">
					<br/>
					<br/>
					<br/>
				</div> 
			  </div>
			</div>   
			<!-- fin -->

			<!-- Titulo de Error -->
			<div class="container-excelautomotriz" style="background-color:#1e1e1e;">
			  <div class="row">
				<div class="col-md-12 col-sm-12 col-12">
				  <div class="video">
					<div class="tituloerror" style="border-radius: 10px;"><h2>¡Vaya! Algo salió mal.</h2></div>
					<input type="hidden" value="<?php echo $_GET['mensaje']; ?>">
					<div class="centertxt"><a href="javascript:history.back(-1);"><i style="transform: rotate(180deg);" class="fa fa-sign-out" aria-hidden="true"></i> Regresar</a></div>
				  </div>
				</div> 
			  </div>
			</div>
			<!-- fin -->

			<!-- Version -->
			  <div id="mi-aside" class="container-excelautomotriz" style="background-color:#d13239;">
				<div class="row">
				  <div class="col-12 col-sm-12 col-md-12 col-lg-12">
					<img src="/assets/img/bg-excel-talleres-error.png" style="width: 100%; height: auto;">
				  </div>
				</div> 
			  </div>
			<!-- fin -->
		</section> 	
		<!-- Fin Contenido -->

		<!-- Inicio Footer -->
		<footer>
			<!-- Inicio Footer-parte 1 -->
			<div class="container-excelautomotriz" style="background-color:#1e1e1e;">
			<div class="row">
			  <div class="col-md-12 col-sm-12 col-12">
				<br/>
				<div style="display: flex; justify-content: center;">
					<span>
					  <img title="Version" src="/assets/img/excel-logo-small.png" alter="excel-footer" style="width: 30px;" />
					</span>
				</div>
				<p style="text-align: center; margin-bottom: 0px; font-weight: bold; color: #fff; font-size: 12px;">v2.0</p>
				<br/>
			  </div> 
			</div>
			</div>
			<!-- Fin Footer-parte 1 -->

			<!-- Inicio Footer-parte 2 -->
			<div class="container-excelautomotriz" style="background-color:#d13239; border-bottom-left-radius:10px; border-bottom-right-radius:10px;">
			<div class="row">
			  <div class="col-md-12 col-sm-12 col-12">
			   <div style="margin-top:50px;"></div>
			   </div> 
			</div>
			</div>
			<!-- Fin Footer-parte 2 -->

			<!-- Inicio Copyright -->
			<div class="container-excelautomotriz">
			<div class="row">
			  <div class="col-md-12 col-sm-12 col-12">
				<br/>
				<center>
				<div class="footer2"><i class="fa fa-copyright" aria-hidden="true"></i> Todos los Derechos Reservados <?php $anyo = getdate(); echo "$anyo[year]"; ?> | <a style="color: #d4081c;" href="https://www.markcoweb.com/" target="_blank">Powered by: MarkCoWeb</a>
									  </div>
				</center>
				<br/> 
			   </div> 
			</div>
			</div>
			<!-- Fin Copyright -->
		</footer>
		<!-- Fin Footer -->
    </body>
</html>

    
    