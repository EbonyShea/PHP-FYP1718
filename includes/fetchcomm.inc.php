<?php
	session_start();
	if (!isset($_SESSION['username']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
		if ($_SERVER['REQUEST_METHOD'] === 'POST'){
			echo "Access denied";
		} else {
			header("Location: ../dashboard.php");
			exit();
		}
	} else {
		include_once 'dbh.inc.php';
		$output = '';
		if (isset($_POST['forum_ID'])){
			$sql = "SELECT comment.*, user.username, user.user_img, user.User_Type 
					FROM comment, user
					WHERE comment.User_ID = user.User_ID AND comment.Content_ID = ?
					ORDER BY Comment_Date ASC;";
			$f_ID =  mysqli_real_escape_string($conn, $_POST['forum_ID']);	
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				echo "ERROR";
			} else {
				mysqli_stmt_bind_param($stmt, "s", $f_ID);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $c_ID, $c_Cont, $c_Date, $c_Content, $u_ID, $username, $u_Img, $u_Type);
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) > 0){
					while(mysqli_stmt_fetch($stmt)){
						$date = date("j-m-Y", strtotime($c_Date));
						$c_Cont = stripslashes($c_Cont);
						$output .= '<div class = "comm">
										<div class = "userinfo">
											<img src = "img/user/'.$u_Img.'"/>
											<h4>'.$username.'</h4>
										</div>
										<div class = "commText">
											<h4>Commented on '.$date.'</h4>
											<p>'.$c_Cont.'</p>
										</div>
									</div>
									<hr>';
					}
				} else {
					$output .= "<div class = 'nothing'>~ There's nothing here ~</div>";
				}
			}
			mysqli_stmt_close($stmt);
			echo $output;
		} else {
			echo "This is not the function you are looking for";
		}
	}
?>