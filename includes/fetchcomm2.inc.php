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
		if ($_POST['data_type'] == "comment" && $_POST['query']){
			$keyword = "";
			$sql = "SELECT comment.*, forum.Forum_Title, user.Username 
					FROM 
					comment, forum, user
					WHERE
					(Comment_Content like ?) AND
					(comment.User_ID = user.User_ID OR comment.User_ID is NULL) AND 
					(forum.Forum_ID = comment.Content_ID)
					ORDER BY Comment_Date DESC;";
			$keyword =  mysqli_real_escape_string($conn, $_POST['query']);
			$keyword = "%".$keyword."%";			
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				echo "ERROR";
			} else {
				mysqli_stmt_bind_param($stmt, "s", $keyword);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $c_ID, $c_Cont, $c_Date, $f_ID, $c_userID, $f_Topic, $c_username);
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) > 0){
					while(mysqli_stmt_fetch($stmt)){
						$date = date("j-m-Y", strtotime($c_Date));
						$f_Topic = stripslashes($f_Topic);
						$c_Cont = stripslashes($c_Cont);
						$output .= '<tr>
								<td><input type = "checkbox" class = "emp_checkbox" data-emp-id = "'.$c_ID.'"/></td>
								<td>'.$f_Topic.'</td>
								<td>'.$c_Cont.'</td>
								<td>'.$date.'</td>
								<td><div class = "btn-group dropdown">
										<button type = "button" class="btn btn-info dropdown-toggle" data-toggle = "dropdown">
											<span class="glyphicon glyphicon-cog"/> <span class="caret"/>
										</button>
										<ul class="dropdown-menu dropdown-menu-right">										
											<li><a class = "btn delete_data" data-id="'.$c_ID.'">Delete</a></li>
											<li><a class = "btn edit_data" id = "'.$c_ID.'">Edit</a></li>
											<li><a class = "btn view_data" id="'.$c_ID.'">View</a></li>
										</ul>
									</div>
								</td>
							</tr>';
						
					}
				} else {
					$output .= '<td colspan = "5" style = "text-align: center; background-color: #fff;">No data found</td>';
				}
			}
			mysqli_stmt_close($stmt);
			echo $output;
		} else {
			echo "This is not the function you are looking for";
		}
	}
?>