<?php
session_start();
include('../../class/normal_data.php');
$normaldata = new NormalData();

if(!isset($_SESSION['user']))
{
	if(isset($_POST['submit']))
	{

		$user = htmlspecialchars($_POST['uname']);
		$pass = htmlspecialchars($_POST['upass']);
		
		$check = $normaldata->get_data($user, $pass);

		if ($check>=1)
		{
			$_SESSION['user'] = $user;
			header('location:../home.crypt');
		}
		$_SESSION['msg'] = " UserName or password Error";
	}
		header('location:userlogin');
}
else
	header('location:../home.crypt');
?>