<?php
	session_start();
	if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 1 || $_SERVER['REQUEST_METHOD'] != 'POST') {
		if ($_SERVER['REQUEST_METHOD'] === 'POST'){
			echo "Access denied";
		} else {
			header("Location: ../dashboard.php");
			exit();
		}
	} else {
		include_once 'dbh.inc.php';
		if (isset($_POST['video_ID'])){
			$v_ID =  mysqli_real_escape_string($conn, $_POST['video_ID']);
			$sql = "SELECT video.*, user.Username FROM video, user WHERE Video_ID = '".$v_ID."' AND video.User_ID = user.User_ID;";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result);
			$row['Video_Title'] = stripslashes($row['Video_Title']);
			$row['Video_Desc'] = stripslashes($row['Video_Desc']);
			echo json_encode($row);
		}
	}
?>