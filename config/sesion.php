<?php 

	ini_set('session.gc_maxlifetime', '180');
	ini_set("session.cookie_lifetime","600");
	
	session_start();

	if (!isset($_SESSION['usuario'])) {
		header('Location: admin');
	}
?>


