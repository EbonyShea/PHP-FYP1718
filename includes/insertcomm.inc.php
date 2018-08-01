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
		if (!isset($_POST['comment'])){
			echo "This is not the function you are looking for";
		} else {
			if(empty($_POST) || empty($_POST['comment']) || ctype_space($_POST['comment'])){
				echo "Empty input detected on required field";
			} else {
				include_once 'dbh.inc.php';
				$u_ID = $_SESSION['user_ID'];
				$comment = mysqli_real_escape_string($conn, $_POST['comment']);
				if (strlen($comment) > 300){
					echo "Comment too long";
				} else {
					if (isset($_POST['comment_ID']) && $_POST['comment_ID']!= ''){
						/* Update */
						$c_ID = mysqli_real_escape_string($conn, $_POST['comment_ID']);
						$sql = "UPDATE comment SET Comment_Content = ? WHERE Comment_ID = ?;";
						$stmt = mysqli_stmt_init($conn);
						if (!mysqli_stmt_prepare($stmt, $sql)){
							echo "ERROR:1";
						} else {
							mysqli_stmt_bind_param($stmt, "ss", $comment, $c_ID);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_close($stmt);
							echo 1;
						}
					} else {
						/* Add */
						if (!isset($_POST['forum_ID'])){
							echo "ERROR:2";
						} else {
							$f_ID = mysqli_real_escape_string($conn, $_POST['forum_ID']);
							$sql = "SELECT Counter FROM content_ctr WHERE Content_Type = 'Comment' LIMIT 1;";
							$result = mysqli_query($conn, $sql);
							$row = $result->fetch_assoc();
							$num = $row['Counter'];
							$iterate = $num + 1;
							$increment = sprintf("%09d",$iterate);							
							$c_ID = 'C'.$increment;
							
							$sql2 = "SELECT Forum_Comm FROM Forum WHERE Forum_ID = '".$f_ID."' LIMIT 1;";
							$result = mysqli_query($conn, $sql2);
							$row = mysqli_fetch_array($result);
							if ($row['Forum_Comm'] == 0){
								echo "Comment disabled for this topic";
							} else {
								$sql = "INSERT INTO comment (Comment_ID, Comment_Content, Content_ID, User_ID) VALUES (?,?,?,?);";
								$stmt = mysqli_stmt_init($conn);
								if(!mysqli_stmt_prepare($stmt, $sql)) {
									echo "ERROR:3";
								} else {
									mysqli_stmt_bind_param($stmt, "ssss", $c_ID, $comment, $f_ID, $_SESSION['user_ID']);
									mysqli_stmt_execute($stmt);
									mysqli_stmt_close($stmt);
									mysqli_query($conn, "UPDATE content_ctr SET Counter = '$iterate' WHERE Content_Type = 'comment';");
									echo 1;
								}
							}
						}
					}
				}
			}
		}
	}