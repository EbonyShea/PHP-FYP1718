<?php
	include_once 'includes/dashheader.php';
 	if($_SESSION['user_type'] == 0){
		header("Location:dashboard.php");
		exit();
	} 
?>

<section id = "parent-container">
	<div class ="control-panel">
		<h1 class = "forum-color">Forum Management</h1><br><hr>
		<input type = "text" id = "search" name = "search" class = "search" placeholder = "Search..." autofocus></input>
		<div class = "btn-group topbtn">
			<a type = "button" class = "btn btn-default" id = "enable_records">Enable Selected</a>
			<a type = "button" class = "btn btn-default" id = "disable_records">Disable Selected</a>
			<a type = "button" class = "btn btn-default" id = "clear_records">Clear Selected Comments</a>
			<a type = "button" class = "btn btn-default" id = "delete_records">Delete Selected</a>
			<button class = "btn btn-danger add_data" data-toggle="modal" data-target="#add_dataModal" class="btn">+</button>
		</div>
	</div>
	<div id = "managementTbl">
		<table>
			<thead>
			<tr>
				<th><input type="checkbox" id = "select_all"/></th>
				<th>Topic</th>
				<th>Details</th>
				<th>Date Added</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody id = "topic-container"></tbody>
		</table>
	</div>
	<div class = "control-footer">
		<span id = "contentCount"/>
	</div>
</section>
</div>
</body>
</html>

