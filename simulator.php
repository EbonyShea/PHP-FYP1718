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
	<link href="assets/dash.css" rel="stylesheet" type="text/css">
	<!-- Simulator -->
	<link rel="stylesheet" href="simulator/assets/components.css">
	<script type="text/javascript" src="simulator/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="simulator/libs/jquery.jsPlumb-1.7.6-min.js"></script>
	<script type="text/javascript" src="simulator/libs/jquery-ui.min.js"></script>
	<script type="text/javascript" src="simulator/simulator.js"></script>
</head>

<body>
<div class = "main-container">
	<div class = "container-fluid nav-items">
		<a href = "help.php"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
		<a href = "setting.php"><i class="fa fa-cog" aria-hidden="true"></i></a>
		<a href = "includes/logout.inc.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
	</div>
	
	<div id = "top-nav">
		<div class = "container-fluid">
			<a href = "dashboard.php" class = "nav-toggle">Dashboard</a>
		</div>
	</div>
	
	<section id = "sim-container">
		<div id = "controls" class="dropdown">
			<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Logic Gates
			<span class="caret"></span></button>
			<ul class="dropdown-menu dropdown-menu-right">
				<li><a onclick="new Components.And(80,80);">And (2-input)</a></li>
				<li><a onclick="new Components.AAnd(80,80);">And (3-input)</a></li>
				<li><a onclick="new Components.AAAnd(80,80);">And (4-input)</a></li>
				<li class="divider"></li>
				<li><a onclick="new Components.Nand(80,80);">Nand (2-input)</a></li>
				<li><a onclick="new Components.NNand(80,80);">Nand (3-input)</a></li>
				<li><a onclick="new Components.NNNand(80,80);">Nand (4-input)</a></li>
				<li class="divider"></li>
				<li><a onclick="new Components.Or(80,80);">Or (2-input)</a></li>
				<li><a onclick="new Components.OOr(80,80);">Or (3-input)</a></li>
				<li><a onclick="new Components.OOOr(80,80);">Or (4-input)</a></li>
				<li class="divider"></li>
				<li><a onclick="new Components.Nor(80,80);">Nor (2-input)</a></li>
				<li><a onclick="new Components.NNor(80,80);">Nor (3-input)</a></li>
				<li><a onclick="new Components.NNNor(80,80);">Nor (4-input)</a></li>
				<li class="divider"></li>
				<li><a onclick="new Components.Xor(80,80);">Xor (2-input)</a></li>
				<li><a onclick="new Components.XXor(80,80);">Xor (3-input)</a></li>
				<li><a onclick="new Components.XXXor(80,80);">Xor (4-input)</a></li>
				<li class="divider"></li>
				<li><a onclick="new Components.Xnor(80,80);">XNor (2-input)</a></li>
				<li><a onclick="new Components.XXnor(80,80);">XNor (3-input)</a></li>
				<li><a onclick="new Components.XXXnor(80,80);">XNor (4-input)</a></li>
				<li class="divider"></li>
				<li><a onclick="new Components.Not(80,80);">Not (Inverter)</a></li>
				<li><a onclick="new Components.Switch(80,80);">Switch</a></li>
				<li><a onclick="new Components.Light(80,80);">Light</a></li>
			</ul>
		</div>
		<a id = "clearBtn" class = "btn btn-primary" onclick='$("#screen").empty()'>Clear</a>
		<div id="screen"></div>
    </section>
	
	<section id = "mobile-warning">
		<i class="fa fa-microchip" aria-hidden="true"></i>
		</br>
		<p>Simulator is not yet available for mobile yet, sorry!</p>
	</section>
</div>
</body>
</html>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113639948-2"></script>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-113639948-2');
</script>