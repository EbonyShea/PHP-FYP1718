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
		if (!isset($_POST['quiz_title']) || !isset($_POST['quiz_desc']) || !isset($_POST['quiz_url'])){
			echo "This is not the function you are looking for";
		} else {
			if(empty($_POST) || ctype_space($_POST['quiz_title']) || ctype_space($_POST['quiz_desc']) || ctype_space($_POST['quiz_url'])){
				echo "Empty input detected on required field";
			} else { // BEGIN
				include_once 'dbh.inc.php';
				$errors = "";
				
				/* === Variables === */
				$quiz_title = mysqli_real_escape_string($conn, $_POST['quiz_title']);
				$quiz_desc = mysqli_real_escape_string($conn, $_POST['quiz_desc']);
				$quiz_url = mysqli_real_escape_string($conn, $_POST['quiz_url']);
				$quiz_dl = mysqli_real_escape_string($conn, $_POST['quiz_dl']);
				/* === Variables === */
				
				/* === Update only === */
				$up_Img = mysqli_real_escape_string($conn, $_POST['updateImg']);
				$up_File = mysqli_real_escape_string($conn, $_POST['updateFile']);
				/* === Update only === */
				
				/* === Files === */
				// Image File
				$quiz_imgName = $_FILES['quiz_img']['name'];
				$quiz_imgTmp = $_FILES['quiz_img']['tmp_name'];
				$quiz_imgSize = $_FILES['quiz_img']['size'];
				$quiz_imgError = $_FILES['quiz_img']['error'];
				$quiz_imgType = $_FILES['quiz_img']['type'];
				$quiz_imgExt = explode ('.', $quiz_imgName);
				$quiz_imgActualExt = strtolower(end($quiz_imgExt));
				$allowed_img = array('jpg','jpeg','png');
				
				// Local File
				$quiz_fileName = $_FILES['quiz_file']['name'];
				$quiz_fileTmp = $_FILES['quiz_file']['tmp_name'];
				$quiz_fileSize = $_FILES['quiz_file']['size'];
				$quiz_fileError = $_FILES['quiz_file']['error'];
				$quiz_fileType = $_FILES['quiz_file']['type'];
				$quiz_fileExt = explode ('.', $quiz_fileName);
				$quiz_fileActualExt = strtolower(end($quiz_fileExt));
				$allowed_file = array('zip','rar','pdf','doc','docx','txt');
				/* === Files === */
				
				
				/* === Error Handling === */
				if (strlen($quiz_title) > 50){
					$errors .= "\nQuiz title too long";
				} else {
					if (strlen($quiz_desc) > 200){
						$errors .= "\nQuiz description too long";
					} else {
						if(strlen($quiz_url) > 200 || filter_var($quiz_url, FILTER_VALIDATE_URL) === FALSE 
							|| (strpos($quiz_url, "http://") === FALSE && (strpos($quiz_url, "https://") === FALSE))
							|| (strpos($quiz_url, "kahoot") === FALSE && (strpos($quiz_url, "cram") === FALSE) && (strpos($quiz_url, "edpuzzle") === FALSE))
							){
							$errors .= "\nInvalid Quiz URL";
						} else {
							/* === OPTIONALs AND FILEs CHECKING === */
							if (empty($quiz_imgName)){
								if ($_POST['quiz_ID'] === '' || (isset($_POST['quiz_ID']) && $up_Img === '')){
									$quiz_imgName = NULL;
								}
							} else {
								if ($quiz_imgError != 0 || !in_array($quiz_imgActualExt, $allowed_img) || $quiz_imgSize > 1000000){
									$errors .= "\nInvalid image file";
								}
							}
							
							if (empty($quiz_dl) || ctype_space($quiz_dl)){
								$quiz_dl = NULL;
							} else {
								if (!filter_var($quiz_dl, FILTER_VALIDATE_URL) || strpos($quiz_dl, 'https://drive.google.com/open?id=')
									|| strlen($quiz_dl) > 150){
									$errors .= "\nInvalid Drive URL";
								}
							}
							
							if (empty($quiz_fileName)){
								if($_POST['quiz_ID'] === '' || (isset($_POST['quiz_ID']) && $up_File === '')){
									$quiz_fileName = NULL;
								}
							} else {
								if ($quiz_fileError != 0 || !in_array($quiz_fileActualExt, $allowed_file) || $quiz_fileSize > 10000000){
									$errors .= "\nInvalid local file";
								}
							}
							/* === OPTIONAL AND FILE CHECKING === */
						}
					}
				}
				/* === Error Handling === */
				
				/* === Quiz Insert === */
				if (!empty($errors)){
					echo $errors;
				} else {
					if (isset($_POST['quiz_ID']) && $_POST['quiz_ID'] != ''){
						/* UPDATE */
						$quiz_ID = mysqli_real_escape_string($conn, $_POST['quiz_ID']);
						
						if (!empty($quiz_imgName)){
							$quiz_imgName = $quiz_ID.".".$quiz_imgActualExt;
							move_uploaded_file($quiz_imgTmp, "../img/Quiz/".$quiz_ID.".".$quiz_imgActualExt);
						} else {
							if ($up_Img != ''){
								$quiz_imgName = $up_Img;
							}
						}
						
						if (!empty($quiz_fileName)){
							$quiz_fileName = $quiz_ID.".".$quiz_fileActualExt;
							move_uploaded_file($quiz_fileTmp, "../dl/Quiz/".$quiz_ID.".".$quiz_fileActualExt);
						} else {
							if ($up_File != ''){
								$quiz_fileName = $up_File;
							}
						}
						
						$sql = "UPDATE Quiz 
						SET quiz_title = ?, quiz_desc = ?, quiz_img = ?, quiz_dl = ?, quiz_file = ?, quiz_url = ?, User_ID = ?
						WHERE quiz_ID = ?;";
						$stmt2 = mysqli_stmt_init($conn);
						if (!mysqli_stmt_prepare($stmt2, $sql)){
							echo "ERROR:1";
						} else {
							mysqli_stmt_bind_param($stmt2, "ssssssss", $quiz_title, $quiz_desc, $quiz_imgName, $quiz_dl, $quiz_fileName, $quiz_url, $_SESSION['user_ID'], $quiz_ID);
							mysqli_stmt_execute($stmt2);
							mysqli_stmt_close($stmt2);
						}
					} else {
						/* ADD */
						$sql = "SELECT Counter FROM content_ctr WHERE Content_Type = 'Quiz' LIMIT 1;";
						$result = mysqli_query($conn, $sql);
						$row = $result->fetch_assoc();
						$num = $row['Counter'];
						$iterate = $num + 1;
						$increment = sprintf("%09d",$iterate);							
						$quiz_ID = 'Q'.$increment;
						if($quiz_imgName!=NULL){
							$quiz_imgName = $quiz_ID.".".$quiz_imgActualExt;
							move_uploaded_file($quiz_imgTmp, "../img/Quiz/".$quiz_ID.".".$quiz_imgActualExt);
						}
						if($quiz_fileName!=NULL){
							$quiz_fileName = $quiz_ID.".".$quiz_fileActualExt;
							move_uploaded_file($quiz_fileTmp, "../dl/Quiz/".$quiz_ID.".".$quiz_fileActualExt);
						}
						mysqli_query($conn, "UPDATE content_ctr SET Counter = '$iterate' WHERE Content_Type = 'Quiz';");
						$sql = "INSERT INTO Quiz (quiz_ID, quiz_title, quiz_desc, quiz_img, quiz_dl, quiz_file, quiz_url, User_ID) 
						VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
						$stmt = mysqli_stmt_init($conn);
						if(!mysqli_stmt_prepare($stmt, $sql)) {
							echo "ERROR:2";
						} else {
							mysqli_stmt_bind_param($stmt, "ssssssss", $quiz_ID, $quiz_title, $quiz_desc, $quiz_imgName, $quiz_dl, $quiz_fileName, $quiz_url, $_SESSION['user_ID']);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_close($stmt);
						}
					}
					echo 1;
				}
				/* === Quiz Insert === */
			} // END
		}
	}
?>