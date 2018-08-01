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
		if (empty($_POST) || !isset($_POST['username']) || !isset($_POST['password'])) {
			echo "This is not the function you are looking for";
		} else {
			include_once 'dbh.inc.php';
			$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
			$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
			$username = mysqli_real_escape_string($conn, $_POST['username']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$type = mysqli_real_escape_string($conn, $_POST['type']);
			$status = mysqli_real_escape_string($conn, $_POST['status']);
			
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
			
			// ERROR HANDLERS	
			if (empty($first_name) || empty($last_name) || empty($username) || empty($password) || empty($email) 
				|| ctype_space($first_name) || ctype_space($last_name) || ctype_space($username) || ctype_space($password) || ctype_space($email)) {
				echo "Please enter required information";
			} else {
				if(!preg_match("/^[a-zA-Z\s]*$/", $first_name) || !preg_match("/^[a-zA-Z\s]*$/", $last_name) || strlen($first_name)>35 || strlen($last_name)>35){
					echo "Please enter valid name";
				} else {
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
						echo "Please enter valid email";
					} else {
						$sql = "SELECT * FROM user WHERE username = ?";
						$stmt = mysqli_stmt_init($conn);
						if(!mysqli_stmt_prepare($stmt, $sql)) {
							echo "ERROR";
						} else {
							mysqli_stmt_bind_param($stmt, "s", $username);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_store_result($stmt);
							$resultCheck = mysqli_stmt_num_rows($stmt);
							if ($resultCheck > 0) {
								echo "Username taken";
								mysqli_stmt_close($stmt);
							} else {
								if (strlen($username) < 3 || strlen($username) > 50 || !preg_match('/^[\w.-]*$/', $username)){
									echo "Invalid Username";
								} else {
									if (strlen($password) > 265 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/', $password)){
										echo "Password does not meet requirement(s)";
									} else {
										$sql = "SELECT * FROM user WHERE email = ?";
										$stmt2 = mysqli_stmt_init($conn);
										if(!mysqli_stmt_prepare($stmt2, $sql)) {
											echo "ERROR";
										} else {
											mysqli_stmt_bind_param($stmt2, "s", $email);
											mysqli_stmt_execute($stmt2);
											mysqli_stmt_store_result($stmt2);
											$resultCheck = mysqli_stmt_num_rows($stmt2);
											if ($resultCheck > 0) {
												echo "Email taken";
												mysqli_stmt_close($stmt2);
											} else {
												/* ID */
												$sql = "SELECT Counter FROM content_ctr WHERE Content_Type = 'User' LIMIT 1;";
												$result = mysqli_query($conn, $sql);
												$row = $result->fetch_assoc();
												$num = $row['Counter'];
												$iterate = $num + 1;
												$increment = sprintf("%09d",$iterate);							
												$user_ID = 'U'.$increment;
												
												/* Image */
												$error = "";
												$imgName = $_FILES['user_img']['name'];
												$imgTmp = $_FILES['user_img']['tmp_name'];
												$imgSize = $_FILES['user_img']['size'];
												$imgError = $_FILES['user_img']['error'];
												$imgType = $_FILES['user_img']['type'];
												$imgExt = explode ('.', $imgName);
												$imgActualExt = strtolower(end($imgExt));
												$allowed_img = array('jpg','jpeg','png');
												
												$img = "default.png";
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
													$hashed_Pwd = password_hash($password, PASSWORD_DEFAULT);
													mysqli_query($conn, "UPDATE content_ctr SET Counter = '$iterate' WHERE Content_Type = 'User';");
													$sql = "INSERT INTO user (User_ID, First_Name, Last_Name, Username, Password, Email, User_Img, User_Type, User_Status) VALUES (?,?,?,?,?,?,?,?,?);";
													$stmt3 = mysqli_stmt_init($conn);
													if(!mysqli_stmt_prepare($stmt3, $sql)) {
														echo "ERROR:2";
													} else {
														mysqli_stmt_bind_param($stmt3, "sssssssss", $user_ID, $first_name, $last_name, $username, $hashed_Pwd, $email, $img, $type, $status);
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
				}
			}
		}
	}
?>