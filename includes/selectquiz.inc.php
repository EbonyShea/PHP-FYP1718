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
		if (isset($_POST['quiz_ID'])){
			$q_ID =  mysqli_real_escape_string($conn, $_POST['quiz_ID']);
			$sql = "SELECT quiz.*, user.Username FROM quiz, user WHERE Quiz_ID = '".$q_ID."' AND quiz.User_ID = user.User_ID;";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result);
			$row['Quiz_Title'] = stripslashes($row['Quiz_Title']);
			$row['Quiz_Desc'] = stripslashes($row['Quiz_Desc']);
			echo json_encode($row);
		}
	}
?>