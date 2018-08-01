<?php
	include_once 'includes/dashheader.php';
?>

<section id = "parent-container">
	<div id = "setting-container">
		<div class = "box" style = "text-align: center;">
			</br>
			<img id = "img" src = "img/user/default.png"/>
			</br>
			<label id = "welcome"></label>
			</br>
			<hr>
			<div id = "calender"></div>
		</div>
		<div class = "box" style = "text-align: center;">
			<label>Announcements</label>
			<hr>
			<div id = "announcement"></div>
		</div>
		<div class = "box" style = "text-align: center;">
			<label>Related Sites</label>
			<hr>
			<a class="yt" href = "https://www.youtube.com/channel/UCWx2gfoCyIaYitDe2zbeBNQ/" target="_blank">
			<i class="fa fa-youtube-play" style = "margin-right: 10px;" aria-hidden="true"></i>Youtube</a>
			<a class="fb" href="https://www.facebook.com/groups/502398926776616" target="_blank">
			<i class="fa fa-facebook-square" style = "margin-right: 10px;" aria-hidden="true"></i>Facebook</a>
			</br></br>
		</div>
		<div class = "box" style = "text-align: center;">
			<a href ="https://goo.gl/forms/VP3XBuB5cAEkSVxa2" target="_blank"><img class = "surveyBanner" src = "img/surveyBanner.png"/></a>
		</div>
	</div>
</section>

</div>
</body>
</html>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113639948-2"></script>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-113639948-2');

$(document).ready(function(){
	function fetch_data(){
		var user_ID = "<?php echo $_SESSION['user_ID']; ?>";
		$.ajax({
			url: "includes/selectuser.inc.php",
			method: "POST",
			data: {user_ID:user_ID},
			dataType:"json",
			success: function(data){
				document.getElementById("img").src="img/user/"+data.User_Img;
				$('#welcome').text("Welcome, "+data.Username+"!");
			}
		});
	}
	
	function fetch_ann(){
		$.ajax({
			url: "includes/fetchann.inc.php",
			method: "POST",
			success: function(data){
				$('#announcement').html(data);
			}
		});
	}
	
	function fetch_calender(){
		$.ajax({
			url: "includes/calender.inc.php",
			success: function(data){
				$('#calender').html(data);
			}
		});
	}
	fetch_data();
	fetch_ann();
	fetch_calender();
});
</script>