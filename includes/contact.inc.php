<?php
	session_start();
	// To disallow illegal access
	if ($_SERVER['REQUEST_METHOD'] != 'POST'){
		header("Location: ../dashboard.php");
		exit();
	} else {
		if (!isset($_POST['fullname']) || !isset($_POST['emails']) || !isset($_POST['details'])){
			echo "This is not the function you are looking for";
		} else {
			include_once 'dbh.inc.php';
			if(empty($_POST) || empty($_POST['fullname']) || ctype_space($_POST['fullname'])
				|| empty($_POST['emails']) || ctype_space($_POST['emails'])
				|| empty($_POST['details']) || ctype_space($_POST['details'])){
				echo "Empty input detected on required field";				
			} else {
				$fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
				$emails = mysqli_real_escape_string($conn, $_POST['emails']);
				$details = mysqli_real_escape_string($conn, $_POST['details']);
				
				if(!filter_var($emails, FILTER_VALIDATE_EMAIL)) {
					echo "Invalid email";
				} else {
					if(mail('CircuitFYP@gmail.com','Logic Portal Help',$details, $emails)){
						echo 1;
					} else {
						echo "Error encountered!";
					}
				}
			}
		}
	}
?>