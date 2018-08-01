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
		/* Individual */
		if (isset($_POST['forum_ID']) && ($_POST['query'] == "delete" || $_POST['query'] == "enable" || $_POST['query'] == "disable" || $_POST['query'] == "clear")){
			$forum_id = mysqli_real_escape_string($conn, $_POST['forum_ID']);
			
			/* Delete Topic */
			if($_POST['query'] == "delete"){
				$sql = "DELETE FROM forum WHERE Forum_ID = ?;";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					echo "ERROR:1";
				} else {
					mysqli_stmt_bind_param($stmt, "s", $forum_id);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);
					echo "Delete Success";
				}
			}
			
			/* Enable or Disable Comment */
			if($_POST['query'] == "enable" || $_POST['query'] == "disable"){
				$status = 1;
				$msg = "Topic Comment Enabled";
				if ($_POST['query'] == "disable"){
					$status = 0;
					$msg = "Topic Comment Disabled";
				}
				$sql2 = "UPDATE forum SET Forum_Comm = ? WHERE Forum_ID = ?;";
				$stmt2 = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt2, $sql2)) {
					echo "ERROR:2";
				} else {
					mysqli_stmt_bind_param($stmt2, "ss", $status ,$forum_id);
					mysqli_stmt_execute($stmt2);
					mysqli_stmt_close($stmt2);
					echo $msg;
				}
			}
			
			/* Clear Comment */
			if ($_POST['query'] == "clear"){
				$sql3 = "DELETE FROM comment WHERE Content_ID = ?";
				$stmt3 = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt3, $sql3)) {
					echo "ERROR:3";
				} else {
					mysqli_stmt_bind_param($stmt3, "s", $forum_id);
					mysqli_stmt_execute($stmt3);
					mysqli_stmt_close($stmt3);
					echo "All Comments Cleared";
				}
			}
		} else {
			/* Multiple */
			if (isset($_POST['selected_topic']) && ($_POST['query'] == "delete" || $_POST['query'] == "enable" || $_POST['query'] == "disable" || $_POST['query'] == "clear")){
				$temp_id = mysqli_real_escape_string($conn, $_POST['selected_topic']);
				$emp_id = explode(',', $temp_id);
				
				/* Delete Topic */
				if($_POST['query'] == "delete"){
					$sql4 = "DELETE FROM forum WHERE Forum_ID = ?;";
					$stmt4 = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmt4, $sql4)) {
						echo "ERROR:4";
					} else {
						for ($i = 0; $i < count($emp_id); $i++){
							mysqli_stmt_bind_param($stmt4, "s", $emp_id[$i]);
							mysqli_stmt_execute($stmt4);
						}
						mysqli_stmt_close($stmt4);
						echo "Select Delete Success";
					}
				}
				
				/* Enable or Disable Comment */
				if($_POST['query'] == "enable" || $_POST['query'] == "disable"){
					$status = 1;
					$msg = "Topic(s) Comment Enabled";
					if ($_POST['query'] == "disable"){
						$status = 0;
						$msg = "Topic(s) Comment Disabled";
					}
					$sql5 = "UPDATE forum SET Forum_Comm = ? WHERE Forum_ID = ?;";
					$stmt5 = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmt5, $sql5)) {
						echo "ERROR:5";
					} else {
						for ($i = 0; $i < count($emp_id); $i++){
							mysqli_stmt_bind_param($stmt5, "ss", $status, $emp_id[$i]);
							mysqli_stmt_execute($stmt5);
						}
						mysqli_stmt_close($stmt5);
						echo $msg;
					}
				}
				
				/* Clear Comment */
				if ($_POST['query'] == "clear"){
					$sql6 = "DELETE FROM comment WHERE Content_ID = ?";
					$stmt6 = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmt6, $sql6)) {
						echo "ERROR:6";
					} else {
						for ($i = 0; $i < count($emp_id); $i++){
							mysqli_stmt_bind_param($stmt6, "s", $emp_id[$i]);
							mysqli_stmt_execute($stmt6);
						}
						mysqli_stmt_close($stmt6);
						echo "All Comments Cleared";
					}
				}
			}
		}
	}
?>