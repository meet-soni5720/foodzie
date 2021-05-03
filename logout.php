<?php 
	include('config.php');
	include('config_login.php');
	session_start();
	session_unset($_SESSION['user']);

	//Reset OAuth access token
	$google_client->revokeToken();
	session_destroy();
	header('location: login.php');
?>