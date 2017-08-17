<?php
	session_start();
	if(isset($_SESSION['user']))
	{
		unset($_SESSION['user']);
		session_destroy();
		session_start();
		$_SESSION['msg'] = "Logged Out";
	}
	header('location:userlogin');
?>