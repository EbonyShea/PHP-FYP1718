<?php
	include_once 'includes/dashheader.php';
 	if($_SESSION['user_type'] == 0){
		header("Location:dashboard.php");
		exit();
	} 
?>

<section id = "parent-container">
	<div class ="control-panel">
		<h1 class = "user-color">User Management</h1><br><hr>
		<input type = "text" id = "search" name = "search" class = "search" placeholder = "Search..." autofocus></input>
		<div class = "btn-group topbtn">
			<a type = "button" class = "btn btn-default" id = "enable_records">Enable Selected</a>
			<a type = "button" class = "btn btn-default" id = "disable_records">Disable Selected</a>
			<a type = "button" class = "btn btn-default" id = "delete_records">Delete Selected</a>
			<button class = "btn btn-danger add_data" data-toggle="modal" data-target="#register_dataModal" class="btn">+</button>
		</div>
	</div>
	<div id = "managementTbl">
		<table>
			<thead>
			<tr>
				<th><input type="checkbox" id = "select_all"/></th>
				<th>Username</th>
				<th>User Type</th>
				<th>Date Added</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody id = "User_Table"></tbody>
		</table>
	</div>
	<div class = "control-footer">
		<span id = "contentCount"/>
	</div>
</section>
</div>
</body>
</html>

