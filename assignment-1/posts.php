<?php

	session_start();
	if(!isset($_SESSION['username'])){
		header('Location: login.html');
		exit();
	}
	include('database.php');
	include('functions.php');

	$conn = connect_db();

	$content = sanitizeString($conn, $_POST['content']);
	$UID = sanitizeString($conn, $_POST['UID']);

	$result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$UID'");
	$row = mysqli_fetch_assoc($result);
	//Fetch User information
	$name = $row["Name"];
	$profile_pic = $row["profile_pic"];
	echo "$name";
	$result_insert = mysqli_query($conn, "INSERT INTO posts(content, UID, name, profile_pic, likes) VALUES ('$content', $UID, '$name', '$profile_pic', 0)");
	if($result_insert){
		header("Location: feed.php");
    exit();
	}else{
		echo "Oops! Something went wrong! Please try again!";
    exit();
  }

?>
