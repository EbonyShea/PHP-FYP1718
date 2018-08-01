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
		if (isset($_POST['forum_ID'])){
			$f_ID =  mysqli_real_escape_string($conn, $_POST['forum_ID']);			
			$sql = "SELECT forum.*, user.Username, user.User_Img, user.User_Type, 
			(SELECT COUNT(*) from comment WHERE (Content_ID = '".$f_ID."')) as count_Comm
			FROM forum, user WHERE Forum_ID = '".$f_ID."' 
			AND forum.User_ID = user.User_ID 
			LIMIT 1;";
			
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result);
			$row['Forum_Title'] = stripslashes($row['Forum_Title']);
			$row['Forum_Content'] = stripslashes($row['Forum_Content']);
			echo json_encode($row);
		}
	}
?>