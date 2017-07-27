<?php
	function get_name($name)//creates file name using table
	{
		return $name.".txt";//returns file name in txt format
	}


	function get_header($header)//returns the header for the table
	{
		$split_header = split(" ", $header);// Splits header using space
		$size = sizeof($split_header)-1;// removes semi-colon
		$i = 0;
		$j = 0;
		for($i=0;$i<$size;$i=$i+2)
		{
			$aheader[$j][0]= $split_header[$i];//adds header
			$aheader[$j][1]= $split_header[$i+1];//adds datatype
			$j++;
		}
		return $aheader;
	}


	function get_row($arr)//returns a row as a array
	{
		$row_split = split(" ", $arr);
		return $row_split;
	}


	function create_table($arr)//Create table as a file
	{
		if (authenticate_ci($arr))
		{
			$tablename = get_name($arr[1]);
			if (!file_exists($tablename))//check if the file exists
			{
				
				$header = "";
				for ($i = 2; $i <sizeof($arr);$i = $i+3)//break header and datatype
				{		
					if($arr[$i] ==";")
					break;
					$type = str_replace(",", " ", $arr[$i+2]);
					if (exist_datatype($type)==0)
					{	
						die("Datatype missmatch");	
					}
					$header = $header.$arr[$i]." ".$type;	
				}
				$header = $header." ;".PHP_EOL;
				$file = fopen($tablename, "a");
				fwrite($file, $header);// write header
				echo "Table ".$arr[1]." was created.";
			}
			else
			die("Error creating table Table name already exists!!");
			fclose($file);
		}
		else
			echo "Create Syntax error!!!!";
	}


	function insert($arr)//Insert a row into the table
	{
		if (authenticate_ci($arr))//Checks for correct syntax for insert
		{
			$tablename = get_name($arr[1]);
			$tableheader = fopen($tablename, "r") or die("Table not found!!!");//open file to read header
			$tableentry = fopen($tablename, "a") or die("Table not found!!!");//open file for entry
			$header_string = fgets($tableheader);
			$header = get_header($header_string);
			$flag = 0;
			$size = sizeof($arr);
			$j = 0;

			$data = "";//for data entry
			for ($i = 2; $i<$size; $i = $i+3)
				{
					if($arr[$i] ==";")
					break;
					$arr[$i+2] = str_replace(",", " ", $arr[$i+2]);
					if (check_header($header[$j][0], $arr[$i])==1)//checks if the header matches the input 
						{
							echo "Heading missmatch";
							$flag = 1;
							break;
						}
					if(check_datatype($header[$j][1],$arr[$i+2])==1)//checks if the datatype matches the input 
						{
							echo "Type missmatch";
							$flag = 1;
							exit();
						}
					$data = $data.$arr[$i+2];
					$j++;
				}
				if($flag == 0)//checks if the datatype and header matches for input
				{	
					$data = $data." ;".PHP_EOL;
					fwrite($tableentry, $data);
				}
				fclose($tableentry);
				fclose($tableheader);
				echo "data was inserted";
		}
		else
			echo "Insert Syntax Error";
	}


	function display($arr)// Display the table in tabular format
	{
		$tablename = get_name($arr[1]);
		$tableentry = fopen($tablename, "r") or die("Table not found!!!");
		$header = get_header(fgets($tableentry));// Move a line to get header

		echo "<table border = 1 style='width:30%;'> <tr> ";
		for ($i=0;$i<sizeof($header);$i++)
		{
			echo "<td>".$header[$i][0]."</td>";
		}
		echo "</tr>";
		while(!feof($tableentry))
		{
			$row = get_row(fgets($tableentry));
			echo "<tr>";
			for ($i = 0;$i<sizeof($row)-1;$i++)
			{
				if ($row[$i]!=";")
					echo "<td>".$row[$i]."</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
		fclose($tableentry);	
	}

	function display_selected($arr)
	{
		if (authenticate_delete($arr))// authenticates as delete syntax
		{
			$tablename = get_name($arr[1]);
			$tableentry = fopen($tablename, "r") or die("Table not found!!!");
			$header = get_header(fgets($tableentry));// Move a line to get header
			$place = -1;
			$size = sizeof($arr);
		
			for ($i = 0;$i<sizeof($header); $i++)//check if the such column exists
			{
					if ($header[$i][0]==$arr[$size-4])
					{
						$place = $i;
					}
			}
			if ($place == -1)// if column doesn't exists
			{
				echo "no such columnname ";
				exit();
			}

			echo "<table border = 1 style='width:30%;'> <tr> ";
			for ($i=0;$i<sizeof($header);$i++)
			{
				echo "<td>".$header[$i][0]."</td>";
			}
			echo "</tr>";
			while(!feof($tableentry))
			{
				$row = get_row(fgets($tableentry));
				echo "<tr>";
				for ($i = 0;$i<sizeof($row)-1;$i++)
				{
					if ($row[0] != "" && $row[$place]==$arr[$size-2])//If the row is not empty and the row matches the request
					{
						echo "<td>".$row[$i]."</td>";
					}
				}
				echo "</tr>";
			}
			echo "</table>";
			fclose($tableentry);
		}
		else
			echo "Display syntax error";

	}

	function update_data($arr)// update the data
	{
		if (authenticate_update($arr))
		{
			$tablename = get_name($arr[1]);
			$size = sizeof($arr);
			$place = -1;
			$match = 0;
			$tableentry = fopen($tablename, "r+") or die("Table not found!!!");//open the existing table to update
			$newfile = fopen("temp.txt", "w+") or die("error!!!");// open an temporary file to replace existing file

			$new_header = fgets($tableentry);// header for updated table

			fwrite($newfile, $new_header);		
			$header = get_header($new_header);
			fgets($newfile);
			$j = 2;
			for ($i = 0;$i<sizeof($header); $i++)//check if the such column exists
			{
					if ($header[$i][0]==$arr[$size-4])
					{
						$place = $i;
					}
			}
			if ($place == -1)// if column doesn't exists
			{
				echo "no such columnname ";
				exit();
			}
			while (!feof($tableentry))
			{
				$insert = "";
				$entry = fgets($tableentry);
				$row = get_row($entry);

				$j = 4;
				if ($row[0] != "" && $row[$place]==$arr[$size-2])//If the row is not empty and the row matches the requested update
				{		
					$match = 1;
					for ($i=0;$i<sizeof($row)-1;$i++)
					{
						$insert = $insert.str_replace(",", "",$arr[$j])." ";
						$j = $j + 3;
					}
					$insert = $insert.";".PHP_EOL;
				}
				else
				{
					$insert = $entry;
				}
				fwrite($newfile, $insert);
				}
				if ($match == 1)	
				{
					fclose($tableentry);
					fclose($newfile);
					unlink($tablename);// deletes the existing file
					rename("temp.txt", get_name($arr[1]));// renames to replace the existing table
					echo "Your data was updated";
				}
				else
				{
					echo "No such row";
					fclose($tableentry);
					fclose($newfile);
				}
		}
		else
		{
			die("Syntax error");
		}
	}


	function delete_file($arr)// deletes the table
	{
		$name = get_name($arr);

		if (file_exists($name))
		{
			unlink($name);
			echo "You deleted the table ".$arr.".txt";
		}
		else
			echo "The file does not exists.";
	}


	function delete_data($arr)//Deletes the existing row
	{
		if (authenticate_delete($arr))// authenticates for delete syntax
		{
			$tablename = get_name($arr[1]);
			$size = sizeof($arr);
			$place = -1;
			
			$tableentry = fopen($tablename, "r+") or die("Table not found!!!");//open the existing table to delete row
			$newfile = fopen("temp.txt", "w+") or die("error!!!");//open a new file to replace the deleted row's table

			$new_header = fgets($tableentry);
			fwrite($newfile, $new_header);//Inserts the header

			$header = get_header($new_header);

			fgets($newfile);
			for ($i = 0;$i<sizeof($header)-1; $i++)//If the row is not empty and the row matches the requested delete
			{

				if ($header[$i][0]==$arr[$size-4])
					{
						$place = $i;
					}
			}
			if ($place == -1)
			{
				echo "no such columnname ";
				exit();
			}
			$nodata = 0;
			while (!feof($tableentry))
			{
				$insert = "";
				$entry = fgets($tableentry);
				$row = get_row($entry);
				$j = 4;
				if ($row[0] != "" && $row[$place]==$arr[$size-2])
				{
					$nodata = 1;
					continue;
				}
				else
				{
					$insert = $entry;
				}
				fwrite($newfile, $insert);
			}
			fclose($tableentry);
			fclose($newfile);
			if ($nodata == 1)
			{
				unlink($tablename);//deletes the existing file
				rename("temp.txt", get_name($arr[1]));// renames to replace the existing table
				echo "The row was deleted";
			}
			else
				echo "No such row found";
		}
		else
			echo "Delete syntax error";
	}


	function check_datatype($header, $arr)//checks if the datatype matches the input 
	{
		$arr = trim($arr);//removes spaces
		$return = 0;
		echo $arr." ".$header;
	
		if (is_numeric($arr))
		{
			if(ucfirst($header) == "Integer")
				$return = 0;
			else
				$return = 1;
		}
		else if (is_bool($arr))
			{
				if(ucfirst($header) == "Boolean")
					$return = 0;
				else
					$return = 1;
			}
		else if (is_float($arr))
			{
				if(ucfirst($header) == "Float")
					$return = 0;
				else
					$return = 1;
			}
		else if (is_string($arr))
			{
				if(ucfirst($header) == "String")
					$return = 0;
				else
					$return = 1;
			}
		else
			$return = 1;
		return $return;
	}


	function check_header($header, $arr)//Checks if the header matches the given input
	{
		$return = 0;
		if ($header!=$arr)
			$return = 1;
		return $return;
	}


	function authenticate_ci($arr)// authenticates the syntax for create and insert
	{
		$size = sizeof($arr);
		$return = 1;
		if ($size<6)// makes sure if enough syntax is given
			{
				$return = 0;
			}
		else
		{
			for($i = 3; $i < $size-1; $i = $i + 3)// checks if syntax is correct
				{

					if ($arr[$i] != "=")
						{
							echo "<br>= placing error";
							$return = 0;
						}
				}
		}
		return $return;
	}


	function authenticate_delete($arr)//authenticates the delete syntax
	{
		$size = sizeof($arr);
		$return = 1;

		if ($size != 6)//delete syntax must be of this length
			$return = 0;
		else if ($arr[3] != "=")//delete syntax must only have a single equals to sign
			$return = 0;

		return $return;
	}


	function authenticate_name($arr)// authenticates if the given syntax has minimum length
	{
		if (sizeof($arr)<=1||empty($arr[1]))//checks if input is not empty table and enough syntax exists
			return 0;
		else
			return 1;
	}


	function authenticate_update($arr)//authenticates for update syntax
	{
		$size = sizeof($arr);
		$return = 1;
		if ($arr[$size-5]!="with")//checks if the syntax has 'with'
			$return = 0;
		else if ($arr[$size-3] != "=")//checks if the with has correct syntax
			$return = 0;
		else
		{
			for ($i = 0; $i < ($size-5); $i++)
			{
				$temp[$i] = $arr[$i]; 
			}
			if (!authenticate_ci($temp))//checcks if the given syntax is correct for insert
				$return = 0;
		}
		return $return;
	}

		function exist_datatype($data_type)
	{
		$return = 0;
		$data_type = trim($data_type);
		$datatypes = array("String", "Boolean", "Integer", "Float");
		foreach($datatypes as $var)
		{
			if (strcmp($var,(ucfirst($data_type))) == 0)
				{
					$return = 1;
					break;
				}
		}
		return $return;
	}

?>