<script>
$(document).ready(function(){	
	$(':input').focus(function(){
		$('.hint').hide();
		$(this).next().fadeIn();
	});
	
	$(document).on('click', '.clearinput', function(){
		if (confirm("Clear all input?")){
			$('#register_dataModal').find('form').trigger('reset');
		}
	});
	
	$('#login-form').on('submit', function(event){
		if ($('#logUser').val() == ""){
			alert ("Username is required");
		}.else if ($('#logPass').val() == ""){
			alert ("Password is required");
		} else {
			$.ajax({
				type: "POST",
				url: "includes/register.inc.php",
				data: $('#register_form').serialize(),
				beforeSend: function(){  
					$('#insert_register').val("Registering");
				},
				success: function(data){
					$('#register_form')[0].reset();
					$('#register_dataModal').modal('hide');
					$('#insert_register').val("Create Account");
					alert(data);
				}
			});
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
		} else {
			$.ajax({
				type: "POST",
				url: "includes/register.inc.php",
				data: $('#register_form').serialize(),
				beforeSend: function(){  
					$('#insert_register').val("Registering");
				},
				success: function(data){
					$('#register_form')[0].reset();
					$('#register_dataModal').modal('hide');
					$('#insert_register').val("Create Account");
					alert(data);
				}
			});
		}
	});
	
	var left_fn = 35;
	var left_ln = 35;
	var left_u = 50;
	var left_e = 40;
	
	$('#charcount_fn').text('Characters left: ' + left_fn);
	$('#charcount_ln').text('Characters left: ' + left_ln);
	$('#charcount_u').text('Characters left: ' + left_u);
	$('#charcount_e').text('Characters left: ' + left_e);
	
	$('#first_name').keyup(function(){
		left_fn = 35 - $(this).val().length;
		$('#charcount_fn').text('Characters left: ' + left_fn);
	});	
	
	$('#last_name').keyup(function(){
		left_ln = 35 - $(this).val().length;
		$('#charcount_ln').text('Characters left: ' + left_ln);
	});	
	
	$('#username').keyup(function(){
		left_u = 50 - $(this).val().length;
		$('#charcount_u').text('Characters left: ' + left_u);
	});	
	
	$('#email').keyup(function(){
		left_e = 40 - $(this).val().length;
		$('#charcount_e').text('Characters left: ' + left_e);
	});		
	
	$('#password').keyup(function(){
		if ($(this).val().length > 7){
			$('#charcount_p').text('');
		} else {
			$('#charcount_p').text('Min length: 8');
		}
	});
});