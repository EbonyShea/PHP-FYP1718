<!DOCTYPE HTML>
<?php
	session_start();	
	if(!isset($_SESSION['username'])){
		header("Location: index.php");
		exit();
	}
?>
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
	<link href="assets/dash.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class = "main-container">
	<div class = "container-fluid nav-items">
		<a href = "help.php"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
		<a href = "setting.php"><i class="fa fa-cog" aria-hidden="true"></i></a>
		<a href = "includes/logout.inc.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
	</div>
	<div id = "top-nav">
		<div class = "container-fluid sideToggleHide">
			<button class = "nav-toggle" id="sidenavToggle" aria-expanded="false">
				<i class="fa fa-bars" aria-hidden="true"></i>
			</button>
		</div>
		<nav class = "navbar navbar-inverse">
			<div class = "container-fluid">
				<button class = "nav-toggle" data-toggle = "collapse" data-target="#topNavbar" aria-expanded="false">
					<i class="fa fa-bars" aria-hidden="true"></i>
				</button>
			</div>
			<div id = "topNavbar" class = "collapse navbar-collapse">
				<ul class = "nav navbar-nav">
					<li><a href = "dashboard.php"><i class="fa fa-tachometer"></i>Dashboard</a></li>
					<li><a href = "forum.php"><i class="fa fa-users"></i>Forum</a></li>
					<li class = "dropdown">
						<a class = "dropdown-toggle" data-toggle = "dropdown" href = ""><i class="fa fa-tasks" aria-hidden="true"></i>Learning Tools<span class = "caret"></span></a>
						<ul class = "dropdown-menu">
							<li><a href = "lesson.php"><i class="fa fa-book" aria-hidden="true"></i>Lesson</a></li>
							<li><a href = "video.php"><i class="fa fa-youtube-play" aria-hidden="true"></i>Video</a></li>
							<li><a href = "flashcard.php"><i class="fa fa-files-o" aria-hidden="true"></i>Flashcard</a></li>
							<li><a href = "quiz.php"><i class="fa fa-puzzle-piece" aria-hidden="true"></i>Quiz</a></li>
							<li><a href = "misc.php"><i class="fa fa-archive" aria-hidden="true"></i>Misc</a></li>
							<li><a href = "simulator.php"><i class="fa fa-microchip" aria-hidden="true"></i>Simulator</a></li>
						</ul>
					</li>
					<?php if ($_SESSION['user_type'] == 1) { ?>
					<li class = "dropdown">
						<a class = "dropdown-toggle" data-toggle = "dropdown" href = ""><i class="fa fa-wrench" aria-hidden="true"></i>Management<span class = "caret"></span></a>
						<ul class = "dropdown-menu">
							<li><a href = "mvideo.php"><i class="fa fa-youtube-play" aria-hidden="true"></i>Manage Video</a></li>
							<li><a href = "mflashcard.php"><i class="fa fa-files-o" aria-hidden="true"></i>Manage Flashcard</a></li>
							<li><a href = "mquiz.php"><i class="fa fa-puzzle-piece" aria-hidden="true"></i>Manage Quiz</a></li>
							<li><a href = "mmisc.php"><i class="fa fa-archive" aria-hidden="true"></i>Manage Misc</a></li>
							<li><a href = "mforum.php"><i class="fa fa-users"></i>Manage Forum</a></li>
							<li><a href = "mcomment.php"><i class="fa fa-list-alt" aria-hidden="true"></i>Manage Comment</a></li>
							<li><a href = "muser.php"><i class="fa fa-address-card-o" aria-hidden="true"></i>Manage User</a></li>
							<li><a href = "mann.php"><i class="fa fa-bullhorn" aria-hidden="true"></i>Manage Announcement</a></li>
						</ul>
					</li>
					<?php } ?>
				</ul>
			</div>
		</nav>
	</div>

	<div id = "side-nav">
		<ul class = "components">
			<li><a href = "dashboard.php"><i class="fa fa-tachometer"></i>Dashboard</a></li>
			<li><a href = "forum.php"><i class="fa fa-users"></i>Forum</a></li>
			<li>
				<a href="#toolSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fa fa-tasks" aria-hidden="true"></i>Learning Tools<span class = "caret"></span></a>
				<ul class="collapse" id="toolSubmenu">
					<li><a href = "lesson.php"><i class="fa fa-book" aria-hidden="true"></i>Lesson</a></li>
					<li><a href = "video.php"><i class="fa fa-youtube-play" aria-hidden="true"></i>Video</a></li>
					<li><a href = "flashcard.php"><i class="fa fa-files-o" aria-hidden="true"></i>Flashcard</a></li>
					<li><a href = "quiz.php"><i class="fa fa-puzzle-piece" aria-hidden="true"></i>Quiz</a></li>
					<li><a href = "misc.php"><i class="fa fa-archive" aria-hidden="true"></i>Misc</a></li>
					<li><a href = "simulator.php"><i class="fa fa-microchip" aria-hidden="true"></i>Simulator</a></li>					
				</ul>
			</li>
			<?php if ($_SESSION['user_type'] == 1) { ?>
			<li>
				<a href="#manageSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fa fa-wrench" aria-hidden="true"></i>Management<span class = "caret"></span></a>
				<ul class="collapse" id="manageSubmenu">
					<li><a href = "mvideo.php"><i class="fa fa-youtube-play" aria-hidden="true"></i>Manage Video</a></li>
					<li><a href = "mflashcard.php"><i class="fa fa-files-o" aria-hidden="true"></i>Manage Flashcard</a></li>
					<li><a href = "mquiz.php"><i class="fa fa-puzzle-piece" aria-hidden="true"></i>Manage Quiz</a></li>
					<li><a href = "mmisc.php"><i class="fa fa-archive" aria-hidden="true"></i>Manage Misc</a></li>
					<li><a href = "mforum.php"><i class="fa fa-users"></i>Manage Forum</a></li>
					<li><a href = "mcomment.php"><i class="fa fa-list-alt" aria-hidden="true"></i>Manage Comment</a></li>
					<li><a href = "muser.php"><i class="fa fa-address-card-o" aria-hidden="true"></i>Manage User</a></li>
					<li><a href = "mann.php"><i class="fa fa-bullhorn" aria-hidden="true"></i>Manage Announcement</a></li>
				</ul>
			</li>
			<?php } ?>
		</ul>
	</div>

<script>
$(document).ready(function () {
	$('#sidenavToggle').on('click', function () {
		$('#side-nav').toggleClass('active');
		$('#parent-container').toggleClass('active');
		$('.collapse.in').toggleClass('in');
		$('a[aria-expanded=true]').attr('aria-expanded', 'false');
	});

	$('#side-nav').on("shown.bs.collapse", ".collapse", function() {
		$('#side-nav').find(".collapse").not(this).collapse("hide");
	});
});
</script>

