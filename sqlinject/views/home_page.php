<?php
	session_start();
	if (!isset($_SESSION['user']))
		header('location:login/userlogin');
?>

<?php include("includes/header.php"); ?>



	<span style="color: white;font-size: 100px">SQL Injections</span>
	


<?php include("includes/footer.php"); ?>
		