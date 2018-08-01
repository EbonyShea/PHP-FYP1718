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
		if (isset($_POST['flashcard_ID'])){
			$fc_ID =  mysqli_real_escape_string($conn, $_POST['flashcard_ID']);
			$sql = "SELECT flashcard.*, user.Username FROM flashcard, user WHERE Fc_ID = '".$fc_ID."' AND flashcard.User_ID = user.User_ID;";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result);
			$row['fc_Title'] = stripslashes($row['fc_Title']);
			$row['fc_Desc'] = stripslashes($row['fc_Desc']);
			echo json_encode($row);
		}
	}
?>