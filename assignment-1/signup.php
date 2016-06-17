<?php
  session_start();
  include('database.php');
  include('functions.php');

  //call to database.php to connect to sql database
  $conn = connect_db();

  // all variables are sanitized when they are assigned to
  // variables that are taken from the $_POST array
  $username = sanitizeString($conn, $_POST['username']);
  $password = sanitizeString($conn, $_POST['password']);
  $name = sanitizeString($conn, $_POST['name']);
  $email = sanitizeString($conn, $_POST['email']);
  $dob = sanitizeString($conn, $_POST['dob']);
  $gender = sanitizeString($conn, $_POST['gender']);
  $question = sanitizeString($conn, $_POST['question']);
  $answer = sanitizeString($conn, $_POST['answer']);
  $location = sanitizeString($conn, $_POST['location']);
  $pic = sanitizeString($conn, $_POST['pic']);

  $password = md5($password);

  $sql = "INSERT INTO users(Username, Password, Name, email, dob, gender
          , verification_question, verification_answer, location, profile_pic)
          VALUES ('$username', '$password', '$name', '$email', '$dob'
          , '$gender', '$question', '$answer', '$location', '$pic')";

  $result = mysqli_query($conn, $sql);

  if($result){
    $_SESSION['username'] = $username;
    mysqli_close($conn);
    header('Location: feed.php');
    exit();
  }
  else {
    echo $conn->error;
    exit();
  }



?>
