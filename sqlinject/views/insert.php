<?php
	include("includes/header.php");
	session_start();
	if (!isset($_SESSION['user']))
		header('location:login/userlogin');

?>

<form action="insert_process.php" method = "POST" class="form-horizontal" >
	<div class="container text-center">
		<div class="form-group">	
			<label class="col-sm-2 control-label">UserName:</label>
			<div class=" col-sm-4"><input type="text" name="uname" class="form-control" required></div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Password:</label>
			<div class=" col-sm-4"><input type="password" name="upass" class="form-control col-sm-8" required></div>
		</div>
			<div class="col-sm-6"><input type="submit" class = "btn btn-default" name="submit" value="Create User"></div>
	</div>
</form>

<?php
	if (isset($_SESSION['insert_normal']))
	{
		echo "<hr>".$_SESSION['insert_normal'];
		unset($_SESSION['insert_normal']);
	}
	if (isset($_SESSION['insert_hash']))
	{
		echo "<hr>".$_SESSION['insert_hash'];
		unset($_SESSION['insert_hash']);
	}
?>

<?php include("includes/footer.php"); ?>