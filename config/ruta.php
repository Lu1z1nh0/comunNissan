<?php	

	$host = getenv('HTTP_HOST'); //$_SERVER['HTTP_HOST'];
	//$ruta = rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); //incluye el fichero actual en la ruta
	$protocol = "";

	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
	    $protocol = "https";
	}
	else {
		$protocol = "http";
	}

	$url = "$protocol://$host/";

?>