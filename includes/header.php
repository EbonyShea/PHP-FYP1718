<?php
	session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
	<!-- Default -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Logic Circuit E-learning Portal</title>
	
	<!-- jQuery CDN -->
	<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Js -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Font Awesome CSS -->
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<!-- Custom stylesheet-->
	<link href="assets/main.css" rel="stylesheet" type="text/css">
</head>

<body>
<header>
	<div class = "wrapper">
		<div class = "nav-login container">
			<a class = "logo desktopView" href = "index.php"><img src = "img/logo.png" alt="Homepage"/></a>
			<a class = "logo mobileView" href = "index.php"><img src = "img/smallLogo.png" alt="Homepage"/></a>
			<?php if (isset($_SESSION['username'])) { ?>
				<a href = "includes/logout.inc.php">Logout</a>
				<a href = "dashboard.php">Dashboard</a>
			<?php } else if (!isset($_SESSION['username'])){ ?>
				<a href = "register.php">Register</a>
				<a href = "login.php">Login</a>
			<?php } ?>
		</div>
	</div>
</header>