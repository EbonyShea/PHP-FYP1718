<?php
session_start();
if (isset($_SESSION['username']) && $_GET['dl'] && $_GET['type']){
	include_once 'dbh.inc.php';
	$filename = mysqli_real_escape_string($conn, $_GET['dl']);
	$filetype = mysqli_real_escape_string($conn, $_GET['type']);
	$file = "../dl/".$filetype."/".$filename;
	if (file_exists($file)){
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($file).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		exit;
	} else {
		header("Location: ../dashboard.php");
		exit();
	}
} else {
	header("Location:../dashboard.php");
	exit();
}
?>
