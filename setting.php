<?php
	include_once 'includes/dashheader.php';
?>

<section id = "parent-container">
	<div id = "setting-container">
		<div class = "box">
			<h2><strong>Profile</strong></h2>
			</br>
			<img id = "img" src = "img/user/default.png" alt = "Image Error"/>
			</br>
			<label>First Name: </label>
				</br>
				<span id = "firstname"></span>
				</br></br>
			<label>Last Name: </label>
				</br>
				<span id = "lastname"></span>
				</br></br>
			<label>Username: </label>
				</br>
				<span id = "username"></span>
				</br></br>
			<label>Email: </label>
				</br>
				<span id = "email"></span>
				</br></br>
			<label>Type: </label>
				</br>
				<span id = "type"></span>
				</br></br>
			<label>Created Date: </label>
				</br>
				<span id = "date"></span>
				</br></br>
		</div>
		
		<div class = "box">
			<h2><strong>Change Email</strong></h2>
			</br>
			<form id = "email_form" action ="" method="POST">
				<input type = "hidden" id = "e_query" name = "e_query" value = "changeEmail"></input>
				<div class="input-group">
					<input type = "email" class="form-control" id = "u_oEmail" name = "u_oEmail" maxlength = "40" placeholder = "Current Email"></input>
					<span data-toggle="tooltip" data-placement="top" title="Enter your current Email" class="input-group-addon">
					<span class="glyphicon glyphicon-info-sign"></span>
				</div>					
				</br>
				<div class="input-group">
					<input type = "email" class="form-control" id = "u_Email" name = "u_Email" maxlength = "40" placeholder = "New Email"></input>
					<span data-toggle="tooltip" data-placement="top" title="Enter your new Email" class="input-group-addon">
					<span class="glyphicon glyphicon-info-sign"></span>
				</div>					
				</br>
				<div class="input-group">
					<input type = "email" class="form-control" id = "u_cEmail" name = "u_cEmail" maxlength = "40" placeholder = "Confirm New Email"></input>
					<span data-toggle="tooltip" data-placement="top" title="Match the new Email entered above" class="input-group-addon">
					<span class="glyphicon glyphicon-info-sign"></span>
				</div>					
				<input type = "submit" name="submit" id="e_update" value="Edit" class="btn btn-success"></input>
				<input type = "reset" value="Clear" class="btn btn-default"></input>
			</form>
		</div>
		<div class = "box">
			<h2><strong>Change Password</strong></h2>
			</br>
			<form id = "password_form" action ="" method="POST">
				<input type = "hidden" id = "p_query" name = "p_query" value = "changePassword"></input>
				<div class="input-group">
					<input type = "password" class="form-control" id = "u_oPass" name = "u_oPass" pattern = ".{8,}" maxlength = "265" placeholder = "Current Password"></input>
					<span data-toggle="tooltip" data-placement="top" title="Enter your current password" class="input-group-addon">
					<span class="glyphicon glyphicon-info-sign"></span>
				</div>
				</br>
				<div class="input-group">
					<input type = "password" class="form-control" id = "u_Pass" name = "u_Pass" pattern = ".{8,}" maxlength = "265" placeholder = "New Password"></input>
					<span data-toggle="tooltip" data-placement="top" title="New password must contain at least 8 characters, including UPPER/lowercase, special character(s) and number(s)" class="input-group-addon">
					<span class="glyphicon glyphicon-info-sign"></span>
				</div>
				</br>
				<div class="input-group">
					<input type = "password" class="form-control" id = "u_cPass" name = "u_cPass" pattern = ".{8,}" maxlength = "265" placeholder = "Confirm New Password"></input>
					<span data-toggle="tooltip" data-placement="top" title="Match the new Password entered above" class="input-group-addon">
					<span class="glyphicon glyphicon-info-sign"></span>
				</div>
				<input type = "submit" name="submit" id="p_update" value="Edit" class="btn btn-success"></input>
				<input type = "reset" value="Clear" class="btn btn-default"></input>
			</form>
		</div>
		<div class = "box">
			<h2><strong>Change Profile Picture</strong></h2>
			</br>
			<form id = "img_form" action ="" method="POST">
				<input type = "hidden" id = "i_query" name = "i_query" value = "changeImg"></input>
				<div class="input-group">
					<input type = "file" class="form-control" id = "u_Img" name = "u_Img"></input>
					<span data-toggle="tooltip" data-placement="top" title="Max Size: 1MB, Format: *.jpg, *.jpeg,*.png" class="input-group-addon">
					<span class="glyphicon glyphicon-info-sign"></span>
				</div>
				<input type = "checkbox" id = "clearImg" name = "clearImg"> Remove picture </input>
				</br>
				<input type = "submit" name="submit" id="i_update" value="Edit" class="btn btn-success"></input>
				<input type = "reset" value="Clear" class="btn btn-default"></input>
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
	$(':input').focus(function(){
		$('.hint').hide();
		$(this).next().fadeIn();
	});
	
	function fetch_data(){
		var user_ID = "<?php echo $_SESSION['user_ID']; ?>";
		$.ajax({
			url: "includes/selectuser.inc.php",
			method: "POST",
			data: {user_ID:user_ID},
			dataType:"json",
			success: function(data){
				document.getElementById("img").src="img/user/"+data.User_Img;
				$('#firstname').text(data.First_Name);
				$('#lastname').text(data.Last_Name);
				$('#username').text(data.Username);
				$('#email').text(data.Email);
				if (data.User_Type = 1){
					$('#type').text("Admin");
				} else {
					$('#type').text("Default");
				}
				$('#date').text(data.User_CreatedDate);
			}
		});
	}
	fetch_data();
		
	$('#email_form').on('submit', function(event){
		event.preventDefault();
		if ($('#u_oEmail').val() == ""){
			alert("Please enter current Email");
		} else if ($('#u_Email').val() == ""){
			alert("New Email is required");
		} else if ($('#u_cEmail').val() == ""){
			alert("Please confirm new email");
		} else if ($('#u_Email').val() != $('#u_cEmail').val()) {
			alert("The new Email you entered does not match");
		} else {
			$.ajax({
				type: "POST",
				url: "includes/settinguser.inc.php",
				data: $('#email_form').serialize(),
				success: function(data){
					if (data == 1){
						$('#email_form')[0].reset();
						alert("Update Email Successful!");						
					} else {
						alert(data);
					}
					fetch_data();
				}
			});
		}
	});
	
	$('#password_form').on('submit', function(event){
		event.preventDefault();
		if ($('#u_oPass').val() == ""){
			alert("Please enter current Password");
		} else if ($('#u_Pass').val() == ""){
			alert("New Password is required");
		} else if ($('#u_cPass').val() == ""){
			alert("Please confirm new password");
		} else if ($('#u_Pass').val() != $('#u_cPass').val()) {
			alert("The new Password you entered does not match");
		} else {
			$.ajax({
				type: "POST",
				url: "includes/settinguser.inc.php",
				data: $('#password_form').serialize(),
				success: function(data){
					if (data == 1){
						$('#password_form')[0].reset();
						alert("Update Password Successful!");						
					} else {
						alert(data);
					}
					fetch_data();
				}
			});
		}
	});	
	
	$('#img_form').on('submit', function(event){
		event.preventDefault();
		if( document.getElementById("u_Img").files.length == 0 && document.getElementById('clearImg').checked == false){
			alert("No change needed");
		} else {
			var uploadData = new FormData($(this)[0]);
			$.ajax({
				type: "POST",
				url: "includes/settinguser.inc.php",
				data: uploadData,
				success: function(data){
					if (data == 1){
						$('#img_form')[0].reset();
						alert("Update Profile Picture Successful");
						window.location.reload(true);
					} else {
						alert(data);
					}
					fetch_data();
				},
				cache: false,
				contentType: false,
				processData:false
			});
		}
	});	
	
});
</script>