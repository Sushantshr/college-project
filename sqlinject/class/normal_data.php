<?php

class NormalData
{
	private $hostname = 'localhost';
	private $dbuser = 'root';
	private $dbpass = '';
	private $dbname = 'sql_injection';

	public $conn;
//constructor for connect
	public function __construct()
	{
		$this->connection();
	}

//create a connection
	public function connection()
	{
		$this->conn = new mysqli($this->hostname,$this->dbuser,$this->dbpass,$this->dbname);
	}

// check username and password
	public function get_data($username, $password)
	{				
		$query = "Select * from userid where username = '".$username."' and password = '".$password."'";// select query
			if($this->conn->query($query))
			{
				$result = $this->conn->query($query);
				$row = mysqli_fetch_assoc($result);
				if($result->num_rows>0)// check for rows to return
					return $row['id'];
				else
					return "Incorrect username or password";//if no rows are found
			}
			else
				return "Query error";
	}

	public function insert_normal_data($username, $password)
	{
		$query = "Insert into userid (username, password) values ('".$username."', '".$password."')";
		if($this->conn->query($query))
		{
			return "Normal Insert Successful";
		}
		else
			return "Error on Normal insertion";
	}
}

?>