<?php
	session_start();
	// To disallow illegal access
	if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 1 || $_SERVER['REQUEST_METHOD'] != 'POST'){
		if ($_SERVER['REQUEST_METHOD'] === 'POST'){
			echo "Access denied";
		} else {
			header("Location: ../dashboard.php");
			exit();
		}
	} else {
		if (!isset($_POST['ann'])){
			echo "This is not the function you are looking for";
		} else {
			if(empty($_POST) || empty($_POST['ann']) || ctype_space($_POST['ann'])){
				echo "Empty input detected on required field";
			} else {
				
				include_once 'dbh.inc.php';
				$ann = mysqli_real_escape_string($conn, $_POST['ann']);
				if (strlen($ann) > 200){
					echo "Announcement too long";
				} else {
					if (isset($_POST['ann_ID']) && $_POST['ann_ID'] != ''){
						/* Update */
						$ann_ID = mysqli_real_escape_string($conn, $_POST['ann_ID']);
						$sql = "UPDATE announcement SET Ann_Content = ? WHERE Ann_ID = ?;";
						$stmt = mysqli_stmt_init($conn);
						if (!mysqli_stmt_prepare($stmt, $sql)){
							echo "ERROR:1";
						} else {
							mysqli_stmt_bind_param($stmt, "ss", $ann, $ann_ID);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_close($stmt);
							echo 1;
						}
					} else {
						/* Add */
						$sql = "SELECT Counter FROM content_ctr WHERE Content_Type = 'Announcement' LIMIT 1;";
						$result = mysqli_query($conn, $sql);
						$row = $result->fetch_assoc();
						$num = $row['Counter'];
						$iterate = $num + 1;
						$increment = sprintf("%09d",$iterate);							
						$ann_ID = 'A'.$increment;
						
						$sql2 = "INSERT INTO announcement (Ann_ID, Ann_Content, User_ID) VALUES (?,?,?);";
						$stmt = mysqli_stmt_init($conn);
						if(!mysqli_stmt_prepare($stmt, $sql2)) {
							echo "ERROR:3";
						} else {
							mysqli_stmt_bind_param($stmt, "sss", $ann_ID, $ann, $_SESSION['user_ID']);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_close($stmt);
							mysqli_query($conn, "UPDATE content_ctr SET Counter = '$iterate' WHERE Content_Type = 'announcement';");
							echo 1;
						}
					}
				}
			}
		}
	}
?>