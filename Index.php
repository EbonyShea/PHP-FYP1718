<?php
	include_once 'includes/mainheader.php';
?>

<section class = "main-container">
	<!-- Carousel -->
	<div class = "carousel-container">
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
			</ol>
			<div class="carousel-inner">
				<div class="item active">
					<img src="img/carousel/1.png" alt="Google Survey">
					<div class="carousel-caption">
						<a class = "btn" href ="https://goo.gl/forms/VP3XBuB5cAEkSVxa2" target="_blank">CLICK HERE</a>
					</div>
				</div>
				<div class="item">
					<img src="img/carousel/2.png" alt="Register Here">
					<div class="carousel-caption">
						<a class = "btn" href ="register.php">REGISTER</a>
					</div>
				</div>				
				<div class="item">
					<img src="img/carousel/3.png" alt="Register Here">
					<div class="carousel-caption">
						<a class = "btn" href ="register.php">REGISTER</a>
					</div>
				</div>
			</div>
			<a class="left carousel-control" href="#myCarousel" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>
	<!-- Carousel -->
</section>

<section class = "main-container">
	<div class = "selection">
		<a href = "#aboutus" class = "btn">About Us</a>
		<a href = "#learningtools" class = "btn">Learning Tools</a>
		<a href = "#contactus" class = "btn">Contact Us</a>
	</div>
</section>

<section class = "main-container">
	<div id = "aboutus">
		<h1>About Us</h1>
		<p>Our goal is to help you learn with ease and speed through our abundance of learning tools.</p>
		<p>Come join us today and help us improve along the way!</p>
		</br>
		<a href = "register.php" class = "btn btn-default">Register Now</a>
		<a href = "login.php" class = "btn btn-default">Login Now</a>
	</div>
</section>

<section class = "main-container">
	<div id = "learningtools">
		<h1>Learning Tools</h1>
		<div class = "tools">
			<div class = "lessonImg"><p>Lessons</p></div>
			<div class = "youtubeImg"><p>Videos</p></div>
			<div class = "fcImg"><p>Flashcards</p></div>
			<div class = "quizImg"><p>Quizzes</p></div>
			<div class = "gameImg"><p>Games</p></div>
			<div class = "circuitImg"><p>Simulator</p></div>
			<div class = "forumImg"><p>Forum</p></div>
		</div>
	</div>
</section>

<section class = "main-container">
	<div id = "contactus">
		<div class = "contact-box">
			<h1>Contact Us</h1>
			<hr>
			<form method="post" id="help_form">
				<label>Full Name</label>
					<input type = "text" class = "form-control" id = "fullname" name = "fullname" maxlength = "50" required></input>
				</br>
				<label>Email</label>
					<input type = "email" class = "form-control" id = "emails" name = "emails" maxlength = "50" required></input>
				</br>
				<label>Details</label>
					<input type = "text" class = "form-control" id = "details" name = "details" maxlength = "300" required></input>
				</br>
				<input class = "btn btn-default" id = "reset_contact" type = "reset" value = "Clear"></input>
				<input class = "btn btn-info" id = "submit_contact" type = "submit" name = "submit" value = "Send"></input>
			</form>
		</div>
	</div>
</section>

<div id = "footer">
	<div class = "siteMap">
		<a href = "register.php">Register</a>
		<a href = "login.php">Login</a>
		<a href="https://www.facebook.com/groups/502398926776616" target="_blank">Facebook</a>
		<a href = "https://www.youtube.com/channel/UCWx2gfoCyIaYitDe2zbeBNQ/" target="_blank">YouTube</a>
	</div>
</div>
</body>
</html>

<div id = "register_dataModal" class = "modal fade">
	<div class = "modal-dialog">
		<div class = "modal-content">
			<div class = "modal-header">
				<button type="button" class = "close" data-dismiss="modal">&times;</button>
				<h4 class = "modal-title">Register</h4>
			</div>
			<div class="modal-body" id="register_detail">
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
			<div class = "modal-footer">
				<button type = "button" class = "btn btn-default" data-dismiss = "modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113639948-2"></script>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-113639948-2');
  
$(document).ready(function(){
	$('#login_form')[0].reset();
	$('[data-toggle="tooltip"]').tooltip();
	$(document).on('click', '.clearinput', function(){
		if (confirm("Clear all input?")){
			$('#register_dataModal').find('form').trigger('reset');
		}
	});
	
	$('#help_form').on('submit', function(event){
		event.preventDefault();
		if ($('#fullname').val() == ""){
			alert("Name is required");
		} else if ($('#emails').val() == ""){
			alert("Email is required");
		} else if($('#details').val() == ""){
			alert("Details is required");
		} else {
			$.ajax({
				type: "POST",
				url: "includes/contact.inc.php",
				data: $('#help_form').serialize(),
				beforeSend : function() {
					$('#submit_contact').val("Sending...");
				},
				success: function(data){
					$('#submit_contact').val("Send");
					if (data == 1){
						document.getElementById("help_form").reset();
						alert("Sent!");
					} else {
						alert(data);
					}
				}
			});
		}
	});
	
	$(document).on('click', '.register', function(){
		$('#insert_register').val("Register");
		$('#register_form')[0].reset();
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
					} else {
						alert(data);
					}
				}
			});
		}
	});
	
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
						window.location.href = "login.php";
					}
				}
			});
		}
	});
	
	$(':input').focus(function(){
		$('.hint').hide();
		$(this).next().fadeIn();
	});
	
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