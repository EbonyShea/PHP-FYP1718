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
		if ($_POST['data_type'] == "announcement" && $_POST['query']){
			$keyword = "";
			$sql = "SELECT announcement.Ann_ID, announcement.Ann_Content, announcement.Ann_Date, user.Username 
			FROM announcement, user 
			WHERE announcement.Ann_Content like ? AND announcement.User_ID = user.User_ID ORDER BY announcement.Ann_Date DESC;";
			$keyword =  mysqli_real_escape_string($conn, $_POST['query']);
			$keyword = "%".$keyword."%";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				echo "ERROR";
			} else {
				mysqli_stmt_bind_param($stmt, "s", $keyword);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $ann_ID, $ann_Cont, $ann_Date, $username);
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) > 0){
					while(mysqli_stmt_fetch($stmt)){
						$date = date("j-m-Y", strtotime($ann_Date));
						$ann_Cont = stripslashes($ann_Cont);
						$output .= '<tr>
								<td><input type = "checkbox" class = "emp_checkbox" data-emp-id = "'.$ann_ID.'"/></td>
								<td>'.$username.'</td>
								<td>'.$ann_Cont.'</td>
								<td>'.$date.'</td>
								<td><div class = "btn-group dropdown">
										<button type = "button" class="btn btn-info dropdown-toggle" data-toggle = "dropdown">
											<span class="glyphicon glyphicon-cog"/> <span class="caret"/>
										</button>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a class = "btn delete_data" data-id="'.$ann_ID.'">Delete</a></li>
											<li><a class = "btn edit_data" id = "'.$ann_ID.'">Edit</a></li>
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