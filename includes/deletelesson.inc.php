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
		if (isset($_POST['lesson_id'])){
			$lesson_id = mysqli_real_escape_string($conn, $_POST['lesson_id']);
			
			$sql = "DELETE FROM lesson WHERE lesson_id = ?;";
			$stmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmt, $sql)) {
				echo "ERROR";
			} else {
				mysqli_stmt_bind_param($stmt, "s", $lesson_id);
				mysqli_stmt_execute($stmt);
				echo "Delete Success";
			}
			mysqli_stmt_close($stmt);
		} else {
			if (isset($_POST['selected_lesson'])){
				$temp_id = mysqli_real_escape_string($conn, $_POST['selected_lesson']);
				$emp_id = explode(',', $temp_id);				
				$sql2 = "DELETE FROM lesson WHERE lesson_id = ?;";
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