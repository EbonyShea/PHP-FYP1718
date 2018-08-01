<?php
	session_start();
	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		echo "ERROR:1";
	} else {
		include_once 'dbh.inc.php';
		$username = mysqli_real_escape_string($conn, $_POST['logUsername']);
		$password = mysqli_real_escape_string($conn, $_POST['logPassword']);
		if (empty($username) || empty($password) || ctype_space($username) || ctype_space($password)) {
			echo "Invalid Username/Password";
		} else {
			$sql = "SELECT * FROM user WHERE username = ?;";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				echo "ERROR:2";
			} else {
				mysqli_stmt_bind_param($stmt, "s", $username);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				if ($row = mysqli_fetch_assoc($result)) {
					$hashedPwdCheck = password_verify($password, $row['Password']);
					mysqli_stmt_close($stmt);
					if ($hashedPwdCheck == false) {
						echo "Invalid Username/Password";
					} else {
						if($row['User_Status'] == 0){
							echo "Your account is blocked";
						} else {
							$_SESSION['user_ID'] = $row['User_ID'];
							$_SESSION['first_name'] = $row['First_Name'];
							$_SESSION['last_name'] = $row['Last_Name'];
							$_SESSION['username'] = $row['Username'];
							$_SESSION['password'] = $row['Password'];
							$_SESSION['email'] = $row['Email'];
							$_SESSION['user_img'] = $row['User_Img'];
							$_SESSION['user_type'] = $row['User_Type'];
							$_SESSION['user_status'] = $row['User_Status'];
							echo 1;
						}
					}
				} else {
					echo "Invalid Username/Password";
				}
			}
		}
	}

?>