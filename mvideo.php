<?php
	include_once 'includes/dashheader.php';
 	if($_SESSION['user_type'] == 0){
		header("Location:dashboard.php");
		exit();
	} 
?>

<section id = "parent-container">
	<div class ="control-panel">
		<h1 class = "video-color">Videos Management</h1><br><hr>
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
			<tbody id = "Video_Table"></tbody>
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
				<h4 class = "modal-title"> Video Details </h4>
			</div>
			<div class = "modal-body" id = "video_detail">
				<label>Uploaded by: </label>
				<span id = "display_user"></span>
				</br></br>				
				<label>ID: </label>
				<span id = "display_vID"></span>
				</br></br>
				<label>Title: </label>
				<span id = "display_vTitle"></span>
				</br></br>
				<label>Description: </label>
				<span id = "display_vDesc"></span>
				</br></br>
				<label>Youtube URL: </label>
				<a id = "display_vURL" href = "#" target="_blank"></a>
				</br></br>
				<label>Drive URL: </label>
				<span id = "display_driveText"></span><a id = "display_vDrive" href = "#" target="_blank"></a>
				</br></br>
				<label>Local File: </label>
				<span id = "display_localText"></span><a id = "display_vLocal" href = "#"></a>
				</br></br>
				<label>Logo: </label>
				<img id = "display_vLogo" src = "img/video/noimage.png"/>
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
			<div class = "modal-body" id = "video_detail">
				<form method="post" id="insert_form">
					<div id = "editOnly" style = "display: none">
						<label>Uploaded by: </label> <span id = "username"></span>
						</br></br>
						<label>ID: </label>
						<input type = "text" class="form-control" id = "video_ID" name = "video_ID" readonly="readonly"/>
					</div>
					</br>
					<label>Title<i class = "fa fa-asterisk"></i></label>
						<input type = "text" maxlength = "50" class="form-control" id = "video_title" name = "video_title"></input>
						<span id = "charcount_t" class = "hint"></span>
					</br>
					<label>Description<i class = "fa fa-asterisk"></i></label>
						<input type = "text" maxlength = "200" class="form-control" id = "video_desc" name = "video_desc"></input>
						<span id ="charcount_d" class = "hint"></span>
					</br>
					<label>Youtube URL<i class = "fa fa-asterisk"></i></label>
						<div class="input-group">
							<input type = "text" maxlength= "200" class="form-control" id = "video_url" name = "video_url"></input>
							<span data-toggle="tooltip" data-placement="top" title="E.g. https://www.youtube.com/watch?v=..." class="input-group-addon">
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
								<input type = "text" id = "video_dl" maxlength= "150" name = "video_dl" class="form-control"></input>
								<span data-toggle="tooltip" data-placement="top" title="E.g. https://drive.google.com/open?id=..." class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign"></span>
								</span>								
							</div>
						</br>
						<label>File Upload</label>
							<div class="input-group">
								<input type = "file" id = "video_file" name = "video_file" class="form-control"></input>
								<span data-toggle="tooltip" data-placement="top" title="Max Size: 15MB, Format: *.zip, *.rar, *.wmv, *.mp4" class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign"></span>
								</span>								
							</div>
						</br>
						<label>Logo</label>
							<div class="input-group">
								<input type = "file" id = "video_img" name = "video_img" class="form-control"></input>
								<span data-toggle="tooltip" data-placement="top" title="Max Size: 1MB, Format: *.jpg, *.jpeg,*.png" class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign"></span>
								</span>								
							</div>							
						</br>
					</div>
					<input type = "hidden" id = "updateFile" name = "updateFile"/>
					<input type = "hidden" id = "updateImg" name = "updateImg"/>
					<input type = "submit" name="submit" id="insert_video" class="btn btn-success"></input>
					<input type = "button" name="clear_video" id="clear_video" value="Clear" class="btn clearinput btn-default"></input>
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
		var data_type = "video";
		$.ajax({
			method: "POST",
			url: "includes/fetchvideo.inc.php",
			data: {query:query, data_type:data_type},
			success: function(data){
				$('#Video_Table').html(data);
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
		$('#modalTitle').html("Add Video");
		$('#editOnly').hide();
		$('#clear_video').show();
		$('#insert_video').val("Insert");
		$('#insert_form')[0].reset();
		$('#optionalFields').hide();
	});
	
	$(document).on('click','.edit_data', function(){
		var video_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectvideo.inc.php",
			method: "POST",
			data:{video_ID:video_ID},
			dataType:"json",
			success: function(data){
				$('#modalTitle').html("Edit Video");
				$('#editOnly').show();
				$('#clear_video').hide();
				$('#insert_form')[0].reset();
				$('#optionalFields').hide();
				$('#video_ID').val(data.Video_ID);
				$('#username').html(data.Username);
				$('#video_title').val(data.Video_Title);
				$('#video_desc').val(data.Video_Desc);
				$('#video_url').val(data.Video_URL);
				$('#video_dl').val(data.Video_DL);
				/* Optional */
				$('#updateFile').val(data.Video_File);
				$('#updateImg').val(data.Video_Img);
				/* Optional */
				$('#insert_video').val("Edit");
				$('#add_dataModal').modal('show');
			}
		});
	});

	$(document).on('click', '.view_data', function(){
		var video_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectvideo.inc.php",
			method: "POST",
			data:{video_ID:video_ID},
			dataType:"json",
			success: function(data){
				/* GET DATA */
				$('#display_user').html(data.Username);
				$('#display_vID').html(data.Video_ID);
				$('#display_vTitle').html(data.Video_Title);
				$('#display_vDesc').html(data.Video_Desc);
				$('#display_vURL').html(data.Video_URL);
				document.getElementById('display_vURL').href = data.Video_URL;
				if (data.Video_DL != null){
					document.getElementById('display_vDrive').href = data.Video_DL;	
					$('#display_vDrive').text(data.Video_DL);
					$('#display_driveText').text("");
				} else if (data.Video_DL == null) {
					document.getElementById('display_vDrive').href = "";
					$('#display_vDrive').text("");
					$('#display_driveText').text("Not available");
				}
				
				if (data.Video_File != null ){
					document.getElementById('display_vLocal').href = "includes/download.inc.php?type=video&dl="+data.Video_File;
					$('#display_vLocal').text(data.Video_File);
					$('#display_localText').text("");
				} else if (data.Video_File == null){
					document.getElementById('display_vLocal').href = "";
					$('#display_vLocal').text("");
					$('#display_localText').text("Not available");
				}
				if (data.Video_Img != null){
					document.getElementById("display_vLogo").src="img/video/"+data.Video_Img;
				} else {
					document.getElementById("display_vLogo").src="img/video/noimage.png";
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
		if ($('#video_title').val() == ""){
			alert("Video Title is required");
		} else if ($('#video_desc').val() == ""){
			alert("Video Description is required");
		} else if ($('#video_url').val() == ""){
			alert("Video link is required");
		} else {
			var uploadData = new FormData($(this)[0]);
			$.ajax({
				type: "POST",
				url: "includes/insertvideo.inc.php",
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
		var video_id=$(this).data("id"); 
		$.ajax({
			type: "POST",
			url: "includes/deletevideo.inc.php",
			data: {video_id:video_id},
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
				var selected_videos = selected.join(",");
				$.ajax({
					type: "POST",
					url: "includes/deletevideo.inc.php",
					cache: false,
					data: {selected_videos:selected_videos},
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
	
	$('#video_title').keyup(function(){
		var left_t = 50 - $(this).val().length;
		$('#charcount_t').text('Characters left: ' + left_t);
	});	
	
	$('#video_desc').keyup(function(){
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