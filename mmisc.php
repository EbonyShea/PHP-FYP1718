<?php
	include_once 'includes/dashheader.php';
 	if($_SESSION['user_type'] == 0){
		header("Location:dashboard.php");
		exit();
	} 
?>

<section id = "parent-container">
	<div class ="control-panel">
		<h1 class = "misc-color">Misc Management</h1><br><hr>
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
			<tbody id = "Misc_Table"></tbody>
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
				<h4 class = "modal-title"> Misc Details </h4>
			</div>
			<div class = "modal-body">
				<label>Uploaded by: </label>
				<span id = "display_user"></span>
				</br></br>				
				<label>ID: </label>
				<span id = "display_mID"></span>
				</br></br>
				<label>Title: </label>
				<span id = "display_mTitle"></span>
				</br></br>
				<label>Description: </label>
				<span id = "display_mDesc"></span>
				</br></br>
				<label>Misc URL: </label>
				<span id = "display_urlText"></span><a id = "display_mURL" href = "#" target="_blank"></a>
				</br></br>
				<label>Drive URL: </label>
				<span id = "display_driveText"></span><a id = "display_mDrive" href = "#" target="_blank"></a>
				</br></br>
				<label>Local File: </label>
				<span id = "display_localText"></span><a id = "display_mLocal" href = "#"></a>
				</br></br>
				<label>Logo: </label>
				<img id = "display_mLogo" src = "img/misc/noimage.png"/>
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
						<input type = "text" class="form-control" id = "misc_ID" name = "misc_ID" readonly="readonly"/>
					</div>
					</br>
					<label>Title<i class = "fa fa-asterisk"></i></label>
						<input type = "text" maxlength = "50" class="form-control" id = "misc_title" name = "misc_title"></input>
						<span id = "charcount_t" class = "hint"></span>
					</br>
					<label>Description<i class = "fa fa-asterisk"></i></label>
						<input type = "text" maxlength = "200" class="form-control" id = "misc_desc" name = "misc_desc"></input>
						<span id ="charcount_d" class = "hint"></span>
					</br>
					<hr>
					<div style = "text-align: center; border: 2px solid #000; padding: 5px;">
						<label>Choose at least one<i class = "fa fa-asterisk"></i></label>
					</div>
					</br>
					<label>Misc URL</label>
					<div class="input-group">
						<input type = "text" maxlength= "200" class="form-control" id = "misc_url" name = "misc_url"></input>
						<span data-toggle="tooltip" data-placement="top" title="E.g. http://..., https://..." class="input-group-addon">
						<span class="glyphicon glyphicon-info-sign"></span>
						</span>								
					</div>
					</br>
					<label>Drive URL</label>
						<div class="input-group">
							<input type = "text" id = "misc_dl" name = "misc_dl" maxlength= "150" class="form-control"></input>
							<span data-toggle="tooltip" data-placement="top" title="E.g. https://drive.google.com/open?id=..." class="input-group-addon">
							<span class="glyphicon glyphicon-info-sign"></span>
							</span>								
						</div>								
					</br>
					<label>File Upload</label>
						<div class="input-group">
							<input type = "file" id = "misc_file" name = "misc_file" class="form-control"></input>
							<span data-toggle="tooltip" data-placement="top" title="Max Size: 20MB" class="input-group-addon">
							<span class="glyphicon glyphicon-info-sign"></span>
							</span>								
						</div>								
					</br>
					<h4 class = "modal-title"> Optional <input type = "checkbox" id = "optionalCB" /></h4>
					</br>
					<div id = "optionalFields" style = "display:none">
						<label>Logo</label>
							<div class="input-group">
								<input type = "file" id = "misc_img" name = "misc_img" class="form-control"></input>
								<span data-toggle="tooltip" data-placement="top" title="Max Size: 1MB, Format: *.jpg, *.jpeg,*.png" class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign"></span>
								</span>								
							</div>								
						</br>
					</div>
					<input type = "hidden" id = "updateFile" name = "updateFile"/>
					<input type = "hidden" id = "updateImg" name = "updateImg"/>
					<input type = "submit" name="submit" id="insert_misc" class="btn btn-success"></input>
					<input type = "button" name="clear_misc" id="clear_misc" value="Clear" class="btn clearinput btn-default"></input>
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
		var data_type = "misc";
		$.ajax({
			method: "POST",
			url: "includes/fetchmisc.inc.php",
			data: {query:query, data_type:data_type},
			success: function(data){
				$('#Misc_Table').html(data);
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
		$('#modalTitle').html("Add Misc");
		$('#editOnly').hide();
		$('#clear_misc').show();
		$('#insert_misc').val("Insert");
		$('#insert_form')[0].reset();
		$('#optionalFields').hide();
	});
	
	$(document).on('click','.edit_data', function(){
		var misc_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectmisc.inc.php",
			method: "POST",
			data:{misc_ID:misc_ID},
			dataType:"json",
			success: function(data){
				$('#modalTitle').html("Edit Misc");
				$('#editOnly').show();
				$('#clear_misc').hide();
				$('#insert_form')[0].reset();
				$('#optionalFields').hide();
				$('#misc_ID').val(data.Misc_ID);
				$('#username').html(data.Username);
				$('#misc_title').val(data.Misc_Title);
				$('#misc_desc').val(data.Misc_Desc);
				$('#misc_url').val(data.Misc_URL);
				$('#misc_dl').val(data.Misc_DL);
				/* Optional */
				$('#updateFile').val(data.Misc_File);
				$('#updateImg').val(data.Misc_Img);
				/* Optional */
				$('#insert_misc').val("Edit");
				$('#add_dataModal').modal('show');
			}
		});
	});

	$(document).on('click', '.view_data', function(){
		var misc_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectmisc.inc.php",
			method: "POST",
			data:{misc_ID:misc_ID},
			dataType:"json",
			success: function(data){
				/* GET DATA */
				$('#display_user').html(data.Username);
				$('#display_mID').html(data.Misc_ID);
				$('#display_mTitle').html(data.Misc_Title);
				$('#display_mDesc').html(data.Misc_Desc);
				$('#display_mURL').html(data.Misc_URL);
				if (data.Misc_URL != null){
					document.getElementById('display_mURL').href = data.Misc_URL;	
					$('#display_mURL').text(data.Misc_URL);
					$('#display_urlText').text("");
				} else if (data.Misc_URL == null) {
					document.getElementById('display_mURL').href = "";
					$('#display_mURL').text("");
					$('#display_urlText').text("Not available");
				}
				if (data.Misc_DL != null){
					document.getElementById('display_mDrive').href = data.Misc_DL;	
					$('#display_mDrive').text(data.Misc_DL);
					$('#display_driveText').text("");
				} else if (data.Misc_DL == null) {
					document.getElementById('display_mDrive').href = "";
					$('#display_mDrive').text("");
					$('#display_driveText').text("Not available");
				}
				if (data.Misc_File != null ){
					document.getElementById('display_mLocal').href = "includes/download.inc.php?type=misc&dl="+data.Misc_File;
					$('#display_mLocal').text(data.Misc_File);
					$('#display_localText').text("");
				} else if (data.Misc_File == null){
					document.getElementById('display_mLocal').href = "";
					$('#display_mLocal').text("");
					$('#display_localText').text("Not available");
				}
				if (data.Misc_Img != null){
					document.getElementById("display_mLogo").src="img/misc/"+data.Misc_Img;
				} else {
					document.getElementById("display_mLogo").src="img/misc/noimage.png";
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
		if ($('#misc_title').val() == ""){
			alert("Misc Title is required");
		} else if ($('#misc_desc').val() == ""){
			alert("Misc Description is required");
		} else {
			var uploadData = new FormData($(this)[0]);
			$.ajax({
				type: "POST",
				url: "includes/insertmisc.inc.php",
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
		var misc_id=$(this).data("id"); 
		$.ajax({
			type: "POST",
			url: "includes/deletemisc.inc.php",
			data: {misc_id:misc_id},
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
				var selected_misc = selected.join(",");
				$.ajax({
					type: "POST",
					url: "includes/deletemisc.inc.php",
					cache: false,
					data: {selected_misc:selected_misc},
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
	
	$('#misc_title').keyup(function(){
		var left_t = 50 - $(this).val().length;
		$('#charcount_t').text('Characters left: ' + left_t);
	});	
	
	$('#misc_desc').keyup(function(){
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