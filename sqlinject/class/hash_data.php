<?php

class HashData
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
		return $this->conn = new mysqli($this->hostname,$this->dbuser,$this->dbpass,$this->dbname);
	}

// check username and password
	public function getfrom_hashdata($username, $password)
	{
		$username = $this->conn->real_escape_string($username);
		$password = $this->conn->real_escape_string($password);
		$query = "Select * from hashuserid";// select query
		$found = 0;
		if($this->conn->query($query))
		{
			$result = $this->conn->query($query);
			if($result->num_rows>0)// check for rows to return
			{							
				while($row = mysqli_fetch_assoc($result))
				{
				if(password_verify($username, $row['hash_username'])&&password_verify($password, $row['hash_password']))
				{
					return $row['id'];
					$found = 1;
				}
				}
			}
			if($found == 0)
				return "Incorrect username or password";//if no rows are found
		}
		else
			return "Query error";
	}

	public function insert_hash_data($username, $password)
	{
		$uname = password_hash($username, PASSWORD_DEFAULT);
		$upass = password_hash($password, PASSWORD_DEFAULT);
		$query = "Insert into hashuserid (hash_username, hash_password) values ('".$uname."', '".$upass."')";
		if($this->conn->query($query))
		{
			return "Hash Insert Successful";
		}
		else
			return "Error on Hash insertion";
	}
}

?>