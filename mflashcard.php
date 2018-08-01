<?php
	include_once 'includes/dashheader.php';
 	if($_SESSION['user_type'] == 0){
		header("Location:dashboard.php");
		exit();
	} 
?>

<section id = "parent-container">
	<div class ="control-panel">
		<h1 class = "fc-color">Flashcard Management</h1><br><hr>
		<input type = "text" id = "search" name = "search" class = "search" placeholder = "Search..." autofocus></input>
		<div class = "btn-group topbtn">
			<a type = "button" class = "btn btn-default" id = "delete_records">Delete Selected</a>
			<button class = "btn btn-danger add_data" data-toggle="modal" data-target="#add_dataModal" class="btn">+</button>
		</div>
	</div>
	<div id = "managementTbl">
		<table>
			<thead>
			<tr>
				<th><input type="checkbox" id = "select_all"/></th>
				<th>Title</th>
				<th>Description</th>
				<th>Date Added</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody id = "Flashcard_Table"></tbody>
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
				<h4 class = "modal-title">Flashcard Details</h4>
			</div>
			<div class = "modal-body" id = "flashcard_detail">
				<label>Uploaded by: </label>
				<span id = "display_user"></span>
				</br></br>				
				<label>ID: </label>
				<span id = "display_fcID"></span>
				</br></br>
				<label>Title: </label>
				<span id = "display_fcTitle"></span>
				</br></br>
				<label>Description: </label>
				<span id = "display_fcDesc"></span>
				</br></br>
				<label>Flashcard URL: </label>
				<a id = "display_fcURL" href = "#" target="_blank"></a>
				</br></br>
				<label>Drive URL: </label>
				<span id = "display_driveText"></span><a id = "display_fcDrive" href = "#" target="_blank"></a>
				</br></br>
				<label>Local File: </label>
				<span id = "display_localText"></span><a id = "display_fcLocal" href = "#"></a>
				</br></br>
				<label>Logo: </label>
				<img id = "display_fcLogo" src = "img/flashcard/noimage.png"/>
				</br>
			</div>
			<div class = "modal-footer">
				<button type = "button" class = "btn btn-default" data-dismiss = "modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id = "add_dataModal" class = "modal fade">
	<div class = "modal-dialog">
		<div class = "modal-content">
			<div class = "modal-header">
				<button type="button" class = "close" data-dismiss="modal">&times;</button>
				<h4 id = "modalTitle" class = "modal-title"></h4>
			</div>
			<div class = "modal-body" id = "flashcard_detail">
				<form method="post" id="insert_form">
					<div id = "editOnly" style = "display: none">
						<label>Uploaded by: </label> <span id = "username"></span>
						</br></br>
						<label>ID: </label>
						<input type = "text" class="form-control" id = "fc_ID" name = "fc_ID" readonly="readonly"/>
					</div>
					</br>
					<label>Title<i class = "fa fa-asterisk"></i></label>
						<input type = "text" maxlength = "50" class="form-control" id = "fc_title" name = "fc_title"></input>
						<span id = "charcount_t" class = "hint"></span>
					</br>
					<label>Description<i class = "fa fa-asterisk"></i></label>
						<input type = "text" maxlength = "200" class="form-control" id = "fc_desc" name = "fc_desc"></input>
						<span id ="charcount_d" class = "hint"></span>
					</br>
					<label>Flashcard URL<i class = "fa fa-asterisk"></i></label>
						<div class="input-group">
							<input type = "text" maxlength= "150" class="form-control" id = "fc_url" name = "fc_url"></input>
							<span data-toggle="tooltip" data-placement="top" title="E.g. Goconqr.com, Cram.com, Quizlet.com" class="input-group-addon">
							<span class="glyphicon glyphicon-info-sign"></span>
							</span>								
						</div>
					</br>
					<hr>
					<h4 class = "modal-title"> Optional <input type = "checkbox" id = "optionalCB" /></h4>
					</br>
					<div id = "optionalFields" style = "display:none">
						<label>Drive URL</label>
							<div class="input-group">
								<input type = "text" id = "fc_dl" name = "fc_dl" maxlength= "150" class="form-control"></input>
								<span data-toggle="tooltip" data-placement="top" title="E.g. https://drive.google.com/open?id=..." class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign"></span>
								</span>								
							</div>
						</br>
						<label>File Upload</label>
							<div class="input-group">
								<input type = "file" id = "fc_file" name = "fc_file" class="form-control"></input>
								<span data-toggle="tooltip" data-placement="top" title="Max Size: 10MB, Format: *.zip, *.rar, *.pdf, *.doc, *.docx, *.pptx, *.txt, *.csv" class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign"></span>
								</span>								
							</div>
						</br>
						<label>Logo</label>
							<div class="input-group">
								<input type = "file" id = "fc_img" name = "fc_img" class="form-control"></input>
								<span data-toggle="tooltip" data-placement="top" title="Max Size: 1MB, Format: *.jpg, *.jpeg,*.png" class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign"></span>
								</span>								
							</div>								
						</br>
					</div>
					<input type = "hidden" id = "updateFile" name = "updateFile"/>
					<input type = "hidden" id = "updateImg" name = "updateImg"/>
					<input type = "submit" name="submit" id="insert_flashcard" class="btn btn-success"></input>
					<input type = "button" name="clear_flashcard" id="clear_flashcard" value="Clear" class="btn clearinput btn-default"></input>
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
		var data_type = "flashcard";
		$.ajax({
			method: "POST",
			url: "includes/fetchfc.inc.php",
			data: {query:query, data_type:data_type},
			success: function(data){
				$('#Flashcard_Table').html(data);
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
	
	$('#optionalCB').change(function(){
		if (this.checked){
			$('#optionalFields').fadeIn('fast');
		} else {
			$('#optionalFields').fadeOut('fast');
		}
	});
	
	$(document).on('click', '.add_data', function(){
		$('#modalTitle').html("Add Flashcard");
		$('#editOnly').hide();
		$('#clear_flashcard').show();
		$('#insert_flashcard').val("Insert");
		$('#insert_form')[0].reset();
		$('#optionalFields').hide();
	});
	
	$(document).on('click','.edit_data', function(){
		var flashcard_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectfc.inc.php",
			method: "POST",
			data:{flashcard_ID:flashcard_ID},
			dataType:"json",
			success: function(data){
				$('#modalTitle').html("Edit Flashcard");
				$('#editOnly').show();
				$('#clear_flashcard').hide();
				$('#insert_form')[0].reset();
				$('#optionalFields').hide();
				$('#fc_ID').val(data.fc_ID);
				$('#username').html(data.Username);
				$('#fc_title').val(data.fc_Title);
				$('#fc_desc').val(data.fc_Desc);
				$('#fc_url').val(data.fc_URL);
				$('#fc_dl').val(data.fc_DL);
				/* Optional */
				$('#updateFile').val(data.fc_File);
				$('#updateImg').val(data.fc_Img);
				/* Optional */
				$('#insert_flashcard').val("Edit");
				$('#add_dataModal').modal('show');
			}
		});
	});

	$(document).on('click', '.view_data', function(){
		var flashcard_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectfc.inc.php",
			method: "POST",
			data:{flashcard_ID:flashcard_ID},
			dataType:"json",
			success: function(data){
				/* GET DATA */
				$('#display_user').html(data.Username);
				$('#display_fcID').html(data.fc_ID);
				$('#display_fcTitle').html(data.fc_Title);
				$('#display_fcDesc').html(data.fc_Desc);
				$('#display_fcURL').html(data.fc_URL);
				document.getElementById('display_fcURL').href = data.fc_URL;
				if (data.fc_DL != null){
					document.getElementById('display_fcDrive').href = data.fc_DL;	
					$('#display_fcDrive').text(data.fc_DL);
					$('#display_driveText').text("");
				} else if (data.fc_DL == null) {
					document.getElementById('display_fcDrive').href = "";
					$('#display_fcDrive').text("");
					$('#display_driveText').text("Not available");
				}
				
				if (data.fc_File != null ){
					document.getElementById('display_fcLocal').href = "includes/download.inc.php?type=flashcard&dl="+data.fc_File;
					$('#display_fcLocal').text(data.fc_File);
					$('#display_localText').text("");
				} else if (data.fc_File == null){
					document.getElementById('display_fcLocal').href = "";
					$('#display_fcLocal').text("");
					$('#display_localText').text("Not available");
				}
				if (data.fc_Img != null){
					document.getElementById("display_fcLogo").src="img/flashcard/"+data.fc_Img;
				} else {
					document.getElementById("display_fcLogo").src="img/flashcard/noimage.png";
				}
				$('#view_dataModal').modal("show");
			}
		});
	});
	
	$(document).on('click', '.clearinput', function(){
		if (confirm("Clear all input?")){
			$('#add_dataModal').find('form').trigger('reset');
			$('#optionalFields').hide();
		}
	});
	
	$('#insert_form').on('submit', function(event){
		event.preventDefault();
		if ($('#fc_title').val() == ""){
			alert("Flashcard Title is required");
		} else if ($('#fc_desc').val() == ""){
			alert("Flashcard Description is required");
		} else if ($('#fc_url').val() == ""){
			alert("Flashcard link is required");
		} else {
			var uploadData = new FormData($(this)[0]);
			$.ajax({
				type: "POST",
				url: "includes/insertflashcard.inc.php",
				data: uploadData,
				success: function(data){
					if (data == 1){
						$('#add_dataModal').modal('hide');
						$('#insert_form')[0].reset();
						alert("Successful!");
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
	
	$(document).on('click', '.delete_data', function(){  
		var fc_id=$(this).data("id"); 
		$.ajax({
			type: "POST",
			url: "includes/deletefc.inc.php",
			data: {fc_id:fc_id},
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
				var selected_flashcard = selected.join(",");
				$.ajax({
					type: "POST",
					url: "includes/deletefc.inc.php",
					cache: false,
					data: {selected_flashcard:selected_flashcard},
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
		
	$(':input').focus(function(){
		$('.hint').hide();
		$(this).next().fadeIn();
	});
	
	$('#fc_title').keyup(function(){
		var left_t = 50 - $(this).val().length;
		$('#charcount_t').text('Characters left: ' + left_t);
	});	
	
	$('#fc_desc').keyup(function(){
		var left_d = 200 - $(this).val().length;
		$('#charcount_d').text('Characters left: ' + left_d);
	});
	
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