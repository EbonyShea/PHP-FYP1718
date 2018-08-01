<?php
	include_once 'includes/header.php';
?>

<section class = "main-container">
	<div class = "main-wrapper">
		<div class = "form-wrapper">
			<h1>LOGIN</h1>
			<hr>
			<form id = "login_form" action ="" method="POST">
				<label>Username</label>
					<input type = "text" class = "form-control" id = "logUsername" name ="logUsername" placeholder = "Username" autofocus>
				</br>
				<label>Password</label>
					<input type = "password" class = "form-control" id = "logPassword" name ="logPassword" placeholder = "Password">
				</br>
				<button class = "btn btn-info" type = "submit" id = "insert_login" name = "submit">Login</button>
			</form>
		</div>
	</div>
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
  
$(document).ready(function(){	
 	$('#login_form').on('submit', function(event){
		event.preventDefault();
		if ($('#logUsername').val() == ""){
			alert ("Username is required");
		} else if ($('#logPassword').val() == ""){
			alert ("Password is required");
		} else {
			$.ajax({
				type: "POST",
				url: "includes/login2.inc.php",
				data: $('#login_form').serialize(),
				success: function(data){
					if(data == 1){
						$('#login_form')[0].reset();
						alert("Login Successful, redirecting to dashboard.");
						window.location.href = "dashboard.php";
					} else {
						alert(data);
					}
				}
			});
		}
	});
});
</script>