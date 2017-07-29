<?php
session_start();
	include('mainclass.php');

	$username = $_POST['username'];
	$password = $_POST['password'];

	$user = new DB;
	//regular entry
	$regular = $user->get_data($username, $password);
	$_SESSION['regular'] = ($regular);
	//static analysis
	$static = $user->get_id($username, $password);
	$_SESSION['static'] = $static;
	//print_r($_SESSION['static']);
	
	header("location:home");
?>