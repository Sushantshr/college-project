<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<link rel="stylesheet"  href="../assets/css/bootstrap.min.css">
	<script type="text/javascript" src = "../assets/js/jquery.min.js"></script>
	<script type="text/javascript" src = "../assets/js/bootstrap.min.js"></script>
	<style type="text/css">
		table td, tr
		{
			border:1px solid white;
			padding: 10px;
			border-spacing: 10px;
		}
	</style>
</head>
<body style="background-image: url('black.jpg'); background-size: cover; background-repeat: no-repeat; color:white;">
<div class="container" >
	<nav class="nav navbar-inverse">
	<div class="container-fluid">
		<div class="nav navbar-header">
			<a href="home.crypt" class = "navbar-brand ">Home</a>
		</div>
		<ul class="nav navbar-nav">

			<li ><a href="insertuser">Insert User</a></li>
			<li><a href="getid" >Getid</a></li>
			<li ><a href="#" class="dropdown-toggle" data-toggle = "dropdown">Analysis<span class="caret"></span></a>
			<ul class="dropdown-menu navbar-nav navbar-inverse">
				<li><a href="analysisinsert.1">Insert time</a></li>
				<li><a href="analysisget.1">Get time</a></li>
			</ul>
			</ul>
		<div class="nav navbar-nav navbar-right">
			<li><a href="login/userlogout" >Log out</a> </li>
		</div>
		</div>	
	</nav>
	<hr>
</div>
<div class="container text-center" style="height:500px;">