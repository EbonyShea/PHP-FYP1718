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
		if (isset($_POST['user_ID'])){
			$u_ID =  mysqli_real_escape_string($conn, $_POST['user_ID']);
			$sql = "SELECT * FROM user WHERE User_ID = '".$u_ID."'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result);
			$row['Username'] = stripslashes($row['Username']);
			echo json_encode($row);
		}
	}
?>