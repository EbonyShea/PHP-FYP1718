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
		if ($_POST['data_type'] == "user" && $_POST['query']){
			$keyword = "";
			$sql = "SELECT * FROM user WHERE (Username like ? OR Email like ? OR First_Name like ? OR Last_Name like ?) AND Username != ? ORDER BY User_CreatedDate DESC;";
			$currentUser = $_SESSION['username'];
			$keyword =  mysqli_real_escape_string($conn, $_POST['query']);
			$keyword = "%".$keyword."%";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				echo "ERROR";
			} else {
				mysqli_stmt_bind_param($stmt, "sssss", $keyword, $keyword, $keyword, $keyword, $currentUser);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $User_ID, $First_Name, $Last_Name, $Username, $Password, $Email, $User_Img, $User_Type, $User_Status, $User_CreatedDate);
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) > 0){
					while(mysqli_stmt_fetch($stmt)){
						$date = date("j-m-Y", strtotime($User_CreatedDate));
						$Username = stripslashes($Username);
						$type = "";
						$option = "";
						if ($User_Type == 1){
							$type = "Admin";
							$option = '<li><a class = "btn default_data" data-id="'.$User_ID.'">Revert Default</a></li>';
						} else {
							$type = "Normal";
							$option = '<li><a class = "btn admin_data" data-id="'.$User_ID.'">Make Admin</a></li>';
						}
						$output .= '<tr>
								<td><input type = "checkbox" class = "emp_checkbox" data-emp-id = "'.$User_ID.'"/></td>
								<td>'.$Username.'</td>
								<td>'.$type.'</td>
								<td>'.$date.'</td>';
						/* Super admin untouchable */
						if($Username == 'Admin'){
							$output .= 
								'<td><div class = "btn-group dropdown">
										<button type = "button" class="btn">
											<span class="glyphicon glyphicon-lock"></span> <span class="caret"/>
										</button>
									</div>
								</td>';
						/* Other users */
						} else {
							$output .= 
								'<td><div class = "btn-group dropdown">
										<button type = "button" class="btn btn-info dropdown-toggle" data-toggle = "dropdown">
											<span class="glyphicon glyphicon-cog"/> <span class="caret"/>
										</button>
										<ul class="dropdown-menu dropdown-menu-right">
											'.$option.'
											<li><a class = "btn delete_data" data-id="'.$User_ID.'">Delete</a></li>
											<li><a class = "btn edit_data" id = "'.$User_ID.'">Edit</a></li>
											<li><a class = "btn view_data" id="'.$User_ID.'">View</a></li>
										</ul>
									</div>
								</td>';
						}
						$output .= '</tr>';
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