
<!-- Inicio Titulo -->
<div class="container-excelautomotriz" style="background-color: #d13239; border-top-left-radius: 10px; border-top-right-radius: 10px;">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-12">
      <div class="titulocampana"><h2>Registro de Campañas</h2></div>
		<?php 

			//Debug
			//var_export( $_SESSION['usuario'] );
			//var_dump($_SESSION['usuario']);

			foreach (@$_SESSION['usuario'] as $key => $currentuser){ 

					if($key == "\0Usuario\0id"){
						$usrid = $currentuser;
						//echo '<script> console.log("userid: '.$usrid.' "); </script>';
					} elseif ($key == "\0Usuario\0nombre") {
						$usrname = $currentuser;
						//echo '<script> console.log("usrname: '.$usrname.' "); </script>';
					} elseif ($key == "\0Usuario\0correo") {
						$usrmail = $currentuser;
						//echo '<script> console.log("usrmail: '.$usrmail.' "); </script>';
					}

				} 
		?>
      <div class="loguser"><p class="centertxt"><i class="fa fa-user-circle-o" aria-hidden="true"></i> <span title="Hola :)"><?php if(isset($usrmail)) { echo $usrmail; } else { echo "USUARIO EN SESIÓN"; } ?></span></p></div>
     </div> 
  </div>
</div>
<!-- Fin Titulo --> 

			


