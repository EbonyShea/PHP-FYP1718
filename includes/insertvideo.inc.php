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
		if (!isset($_POST['video_title']) || !isset($_POST['video_desc']) || !isset($_POST['video_url'])){
			echo "This is not the function you are looking for";
		} else {
			if(empty($_POST) || ctype_space($_POST['video_title']) || ctype_space($_POST['video_desc']) || ctype_space($_POST['video_url'])){
				echo "Empty input detected on required field";
			} else { // BEGIN
				include_once 'dbh.inc.php';
				$errors = "";
				
				/* === Variables === */
				$v_title = mysqli_real_escape_string($conn, $_POST['video_title']);
				$v_desc = mysqli_real_escape_string($conn, $_POST['video_desc']);
				$v_url = mysqli_real_escape_string($conn, $_POST['video_url']);
				$v_dl = mysqli_real_escape_string($conn, $_POST['video_dl']);
				/* === Variables === */
				
				/* === Update only === */
				$up_Img = mysqli_real_escape_string($conn, $_POST['updateImg']);
				$up_File = mysqli_real_escape_string($conn, $_POST['updateFile']);
				/* === Update only === */
				
				/* === Files === */
				// Image File
				$v_imgName = $_FILES['video_img']['name'];
				$v_imgTmp = $_FILES['video_img']['tmp_name'];
				$v_imgSize = $_FILES['video_img']['size'];
				$v_imgError = $_FILES['video_img']['error'];
				$v_imgType = $_FILES['video_img']['type'];
				$v_imgExt = explode ('.', $v_imgName);
				$v_imgActualExt = strtolower(end($v_imgExt));
				$allowed_img = array('jpg','jpeg','png');
				
				// Local File
				$v_fileName = $_FILES['video_file']['name'];
				$v_fileTmp = $_FILES['video_file']['tmp_name'];
				$v_fileSize = $_FILES['video_file']['size'];
				$v_fileError = $_FILES['video_file']['error'];
				$v_fileType = $_FILES['video_file']['type'];
				$v_fileExt = explode ('.', $v_fileName);
				$v_fileActualExt = strtolower(end($v_fileExt));
				$allowed_file = array('zip','rar','wmv','mp4');
				/* === Files === */
				
				
				/* === Error Handling === */
				if (strlen($v_title) > 50){
					$errors .= "\nVideo title too long";
				} else {
					if (strlen($v_desc) > 200){
						$errors .= "\nVideo description too long";
					} else {
						if(strlen($v_url) > 200 || filter_var($v_url, FILTER_VALIDATE_URL) === FALSE 
							|| (strpos($v_url, "https://www.youtube.com/watch?v=") === FALSE && strpos($v_url, "https://youtu.be/") === FALSE)){
							$errors .= "\nInvalid video URL";
						} else {
							/* === OPTIONALs AND FILEs CHECKING === */
							if (empty($v_imgName)){
								if ($_POST['video_ID'] === '' || (isset($_POST['video_ID']) && $up_Img === '')){
									$v_imgName = NULL;
								}
							} else {
								if ($v_imgError != 0 || !in_array($v_imgActualExt, $allowed_img) || $v_imgSize > 1000000){
									$errors .= "\nInvalid image file";
								}
							}
							
							if (empty($v_dl) || ctype_space($v_dl)){
								$v_dl = NULL;
							} else {
								if (!filter_var($v_dl, FILTER_VALIDATE_URL) || strpos($v_dl, 'https://drive.google.com/open?id=')
									|| strlen($v_dl) > 150){
									$errors .= "\nInvalid Drive URL";
								}
							}
							
							if (empty($v_fileName)){
								if($_POST['video_ID'] === '' || (isset($_POST['video_ID']) && $up_File === '')){
									$v_fileName = NULL;
								}
							} else {
								if ($v_fileError != 0 || !in_array($v_fileActualExt, $allowed_file) || $v_fileSize > 15999999){
									$errors .= "\nInvalid local file";
								}
							}
							/* === OPTIONAL AND FILE CHECKING === */
						}
					}
				}
				/* === Error Handling === */
				
				/* === Video Insert === */
				if (!empty($errors)){
					echo $errors;
				} else {
					if (isset($_POST['video_ID']) && $_POST['video_ID'] != ''){
						/* UPDATE */
						$v_ID = mysqli_real_escape_string($conn, $_POST['video_ID']);
						
						if(!empty($v_imgName)){
							$v_imgName = $v_ID.".".$v_imgActualExt;
							move_uploaded_file($v_imgTmp, "../img/Video/".$v_ID.".".$v_imgActualExt);
						} else {
							if ($up_Img != ''){
								$v_imgName = $up_Img;
							}
						}
						
						if(!empty($v_fileName)){
							$v_fileName = $v_ID.".".$v_fileActualExt;			
							move_uploaded_file($v_fileTmp, "../dl/Video/".$v_ID.".".$v_fileActualExt);
						} else {
							if ($up_File != ''){
								$v_fileName = $up_File;
							}
						}
						
						$sql = "UPDATE video 
						SET Video_Title = ?, Video_Desc = ?, Video_Img = ?, Video_DL = ?, Video_File = ?, Video_URL = ?, User_ID = ?
						WHERE Video_ID = ?;";
						$stmt2 = mysqli_stmt_init($conn);
						if (!mysqli_stmt_prepare($stmt2, $sql)){
							echo "ERROR:1";
						} else {
							mysqli_stmt_bind_param($stmt2, "ssssssss", $v_title, $v_desc, $v_imgName, $v_dl, $v_fileName, $v_url, $_SESSION['user_ID'], $v_ID);
							mysqli_stmt_execute($stmt2);
							mysqli_stmt_close($stmt2);
						}
					} else {
						/* ADD */
						$sql = "SELECT Counter FROM content_ctr WHERE Content_Type = 'Video' LIMIT 1;";
						$result = mysqli_query($conn, $sql);
						$row = $result->fetch_assoc();
						$num = $row['Counter'];
						$iterate = $num + 1;
						$increment = sprintf("%09d",$iterate);							
						$v_ID = 'V'.$increment;
						if($v_imgName!=NULL){
							$v_imgName = $v_ID.".".$v_imgActualExt;
							move_uploaded_file($v_imgTmp, "../img/Video/".$v_ID.".".$v_imgActualExt);
						}
						if($v_fileName!=NULL){
							$v_fileName = $v_ID.".".$v_fileActualExt;
							move_uploaded_file($v_fileTmp, "../dl/Video/".$v_ID.".".$v_fileActualExt);
						}
						mysqli_query($conn, "UPDATE content_ctr SET Counter = '$iterate' WHERE Content_Type = 'Video';");
						$sql = "INSERT INTO video (Video_ID, Video_Title, Video_Desc, Video_Img, Video_DL, Video_File, Video_URL, User_ID) 
						VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
						$stmt = mysqli_stmt_init($conn);
						if(!mysqli_stmt_prepare($stmt, $sql)) {
							echo "ERROR:2";
						} else {
							mysqli_stmt_bind_param($stmt, "ssssssss", $v_ID, $v_title, $v_desc, $v_imgName, $v_dl, $v_fileName, $v_url, $_SESSION['user_ID']);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_close($stmt);
						}
					}
					echo 1;
				}
				/* === Video Insert === */
			} // END
		}
	}
?>