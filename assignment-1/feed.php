<!DOCTYPE html>
<html>
	<head>
		<title>MyFacebook Feed</title>
		<link rel='stylesheet' href='main.css' type='text/css';
	</head>
	<body>
		<?php
			session_start();
			if(!isset($_SESSION['username'])){
				header('Location: login.html');
				exit();
			}
			include('database.php');
			$conn = connect_db();
			$username = $_SESSION["username"];
			$result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
			//user information
			$row = mysqli_fetch_assoc($result);
			echo "<h1>Welcome back ".$row['Name']."!</h1>";
			echo "<form method='POST' action='logout.php'>";
			echo "<p><input type='submit' value='Logout'></p>";
			echo "</form>";
			echo "<img height='250' width='300' src='".$row['profile_pic']."'>";
			echo "<hr>";
			echo "<h2>Make A Post</h2>";
	  	echo "<form method='POST' action='posts.php'>";
			echo "<p><textarea rows='10' cols='50' name='content' placeholder='Whats on your mind?'></textarea></p>";
			echo "<input type='hidden' name='UID' value='$row[id]'>";
			echo "<p><input type='submit'></p>";
			echo "</form>";
			echo "<br />";

			$UID = $row['id'];
			$name = $row['Name'];

	  	$result_posts = mysqli_query($conn, "SELECT * FROM posts");
			$num_of_rows = mysqli_num_rows($result_posts);
			echo "<hr />";
	  	echo "<h2>My Feed</h2>";

	  	//show all posts on myfacebook
			for($i = 0; $i < $num_of_rows; $i++){
				$row = mysqli_fetch_row($result_posts);
				echo "<fieldset>";
				echo "<legend><img height='100' width='100' src='$row[4]' /> <br /> Post by $row[3] <br /></legend>";
				echo "<p>$row[1]</p>";
				$date = date('m/d/Y h:i A', strtotime($row[6]));
				echo "<p>Likes: $row[5]</p> <p>$date</p>";
				echo "<form action='likes.php' method='POST'> <input type='hidden' name='PID' value='$row[0]'> <input type='submit' value='Like'></form> <br />";
				echo "<form method='POST' action='comment.php'>";
				echo "<p><textarea rows='5' cols='40' name='comment' placeholder='What do you think?'></textarea></p>";
				echo "<input type='hidden' name='UID' value='$UID'>";
				echo "<input type='hidden' name='post_id' value='$row[0]'>";
				echo "<p><input type='submit' value='Comment'></p>";
				echo "</form>";
				echo "<br />";

				$result_comments = mysqli_query($conn, "SELECT * FROM comments where post_id='$row[0]'");
				$num_rows_2 = mysqli_num_rows($result_comments);
				
				// all of the comments for a given post are displayed under the post
				for($j = 0; $j < $num_rows_2; $j++){
						$row2 = mysqli_fetch_row($result_comments);
						echo "<fieldset>";
						echo "<legend>Comment by $row2[3]</legend>";
						echo "<p>$row2[1]</p>";
						$date = date('m/d/Y h:i A', strtotime($row[6]));
						echo "<p>$date</p>";
						echo "</fieldset>";
						echo "<br />";
				}
				echo "</fieldset>";
				echo "<br />";
			}
		?>
	</body>
</html>
