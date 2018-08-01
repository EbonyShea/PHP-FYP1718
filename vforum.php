<?php
	include_once 'includes/dashheader.php';
	if (!isset($_GET['id'])){
		header("Location: forum.php");
		exit();
	}
?>

<section id = "parent-container">
	<div class = "content-container">
		<div id = "displayTopic">
			<a class = "btn btn-info" href = "forum.php">Return</a>
			<div class = "topic forum-color">
				<div class = "userinfo">
					<img id = "img"/>
					<h4 id = "username"></h4>
				</div>
				<div class = "posttext">
					<h3 id = "topic_date"></h3>
					<h2 id = "topic_title"></h2>
					<p id = "topic_desc"></p>
				</div>
			</div>
			<div class = "comment">
				<div class = "insertComment">
					<form id = "comment_form" action ="" method="POST">
						<input type = "hidden" id = "forum_ID" name = "forum_ID"></input>
						<div class = "input-group">
							<input type = "text" maxlength = "300" class = "form-control" id = "comment" name = "comment" placeholder = "Max 300 characters"></input>
							<a type = "submit" id = "insert_comment" name = "submit" class="input-group-addon btn btn-info">Comment</a>
						</div>
						<span id = "remainComm" class = "hint"></span>
					</form>
				</div>
				<div class = "CommentDisabled">Comment Disabled</div>
			</div>
			<div id = "comment-container">
				<h2>Comments</h2>
				<hr>
				<div id = "commentsection"></div>
			</div>
		</div>	
	</div>
</section>
</div>
</body>
</html>

<script>
$(document).ready(function(){
	function fetch_comment(){
		var url_string = window.location.href
		var url = new URL(url_string);
		var forum_ID = url.searchParams.get("id");
		$.ajax({
			method: "POST",
			url: "includes/fetchcomm.inc.php",
			data: {forum_ID:forum_ID},
			success: function(data){
				$('#commentsection').html(data);
			}
		});
	}
	
	function get_info(){	
		var url_string = window.location.href
		var url = new URL(url_string);
		var forum_ID = url.searchParams.get("id");
		$.ajax({
			method: "POST",
			url: "includes/selectforum.inc.php",
			data: {forum_ID:forum_ID},
			dataType:"json",
			success: function(data){
				document.getElementById("img").src="img/user/"+data.User_Img;
				$('#username').text(data.Username);
				$('#topic_title').text(data.Forum_Title);
				var date = data.Forum_Date;
				date = date.split(' ')[0];
				$('#topic_date').text("Created on "+date);
				$('#topic_desc').text(data.Forum_Content);
				$('#forum_ID').val(forum_ID);
				if (data.Forum_Comm == 1){
					$('.insertComment').show();
					$('.CommentDisabled').hide();
				} else {
					$('.CommentDisabled').show();
					$('.insertComment').hide();
					document.getElementById("comment").disabled = true;
				}
			}
		});
	}
	get_info();
	fetch_comment();
	
	$(':input').focus(function(){
		$('.hint').hide();
		$(this).next().fadeIn();
	});
	
	$('#comment').keyup(function(){
		var left = 300 - $(this).val().length;
		$('#remainComm').text('Characters left: ' + left);
	});
	
 	$('#insert_comment').on("click", function(event) {
		event.preventDefault();
		if ($('#comment').val() == ""){
			alert ("Comment field is empty");
		} else {
			$.ajax({
				type: "POST",
				url: "includes/insertcomm.inc.php",
				data: $('#comment_form').serialize(),
				success: function(data){
					if(data == 1){
						$('#comment_form')[0].reset();
						$('#remainComm').hide();
						alert("Comment successful");
					} else {
						alert(data);
					}
					fetch_comment();
				}
			});
		}
	});
});
</script>