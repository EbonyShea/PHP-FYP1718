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
		if (empty($_POST) || !isset($_POST['user_ID']) || !isset($_POST['u_username'])) {
			echo "This is not the function you are looking for";
		} else {
			include_once 'dbh.inc.php';
			$user_ID = mysqli_real_escape_string($conn, $_POST['user_ID']);
			$username = mysqli_real_escape_string($conn, $_POST['u_username']);
			$password = mysqli_real_escape_string($conn, $_POST['u_password']);
			$email = mysqli_real_escape_string($conn, $_POST['u_email']);
			$type = mysqli_real_escape_string($conn, $_POST['u_type']);
			$status = mysqli_real_escape_string($conn, $_POST['u_status']);
			
			$sql = "SELECT * FROM user WHERE User_ID = '".$user_ID."'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result);
			
			if($type == "default"){
				$type = 0;
			} else {
				$type = 1;
			}
			
			if($status == "disable"){
				$status = 0;
			} else {
				$status = 1;
			}
			
			if ( empty($user_ID) || empty($username) || empty($email)
				|| ctype_space($user_ID) || ctype_space($username) || ctype_space($email)) {
				echo "Please enter required information";
			} else {
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
					echo "Please enter valid email";
				} else {
					if (!empty($password) && (ctype_space($password) || strlen($password) > 265 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/', $password))){
						echo "Password does not meet requirement(s)";
					} else {
						$sql = "SELECT * FROM user WHERE email = ?";
						$stmt2 = mysqli_stmt_init($conn);
						if(!mysqli_stmt_prepare($stmt2, $sql)) {
							echo "ERROR:2";
						} else {
							mysqli_stmt_bind_param($stmt2, "s", $email);
							mysqli_stmt_execute($stmt2);
							mysqli_stmt_store_result($stmt2);
							$resultCheck = mysqli_stmt_num_rows($stmt2);
							if ($resultCheck > 0 && $email != $row['Email']) {
								echo "Email taken";
								mysqli_stmt_close($stmt2);
							} else {
								/* Image */
								$error = "";
								$img = $row['User_Img'];
								$imgName = $_FILES['u_user_img']['name'];
								$imgTmp = $_FILES['u_user_img']['tmp_name'];
								$imgSize = $_FILES['u_user_img']['size'];
								$imgError = $_FILES['u_user_img']['error'];
								$imgType = $_FILES['u_user_img']['type'];
								$imgExt = explode ('.', $imgName);
								$imgActualExt = strtolower(end($imgExt));
								$allowed_img = array('jpg','jpeg','png');
								
								if (!empty($imgName)){
									if ($imgError != 0 || !in_array($imgActualExt, $allowed_img) || $imgSize > 1000000){
										$error .= "Invalid image file";
									} else {
										$img = $user_ID.".".$imgActualExt;
										move_uploaded_file($imgTmp, "../img/User/".$img);
									}
								}
								
								if (!empty($error)){
									echo $error;
								} else {
									/* Update password */
									if (!empty($password)){
										$hashed_Pwd = password_hash($password, PASSWORD_DEFAULT);
										$sql = "UPDATE user SET Password = ? WHERE User_ID = ?;";
										$stmt = mysqli_stmt_init($conn);
										if(!mysqli_stmt_prepare($stmt, $sql)) {
											echo "ERROR:1";
										} else {
											mysqli_stmt_bind_param($stmt, "ss", $hashed_Pwd, $user_ID);
											mysqli_stmt_execute($stmt);
											mysqli_stmt_close($stmt);
										}
									}
									
									/* Update all */
									$sql = "UPDATE user 
									SET Email = ?, User_Img = ?, User_Type = ?, User_Status = ?
									WHERE User_ID = ?;";
									$stmt3 = mysqli_stmt_init($conn);
									if(!mysqli_stmt_prepare($stmt3, $sql)) {
										echo "ERROR:3";
									} else {
										mysqli_stmt_bind_param($stmt3, "sssss", $email, $img, $type, $status, $user_ID);
										mysqli_stmt_execute($stmt3);
										mysqli_stmt_close($stmt3);
										echo 1;
									}
								}
							}
						}
					}
				}
			}
		}
	}
?>