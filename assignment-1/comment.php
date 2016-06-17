<?php

	session_start();
	if(!isset($_SESSION['username'])){
		header('Location: login.html');
		exit();
	}
	include('database.php');
	include('functions.php');

	$conn = connect_db();

	$comment = sanitizeString($conn, $_POST['comment']);
	$UID = sanitizeString($conn, $_POST['UID']);
  $post_id = sanitizeString($conn, $_POST['post_id']);

	$result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$UID'");
	$row = mysqli_fetch_assoc($result);
	//Fetch User information
	$name = $row["Name"];

	$result_insert = mysqli_query($conn, "INSERT INTO comments(post_id, comment, UID, name) VALUES ('$post_id', '$comment', '$UID', '$name')");
	if($result_insert){
		header("Location: feed.php");
    exit();
	}else{
    echo $conn->error;
		echo "Oops! Something went wrong! Please try again!";
    exit();
  }

?>
