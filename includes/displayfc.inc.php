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
		if ($_POST['data_type'] == "flashcard" && $_POST['query']){
			$keyword = "";
			$sql = "SELECT * FROM flashcard WHERE fc_Title like ? OR fc_Desc like ? ORDER BY fc_Date DESC;";
			$keyword =  mysqli_real_escape_string($conn, $_POST['query']);
			$keyword = "%".$keyword."%";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				echo "ERROR";
			} else {
				mysqli_stmt_bind_param($stmt, "ss", $keyword, $keyword);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $fc_ID, $fc_Title, $fc_Desc, $fc_Img, $fc_URL, $fc_DL, $fc_File, $fc_Date, $u_ID);
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) > 0){
					while(mysqli_stmt_fetch($stmt)){
						$date = date("j-m-Y", strtotime($fc_Date));
						$fc_Title = stripslashes($fc_Title);
						$fc_Desc = stripslashes($fc_Desc);
						$output .= '<div class = "item col-2 col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
										<div class = "item-box">
											<div class = "img-box">';
						if ($fc_Img != null){
							$output .= 		'<img class = "fc-color" src = "img/flashcard/'.$fc_Img.'"/>';
						} else {
							
							$output .= 		'<img class = "fc-color" src = "img/flashcard/noimage.png"/>';
						}
						$output .= 			'<div class = "date">'.$date.'</div>
										</div>
										<div class = "item-content">
											<h2>'.$fc_Title.'</h2>
											<span>'.$fc_Desc.'</span>
										</div>
										<div class = "item-foot">';
						if ($fc_DL != null){
							$output .= 		'<span><a href ="'.$fc_DL.'" target="_blank"><i class="fa fa-google" aria-hidden="true"></i></a></span>';
						}
						if ($fc_File != null){
							$output .= 		'<span><a href ="includes/download.inc.php?type=Flashcard&dl='.$fc_File.'"><i class="fa fa-download" aria-hidden="true"></i></a></span>';
						}
						$output .= 			'<span><a href = "'.$fc_URL.'" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i></a></span>
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