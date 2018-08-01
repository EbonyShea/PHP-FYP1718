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
		if (!isset($_POST['fc_title']) || !isset($_POST['fc_desc']) || !isset($_POST['fc_url'])){
			echo "This is not the function you are looking for";
		} else {
			if(empty($_POST) || ctype_space($_POST['fc_title']) || ctype_space($_POST['fc_desc']) || ctype_space($_POST['fc_url'])){
				echo "Empty input detected on required field";
			} else { // BEGIN
				include_once 'dbh.inc.php';
				$errors = "";
				
				/* === Variables === */
				$fc_title = mysqli_real_escape_string($conn, $_POST['fc_title']);
				$fc_desc = mysqli_real_escape_string($conn, $_POST['fc_desc']);
				$fc_url = mysqli_real_escape_string($conn, $_POST['fc_url']);
				$fc_dl = mysqli_real_escape_string($conn, $_POST['fc_dl']);
				/* === Variables === */
				
				/* === Update only === */
				$up_Img = mysqli_real_escape_string($conn, $_POST['updateImg']);
				$up_File = mysqli_real_escape_string($conn, $_POST['updateFile']);
				/* === Update only === */
				
				/* === Files === */
				// Image File
				$fc_imgName = $_FILES['fc_img']['name'];
				$fc_imgTmp = $_FILES['fc_img']['tmp_name'];
				$fc_imgSize = $_FILES['fc_img']['size'];
				$fc_imgError = $_FILES['fc_img']['error'];
				$fc_imgType = $_FILES['fc_img']['type'];
				$fc_imgExt = explode ('.', $fc_imgName);
				$fc_imgActualExt = strtolower(end($fc_imgExt));
				$allowed_img = array('jpg','jpeg','png');
				
				// Local File
				$fc_fileName = $_FILES['fc_file']['name'];
				$fc_fileTmp = $_FILES['fc_file']['tmp_name'];
				$fc_fileSize = $_FILES['fc_file']['size'];
				$fc_fileError = $_FILES['fc_file']['error'];
				$fc_fileType = $_FILES['fc_file']['type'];
				$fc_fileExt = explode ('.', $fc_fileName);
				$fc_fileActualExt = strtolower(end($fc_fileExt));
				$allowed_file = array('zip','rar','pdf','doc','docx','pptx','txt','csv');
				/* === Files === */
				
				
				/* === Error Handling === */
				if (strlen($fc_title) > 50){
					$errors .= "\nFlashcard title too long";
				} else {
					if (strlen($fc_desc) > 200){
						$errors .= "\nFlashcard description too long";
					} else {
						if(strlen($fc_url) > 200 || filter_var($fc_url, FILTER_VALIDATE_URL) === FALSE 
							|| (strpos($fc_url, "cram.com") === FALSE && strpos($fc_url, "quizlet.com") === FALSE && strpos($fc_url, "goconqr.com") === FALSE)){
							$errors .= "\nInvalid Flashcard URL";
						} else {
							/* === OPTIONALs AND FILEs CHECKING === */
							if (empty($fc_imgName)){
								if ($_POST['fc_ID'] === '' || (isset($_POST['fc_ID']) && $up_Img === '')){
									$fc_imgName = NULL;
								}
							} else {
								if ($fc_imgError != 0 || !in_array($fc_imgActualExt, $allowed_img) || $fc_imgSize > 1000000){
									$errors .= "\nInvalid image file";
								}
							}
							
							if (empty($fc_dl) || ctype_space($fc_dl)){
								$fc_dl = NULL;
							} else {
								if (!filter_var($fc_dl, FILTER_VALIDATE_URL) || strpos($fc_dl, 'https://drive.google.com/open?id=')
									|| strlen($fc_dl) > 150){
									$errors .= "\nInvalid Drive URL";
								}
							}
							
							if (empty($fc_fileName)){
								if($_POST['fc_ID'] === '' || (isset($_POST['fc_ID']) && $up_File === '')){
									$fc_fileName = NULL;
								}
							} else {
								if ($fc_fileError != 0 || !in_array($fc_fileActualExt, $allowed_file) || $fc_fileSize > 10000000){
									$errors .= "\nInvalid local file";
								}
							}
							/* === OPTIONAL AND FILE CHECKING === */
						}
					}
				}
				/* === Error Handling === */
				
				/* === Flashcard Insert === */
				if (!empty($errors)){
					echo $errors;
				} else {
					if (isset($_POST['fc_ID']) && $_POST['fc_ID'] != ''){
						/* UPDATE */
						$fc_ID = mysqli_real_escape_string($conn, $_POST['fc_ID']);
						
						if (!empty($fc_imgName)){
							$fc_imgName = $fc_ID.".".$fc_imgActualExt;
							move_uploaded_file($fc_imgTmp, "../img/Flashcard/".$fc_ID.".".$fc_imgActualExt);
						} else {
							if ($up_Img != ''){
								$fc_imgName = $up_Img;
							}
						}
						
						if (!empty($fc_fileName)){
							$fc_fileName = $fc_ID.".".$fc_fileActualExt;
							move_uploaded_file($fc_fileTmp, "../dl/Flashcard/".$fc_ID.".".$fc_fileActualExt);
						} else {
							if ($up_File != ''){
								$fc_fileName = $up_File;
							}
						}
						
						$sql = "UPDATE Flashcard 
						SET fc_Title = ?, fc_Desc = ?, fc_img = ?, fc_DL = ?, fc_file = ?, fc_URL = ?, User_ID = ?
						WHERE fc_ID = ?;";
						$stmt2 = mysqli_stmt_init($conn);
						if (!mysqli_stmt_prepare($stmt2, $sql)){
							echo "ERROR:1";
						} else {
							mysqli_stmt_bind_param($stmt2, "ssssssss", $fc_title, $fc_desc, $fc_imgName, $fc_dl, $fc_fileName, $fc_url, $_SESSION['user_ID'], $fc_ID);
							mysqli_stmt_execute($stmt2);
							mysqli_stmt_close($stmt2);
						}
					} else {
						/* ADD */
						$sql = "SELECT Counter FROM content_ctr WHERE Content_Type = 'Flashcard' LIMIT 1;";
						$result = mysqli_query($conn, $sql);
						$row = $result->fetch_assoc();
						$num = $row['Counter'];
						$iterate = $num + 1;
						$increment = sprintf("%08d",$iterate);							
						$fc_ID = 'FC'.$increment;
						if($fc_imgName!=NULL){
							$fc_imgName = $fc_ID.".".$fc_imgActualExt;
							move_uploaded_file($fc_imgTmp, "../img/Flashcard/".$fc_ID.".".$fc_imgActualExt);
						}
						if($fc_fileName!=NULL){
							$fc_fileName = $fc_ID.".".$fc_fileActualExt;
							move_uploaded_file($fc_fileTmp, "../dl/Flashcard/".$fc_ID.".".$fc_fileActualExt);
						}
						mysqli_query($conn, "UPDATE content_ctr SET Counter = '$iterate' WHERE Content_Type = 'Flashcard';");
						$sql = "INSERT INTO Flashcard (fc_ID, fc_Title, fc_Desc, fc_img, fc_DL, fc_file, fc_URL, User_ID) 
						VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
						$stmt = mysqli_stmt_init($conn);
						if(!mysqli_stmt_prepare($stmt, $sql)) {
							echo "ERROR:2";
						} else {
							mysqli_stmt_bind_param($stmt, "ssssssss", $fc_ID, $fc_title, $fc_desc, $fc_imgName, $fc_dl, $fc_fileName, $fc_url, $_SESSION['user_ID']);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_close($stmt);
						}
					}
					echo 1;
				}
				/* === Flashcard Insert === */
			} // END
		}
	}
?>