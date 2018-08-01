<?php
	session_start();
	// To disallow illegal access
	if (!isset($_SESSION['username']) || $_SERVER['REQUEST_METHOD'] != 'POST'){
		if ($_SERVER['REQUEST_METHOD'] === 'POST'){
			echo "Access denied";
		} else {
			header("Location: ../dashboard.php");
			exit();
		}
	} else {
		if (!isset($_POST['forum_topic']) || !isset($_POST['forum_details'])){
			echo "This is not the function you are looking for";
		} else {
			if(empty($_POST) || ctype_space($_POST['forum_topic']) || ctype_space($_POST['forum_details'])){
				echo "Empty input detected on required field";
			} else { // BEGIN
				include_once 'dbh.inc.php';
				$errors = "";
				$f_topic = mysqli_real_escape_string($conn, $_POST['forum_topic']);
				$f_details = mysqli_real_escape_string($conn, $_POST['forum_details']);
				
				/* === Error Handling === */
				if (strlen($f_topic) > 50){
					$errors .= "\nTopic title too long";
				}
				if (strlen($f_details) > 500){
					$errors .= "\nTopic details too long";
				}
				/* === Error Handling === */
				
				/* === Topic Insert === */
				if (!empty($errors)){
					echo $errors;
				} else {
					$status = 1;
					if(isset($_POST['status'])){
						if ($_POST['status'] == "disable"){
							$status = 0;
						}
					}
					if (isset($_POST['forum_ID']) && $_POST['forum_ID'] != ''){
						/* Update */
						$f_ID = mysqli_real_escape_string($conn, $_POST['forum_ID']);
						$sql = "UPDATE forum 
						SET Forum_Title = ?, Forum_Content = ?, Forum_Comm = ?, User_ID = ?
						WHERE Forum_ID = ?;";
						$stmt2 = mysqli_stmt_init($conn);
						if (!mysqli_stmt_prepare($stmt2, $sql)){
							echo "ERROR:1";
						} else {
							mysqli_stmt_bind_param($stmt2, "sssss", $f_topic, $f_details, $status, $_SESSION['user_ID'], $f_ID);
							mysqli_stmt_execute($stmt2);
							mysqli_stmt_close($stmt2);
							echo 1;
						}
					} else {
						/* Add */
						$sql = "SELECT Counter FROM content_ctr WHERE Content_Type = 'Forum' LIMIT 1;";
						$result = mysqli_query($conn, $sql);
						$row = $result->fetch_assoc();
						$num = $row['Counter'];
						$iterate = $num + 1;
						$increment = sprintf("%09d",$iterate);							
						$f_ID = 'F'.$increment;
						mysqli_query($conn, "UPDATE content_ctr SET Counter = '$iterate' WHERE Content_Type = 'Forum';");

						$sql = "INSERT INTO forum (Forum_ID, Forum_Title, Forum_Content, Forum_Comm, User_ID) VALUES (?,?,?,?,?);";
						$stmt = mysqli_stmt_init($conn);
						if(!mysqli_stmt_prepare($stmt, $sql)) {
							echo "ERROR";
						} else {
							mysqli_stmt_bind_param($stmt, "sssss", $f_ID, $f_topic, $f_details, $status, $_SESSION['user_ID']);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_close($stmt);
							echo 1;
						}						
					}
				}
				/* === Topic Insert === */
			} // END
		}
	}
?>