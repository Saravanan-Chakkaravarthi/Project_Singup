<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>registration</title>
</head>
<body>
	<?php

	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password1 = $_POST['password1'];

	if(!empty($name) || !empty($email) || !empty($password) || !empty($password1)){
		$host = "localhost";
		$dbusername = "root";
		$dbpassword = "";
		$dbname = "myorange";

		//Create Connection
		$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

		if (mysqli_connect_error()) {
			die('Connect Error ('.mysqli_connect_errno() .') '.mysqli_connect_error());
		}
		else{
			$SELECT = "SELECT email FROM signup WHERE email = ? Limit 1";

			$INSERT = "INSERT INTO signup(name, email, password, password1) VALUES(?,?,?,?)";

			//prepare statements
			$stmt = $conn->prepare($SELECT);
			$stmt->bind_param("s",$email);
			$stmt->execute();
			$stmt->bind_result($email);
			$stmt->store_result();
			$rnum = $stmt->num_rows;

			//checking email 
			if ($rnum==0) {
				$stmt->close();
				$stmt = $conn->prepare($INSERT);
				$stmt->bind_param("ssss",$name, $email, $password, $password1);
				$stmt->execute();

				echo "New record inserted successfully";
			}
			else{
				echo "Someone already registered using this email";
			}
			$stmt->close();
			$conn->close();
		}
	}
	else{
		echo "All fields are required";
	}
?>
<br><br>
<a href="signup.html">Go Back</a>
</body>
</html>
