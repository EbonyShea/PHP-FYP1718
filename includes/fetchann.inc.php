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
		$sql = "SELECT * FROM Announcement ORDER BY Ann_Date DESC LIMIT 3;";	
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0){
			while ($row = mysqli_fetch_assoc($result)) {
				$date = date("j F, Y", strtotime($row['Ann_Date']));
				$row['Ann_Content'] = stripslashes($row['Ann_Content']);
				$output .= '<div class = "ann-box">
								<i>'.$date.'</i>
								<p>'.$row['Ann_Content'].'</p>
							</div>';
			}
		} else {
			$output .= '<div class = "ann-box"><p>No Announcement</p></div>';
		}
		echo $output;
	}
?>