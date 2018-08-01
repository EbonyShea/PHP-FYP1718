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
		if ($_POST['data_type'] == "video" && $_POST['query']){
			$keyword = "";
			$sql = "SELECT * FROM video WHERE Video_Title like ? OR Video_Desc like ? ORDER BY Video_Date DESC;";
			$keyword =  mysqli_real_escape_string($conn, $_POST['query']);
			$keyword = "%".$keyword."%";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				echo "ERROR";
			} else {
				mysqli_stmt_bind_param($stmt, "ss", $keyword, $keyword);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $v_ID, $v_Title, $v_Desc, $v_Img, $v_DL, $v_File, $v_URL, $v_Date, $u_ID);
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) > 0){
					while(mysqli_stmt_fetch($stmt)){
						$date = date("j-m-Y", strtotime($v_Date));
						$v_Title = stripslashes($v_Title);
						$v_Desc = stripslashes($v_Desc);
						$output .= '<div class = "item col-2 col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
										<div class = "item-box">
											<div class = "img-box">';
						if ($v_Img != null){
							$output .= 		'<img class = "video-color" src = "img/video/'.$v_Img.'"/>';
						} else {
							
							$output .= 		'<img class = "video-color" src = "img/video/noimage.png"/>';
						}
						$output .= 			'<div class = "date">'.$date.'</div>
										</div>
										<div class = "item-content">
											<h2><a href = "vvideo.php?id='.$v_ID.'">'.$v_Title.' <i class="fa fa-arrow-circle-o-right"></i></a></h2>
											<span>'.$v_Desc.'</span>
										</div>
										<div class = "item-foot">';
						if ($v_DL != null){
							$output .= 		'<span><a href ="'.$v_DL.'" target="_blank"><i class="fa fa-google" aria-hidden="true"></i></a></span>';
						}
						if ($v_File != null){
							$output .= 		'<span><a href ="includes/download.inc.php?type=Video&dl='.$v_File.'"><i class="fa fa-download" aria-hidden="true"></i></a></span>';
						}
						$output .= 			'<span><a href = "'.$v_URL.'" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i></a></span>
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