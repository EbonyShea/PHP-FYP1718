<?php
	include_once 'includes/header.php';
?>

<section class = "main-container">
	<div class = "main-wrapper">
		<div class = "form-wrapper">
			<h1>REGISTER</h1>
			<hr>
			<form method="post" id="register_form">
				<label>First Name<i class = "fa fa-asterisk"></i></label>
					<div class="input-group">
						<input type = "text" maxlength = "35" class="form-control" id = "first_name" name = "first_name"></input>
						<span id = "charcount_fn" class = "hint"></span>
						<span data-toggle="tooltip" data-placement="top" title="Maximum 35 characters, only alphabets allowed" class="input-group-addon">
						<span class="glyphicon glyphicon-info-sign"></span>
					</div>
				</br>
				<label>Last Name<i class = "fa fa-asterisk"></i></label>
					<div class="input-group">
						<input type = "text" maxlength = "35" class="form-control" id = "last_name" name = "last_name"></input>
						<span id = "charcount_ln" class = "hint"></span>
						<span data-toggle="tooltip" data-placement="top" title="Maximum 35 characters, only alphabets allowed" class="input-group-addon">
						<span class="glyphicon glyphicon-info-sign"></span>
					</div>
				</br>
				<label>Username<i class = "fa fa-asterisk"></i></label>
					<div class="input-group">
						<input type = "text" pattern = ".{3,}" maxlength = "50" class="form-control" id = "username" name = "username"></input>
						<span id = "charcount_u" class = "hint"></span>
						<span data-toggle="tooltip" data-placement="top" title="Minimum 3 characters, maximum 50 characters" class="input-group-addon">
						<span class="glyphicon glyphicon-info-sign"></span>
					</div>							
				</br>
				<label>Email<i class = "fa fa-asterisk"></i></label>
					<input type = "email" maxlength = "40" class="form-control" id = "email" name = "email"></input>
				</br>
				<label>Password<i class = "fa fa-asterisk"></i></label>
					<div class="input-group">
						<input type = "password" pattern = ".{8,}" maxlength = "265" class="form-control" id = "password" name = "password"></input>
						<span data-toggle="tooltip" data-placement="top" title="Password must contain at least 8 characters, including UPPER/lowercase, special character(s) and number(s)" class="input-group-addon">
						<span class="glyphicon glyphicon-info-sign"></span>
						</span>
					</div>
				</br>
				<label>Confirm Password<i class = "fa fa-asterisk"></i></label>
					<div class="input-group">
						<input type = "password" pattern = ".{8,}" maxlength = "265" class="form-control" id = "cpassword" name = "cpassword"></input>
						<span data-toggle="tooltip" data-placement="top" title="Match the Password entered above" class="input-group-addon">
						<span class="glyphicon glyphicon-info-sign"></span>
						</span>
					</div>
				</br>
				<input type = "submit" name="submit" id="insert_register" value="Register" class="btn btn-success"></input>
				<input type = "button" name="clear" id="clear_register" value="Clear" class="btn clearinput btn-default"></input>
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
	$('[data-toggle="tooltip"]').tooltip();
	
	$(document).on('click', '.clearinput', function(){
		if (confirm("Clear all input?")){
			$('.form-wrapper').find('form').trigger('reset');
		}
	});
	
	$('#register_form').on('submit', function(event){
		event.preventDefault();
		if ($('#first_name').val() == ""){
			alert("First name is required");
		} else if ($('#last_name').val() == ""){
			alert("Last name is required");
		} else if ($('#username').val() == ""){
			alert("Username is required");
		} else if($('#password').val() == ""){
			alert("Password is required");
		} else if($('#email').val() == ""){
			alert("Email is required");
		} else if ($('#password').val() != $('#cpassword').val()){
			alert("Confirm passwords invalid");
		} else {
			$.ajax({
				type: "POST",
				url: "includes/register.inc.php",
				data: $('#register_form').serialize(),
				success: function(data){
					if (data == 1){
						$('#register_form')[0].reset();
						$('#register_dataModal').modal('hide');
						alert("Register Successful!");
						window.location.href = "index.php";						
					} else {
						alert(data);
					}
				}
			});
		}
	});
	
	$(':input').focus(function(){
		$('.hint').hide();
		$(this).next().fadeIn();
	});
	
	/* Counter */
	$('#first_name').keyup(function(){
		var left_fn = 35 - $(this).val().length;
		$('#charcount_fn').text('Characters left: ' + left_fn);
	});		
	
	$('#last_name').keyup(function(){
		var left_ln = 35 - $(this).val().length;
		$('#charcount_ln').text('Characters left: ' + left_ln);
	});		

	$('#username').keyup(function(){
		var left_u = 50 - $(this).val().length;
		$('#charcount_u').text('Characters left: ' + left_u);
	});
});
</script>