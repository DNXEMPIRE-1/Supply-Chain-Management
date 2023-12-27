<?php
	include("includes/config.php");
	session_start();
	if(isset($_SESSION['admin_login']) || isset($_SESSION['manufacturer_login']) || isset($_SESSION['retailer_login'])) {
		session_destroy();
		echo "<h1 style=\"color:#009688\">Log Out Successful</h1>";
//		echo "<h2 style=\"color:#009688\">You will be redirected to Login page in 3 seconds...</h2>";
		header('Refresh:2;url="index.php"');
	}
	else {
			header('Location:../index.php');
	}
?>