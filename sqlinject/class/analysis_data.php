<?php
class AnalysisData
{
	private $hostname = 'localhost';
	private $dbuser = 'root';
	private $dbpass = '';
	private $dbname = 'sql_injection';

	public $staticavg;
	public $hashavg;
	public $normalavg;

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

	public function insert_rows()
	{
		$query = "Select * from insert_analysis";
		$result = $this->conn->query($query);
		return $result->num_rows;
	}
 
	public function get_insert_analysis($start)
	{
		$query = "Select * from insert_analysis LIMIT ".$start.", 10";// select query
			if($this->conn->query($query))
			{
				$result = $this->conn->query($query);
				$output = "<table><tr><td>Normal Insert</td><td>Hash Insert</td></tr>";
				$count = 0;
				$i = 0;
				$staticavg = 0;
				$hashavg = 0;
				while($row = mysqli_fetch_assoc($result))
				{
					$staticavg += $row['static_time'];
					$hashavg += $row['hash_time'];
					$output = $output."<tr><td>".$row['static_time']."</td>";
					$output = $output."<td>".$row['hash_time']."</td></tr>";
					if($count == 10)
						break(1);
					$count++;
					$i++;
				}
				$output = $output."</table>";
				$this->staticavg = $staticavg/$i;
				$this->hashavg = $hashavg/$i;
				return $output;
			}
			else
				return 0;
	}



	public function put_insert_analysis($statictime, $hashtime)
	{
		$query = "Insert into insert_analysis (static_time, hash_time) values ('".$statictime."', '".$hashtime."')";
		$this->conn->query($query);
	}

	public function get_rows()
	{
		$query = "Select * from get_analysis";
		$result = $this->conn->query($query);
		return $result->num_rows;
	}

	public function get_id_analysis($start)
	{
		$query = "Select * from get_analysis LIMIT ".$start.", 10";// select query
		if($this->conn->query($query))
		{
			$result = $this->conn->query($query);
			$output = "<table><tr><td>Normal Analysis</td><td>Static Analysis</td><td>Hash Analysis</td></tr>";
			$i = 0;
			$staticavg = 0;
			$hashavg = 0;
			$normalavg = 0;
			while($row = mysqli_fetch_assoc($result))
			{
				$staticavg += $row['static_analysis'];
				$hashavg += $row['hash_analysis'];
				$normalavg += $row['normal_analysis'];
				$output = $output."<tr><td>".$row['normal_analysis']."</td>";
				$output = $output."<td>".$row['static_analysis']."</td>";
				$output = $output."<td>".$row['hash_analysis']."</td></tr>";
				$i++;
			}
			$output = $output."</table>";
			$this->normalavg = $normalavg/$i;
			$this->staticavg = $staticavg/$i;
			$this->hashavg = $hashavg/$i;
			return $output;
		}
		else
			return 0;
	}

	public function get_analysis($j)
	{
		if($j=0)
		{
			$output = "Static:".$this->staticavg;
			$output = $output."<br>Hash:".$this->hashavg;
		}
		else
		{
			$output = "Normal:".$this->normalavg;
			$output = $output."<br>Static:".$this->staticavg;
			$output = $output."<br>Hash:".$this->hashavg;	
		}
		return $output;
	}



	public function put_id_analysis($normaltime, $statictime, $hashtime)
	{
		$query = "Insert into get_analysis (normal_analysis, static_analysis, hash_analysis) values ('".$normaltime."', '".$statictime."','".$hashtime."')";
		$this->conn->query($query);
	}
}
?>