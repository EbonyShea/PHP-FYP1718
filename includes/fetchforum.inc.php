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
		if ($_POST['data_type'] == "forum" && $_POST['query']){
			$keyword = "";
			$sql = "SELECT forum.*, user.username, user.user_img, user.User_Type FROM forum, user 
			WHERE (Forum_Title like ? OR Forum_Content like ?) AND forum.User_ID = user.User_ID 
			ORDER BY Forum_Date DESC;";
			$keyword =  mysqli_real_escape_string($conn, $_POST['query']);
			$keyword = "%".$keyword."%";			
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				echo "ERROR";
			} else {
				mysqli_stmt_bind_param($stmt, "ss", $keyword, $keyword);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $f_ID, $f_Title, $f_Cont, $f_Comm, $f_Date, $f_userID, $f_username, $f_userImg, $f_userType);
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) > 0){
					while(mysqli_stmt_fetch($stmt)){
						$date = date("j-m-Y", strtotime($f_Date));
						$sql2 = "SELECT COUNT(*) AS CommentCounter FROM COMMENT WHERE Content_ID = '".$f_ID."' LIMIT 1;";
						$result = mysqli_query($conn, $sql2);
						$row = mysqli_fetch_array($result);
						$f_Title = stripslashes($f_Title);
						$f_Cont = stripslashes($f_Cont);
						$status = "";
						if ($f_Comm == 0){
							$status = '(Disabled)';
						}
						$comment = '<p>'.$row['CommentCounter'].'</p><p> Comment</p><p>'.$status.'</p>';
						if ($row['CommentCounter'] > 1){
							$comment = '<p>'.$row['CommentCounter'].'</p><p> Comments</p><p>'.$status.'</p>';
						}
						$output .= '<div class = "topic">
										<div class = "userinfo">
											<img src = "img/user/'.$f_userImg.'"/>
											<h4>'.$f_username.'</h4>
										</div>
										<div class = "postinfo">
											<div class = "comments">
												<i class="fa fa-comment"></i>
												'.$comment.'
											</div>
											<div class = "date">
												<i class="fa fa-calendar"></i>
												<p>'.$date.'</p>
											</div>
										</div>
										<div class = "posttext">
											<h2><a href = "vforum.php?id='.$f_ID.'">'.$f_Title.'</a></h2>
											<p>'.$f_Cont.'</p>
										</div>
									</div>';
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