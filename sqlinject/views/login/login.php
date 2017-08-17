<?php
	session_start();
	if (isset($_SESSION['user']))
		header('location:../home.crypt');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet"  href="../../assets/css/bootstrap.min.css">
	<script type="text/javascript" src = "../../assets/js/jquery.min.js"></script>
	<script type="text/javascript" src = "../../assets/js/bootstrap.min.js"></script>
</head>
<body style="background-color:#292929; color: white;">
<div class="container col-md-6 col-md-offset-3">

	<div class="Jumbotron">
		<h1 align="center"> Login to Admin Panel </h1>
	</div>
	<hr>
</div>

<div class="container text-center col-md-6 col-md-offset-3">
<div class="row">
		<form method="POST" action="login_process.php" class="form-horizontal">
		<div class="form-group">	
			<label class="col-sm-2 control-label">Username: </label>
			<div class=" col-sm-6"><input type="text" name="uname" class="form-control col-sm-6" required> </div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Password: </label>
			<div class=" col-sm-6"><input type="password" name="upass" class="form-control col-sm-6" required></div>
		</div>
			<div class="col-sm-6"><input type="submit" class = "btn btn-default" name="submit" value="login"></div>
		</form>
</div>
<hr>
<div class="row col-sm-6">
	<?php
		if(isset($_SESSION['msg']))
		{
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
	?>
</div>
</div>
</body>
</html>