<!DOCTYPE html>

<html lang="ko">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Status of Reservation</title>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	
	<body>
		<?php
		$host = "ec2-75-101-142-182.compute-1.amazonaws.com";
		$user = "kkipierzlcjrhl";
		$pass = "f90158d07fb17ef0d4d5c3d7fac06807d777cce2cdb9247c1f2637db80c44e6d";
		$db = "d26vvd07kpmqjt";
		
		$con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");
		
		echo "Connected successfully";

		pg_close($con);
		?>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	</body>
</html>