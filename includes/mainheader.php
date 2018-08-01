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
				<div class = "desktopView row">
					<button class = "btn btn-default register" data-toggle="modal" data-target="#register_dataModal">Register</button>
					<form id = "login_form" action ="" method="POST">						
						<div class = "input-group pull-right col-lg-4 col-md-4 col-sm-5 col-xs-6">
							<span class = "input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
							<input type = "text" class = "form-control" id = "logUsername" name ="logUsername" placeholder = "Username" autofocus>
							<span class = "input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
							<input type = "password" class = "form-control" id = "logPassword" name ="logPassword" placeholder = "Password">
							<div class = "input-group-btn">
								<button class = "btn btn-default" type = "submit" id = "insert_login" name = "submit">Login</button>
							</div>
						</div>
					</form>
				</div>
				<div class = "mobileView">
					<a href = "register.php">Register</a>
					<a href = "login.php">Login</a>
				</div>
			<?php } ?>
		</div>
	</div>
</header>