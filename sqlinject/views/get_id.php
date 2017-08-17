<?php
	if(isset($_POST['id_submit']))
	{
		session_start();
		include('../class/normal_data.php');
		include('../class/hash_data.php');
		include('../class/static_data.php');
		include('../class/analysis_data.php');

		$username = $_POST['username'];
		$password = $_POST['password'];

//static usage
		$static_data = new StaticData();

		$static_start_time = microtime(true);
		$static = $static_data->getstatic_data($username, $password);
		$static_end_time = microtime(true);
		$static_time_diff = $static_end_time - $static_start_time;

		$_SESSION['static'] = $static;


//hash usage
		$hash_data = new HashData();

		$hash_start_time = microtime(true);
		$hash = $hash_data->getfrom_hashdata($username, $password);
		$hash_end_time = microtime(true);
		$hash_time_diff = $hash_end_time - $hash_start_time;

		$_SESSION['hash'] = $hash;
				

//normal usage 
		$normal_data = new NormalData();

		$normal_start_time = microtime(true);
		$normal = $normal_data->get_data($username, $password);
		$normal_end_time = microtime(true);
		$normal_time_diff = $normal_end_time - $normal_start_time;

		$_SESSION['regular'] = $normal;
		
		

		$analysis_data = new AnalysisData();
		$analysis_data->put_id_analysis($normal_time_diff, $static_time_diff, $hash_time_diff);

		header('location:getid');
	}
	else
		header('location:home.crypt');
?>


