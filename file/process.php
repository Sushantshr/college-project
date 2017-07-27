<?php
include("header.php");
include("functions.php");
	$command = $_POST['cmd'];
	$arr = array();
	$arr = split(" ", $command);
	array_push($arr, ";");
	if(authenticate_name($arr))
	{
		switch(ucfirst($arr[0]))
		{
			case 'Create' :
								create_table($arr);
								break;
			case 'Update' :
								update_data($arr);
								break;
			case 'Delete' :
								if (sizeof($arr)==3)
									delete_file($arr[1]);
								else
									delete_data($arr);
								break;
			case 'Insert' :
								insert($arr);
								break;
			case 'Display' :
								if (sizeof($arr)==3)
									display($arr);
								else
									display_selected($arr);
								break; 
			default :
								echo "Error ";
								break;					
		}
	}
	else
	{
		echo "Input command is not correct!!! please type the command again.";
	}
include("end.php");
?>