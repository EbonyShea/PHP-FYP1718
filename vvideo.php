<?php
	include_once 'includes/dashheader.php';
?>

<section id = "parent-container">
	<div class = "content-container">
		<div id = "displayVideo">
			<a class = "btn btn-info" href = "video.php">Return</a>
			<div class = "videoDetails">
				<label id = "videoTitle"></label>
				<div id = "videoDesc"></div>
			</div>
			<div class = "video-container">
				<iframe id = "vid" width="560" height="315" src="" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>
			</div>
			<div id = "videoTrans"></div>
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
	function get_info(){	
		var url_string = window.location.href
		var url = new URL(url_string);
		var video_ID = url.searchParams.get("id");
		if(video_ID == null){
			window.location.replace("video.php");
		} else {
			$.ajax({
				method: "POST",
				url: "includes/selectvideo2.inc.php",
				data: {video_ID:video_ID},
				dataType:"json",
				success: function(data){
					$('#videoTitle').text(data.Video_Title);
					$('#videoDesc').text(data.Video_Desc);
					$('#videoTrans').text(data.xml_text);
					document.getElementById("vid").src="https://www.youtube.com/embed/"+data.Video_URL;
				}
			});
		}
	}
	get_info();
});
</script>