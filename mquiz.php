<?php
	include_once 'includes/dashheader.php';
 	if($_SESSION['user_type'] == 0){
		header("Location:dashboard.php");
		exit();
	} 
?>

<section id = "parent-container">
	<div class ="control-panel">
		<h1 class = "quiz-color">Quiz Management</h1><br><hr>
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
			<tbody id = "Quiz_Table"></tbody>
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
				<h4 class = "modal-title"> Quiz Details </h4>
			</div>
			<div class = "modal-body" id = "flashcard_detail">
				<label>Uploaded by: </label>
				<span id = "display_user"></span>
				</br></br>				
				<label>ID: </label>
				<span id = "display_qID"></span>
				</br></br>
				<label>Title: </label>
				<span id = "display_qTitle"></span>
				</br></br>
				<label>Description: </label>
				<span id = "display_qDesc"></span>
				</br></br>
				<label>Quiz URL: </label>
				<a id = "display_qURL" href = "#" target="_blank"></a>
				</br></br>
				<label>Drive URL: </label>
				<span id = "display_driveText"></span><a id = "display_qDrive" href = "#" target="_blank"></a>
				</br></br>
				<label>Local File: </label>
				<span id = "display_localText"></span><a id = "display_qLocal" href = "#"></a>
				</br></br>
				<label>Logo: </label>
				<img id = "display_qLogo" src = "img/quiz/noimage.png"/>
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
						<input type = "text" class="form-control" id = "quiz_ID" name = "quiz_ID" readonly="readonly"/>
					</div>
					</br>
					<label>Title<i class = "fa fa-asterisk"></i></label>
						<input type = "text" maxlength = "50" class="form-control" id = "quiz_title" name = "quiz_title"></input>
						<span id = "charcount_t" class = "hint"></span>
					</br>
					<label>Description<i class = "fa fa-asterisk"></i></label>
						<input type = "text" maxlength = "200" class="form-control" id = "quiz_desc" name = "quiz_desc"></input>
						<span id ="charcount_d" class = "hint"></span>
					</br>
					<label>Quiz URL<i class = "fa fa-asterisk"></i></label>
						<div class="input-group">
							<input type = "text" maxlength= "150" class="form-control" id = "quiz_url" name = "quiz_url"></input>
							<span data-toggle="tooltip" data-placement="top" title="E.g. Cram.com, Kahoot.it, Edpuzzle.com" class="input-group-addon">
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
								<input type = "text" id = "quiz_dl" name = "quiz_dl" maxlength= "150" class="form-control"></input>
								<span data-toggle="tooltip" data-placement="top" title="E.g. https://drive.google.com/open?id=..." class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign"></span>
								</span>								
							</div>								
						</br>
						<label>File Upload</label>
							<div class="input-group">
								<input type = "file" id = "quiz_file" name = "quiz_file" class="form-control"></input>
								<span data-toggle="tooltip" data-placement="top" title="Max Size: 10MB, Format: *.zip, *.rar, *.pdf, *.doc, *.docx, *.txt" class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign"></span>
								</span>								
							</div>								
						</br>
						<label>Logo</label>
							<div class="input-group">
								<input type = "file" id = "quiz_img" name = "quiz_img" class="form-control"></input>
								<span data-toggle="tooltip" data-placement="top" title="Max Size: 1MB, Format: *.jpg, *.jpeg,*.png" class="input-group-addon">
								<span class="glyphicon glyphicon-info-sign"></span>
								</span>								
							</div>								
						</br>
					</div>
					<input type = "hidden" id = "updateFile" name = "updateFile"/>
					<input type = "hidden" id = "updateImg" name = "updateImg"/>
					<input type = "submit" name="submit" id="insert_quiz" class="btn btn-success"></input>
					<input type = "button" name="clear_quiz" id="clear_quiz" value="Clear" class="btn clearinput btn-default"></input>
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
		var data_type = "quiz";
		$.ajax({
			method: "POST",
			url: "includes/fetchquiz.inc.php",
			data: {query:query, data_type:data_type},
			success: function(data){
				$('#Quiz_Table').html(data);
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
		$('#modalTitle').html("Add Quiz");
		$('#editOnly').hide();
		$('#clear_quiz').show();
		$('#insert_quiz').val("Insert");
		$('#insert_form')[0].reset();
		$('#optionalFields').hide();
	});
	
	$(document).on('click','.edit_data', function(){
		var quiz_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectquiz.inc.php",
			method: "POST",
			data:{quiz_ID:quiz_ID},
			dataType:"json",
			success: function(data){
				$('#modalTitle').html("Edit Quiz");
				$('#editOnly').show();
				$('#clear_quiz').hide();
				$('#insert_form')[0].reset();
				$('#optionalFields').hide();
				$('#quiz_ID').val(data.Quiz_ID);
				$('#username').html(data.Username);
				$('#quiz_title').val(data.Quiz_Title);
				$('#quiz_desc').val(data.Quiz_Desc);
				$('#quiz_url').val(data.Quiz_URL);
				$('#quiz_dl').val(data.Quiz_DL);
				/* Optional */
				$('#updateFile').val(data.Quiz_File);
				$('#updateImg').val(data.Quiz_Img);
				/* Optional */
				$('#insert_quiz').val("Edit");
				$('#add_dataModal').modal('show');
			}
		});
	});

	$(document).on('click', '.view_data', function(){
		var quiz_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectquiz.inc.php",
			method: "POST",
			data:{quiz_ID:quiz_ID},
			dataType:"json",
			success: function(data){
				/* GET DATA */
				$('#display_user').html(data.Username);
				$('#display_qID').html(data.Quiz_ID);
				$('#display_qTitle').html(data.Quiz_Title);
				$('#display_qDesc').html(data.Quiz_Desc);
				$('#display_qURL').html(data.Quiz_URL);
				document.getElementById('display_qURL').href = data.Quiz_URL;
				if (data.Quiz_DL != null){
					document.getElementById('display_qDrive').href = data.Quiz_DL;	
					$('#display_qDrive').text(data.Quiz_DL);
					$('#display_driveText').text("");
				} else if (data.Quiz_DL == null) {
					document.getElementById('display_qDrive').href = "";
					$('#display_qDrive').text("");
					$('#display_driveText').text("Not available");
				}
				if (data.Quiz_File != null ){
					document.getElementById('display_qLocal').href = "includes/download.inc.php?type=quiz&dl="+data.Quiz_File;
					$('#display_qLocal').text(data.Quiz_File);
					$('#display_localText').text("");
				} else if (data.Quiz_File == null){
					document.getElementById('display_qLocal').href = "";
					$('#display_qLocal').text("");
					$('#display_localText').text("Not available");
				}
				if (data.Quiz_Img != null){
					document.getElementById("display_qLogo").src="img/quiz/"+data.Quiz_Img;
				} else {
					document.getElementById("display_qLogo").src="img/quiz/noimage.png";
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
		if ($('#quiz_title').val() == ""){
			alert("Quiz Title is required");
		} else if ($('#quiz_desc').val() == ""){
			alert("Quiz Description is required");
		} else if ($('#quiz_url').val() == ""){
			alert("Quiz link is required");
		} else {
			var uploadData = new FormData($(this)[0]);
			$.ajax({
				type: "POST",
				url: "includes/insertquiz.inc.php",
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
		var quiz_id=$(this).data("id"); 
		$.ajax({
			type: "POST",
			url: "includes/deletequiz.inc.php",
			data: {quiz_id:quiz_id},
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
				var selected_quiz = selected.join(",");
				$.ajax({
					type: "POST",
					url: "includes/deletequiz.inc.php",
					cache: false,
					data: {selected_quiz:selected_quiz},
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
	
	$('#quiz_title').keyup(function(){
		var left_t = 50 - $(this).val().length;
		$('#charcount_t').text('Characters left: ' + left_t);
	});	
	
	$('#quiz_desc').keyup(function(){
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