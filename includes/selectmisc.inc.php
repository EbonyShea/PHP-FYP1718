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
		if (isset($_POST['misc_ID'])){
			$m_ID =  mysqli_real_escape_string($conn, $_POST['misc_ID']);
			$sql = "SELECT misc.*, user.Username FROM misc, user WHERE misc.Misc_ID = '".$m_ID."' AND user.User_ID = misc.User_ID;";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result);
			$row['Misc_Title'] = stripslashes($row['Misc_Title']);
			$row['Misc_Desc'] = stripslashes($row['Misc_Desc']);
			echo json_encode($row);
		}
	}
?>