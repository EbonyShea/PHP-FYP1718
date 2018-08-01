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
		if (isset($_POST['quiz_id'])){
			$q_id = mysqli_real_escape_string($conn, $_POST['quiz_id']);
			
			$sql = "DELETE FROM quiz WHERE quiz_id = ?;";
			$stmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmt, $sql)) {
				echo "ERROR";
			} else {
				mysqli_stmt_bind_param($stmt, "s", $q_id);
				mysqli_stmt_execute($stmt);
				echo "Delete Success";
			}
			mysqli_stmt_close($stmt);
		} else {
			if (isset($_POST['selected_quiz'])){
				$temp_id = mysqli_real_escape_string($conn, $_POST['selected_quiz']);
				$emp_id = explode(',', $temp_id);				
				$sql2 = "DELETE FROM quiz WHERE quiz_id = ?;";
				$stmt2 = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt2, $sql2)) {
					echo "ERROR";
				} else {
					for ($i = 0; $i < count($emp_id); $i++){
						mysqli_stmt_bind_param($stmt2, "s", $emp_id[$i]);
						mysqli_stmt_execute($stmt2);
					}
					echo "Select Delete Success";
				}
				mysqli_stmt_close($stmt2);
			} else {
				echo "ERROR";
			}
		}
	}
?>