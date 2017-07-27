<!DOCTYPE html>
<html>
<head>
	<title>CRUD using file system</title>
	<link rel="stylesheet" type="text/css" href="start_crud.css">
	<link rel="stylesheet"  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron" style="margin:0px;">
	<h1>CRUDDDD!!!</h1>
</div>

<div id = "header">
	<form method="post" class = "form" action = "process.php" >
	<div class="form-group">
		<label>Enter command:</label>
		<input type="text" name="cmd" style="width:50%; color:black;">
		<input type="submit" name="submit" value = "Exexute" style="color:black;">
	</div>
	</form>
</div>

<div id = "container_command" class="container-fluid">
	<div id = "command">
	<p>Commands:</p>
	<ul>
		<li>
			Create table:
				Create tablename columnname1 = datatype, columnname2 = datatype
		</li><hr>
		<li>
			Insert data:
				Insert tablename columnname1 = value1, columnname2 = value2
		</li><hr>
		<li>
			Update data:
				Update tablename columnname1 = value1, columnname2 = value2 with columnname1 = value
		</li><hr>
		<li>
			Delete data:
				Delete tablename columnname1 = value1
		</li><hr>	
		<li>
		Display data:
			Display tablename
		</li><hr>
		<li>
		Display selected data:
			Display tablename columname1 = value1
		</li><hr>
		<li>
		Delete table:
			Delete tablename
		</li><hr>
	</ul>
	<p>Supported data types</p>
	<ul>
		<li>String</li>
		<li>Boolean</li>
		<li>Integer</li>
		<li>Float</li>
	</ul>
</div>

<div id="output">
