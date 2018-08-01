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
		/* Individual delete */
		if (isset($_POST['user_ID']) && ($_POST['query'] == "delete" || $_POST['query'] == "makeAdmin" || $_POST['query'] == "makeDefault")){
			$user_id = mysqli_real_escape_string($conn, $_POST['user_ID']);
			if($_POST['query'] == "delete"){
				$sql = "DELETE FROM user WHERE user_id = ?;";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					echo "ERROR:1";
				} else {
					mysqli_stmt_bind_param($stmt, "s", $user_id);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);
					echo "Delete Success";
				}
			}

			if($_POST['query'] == "makeAdmin" || $_POST['query'] == "makeDefault"){
				$user_type = 0;
				$msg = "Revert Default Success";
				$sql = "UPDATE user SET User_Type = ? WHERE user_id = ?;";
				$stmt4 = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt4, $sql)) {
					echo "ERROR:1";
				} else {
					if ($_POST['query'] == "makeAdmin"){
						$user_type = 1;
						$msg = "Make Admin Success";
					}
					mysqli_stmt_bind_param($stmt4, "ss", $user_type, $user_id);
					mysqli_stmt_execute($stmt4);
					mysqli_stmt_close($stmt4);
					echo $msg;
				}
			}
		} else {
			/* Multiple select */
			if (isset($_POST['selected_users']) && ($_POST['query'] == "delete" || $_POST['query'] == "enable" || $_POST['query'] == "disable")){
				$temp_id = mysqli_real_escape_string($conn, $_POST['selected_users']);
				$emp_id = explode(',', $temp_id);
				/* Delete */
				if($_POST['query'] == "delete"){
					$sql2 = "DELETE FROM user WHERE user_id = ?;";
					$stmt2 = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmt2, $sql2)) {
						echo "ERROR:2";
					} else {
						for ($i = 0; $i < count($emp_id); $i++){
							mysqli_stmt_bind_param($stmt2, "s", $emp_id[$i]);
							mysqli_stmt_execute($stmt2);
						}
						mysqli_stmt_close($stmt2);
						echo "Select Delete Success";
					}
				}
				
				/* Enable & Disable */
				if($_POST['query'] == "enable" || $_POST['query'] == "disable"){
					$status = 1;
					$msg = "Enable Success";	
					$sql3 = "UPDATE user SET User_Status = ? WHERE User_ID = ?;";
					$stmt3 = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmt3, $sql3)) {
						echo "ERROR:3";
					} else {
						if($_POST['query'] == "disable"){
							$status = 0;
							$msg = "Disable Success";
						}
						for ($i = 0; $i < count($emp_id); $i++){
							mysqli_stmt_bind_param($stmt3, "ss", $status, $emp_id[$i]);
							mysqli_stmt_execute($stmt3);
						}
						mysqli_stmt_close($stmt3);
						echo $msg;
					}
				}
			} else {
				echo "ERROR:SU";
			}
		}
	}
?>