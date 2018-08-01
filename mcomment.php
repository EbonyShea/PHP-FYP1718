<?php
	include_once 'includes/dashheader.php';
 	if($_SESSION['user_type'] == 0){
		header("Location:dashboard.php");
		exit();
	} 
?>

<section id = "parent-container">
	<div class ="control-panel">
		<h1 class = "comment-color">Comment Management</h1><br><hr>
		<input type = "text" id = "search" name = "search" class = "search" placeholder = "Search..." autofocus></input>
		<div class = "btn-group topbtn">
			<a type = "button" class = "btn btn-default" id = "delete_records">Delete Selected</a>
			<button class = "btn btn-danger add_data" data-toggle="modal" data-target="#insert_dataModal" class="btn">+</button>
		</div>
	</div>
	<div id = "managementTbl">
		<table>
			<thead>
			<tr>
				<th><input type="checkbox" id = "select_all"/></th>
				<th>Forum Topic</th>
				<th>Comment</th>
				<th>Date Added</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody id = "comment-container"></tbody>
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
				<h4 class = "modal-title"> Comment Details </h4>
			</div>
			<div class = "modal-body" id = "user_detail">
				<label>Topic: </label>
				</br>
				<span id = "display_cTopic"></span>
				</br></br>
				<label>Comment ID: </label>
				</br>
				<span id = "display_cID"></span>
				</br></br>
				<label>Comment by: </label>
				</br>
				<span id = "display_cUser"></span>
				</br></br>
				<label>Comment: </label>
				</br>
				<span id = "display_cComm"></span>
				</br></br>
			</div>
			<div class = "modal-footer">
				<button type = "button" class = "btn btn-default" data-dismiss = "modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id = "insert_dataModal" class = "modal fade">
	<div class = "modal-dialog">
		<div class = "modal-content">
			<div class = "modal-header">
				<button type="button" class = "close" data-dismiss="modal">&times;</button>
				<h4 id = "modalTitle" class = "modal-title"></h4>
			</div>
			<div class = "modal-body" id = "insert_detail">
				<form method="post" id="insert_form">
					<div id = "editOnly" style = "display: none">
						<label>Topic: </label><span id = "comment_Topic"></span>
						</br></br>
						<label>Commenter: </label><span id = "username"></span>
						</br></br>
						<label>Comment ID: </label>
						<input type = "text" class="form-control" id = "comment_ID" name = "comment_ID" readonly="readonly"/>
					</div>
					</br>
					<div id = "addOnly" style = "display: none">
						<label>Topic<i class = "fa fa-asterisk"></i></label>
							<div id = "select_topic"></div>
						</br>
					</div>
					<label>Comment<i class = "fa fa-asterisk"></i></label>
						<input type = "text" maxlength = "300" class="form-control" id = "comment" name = "comment" required></input>
						<span id = "charcount_comm" class = "hint"></span>
					</br>
					<input type = "submit" name="submit" id="insert_comment" value= "Insert" class="btn btn-success"></input>
					<input type = "button" name="clear" id="clear_insert" value= "Clear" class="btn clearinput btn-default"></input>
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
	function fetch_data(keyword){
		var query = keyword;
		var data_type = "comment";
		$.ajax({
			method: "POST",
			url: "includes/fetchcomm2.inc.php",
			data: {query:query, data_type:data_type},
			success: function(data){
				$('#comment-container').html(data);
				count_content();
			}
		});
	}
	fetch_data('%');
	
	function fetch_topic(){
		$.ajax({
			method: "POST",
			url: "includes/selecttopiclist.inc.php",
			success: function(data){
				$('#select_topic').html(data);
			}
		});
	}
	
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
	
	$(document).on('click', '.add_data', function(){
		$('#modalTitle').html("Add Comment");
		$('#editOnly').hide();
		$('#addOnly').show();
		$('#clear_insert').show();
		$('#insert_comment').val("Insert");
		fetch_topic();
		$('#insert_form')[0].reset();
	});
	
	$(document).on('click', '.clearinput', function(){
		if (confirm("Clear all input?")){
			$('#insert_dataModal').find('form').trigger('reset');
		}
	});
	
	$('#insert_form').on('submit', function(event){
		event.preventDefault();
		if ($('#topic').val() == ""){
			alert("Topic is required");
		} else if ($('#comment').val() == ""){
			alert("Comment is required");
		} else {
			$.ajax({
				type: "POST",
				url: "includes/insertcomm.inc.php",
				data: $('#insert_form').serialize(),
				success: function(data){
					if (data == 1){
						$('#insert_dataModal').modal('hide');
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
	
	$(document).on('click', '.delete_data', function(){ 
		var comment_id=$(this).data("id"); 
		$.ajax({
			type: "POST",
			url: "includes/deletecomm.inc.php",
			data: {comment_id:comment_id},
			dataType: "text", 
			success: function(data){
				alert(data);
				fetch_data('%');
			}
		});
	});
	
	$('#delete_records').on('click', function(e) {
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
				var selected_comment = selected.join(",");
				$.ajax({
					type: "POST",
					url: "includes/deletecomm.inc.php",
					cache: false,
					data: {selected_comment:selected_comment},
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
	
	$(document).on('click','.edit_data', function(){
		var comment_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectcomm.inc.php",
			method: "POST",
			data:{comment_ID:comment_ID},
			dataType:"json",
			success: function(data){
				$('#modalTitle').html("Edit Comment");
				$('#editOnly').show();
				$('#addOnly').hide();
				$('#insert_form')[0].reset();
				
				$('#username').html(data.Username);
				$('#comment_ID').val(data.Comment_ID);
				$('#comment_Topic').html(data.Forum_Title);
				$('#comment').val(data.Comment_Content);
				
				$('#clear_insert').hide();
				$('#insert_comment').val("Edit");
				$('#insert_dataModal').modal('show');
			}
		});
	});
	
	$(document).on('click', '.view_data', function(){
		var comment_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectcomm.inc.php",
			method: "POST",
			data:{comment_ID:comment_ID},
			dataType:"json",
			success: function(data){
				$('#display_cTopic').html(data.Forum_Title);
				$('#display_cID').html(data.Comment_ID);
				$('#display_cUser').html(data.Username);
				$('#display_cComm').html(data.Comment_Content);
				$('#view_dataModal').modal("show");
			}
		});
	});
	$(':input').focus(function(){
		$('.hint').hide();
		$(this).next().fadeIn();
	});
	
	$('#comment').keyup(function(){
		var left_c = 300 - $(this).val().length;
		$('#charcount_comm').text('Characters left: ' + left_c);
	});
});
</script>