<div id = "add_dataModal" class = "modal fade">
	<div class = "modal-dialog">
		<div class = "modal-content">
			<div class = "modal-header">
				<button type="button" class = "close" data-dismiss="modal">&times;</button>
				<h4 id = "modalTitle" class = "modal-title"></h4>
			</div>
			<div class = "modal-body" id = "topic_detail">
				<form method="post" id="insert_form">
					<div id = "editOnly" style = "display: none">
						<label>Uploaded by: </label><span id = "username"></span>
						</br></br>
						<label>ID: </label>
						<input type = "text" class="form-control" id = "forum_ID" name = "forum_ID" readonly="readonly"/>
					</div>
					</br>
					<label>Topic<i class = "fa fa-asterisk"></i></label>
						<input type = "text" maxlength = "50" class="form-control" id = "forum_topic" name = "forum_topic"></input>
						<span id = "charcount_t" class = "hint"></span>
					</br>
					<label>Details<i class = "fa fa-asterisk"></i></label>
						<input type = "text" maxlength = "500" class="form-control" id = "forum_details" name = "forum_details"></input>
						<span id ="charcount_d" class = "hint"></span>
					</br>
					<label>Status: </label>
						<input type = "radio" id = "enable" name = "status" value = "enable" checked> Enable Comment</input>
						<input type = "radio" id = "disable" name = "status" value = "disable"> Disable Comment</input>
					</br></br>
					<input type = "submit" name="submit" id="insert_topic" value = "Insert" class="btn btn-success"></input>
					<input type = "button" name="clear" id="clear_topic" value="Clear" class="btn clearinput btn-default"></input>
				</form>
			</div>
			<div class = "modal-footer">
				<button type = "button" class = "btn btn-default" data-dismiss = "modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id = "view_dataModal" class = "modal fade">
	<div class = "modal-dialog">
		<div class = "modal-content">
			<div class = "modal-header">
				<button type="button" class = "close" data-dismiss="modal">&times;</button>
				<h4 class = "modal-title"> Topic Details </h4>
			</div>
			<div class = "modal-body" id = "topic_detail">
				<label>ID: </label>
				<span id = "display_fID"></span>
				</br></br>
				<label>Title: </label>
				<span id = "display_fTitle"></span>
				</br></br>
				<label>Details: </label>
				</br>
				<span id = "display_fDetail"></span>
				</br></br>
				<label>Uploaded by: </label>
				<span id = "display_fUploader"></span>
				</br></br>
				<label>Status: </label>
				<span id = "display_fStatus"></span>
				</br></br>
				<label>Number of Comments: </label>
				<span id = "display_fNum"></span>
				</br></br>
			</div>
			<div class = "modal-footer">
				<button type = "button" class = "btn btn-default" data-dismiss = "modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	function fetch_data(keyword){
		var query = keyword;
		var data_type = "forum";
		$.ajax({
			method: "POST",
			url: "includes/fetchforum2.inc.php",
			data: {query:query, data_type:data_type},
			success: function(data){
				$('#topic-container').html(data);
				count_content();
			}
		});
	}
	fetch_data('%');
	
	$('#search').keyup(function(){
		var query = $('#search').val();
		if(query != ''){
			fetch_data(query);
		} else {
			fetch_data('%');
		}
	});
	
	function count_content(){
		var count = $('table tbody tr').length;
		if (count == 1 || count == 0){
			$('#contentCount').html("Showing " + count + " Entry.");
		} else {
			$('#contentCount').html("Showing " + count + " Entries.");
		}
	}
	
	/* Insert, Update, Disable / Enable Comment */	
	$(document).on('click', '.add_data', function(){
		$('#modalTitle').html("Add Topic");
		$('#insert_topic').val("Insert");
		$('#editOnly').hide();
		$('#clear_topic').show();
		$('#insert_form')[0].reset();
	});
	
	$('#insert_form').on('submit', function(event){
		event.preventDefault();
		if ($('#forum_topic').val() == ""){
			alert("Topic Title is required");
		} else if ($('#forum_details').val() == ""){
				alert("Topic Details is required");
			} else {
				$.ajax({
					type: "POST",
					url: "includes/insertforum.inc.php",
					data: $('#insert_form').serialize(),
					success: function(data){
						if (data == 1){
							$('#add_dataModal').modal('hide');
							$('#insert_form')[0].reset();
							alert("Successful!");
						} else {
							alert(data);
						}
						fetch_data('%');
					}
				});
			}
	});

	$(document).on('click', '.view_data', function(){
		var forum_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectforum.inc.php",
			method: "POST",
			data:{forum_ID:forum_ID},
			dataType:"json",
			success: function(data){
				$('#display_fID').html(data.Forum_ID);
				$('#display_fTitle').html(data.Forum_Title);
				$('#display_fDetail').html(data.Forum_Content);
				$('#display_fUploader').html(data.Username);
				if (data.Forum_Comm == 1){
					$('#display_fStatus').html("Comment Enabled");
				} else {
					$('#display_fStatus').html("Comment Disabled");
				}
				$('#display_fNum').html(data.count_Comm);
				$('#view_dataModal').modal("show");
			}
		});
	});
	
	$(document).on('click','.edit_data', function(){
		var forum_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectforum.inc.php",
			method: "POST",
			data:{forum_ID:forum_ID},
			dataType:"json",
			success: function(data){
				$('#modalTitle').html("Edit Topic");
				$('#editOnly').show();
				$('#insert_form')[0].reset();
				$('#username').html(data.Username);
				$('#forum_ID').val(data.Forum_ID);
				$('#forum_topic').val(data.Forum_Title);
				$('#forum_details').val(data.Forum_Content);
				if(data.Forum_Comm == 0){
					document.getElementById('disable').checked = true;
				} else {
					document.getElementById('enable').checked = true;
				}
				$('#clear_topic').hide();
				$('#insert_topic').val("Edit");
				$('#add_dataModal').modal('show');
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
				var selected_topic = selected.join(",");
				$.ajax({
					type: "POST",
					url: "includes/amendforum.inc.php",
					cache: false,
					data: {query:query,selected_topic:selected_topic},
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
	
	$(document).on('click', '.delete_data', function(){ 
		var query = "delete";
		var forum_ID=$(this).data("id"); 
		$.ajax({
			type: "POST",
			url: "includes/amendforum.inc.php",
			data: {query:query,forum_ID:forum_ID},
			dataType: "text", 
			success: function(data){
				alert(data);
				fetch_data('%');
			}
		});
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
				var selected_topic = selected.join(",");
				$.ajax({
					type: "POST",
					url: "includes/amendforum.inc.php",
					cache: false,
					data: {query:query,selected_topic:selected_topic},
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
	
	$(document).on('click', '.enable_data', function(){ 
		var query = "enable";
		var forum_ID=$(this).data("id"); 
		$.ajax({
			type: "POST",
			url: "includes/amendforum.inc.php",
			data: {query:query,forum_ID:forum_ID},
			dataType: "text", 
			success: function(data){
				alert(data);
				fetch_data('%');
			}
		});
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
				var selected_topic = selected.join(",");
				$.ajax({
					type: "POST",
					url: "includes/amendforum.inc.php",
					cache: false,
					data: {query:query,selected_topic:selected_topic},
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
	
	$(document).on('click', '.disable_data', function(){ 
		var query = "disable";
		var forum_ID=$(this).data("id"); 
		$.ajax({
			type: "POST",
			url: "includes/amendforum.inc.php",
			data: {query:query,forum_ID:forum_ID},
			dataType: "text", 
			success: function(data){
				alert(data);
				fetch_data('%');
			}
		});
	});
	
	$('#clear_records').on('click', function(e) {
		var query = "clear";
		var selected = [];
		$(".emp_checkbox:checked").each(function(){
			selected.push($(this).data('emp-id'));
		});
		if (selected.length <= 0) {
			alert("Please select records.");
		} else {
			WRN_PROFILE_DELETE = "Are you sure you want to clear comments for "+(selected.length>1?"these":"this")+" row?";
			var checked = confirm(WRN_PROFILE_DELETE);
			if(checked == true) {
				var selected_topic = selected.join(",");
				$.ajax({
					type: "POST",
					url: "includes/amendforum.inc.php",
					cache: false,
					data: {query:query,selected_topic:selected_topic},
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
	
	$(document).on('click', '.clear_data', function(){ 
		var query = "clear";
		var forum_ID=$(this).data("id"); 
		$.ajax({
			type: "POST",
			url: "includes/amendforum.inc.php",
			data: {query:query,forum_ID:forum_ID},
			dataType: "text", 
			success: function(data){
				alert(data);
				fetch_data('%');
			}
		});
	});
	
	/* Character Counting */	
	$('#forum_topic').keyup(function(){
		var left_t = 50 - $(this).val().length;
		$('#charcount_t').text('Characters left: ' + left_t);
	});	
	
	$('#forum_details').keyup(function(){
		var left_d = 500 - $(this).val().length;
		$('#charcount_d').text('Characters left: ' + left_d);
	});
	
	$(document).on('click', '.clearinput', function(){
		if (confirm("Clear all input?")){
			$('#add_dataModal').find('form').trigger('reset');
		}
	});
	
	$(':input').focus(function(){
		$('.hint').hide();
		$(this).next().fadeIn();
	});
});
</script>