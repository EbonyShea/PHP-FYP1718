<?php
	include_once 'includes/dashheader.php';
?>

<section id = "parent-container">
	<div class = "content-container">
		<div class = "forum-panel forum-color">
			<h1>Forum</h1>
			<div>
				<button class = "btn btn-danger add_data addBtn" data-toggle="modal" data-target="#add_dataModal" class="btn">Start new Topic</button>
				<input type = "text" id = "search" name = "search" class = "d-search" placeholder = "Search..." autofocus></input>
			</div>
		</div>
		<div id = "displayForum"></div>	
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
				<h4 id = "modalTitle" class = "modal-title">Add Topic</h4>
			</div>
			<div class = "modal-body" id = "topic_detail">
				<form method="post" id="insert_form">
					<label>Topic<i class = "fa fa-asterisk"></i></label>
						<input type = "text" maxlength = "50" class="form-control" id = "forum_topic" name = "forum_topic"></input>
						<span id = "charcount_t" class = "hint"></span>
					</br>
					<label>Details<i class = "fa fa-asterisk"></i></label>
						<input type = "text" maxlength = "500" class="form-control" id = "forum_details" name = "forum_details"></input>
						<span id ="charcount_d" class = "hint"></span>
					</br>
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

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113639948-2"></script>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-113639948-2');
$(document).ready(function(){
	function fetch_data(keyword){
		var query = keyword;
		var data_type = "forum";
		$.ajax({
			method: "POST",
			url: "includes/fetchforum.inc.php",
			data: {query:query, data_type:data_type},
			success: function(data){
				$('#displayForum').html(data);
			}
		});
	}
	fetch_data('%');
	
	$(document).on('click', '.add_data', function(){
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
						alert("Insert Successful!");
					} else {
						alert(data);
					}
					fetch_data('%');
				}
			});
		}
	});
	
	$(':input').focus(function(){
		$('.hint').hide();
		$(this).next().fadeIn();
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