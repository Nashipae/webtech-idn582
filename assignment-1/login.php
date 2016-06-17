<?php

	//start session
	session_start();
	include('database.php');
	include('functions.php');

	$conn = connect_db();

	$username = sanitizeString($conn, $_POST["username"]);
 	$password = sanitizeString($conn, $_POST["password"]);

	$password = md5($password);

	$result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
	$num_of_rows = mysqli_num_rows($result);
	//Check in the DB
	if($num_of_rows > 0){
		//If authenticated: say hello!
		$_SESSION["username"] = $username;
		mysqli_close($conn);
		header("Location: feed.php");
		exit();
		//echo "Success!! Welcome ".$username;
	}else{
		//else ask to login again..
		mysqli_close($conn);
		echo "Invalid password! Try again!";
	}
?>
