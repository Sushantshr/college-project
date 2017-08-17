<?php

	if(isset($_POST['submit']))
	{
		session_start();
		include('../class/normal_data.php');
		include('../class/hash_data.php');
		include('../class/analysis_data.php');

		$username = $_POST['uname'];
		$password = $_POST['upass'];
		
		$normal_insert = new NormalData();
		
		$normal_start_time = microtime(true);
			$normal_result = $normal_insert->insert_normal_data($username, $password);
		$normal_end_time = microtime(true);
		$normal_time_diff = $normal_end_time - $normal_start_time;

		$_SESSION['insert_normal'] = $normal_result;

		$hash_insert = new HashData();

		$hash_start_time = microtime(true);
			$hash_result = $hash_insert->insert_hash_data($username, $password);
		$hash_end_time = microtime(true);
		$hash_time_diff = $hash_end_time - $hash_start_time;

		$_SESSION['insert_hash'] = $hash_result;
		
		$analysis_data = new AnalysisData();
		$analysis_data->put_insert_analysis($normal_time_diff, $hash_time_diff);

		header("location:insertuser");
	}
?>