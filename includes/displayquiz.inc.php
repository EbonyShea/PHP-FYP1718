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
		if ($_POST['data_type'] == "quiz" && $_POST['query']){
			$keyword = "";
			$sql = "SELECT * FROM quiz WHERE Quiz_Title like ? OR Quiz_Desc like ? ORDER BY Quiz_Date DESC;";
			$keyword =  mysqli_real_escape_string($conn, $_POST['query']);
			$keyword = "%".$keyword."%";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				echo "ERROR";
			} else {
				mysqli_stmt_bind_param($stmt, "ss", $keyword, $keyword);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $q_ID, $q_Title, $q_Desc, $q_URL, $q_File, $q_Img, $q_DL, $q_Date, $u_ID);
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) > 0){
					while(mysqli_stmt_fetch($stmt)){
						$date = date("j-m-Y", strtotime($q_Date));
						$q_Title = stripslashes($q_Title);
						$q_Desc = stripslashes($q_Desc);
						$output .= '<div class = "item col-2 col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
										<div class = "item-box">
											<div class = "img-box">';
						if ($q_Img != null){
							$output .= 		'<img class = "quiz-color" src = "img/quiz/'.$q_Img.'"/>';
						} else {
							
							$output .= 		'<img class = "quiz-color" src = "img/quiz/noimage.png"/>';
						}
						$output .= 			'<div class = "date">'.$date.'</div>
										</div>
										<div class = "item-content">
											<h2>'.$q_Title.'</h2>
											<span>'.$q_Desc.'</span>
										</div>
										<div class = "item-foot">';
						if ($q_DL != null){
							$output .= 		'<span><a href ="'.$q_DL.'" target="_blank"><i class="fa fa-google" aria-hidden="true"></i></a></span>';
						}
						if ($q_File != null){
							$output .= 		'<span><a href ="includes/download.inc.php?type=Quiz&dl='.$q_File.'"><i class="fa fa-download" aria-hidden="true"></i></a></span>';
						}
						$output .= 			'<span><a href = "'.$q_URL.'" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i></a></span>
										</div>
									</div>
								</div>';
												
					}
				}
			}
			mysqli_stmt_close($stmt);
			echo $output;
		} else {
			echo "This is not the function you are looking for";
		}
	}
?>