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
		$output = '';
		$sql = "SELECT * FROM forum;";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result);
		if ($result = mysqli_query($conn, $sql)) {
			$output .= '<select class="form-control" name="forum_ID">';
			$row['Forum_Title'] = stripslashes($row['Forum_Title']);
			while ($row = mysqli_fetch_assoc($result)) {
				$output .= '<option id = "forum_ID" value = "'.$row['Forum_ID'].'">'.$row['Forum_Title'].'</option>';
			}
			$output .= '</select>';
		}
		echo $output;
	}
?>