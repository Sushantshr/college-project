<?php include("includes/header.php"); ?>

<div class="container text-center">
<div class="row">
		<form method="POST" action="get_id.php" class="form-horizontal">
		<div class="form-group">	
			<label class="col-sm-2 control-label">Username</label>
			<div class=" col-sm-4"><input type="text" name="username" class="form-control" required></div>
		</div>
		<div class="form-group">	
			<label class="col-sm-2 control-label">password</label>
			<div class=" col-sm-4"><input type="password" name="password" class="form-control" required></div>
		</div>
			<div class="col-sm-6"><input type="submit" class = "btn btn-default" name="id_submit" value="View"></div>
		</form>
</div>
</div>

<?php
	session_start();
	if(isset($_SESSION['regular']))
		{
			echo "<div id = 'regular' class='row container text-center' > <h4>Without any check</h4>
		<hr>";
			echo $_SESSION['regular'];
			unset($_SESSION['regular']);
			echo "</div>";
		}
?>

<div id="detected" class="row container ">
	
		<?php
		if(isset($_SESSION['static']))
		{
			echo "<div id = 'static' class='col-sm-5'>
		<h4>Using static analysis</h4>
		<hr>";
			echo $_SESSION['static'];
			unset($_SESSION['static']);
			echo "</div>";
		}
		?>
	
	<div class="col-sm-2"></div>
	<?php
		if(isset($_SESSION['hash']))
		{
			echo "<div id='hash' class='col-sm-5'>
		<h4>Using hash function</h4>
		<hr>";
			echo $_SESSION['hash'];
			unset($_SESSION['hash']);
			echo "</div>";
		}
		?>
	
</div>

<?php include("includes/footer.php"); ?>