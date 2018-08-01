<?php
	include_once 'includes/dashheader.php';
?>

<section id = "parent-container">
	<div id = "help-container">
		<h1>Help</h1>
		<hr>
		<div class = "help-content">
			<details>
				<summary>Cannot upload profile picture</summary>
				<p>
				The file format allowed are *.png, *.jpg, *.jpeg and the maximum size is 1mb.
				</br>
				Hint: Use <a href = "https://tinypng.com/"  target="_blank">TinyPng</a> to shrink you image size.
				</p>
			</details>
			<details>
				<summary>Cannot use simulator in mobile</summary>
				<p>
					The current simulator have not been optimized for mobile yet. Update coming soon!
				</p>
			</details>			
			<details>
				<summary>How to use the simulator?</summary>
				<p>
					1) Select 'Simulator' under the 'Learning Tools' tab.
					</br></br>
					2) Click on the drop down button 'Logic Gates' at top right.
					</br></br>
					3) Select any logic gates.
					</br></br>
					4) Drag the newly placed logic gate and place anywhere you desire.
					</br></br>
					5) After placing all the logic gates you wanted, connect output to input of all the placed logic gates.
					</br></br>
					6) To start over, click 'Clear'.
				</p>
			</details>
			<details>		
				<summary>Problem not in the list? / Have any suggestion?</summary>
				<div class = "contact-box">
					<h2>Contact Us</h2>
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
			</details>
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
});
 </script>