<?php
	session_start();
	if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 1 || $_SERVER['REQUEST_METHOD'] != 'POST') {
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
			$sql = "SELECT forum.*, user.username FROM forum, user 
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
				mysqli_stmt_bind_result($stmt, $f_ID, $f_Title, $f_Cont, $f_Comm, $f_Date, $f_userID, $f_username);
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) > 0){
					while(mysqli_stmt_fetch($stmt)){
						$date = date("j-m-Y", strtotime($f_Date));
						$f_Title = stripslashes($f_Title);
						$f_Cont = stripslashes($f_Cont);
						$type = "";
						$option = "";
						if ($f_Comm == 1){
							$type = "Comment Disabled";
							$option = '<li><a class = "btn disable_data" data-id="'.$f_ID.'">Disable Comment</a></li>';
						} else {
							$type = "Comment Enabled";
							$option = '<li><a class = "btn enable_data" data-id="'.$f_ID.'">Enable Comment</a></li>';
						}
						$output .= '<tr>
								<td><input type = "checkbox" class = "emp_checkbox" data-emp-id = "'.$f_ID.'"/></td>
								<td>'.$f_Title.'</td>
								<td>'.$f_Cont.'</td>
								<td>'.$date.'</td>
								<td><div class = "btn-group dropdown">
										<button type = "button" class="btn btn-info dropdown-toggle" data-toggle = "dropdown">
											<span class="glyphicon glyphicon-cog"/> <span class="caret"/>
										</button>
										<ul class="dropdown-menu dropdown-menu-right">
											'.$option.'
											<li><a class = "btn clear_data" data-id="'.$f_ID.'">Clear Comments</a></li>
											<li><a class = "btn delete_data" data-id="'.$f_ID.'">Delete</a></li>
											<li><a class = "btn edit_data" id = "'.$f_ID.'">Edit</a></li>
											<li><a class = "btn view_data" id="'.$f_ID.'">View</a></li>
										</ul>
									</div></td>
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