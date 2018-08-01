<?php

session_start();

if (isset($_POST['submit'])) {
	
	include_once 'dbh.inc.php';
	
	$username = mysqli_real_escape_string($conn, $_POST['logUsername']);
	$password = mysqli_real_escape_string($conn, $_POST['logPassword']);
	
	// ERROR HANDLERS
	/* if there's any empty fields */
	if (empty($username) || empty($password)) {
		header("Location: ../login.php?login=empty"); 
		exit();
	} else {
		//Check if username exists USING PREPARED STATEMENTS
		$sql = "SELECT * FROM user WHERE username = ?";
		//Create a prepared statement
		$stmt = mysqli_stmt_init($conn);
		//Check if prepared statement fails
		if(!mysqli_stmt_prepare($stmt, $sql)) {
		    header("Location: ../login.php?login=error");
		    exit();
		} else {
			//Bind parameters to the placeholder
			mysqli_stmt_bind_param($stmt, "s", $username);

			//Run query in database
			mysqli_stmt_execute($stmt);

			//Get results from query
        	$result = mysqli_stmt_get_result($stmt);

        	if ($row = mysqli_fetch_assoc($result)) {
				//De-hashing the password
				$hashedPwdCheck = password_verify($password, $row['Password']);
				if ($hashedPwdCheck == false) {
					header("Location: ../login.php?login=error");
					exit();
				} elseif ($hashedPwdCheck == true) {
					//Set SESSION variables and log user in
					$_SESSION['user_ID'] = $row['User_ID'];
					$_SESSION['first_name'] = $row['First_Name'];
					$_SESSION['last_name'] = $row['Last_Name'];
					$_SESSION['username'] = $row['Username'];
					$_SESSION['password'] = $row['Password'];
					$_SESSION['email'] = $row['Email'];
					$_SESSION['user_img'] = $row['User_Img'];
					$_SESSION['user_type'] = $row['User_Type'];
					$_SESSION['user_status'] = $row['User_Status'];
					header("Location: ../dashboard.php");
					exit();
				}
        	} else {
        		header("Location: ../index.php?login=error");
				exit();
        	}
		}
	}
	//Close statement
	mysqli_stmt_close($stmt);
} else {
	header("Location: ../login.php?login=error");
	exit();
}

?>