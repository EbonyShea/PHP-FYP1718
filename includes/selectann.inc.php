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
		if (isset($_POST['ann_ID'])){
			$ann_ID =  mysqli_real_escape_string($conn, $_POST['ann_ID']);
			$sql = "SELECT announcement.*, user.Username FROM announcement, user WHERE Ann_ID = '".$ann_ID."' AND announcement.User_ID = user.User_ID;";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result);
			$row['Ann_Content'] = stripslashes($row['Ann_Content']);
			echo json_encode($row);
		}
	}
?>