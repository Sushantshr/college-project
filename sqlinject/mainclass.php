
<?php

class DB
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


//get the input
	public function get_id($username, $password)
	{
		$username = $this->conn->real_escape_string($username);
		$password = $this->conn->real_escape_string($password);

		$detect_on_username = $this->detect($username); 
		$detect_on_password = $this->detect($password);

		if( $detect_on_username == null && $detect_on_password == null)
		{
			return $this->get_data($username, $password);
		}
		else
			return "On username:".$detect_on_username."<br>On password:".$detect_on_password;
	}

//get actual data
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


//detect inputs
	public function detect($query)
	{	 
		$return = null;
		if($this->detect_quotes($query))//detect quotes
			$return = "quote Detected";
		if($this->detect_bad_input($query))//detect sql query
			$return = $return."<br> Bad input detected ";
		if($this->detect_logical($query))
			$return = $return."<br> Logical operator detected ";
		if($this->detect_good_inputs($query))
			$return = $return."<br> out of the range of good inputs ";
		return $return;
	}

//check for logical operators
	public function detect_logical($query)
	{
		$return = 0;
		$detect = array("or", "and");
		$split = explode(" ", $query);		
		$size = sizeof($split);
		echo strcmp(strtolower($split[0]),$detect[0]);
		for( $i=0;$i<$size;$i++)
		{
			for($j =0;$j<2;$j++)
			{
				if(strcmp(strtolower($split[$i]),$detect[$j])==0)//compare for logical operators
				{
					$return = 1;
					break;
				}
			}
		}
		return $return;
	}

//check for quotes
	public function detect_quotes($query)
	{		
		if (preg_match('/"/',$query)||preg_match("/'/",$query))//check for any quotes
			return 1;
		else 
			return 0;
	}

//check for the sql syntaxs
	public function detect_bad_input($query)
	{
		$return = 0;
		$detect = array("union", "select", "update", "insert", "delete", "--", "drop", "=");//bad inputs for query
		$split = explode(" ", $query);//split the query
		
		$querysize = sizeof($split);
		$detectsize = sizeof($detect);
		
		for( $i=0;$i<$querysize;$i++)
		{
			for($j =0;$j<$detectsize;$j++)
			{
				if(strcmp(strtolower($split[$i]),$detect[$j])==0)//compare from the detection query
				{
					$return = 1;
					break;
				}
			}
		}
		return $return;
	}

//check for only good inputs
	public function detect_good_inputs($query)
	{
		$return = 1;
		echo "ps ".preg_match('/[^a-zA-Z0-9]/', $query); 
		if(!preg_match('/[^a-zA-Z0-9]/', $query))
			$return = 0;
		return $return;
	}

}

?>