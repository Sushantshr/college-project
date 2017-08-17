<?php
	include("includes/header.php");
	include("../class/analysis_data.php");
	session_start();
	if (!isset($_SESSION['user']))
		header('location:login/userlogin');

	$analysis_data = new AnalysisData();
?>

<div class="col-lg-6">
<?php
	$path = explode('.', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	$page =  $path[1];;

	$start = ($page-1)*10;

	$no_rows =  $analysis_data->get_rows();
	echo $analysis_data->get_id_analysis($start);	
?>	
	
<ul class="pagination" style="background-color: none; color: white;">

<?php

	$total_page = ceil($no_rows/10); 
	for ($page=1;$page<=$total_page;$page++){ 
		echo "<li><a href='analysisget.".$page."'>". $page."</a></li>";
	}
?>
</ul>
	
</div>

<div class="col-lg-6">
Average:<br>
<?php echo $analysis_data->get_analysis(1); ?>
</div>
<hr>
<?php
include("includes/footer.php");
?>