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
		if ($_POST['data_type'] == "misc" && $_POST['query']){
			$keyword = "";
			$sql = "SELECT * FROM misc WHERE Misc_Title like ? OR Misc_Desc like ? ORDER BY Misc_Date DESC;";
			$keyword =  mysqli_real_escape_string($conn, $_POST['query']);
			$keyword = "%".$keyword."%";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				echo "ERROR";
			} else {
				mysqli_stmt_bind_param($stmt, "ss", $keyword, $keyword);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $m_ID, $m_Title, $m_Desc, $m_Img, $m_URL, $m_DL, $m_File, $m_Date, $u_ID);
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) > 0){
					while(mysqli_stmt_fetch($stmt)){
						$date = date("j-m-Y", strtotime($m_Date));
						$m_Title = stripslashes($m_Title);
						$m_Desc = stripslashes($m_Desc);
						$output .= '<div class = "item col-2 col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
										<div class = "item-box">
											<div class = "img-box">';
						if ($m_Img != null){
							$output .= 		'<img class = "misc-color" src = "img/misc/'.$m_Img.'"/>';
						} else {
							
							$output .= 		'<img class = "misc-color" src = "img/misc/noimage.png"/>';
						}
						$output .= 			'<div class = "date">'.$date.'</div>
										</div>
										<div class = "item-content">
											<h2>'.$m_Title.'</h2>
											<span>'.$m_Desc.'</span>
										</div>
										<div class = "item-foot">';
						if ($m_DL != null){
							$output .= 		'<span><a href ="'.$m_DL.'" target="_blank"><i class="fa fa-google" aria-hidden="true"></i></a></span>';
						}
						if ($m_File != null){
							$output .= 		'<span><a href ="includes/download.inc.php?type=Misc&dl='.$m_File.'"><i class="fa fa-download" aria-hidden="true"></i></a></span>';
						}
						if ($m_URL != null){
							$output .= '<span><a href = "'.$m_URL.'" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i></a></span>';
						}
						$output .= 		'</div>
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