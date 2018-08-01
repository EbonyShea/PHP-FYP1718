<?php
	include_once 'includes/dashheader.php';
 	if($_SESSION['user_type'] == 0){
		header("Location:dashboard.php");
		exit();
	} 
?>

<section id = "parent-container">
	<div class ="control-panel">
		<h1 class = "ann-color">Announcement Management</h1><br><hr>
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
				<th>Uploader</th>
				<th>Announcement</th>
				<th>Date Added</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody id = "ann-container"></tbody>
		</table>
	</div>
	<div class = "control-footer">
		<span id = "contentCount"/>
	</div>
</section>
</div>
</body>
</html>

<div id = "insert_dataModal" class = "modal fade">
	<div class = "modal-dialog">
		<div class = "modal-content">
			<div class = "modal-header">
				<button type="button" class = "close" data-dismiss="modal">&times;</button>
				<h4 id = "modalTitle" class = "modal-title"></h4>
			</div>
			<div class = "modal-body" id = "insert_detail">
				<form method="post" id="insert_form">
					<div id = "editOnly">
						<label>ID</label>
						<input type = "text" class="form-control" id = "ann_ID" name = "ann_ID" readonly="readonly"/>
					</div>
					</br>
					<label>Announcement<i class = "fa fa-asterisk"></i></label>
						<input type = "text" maxlength = "200" class="form-control" id = "ann" name = "ann"  autofocus></input>
						<span id = "charcount_ann" class = "hint"></span>
					</br>
					<input type = "submit" name="submit" id="insert_ann" value= "Insert" class="btn btn-success"></input>
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
		var data_type = "announcement";
		$.ajax({
			method: "POST",
			url: "includes/fetchann2.inc.php",
			data: {query:query, data_type:data_type},
			success: function(data){
				$('#ann-container').html(data);
				count_content();
			}
		});
	}
	fetch_data('%');
	
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
		$('#modalTitle').html("Add Announcement");
		$('#insert_ann').val("Insert");
		$('#editOnly').hide();
		$('#clear_insert').show();
		$('#insert_form')[0].reset();
	});
	
	$('#insert_form').on('submit', function(event){
		event.preventDefault();
		if ($('#ann').val() == ""){
			alert("Input is required");
		} else {
			$.ajax({
				type: "POST",
				url: "includes/insertann.inc.php",
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
	
	$(document).on('click', '.clearinput', function(){
		if (confirm("Clear input?")){
			$('#insert_dataModal').find('form').trigger('reset');
		}
	});
	
	$(document).on('click', '.delete_data', function(){ 
		var ann_id=$(this).data("id"); 
		$.ajax({
			type: "POST",
			url: "includes/deleteann.inc.php",
			data: {ann_id:ann_id},
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
				var selected_ann = selected.join(",");
				$.ajax({
					type: "POST",
					url: "includes/deleteann.inc.php",
					cache: false,
					data: {selected_ann:selected_ann},
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
		var ann_ID = $(this).attr("id");
		$.ajax({
			url: "includes/selectann.inc.php",
			method: "POST",
			data:{ann_ID:ann_ID},
			dataType:"json",
			success: function(data){
				$('#modalTitle').html("Edit Announcement");
				$('#insert_form')[0].reset();
				$('#ann_ID').val(data.Ann_ID);
				$('#ann').val(data.Ann_Content);
				$('#editOnly').show();
				$('#clear_insert').hide();
				$('#insert_ann').val("Edit");
				$('#insert_dataModal').modal('show');
			}
		});
	});
	
	$(':input').focus(function(){
		$('.hint').hide();
		$(this).next().fadeIn();
	});

	$('#ann').keyup(function(){
		var left_ln = 200 - $(this).val().length;
		$('#charcount_ann').text('Characters left: ' + left_ln);
	});		
});
</script>