<?php
	session_start();
	if (!isset($_SESSION['username']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
		if ($_SERVER['REQUEST_METHOD'] === 'POST'){
			echo "Access denied";
		} else {
			header("Location: ../dashboard.php");
			exit();
		}
	} else {
		include_once 'dbh.inc.php';
		if (isset($_POST['comment_ID'])){
			$comm_ID =  mysqli_real_escape_string($conn, $_POST['comment_ID']);
			$sql = "SELECT comment.*, user.Username, forum.Forum_Title FROM comment, user, forum 
					WHERE comment.Comment_ID = '".$comm_ID."' 
					AND comment.Content_ID = forum.Forum_ID 
					AND comment.User_ID = user.User_ID
					LIMIT 1;";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result);
			$row['Comment_Content'] = stripslashes($row['Comment_Content']);
			echo json_encode($row);
		}
	}
?>