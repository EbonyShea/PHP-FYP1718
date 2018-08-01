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
		if (!isset($_POST['misc_title']) || !isset($_POST['misc_desc']) || (!isset($_POST['misc_url']) && !isset($_POST['misc_dl']) && empty($_FILE["misc_file"]["name"]))){
			echo "This is not the function you are looking for";
		} else {
			if(empty($_POST) || ctype_space($_POST['misc_title']) || ctype_space($_POST['misc_desc']) 
				|| (((ctype_space($_POST['misc_url']) || empty($_POST['misc_url'])) && (ctype_space($_POST['misc_dl']) || empty($_POST['misc_dl'])) && (empty($_FILES['misc_file']['name']))))){
				echo "Empty input detected on required field";
			} else { // BEGIN
				include_once 'dbh.inc.php';
				$errors = "";
				
				/* === Variables === */
				$misc_title = mysqli_real_escape_string($conn, $_POST['misc_title']);
				$misc_desc = mysqli_real_escape_string($conn, $_POST['misc_desc']);
				$misc_url = mysqli_real_escape_string($conn, $_POST['misc_url']);
				$misc_dl = mysqli_real_escape_string($conn, $_POST['misc_dl']);
				/* === Variables === */
				
				/* === Update only === */
				$up_Img = mysqli_real_escape_string($conn, $_POST['updateImg']);
				$up_File = mysqli_real_escape_string($conn, $_POST['updateFile']);
				/* === Update only === */
				
				/* === Files === */
				// Image File
				$misc_imgName = $_FILES['misc_img']['name'];
				$misc_imgTmp = $_FILES['misc_img']['tmp_name'];
				$misc_imgSize = $_FILES['misc_img']['size'];
				$misc_imgError = $_FILES['misc_img']['error'];
				$misc_imgType = $_FILES['misc_img']['type'];
				$misc_imgExt = explode ('.', $misc_imgName);
				$misc_imgActualExt = strtolower(end($misc_imgExt));
				$allowed_img = array('jpg','jpeg','png');
				
				// Local File
				$misc_fileName = $_FILES['misc_file']['name'];
				$misc_fileTmp = $_FILES['misc_file']['tmp_name'];
				$misc_fileSize = $_FILES['misc_file']['size'];
				$misc_fileError = $_FILES['misc_file']['error'];
				$misc_fileType = $_FILES['misc_file']['type'];
				$misc_fileExt = explode ('.', $misc_fileName);
				$misc_fileActualExt = strtolower(end($misc_fileExt));
				/* === Files === */
				
				
				/* === Error Handling === */
				if (strlen($misc_title) > 50){
					$errors .= "\nMisc title too long";
				} else {
					if (strlen($misc_desc) > 200){
						$errors .= "\nMisc description too long";
					} else {
						/* === OPTIONALs AND FILEs CHECKING === */
						if(!empty($misc_url) && (strlen($misc_url) > 200 
							|| filter_var($misc_url, FILTER_VALIDATE_URL) === FALSE 
							|| (strpos($misc_url, "http://") === FALSE && (strpos($misc_url, "https://") === FALSE)))){
							$errors .= "Invalid Misc URL";
						}
						
						if (empty($misc_imgName)){
							if ($_POST['misc_ID'] === '' || (isset($_POST['misc_ID']) && $up_Img === '')){
								$misc_imgName = NULL;
							}
						} else {
							if ($misc_imgError != 0 || !in_array($misc_imgActualExt, $allowed_img) || $misc_imgSize > 1000000){
								$errors .= "\nInvalid image file";
							}
						}
						
						if (empty($misc_dl) || ctype_space($misc_dl)){
							$misc_dl = NULL;
						} else {
							if (!filter_var($misc_dl, FILTER_VALIDATE_URL) || strpos($misc_dl, 'https://drive.google.com/open?id=')
								|| strlen($misc_dl) > 150){
								$errors .= "\nInvalid Drive URL";
							}
						}
						
						if (empty($misc_fileName)){
							if($_POST['misc_ID'] === '' || (isset($_POST['misc_ID']) && $up_File === '')){
								$misc_fileName = NULL;
							}
						} else {
							if ($misc_fileError != 0 || $misc_fileSize > 20000000){
								$errors .= "\nInvalid local file";
							}
						}
						/* === OPTIONAL AND FILE CHECKING === */
					}
				}
				/* === Error Handling === */
				
				/* === Misc Insert === */
				if (!empty($errors)){
					echo $errors;
				} else {
					if (isset($_POST['misc_ID']) && $_POST['misc_ID'] != ''){
						/* UPDATE */
						$misc_ID = mysqli_real_escape_string($conn, $_POST['misc_ID']);
						
						if (!empty($misc_imgName)){
							$misc_imgName = $misc_ID.".".$misc_imgActualExt;
							move_uploaded_file($misc_imgTmp, "../img/Misc/".$misc_ID.".".$misc_imgActualExt);
						} else {
							if ($up_Img != ''){
								$misc_imgName = $up_Img;
							}
						}
						
						if (!empty($misc_fileName)){
							$misc_fileName = $misc_ID.".".$misc_fileActualExt;
							move_uploaded_file($misc_fileTmp, "../dl/Misc/".$misc_ID.".".$misc_fileActualExt);
						} else {
							if ($up_File != ''){
								$misc_fileName = $up_File;
							}
						}
						
						$sql = "UPDATE Misc 
						SET misc_title = ?, misc_desc = ?, misc_img = ?, misc_dl = ?, misc_file = ?, misc_url = ?, User_ID = ?
						WHERE misc_ID = ?;";
						$stmt2 = mysqli_stmt_init($conn);
						if (!mysqli_stmt_prepare($stmt2, $sql)){
							echo "ERROR:1";
						} else {
							mysqli_stmt_bind_param($stmt2, "ssssssss", $misc_title, $misc_desc, $misc_imgName, $misc_dl, $misc_fileName, $misc_url, $_SESSION['user_ID'], $misc_ID);
							mysqli_stmt_execute($stmt2);
							mysqli_stmt_close($stmt2);
						}
					} else {
						/* ADD */
						$sql = "SELECT Counter FROM content_ctr WHERE Content_Type = 'Misc' LIMIT 1;";
						$result = mysqli_query($conn, $sql);
						$row = $result->fetch_assoc();
						$num = $row['Counter'];
						$iterate = $num + 1;
						$increment = sprintf("%09d",$iterate);							
						$misc_ID = 'M'.$increment;
						if($misc_imgName!=NULL){
							$misc_imgName = $misc_ID.".".$misc_imgActualExt;
							move_uploaded_file($misc_imgTmp, "../img/Misc/".$misc_ID.".".$misc_imgActualExt);
						}
						if($misc_fileName!=NULL){
							$misc_fileName = $misc_ID.".".$misc_fileActualExt;
							move_uploaded_file($misc_fileTmp, "../dl/Misc/".$misc_ID.".".$misc_fileActualExt);
						}
						mysqli_query($conn, "UPDATE content_ctr SET Counter = '$iterate' WHERE Content_Type = 'Misc';");
						$sql = "INSERT INTO Misc (misc_ID, misc_title, misc_desc, misc_img, misc_dl, misc_file, misc_url, User_ID) 
						VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
						$stmt = mysqli_stmt_init($conn);
						if(!mysqli_stmt_prepare($stmt, $sql)) {
							echo "ERROR:2";
						} else {
							mysqli_stmt_bind_param($stmt, "ssssssss", $misc_ID, $misc_title, $misc_desc, $misc_imgName, $misc_dl, $misc_fileName, $misc_url, $_SESSION['user_ID']);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_close($stmt);
						}
					}
					echo 1;
				}
				/* === Misc Insert === */
			} // END
		}
	}
?>