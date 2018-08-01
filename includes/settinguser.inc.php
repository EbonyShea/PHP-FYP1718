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
		include_once 'dbh.inc.php';
		$user_ID = $_SESSION['user_ID'];
		if(!isset($_POST['u_FirstName']) && !isset($_POST['u_Email']) && !isset($_POST['u_Pass']) && empty($_FILES['u_Img']) && !isset($_POST['clearImg'])){
			echo "This is not the function you are looking for.";
		} else {
			/* Change Email */
			if(isset($_POST['e_query']) && $_POST['e_query'] == 'changeEmail'){
				/* Email variables */
				$o_email = mysqli_real_escape_string($conn, $_POST['u_oEmail']);
				$email = mysqli_real_escape_string($conn, $_POST['u_Email']);
				$c_email = mysqli_real_escape_string($conn, $_POST['u_cEmail']);
				/* Basic checking */
				if(empty($c_email) || ctype_space($email) || ctype_space($c_email) || ctype_space($o_email)
					|| !filter_var($email, FILTER_VALIDATE_EMAIL) || !filter_var($c_email, FILTER_VALIDATE_EMAIL) || !filter_var($o_email, FILTER_VALIDATE_EMAIL)
					|| strlen($email)>40 || strlen($c_email)>40 || strlen($o_email)>40
					|| $email != $c_email){
					echo "Invalid Email";
				} else {
					/* Check if email taken */
					$sql = "SELECT * FROM user WHERE email = ?;";
					$stmt = mysqli_stmt_init($conn);
					if(!mysqli_stmt_prepare($stmt, $sql)) {
						echo "ERROR:1";
					} else {
						mysqli_stmt_bind_param($stmt, "s", $email);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_store_result($stmt);
						$resultCheck = mysqli_stmt_num_rows($stmt);
						if ($resultCheck > 0) {
							mysqli_stmt_close($stmt);
							echo "Email taken";
						} else {
							/* Check if entered current email matches db */
							$sql2 = "SELECT * FROM user WHERE User_ID = ?;";
							$stmt2 = mysqli_stmt_init($conn);
							if(!mysqli_stmt_prepare($stmt2, $sql2)) {
								echo "ERROR:2";
							} else {
								mysqli_stmt_bind_param($stmt2, "s", $user_ID);
								mysqli_stmt_execute($stmt2);
								$result = mysqli_stmt_get_result($stmt2);
								if ($row = mysqli_fetch_assoc($result)) {
									mysqli_stmt_close($stmt2);
									if($o_email != $row['Email']){
										echo "Invalid current Email";
									} else {
										/* Update function */
										$sql3 = "UPDATE user SET Email = ? WHERE User_ID = ?;";
										$stmt3 = mysqli_stmt_init($conn);
										if(!mysqli_stmt_prepare($stmt3, $sql3)) {
											echo "ERROR:3";
										} else {
											mysqli_stmt_bind_param($stmt3, "ss", $email, $user_ID);
											mysqli_stmt_execute($stmt3);
											mysqli_stmt_close($stmt3);
											$_SESSION['email'] = $email;
											echo 1;
										}
									}
								}
							}
						}
					}
				}
			}
	
			/* Change Password */
			if(isset($_POST['p_query']) && $_POST['p_query'] == "changePassword"){
				/* Password variables */
				$o_pass = mysqli_real_escape_string($conn, $_POST['u_oPass']);
				$pass = mysqli_real_escape_string($conn, $_POST['u_Pass']);
				$c_pass = mysqli_real_escape_string($conn, $_POST['u_cPass']);
				/* Basic checking */
				if(empty($c_pass) || ctype_space($pass) || ctype_space($c_pass) || ctype_space($o_pass)
					|| strlen($pass)>265 || strlen($c_pass)>265 || strlen($o_pass)>265 || strlen($pass)<8 || strlen($c_pass)<8 || strlen($o_pass)<8
					|| $pass != $c_pass || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/', $pass)){
					echo "Password does not meet requirement(s)";
				} else {
					/* Check if entered current password matches db */
					$sql4 = "SELECT * FROM user WHERE User_ID = ?;";
					$stmt4 = mysqli_stmt_init($conn);
					if(!mysqli_stmt_prepare($stmt4, $sql4)) {
						echo "ERROR:4";
					} else {
						mysqli_stmt_bind_param($stmt4, "s", $user_ID);
						mysqli_stmt_execute($stmt4);
						$result = mysqli_stmt_get_result($stmt4);
						if ($row = mysqli_fetch_assoc($result)) {
							$hashedPwdCheck = password_verify($o_pass, $row['Password']);
							mysqli_stmt_close($stmt4);
							if ($hashedPwdCheck == false) {
								echo "Invalid current Password";
							} else {
								/* Update function */
								$hashed_Pwd = password_hash($pass, PASSWORD_DEFAULT);
								$sql5 = "UPDATE user SET Password = ? WHERE User_ID = ?;";
								$stmt5 = mysqli_stmt_init($conn);
								if(!mysqli_stmt_prepare($stmt5, $sql5)) {
									echo "ERROR:5";
								} else {
									mysqli_stmt_bind_param($stmt5, "ss", $hashed_Pwd, $user_ID);
									mysqli_stmt_execute($stmt5);
									mysqli_stmt_close($stmt5);
									$_SESSION['password'] = $pass;
									echo 1;
								}
							}
						}
					}
				}
			}
			
			/* Change picture */
			if(isset($_POST['i_query']) && $_POST['i_query']){
				/* Image variables */
				$error = "";
				$currentImg = "";
				$img = "default.png";
				$imgName = $_FILES['u_Img']['name'];
				$imgTmp = $_FILES['u_Img']['tmp_name'];
				$imgSize = $_FILES['u_Img']['size'];
				$imgError = $_FILES['u_Img']['error'];
				$imgType = $_FILES['u_Img']['type'];
				$imgExt = explode ('.', $imgName);
				$imgActualExt = strtolower(end($imgExt));
				$allowed_img = array('jpg','jpeg','png');
				
				/* Getting current image */
				$sql6 = "SELECT * FROM user WHERE User_ID = ?;";
				$stmt6 = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt6, $sql6)) {
					echo "ERROR:6";
				} else {
					mysqli_stmt_bind_param($stmt6, "s", $user_ID);
					mysqli_stmt_execute($stmt6);
					$result = mysqli_stmt_get_result($stmt6);
					if ($row = mysqli_fetch_assoc($result)) {
						mysqli_stmt_close($stmt6);
						$currentImg = $row['User_Img'];
					}
				}
				
				/* Basic checking */
				if (!empty($imgName) && !isset($_POST['clearImg'])){
					if ($imgError != 0 || !in_array($imgActualExt, $allowed_img) || $imgSize > 1000000){
						$error = "Invalid image file";
					} else {
						if($currentImg != "default.png"){
							unlink("img/User/".$currentImg);
						}
						$img = $user_ID.".".$imgActualExt;
						move_uploaded_file($imgTmp, "../img/User/".$img);
					}
				} else {
					if(isset($_POST['clearImg']) && $currentImg != "default.png"){
						unlink("../img/User/".$currentImg);
						/* $img = "default.png"; */
					}
				}
				
				/* Update function */
				if (!empty($error)){
					echo $error;
				} else {
					$sql7 = "UPDATE user SET User_Img = ? WHERE User_ID = ?;";
					$stmt7 = mysqli_stmt_init($conn);
					if(!mysqli_stmt_prepare($stmt7, $sql7)) {
						echo "ERROR:7";
					} else {
						mysqli_stmt_bind_param($stmt7, "ss", $img, $user_ID);
						mysqli_stmt_execute($stmt7);
						mysqli_stmt_close($stmt7);
						$_SESSION['user_img'] = $img;
						echo 1;
					}
				}
			}
		}
	}
?>