<div id = "view_dataModal" class = "modal fade">
	<div class = "modal-dialog">
		<div class = "modal-content">
			<div class = "modal-header">
				<button type="button" class = "close" data-dismiss="modal">&times;</button>
				<h4 class = "modal-title"> User Details </h4>
			</div>
			<div class = "modal-body" id = "user_detail">
				<label>ID: </label>
				<span id = "display_uID"></span>
				</br></br>
				<label>First Name: </label>
				<span id = "display_uFirst"></span>
				</br></br>
				<label>Last Name: </label>
				<span id = "display_vLast"></span>
				</br></br>
				<label>Username: </label>
				<span id = "display_username"></span>
				</br></br>
				<label>Email: </label>
				<span id = "display_uEmail"></span>
				</br></br>
				<label>User type: </label>
				<span id = "display_uType"></span>
				</br></br>
				<label>User status: </label>
				<span id = "display_uStatus"></span>
				</br></br>
				<label>User image: </label>
				<img id = "display_uImg" src = "img/user/default.png"/>
				</br>
			</div>
			<div class = "modal-footer">
				<button type = "button" class = "btn btn-default" data-dismiss = "modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id = "register_dataModal" class = "modal fade">
	<div class = "modal-dialog">
		<div class = "modal-content">
			<div class = "modal-header">
				<button type="button" class = "close" data-dismiss="modal">&times;</button>
				<h4 class = "modal-title">Add User</h4>
			</div>
			<div class = "modal-body" id = "register_detail">
				<form method="post" id="register_form">
					<label>First Name<i class = "fa fa-asterisk"></i></label>
						<div class="input-group">
							<input type = "text" maxlength = "35" class="form-control" id = "first_name" name = "first_name" required></input>
							<span id = "charcount_fn" class = "hint"></span>
							<span data-toggle="tooltip" data-placement="top" title="Maximum 35 characters, only alphabets allowed" class="input-group-addon">
							<span class="glyphicon glyphicon-info-sign"></span>
						</div>
					</br>
					<label>Last Name<i class = "fa fa-asterisk"></i></label>
						<div class="input-group">
							<input type = "text" maxlength = "35" class="form-control" id = "last_name" name = "last_name" required></input>
							<span id = "charcount_ln" class = "hint"></span>
							<span data-toggle="tooltip" data-placement="top" title="Maximum 35 characters, only alphabets allowed" class="input-group-addon">
							<span class="glyphicon glyphicon-info-sign"></span>
						</div>
					</br>
					<label>Username<i class = "fa fa-asterisk"></i></label>
						<div class="input-group">
							<input type = "text" pattern = ".{3,}" maxlength = "50" class="form-control" id = "username" name = "username" required></input>
							<span id = "charcount_u" class = "hint"></span>
							<span data-toggle="tooltip" data-placement="top" title="Minimum 3 characters, maximum 50 characters" class="input-group-addon">
							<span class="glyphicon glyphicon-info-sign"></span>
						</div>
					</br>
					<label>Email<i class = "fa fa-asterisk"></i></label>
						<input type = "email" maxlength = "40" class="form-control" id = "email" name = "email" required></input>
					</br>
					<label>Password<i class = "fa fa-asterisk"></i></label>
						<div class="input-group">
							<input type = "password" pattern = ".{8,}" maxlength = "265" class="form-control" id = "password" name = "password" required></input>
							<span data-toggle="tooltip" data-placement="top" title="Password must contain at least 8 characters, including UPPER/lowercase, special character(s) and number(s)" class="input-group-addon">
							<span class="glyphicon glyphicon-info-sign"></span>
							</span>
						</div>
					</br>
					<label>Confirm Password<i class = "fa fa-asterisk"></i></label>
						<div class="input-group">
							<input type = "password" pattern = ".{8,}" maxlength = "265" class="form-control" id = "cpassword" name = "cpassword" required></input>
							<span data-toggle="tooltip" data-placement="top" title="Match the Password entered above" class="input-group-addon">
							<span class="glyphicon glyphicon-info-sign"></span>
							</span>
						</div>
					</br>
					<label>Profile Picture</label>
						<div class="input-group">
							<input type = "file" id = "user_img" name = "user_img" class="form-control"></input>
							<span data-toggle="tooltip" data-placement="top" title="Max Size: 1MB, Format: *.jpg, *.jpeg,*.png" class="input-group-addon">
							<span class="glyphicon glyphicon-info-sign"></span>
							</span>
						</div>
					</br>
					<label>Type: </label>
						<input type = "radio" id = "default" name = "type" value = "default" checked>Default</input>
						<input type = "radio" id = "admin" name = "type" value = "admin">Admin</input>
					</br></br>
					<label>Status: </label>
						<input type = "radio" id = "enable" name = "status" value = "enable">Enabled</input>
						<input type = "radio" id = "disable" name = "status" value = "disable" checked>Disabled</input>
					</br></br>
					<input type = "submit" name="submit" id="insert_register" value="Insert" class="btn btn-success"></input>
					<input type = "button" name="clear" id="clear_register" value="Clear" class="btn clearinput btn-default"></input>
				</form>
			</div>
			<div class = "modal-footer">
				<button type = "button" class = "btn btn-default" data-dismiss = "modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id = "update_dataModal" class = "modal fade">
	<div class = "modal-dialog">
		<div class = "modal-content">
			<div class = "modal-header">
				<button type="button" class = "close" data-dismiss="modal">&times;</button>
				<h4 class = "modal-title">Update User</h4>
			</div>
			<div class = "modal-body" id = "update_detail">
				<form method="post" id="update_form">
					<div id = "editOnly">
						<details>
							<summary><i>Additional Information</i></summary>
							</br>
							<label>ID: </label>
								<input type = "text" class="form-control" id = "user_ID" name = "user_ID" readonly="readonly"/>
							</br>
							<label>First Name</label>
								<input type = "text" class="form-control" id = "u_first_name" name = "u_first_name" readonly="readonly"/>
							</br>
							<label>Last Name</label>
								<input type = "text" class="form-control" id = "u_last_name" name = "u_last_name" readonly="readonly"/>
							</br>
							<label>Username</label>
								<input type = "text" class="form-control" id = "u_username" name = "u_username" readonly="readonly"></input>
						</details>
					</div>
					</br>
					<label>Email<i class = "fa fa-asterisk"></i></label>
						<input type = "email" maxlength = "40" class="form-control" id = "u_email" name = "u_email" required></input>
					</br>
					<label>Password</label>
						<div class="input-group">
							<input type = "password" pattern = ".{8,}" maxlength = "265" class="form-control" id = "u_password" name = "u_password" placeholder = "Enter to change password"></input>
							<span data-toggle="tooltip" data-placement="top" title="Password must contain at least 8 characters, including UPPER/lowercase and number(s)" class="input-group-addon">
							<span class="glyphicon glyphicon-info-sign"></span>
							</span>
						</div>
					</br>
					<label>Confirm Password</label>
						<div class="input-group">
							<input type = "password" pattern = ".{8,}" maxlength = "265" class="form-control" id = "u_cpassword" name = "u_cpassword" placeholder = "Confirm password"></input>
							<span data-toggle="tooltip" data-placement="top" title="Match the Password entered above" class="input-group-addon">
							<span class="glyphicon glyphicon-info-sign"></span>
							</span>
						</div>
					</br>
					<label>Profile Picture</label>
						<div class="input-group">
							<input type = "file" id = "u_user_img" name = "u_user_img" class="form-control"></input>
							<span data-toggle="tooltip" data-placement="top" title="Max Size: 1MB, Format: *.jpg, *.jpeg,*.png" class="input-group-addon">
							<span class="glyphicon glyphicon-info-sign"></span>
							</span>
						</div>
					</br>
					<label>Type: </label>
						<input type = "radio" id = "u_default" name = "u_type" value = "default" checked>Default</input>
						<input type = "radio" id = "u_admin" name = "u_type" value = "admin">Admin</input>
					</br></br>
					<label>Status: </label>
						<input type = "radio" id = "u_enable" name = "u_status" value = "enable">Enabled</input>
						<input type = "radio" id = "u_disable" name = "u_status" value = "disable" checked>Disabled</input>
					</br></br>
					<input type = "submit" name="submit" id="update_register" value="Edit" class="btn btn-success"></input>
				</form>
			</div>
			<div class = "modal-footer">
				<button type = "button" class = "btn btn-default" data-dismiss = "modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	function fetch_data(keyword){
		var query = keyword;
		var data_type = "user";
		$.ajax({
			method: "POST",
			url: "includes/fetchuser.inc.php",
			data: {query:query, data_type:data_type},
			success: function(data){
				$('#User_Table').html(data);
				count_content();
			}
		});
	}
	fetch_data('%');	

	function count_content(){
		var count = $('table tbody tr').length;
		if (count == 1 || count == 0){
			$('#contentCount').html("Showing " + count + " Entry.");
		} else {
			$('#contentCount').html("Showing " + count + " Entries.");
		}
	}
		
	$(':input').focus(function(){
		$('.hint').hide();
		$(this).next().fadeIn();
	});
	
	/* Insert & Edit */
	$(document).on('click', '.add_data', function(){
		$('#register_form')[0].reset();
	});
		
	$(document).on('click','.edit_data', function(){
		$('#update_form')[0].reset();
		var user_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectuser.inc.php",
			method: "POST",
			data:{user_ID:user_ID},
			dataType:"json",
			success: function(data){
				$('#update_form')[0].reset();
				$('#user_ID').val(data.User_ID);
				$('#u_first_name').val(data.First_Name);
				$('#u_last_name').val(data.Last_Name);
				$('#u_username').val(data.Username);
				$('#u_email').val(data.Email);
				if(data.User_Type == 0){
					document.getElementById('u_default').checked = true;
				} else {
					document.getElementById('u_admin').checked = true;
				}
				if(data.User_Status == 1){
					document.getElementById('u_enable').checked = true;
				} else {
					document.getElementById('u_disable').checked = true;
				}
				$('#update_dataModal').modal('show');
			}
		});
	});
	
	$(document).on('click', '.view_data', function(){
		var user_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectuser.inc.php",
			method: "POST",
			data:{user_ID:user_ID},
			dataType:"json",
			success: function(data){
				$('#display_uID').html(data.User_ID);
				$('#display_uFirst').html(data.First_Name);
				$('#display_vLast').html(data.Last_Name);
				$('#display_username').html(data.Username);
				$('#display_uEmail').html(data.Email);
				if(data.User_Type == 1){
					$('#display_uType').html("Admin");
				} else {
					$('#display_uType').html("Default");
				}
				if(data.User_Status == 0){
					$('#display_uStatus').html("Disabled");
				} else {
					$('#display_uStatus').html("Enabled");
				}
				if (data.User_Img != "default.png"){
					document.getElementById("display_uImg").src="img/user/"+data.User_Img;
				} else {
					document.getElementById("display_uImg").src="img/user/default.png";
				}
				$('#view_dataModal').modal("show");
			}
		});
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
		} else if($('#password').val() != $('#cpassword').val()){
			alert("Confirm passwords invalid");
		} else {
			var uploadData = new FormData($(this)[0]);
			$.ajax({
				type: "POST",
				url: "includes/insertuser.inc.php",
				data: uploadData,
				success: function(data){
					if (data == 1){
						$('#register_dataModal').modal('hide');
						$('#register_form')[0].reset();
						alert("Insert Successful!");						
					} else {
						alert(data);
					}
					fetch_data('%');
				},
				cache: false,
				contentType: false,
				processData:false
			});
		}
	});
	
	$('#update_form').on('submit', function(event){
		event.preventDefault();
		if ($('#u_first_name').val() == ""){
			alert("First name is required");
		} else if ($('#u_last_name').val() == ""){
			alert("Last name is required");
		} else if($('#u_email').val() == ""){
			alert("Email is required");
		} else if($('#u_password').val() != $('#u_cpassword').val()){
			alert("Confirm passwords invalid");
		} else {
			var uploadData = new FormData($(this)[0]);
			$.ajax({
				type: "POST",
				url: "includes/updateuser.inc.php",
				data: uploadData,
				success: function(data){
					if (data == 1){
						$('#update_dataModal').modal('hide');
						$('#update_form')[0].reset();
						alert("Update Successful!");			
					} else {
						alert(data);
					}
					fetch_data('%');
				},
				cache: false,
				contentType: false,
				processData:false
			});
		}
	});
	
	/* Delete, Enable, Disable, Make Admin, Default */
	$(document).on('click', '.delete_data', function(){ 
		var query = "delete";
		var user_ID=$(this).data("id"); 
		$.ajax({
			type: "POST",
			url: "includes/amenduser.inc.php",
			data: {query:query,user_ID:user_ID},
			dataType: "text", 
			success: function(data){
				alert(data);
				fetch_data('%');
			}
		});
	});
	
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.emp_checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.emp_checkbox').each(function(){
                this.checked = false;
            });
        }
    });
	
	$('#delete_records').on('click', function(e) {
		var query = "delete";
		var selected = [];
		$(".emp_checkbox:checked").each(function(){
			selected.push($(this).data('emp-id'));
		});
		if (selected.length <= 0) {
			alert("Please select records.");
		} else {
			WRN_PROFILE_DELETE = "Are you sure you want to delete "+(selected.length>1?"these":"this")+" row?";
			var checked = confirm(WRN_PROFILE_DELETE);
			if(checked == true) {
				var selected_users = selected.join(",");
				$.ajax({
					type: "POST",
					url: "includes/amenduser.inc.php",
					cache: false,
					data: {query:query,selected_users:selected_users},
					success: function(data){
						alert(data);
						$("#select_all").prop("checked", false);
						$("#search").val("");
						fetch_data('%');
					}
				});
			}
		}
	});
	
	$(document).on('click', '.clearinput', function(){
		if (confirm("Clear all input?")){
			$('#register_dataModal').find('form').trigger('reset');
		}
	});
	
	$('#enable_records').on('click', function(e) {
		var query = "enable";
		var selected = [];
		$(".emp_checkbox:checked").each(function(){
			selected.push($(this).data('emp-id'));
		});
		if (selected.length <= 0) {
			alert("Please select records.");
		} else {
			WRN_PROFILE_DELETE = "Are you sure you want to enable "+(selected.length>1?"these":"this")+" row?";
			var checked = confirm(WRN_PROFILE_DELETE);
			if(checked == true) {
				var selected_users = selected.join(",");
				$.ajax({
					type: "POST",
					url: "includes/amenduser.inc.php",
					cache: false,
					data: {query:query,selected_users:selected_users},
					success: function(data){
						alert(data);
						$("#select_all").prop("checked", false);
						$("#search").val("");
						fetch_data('%');
					}
				});
			}
		}
	});
	
	$('#disable_records').on('click', function(e) {
		var query = "disable";
		var selected = [];
		$(".emp_checkbox:checked").each(function(){
			selected.push($(this).data('emp-id'));
		});
		if (selected.length <= 0) {
			alert("Please select records.");
		} else {
			WRN_PROFILE_DELETE = "Are you sure you want to disable "+(selected.length>1?"these":"this")+" row?";
			var checked = confirm(WRN_PROFILE_DELETE);
			if(checked == true) {
				var selected_users = selected.join(",");
				$.ajax({
					type: "POST",
					url: "includes/amenduser.inc.php",
					cache: false,
					data: {query:query,selected_users:selected_users},
					success: function(data){
						alert(data);
						$("#select_all").prop("checked", false);
						$("#search").val("");
						fetch_data('%');
					}
				});
			}
		}
	});
	
	$(document).on('click', '.default_data', function(){ 
		var query = "makeDefault";
		var user_ID=$(this).data("id"); 
		$.ajax({
			type: "POST",
			url: "includes/amenduser.inc.php",
			data: {query:query,user_ID:user_ID},
			dataType: "text", 
			success: function(data){
				alert(data);
				fetch_data('%');
			}
		});
	});	
	
	$(document).on('click', '.admin_data', function(){ 
		var query = "makeAdmin";
		var user_ID=$(this).data("id"); 
		$.ajax({
			type: "POST",
			url: "includes/amenduser.inc.php",
			data: {query:query,user_ID:user_ID},
			dataType: "text", 
			success: function(data){
				alert(data);
				fetch_data('%');
			}
		});
	});
	
	/* Counter */
	$('#first_name').keyup(function(){
		var left_fn = 35 - $(this).val().length;
		$('#charcount_fn').text('Characters left: ' + left_fn);
	});		
	
	$('#u_first_name').keyup(function(){
		var left_fn = 35 - $(this).val().length;
		$('#u_charcount_fn').text('Characters left: ' + left_fn);
	});	
	
	$('#last_name').keyup(function(){
		var left_ln = 35 - $(this).val().length;
		$('#charcount_ln').text('Characters left: ' + left_ln);
	});		
	
	$('#u_last_name').keyup(function(){
		var left_ln = 35 - $(this).val().length;
		$('#u_charcount_ln').text('Characters left: ' + left_ln);
	});	
	
	$('#username').keyup(function(){
		var left_u = 50 - $(this).val().length;
		$('#charcount_u').text('Characters left: ' + left_u);
	});
	
	/* Search */
	$('#search').keyup(function(){
		var query = $('#search').val();
		if(query != ''){
			fetch_data(query);
		} else {
			fetch_data('%');
		}
	});
});
</script>