<?php
	include_once 'includes/dashheader.php';
?>

<section id = "parent-container">
	<div class = "content-container">
		<div id = "content-panel" class = "misc-color">
			<h1>Misc</h1>
			<input type = "text" id = "search" class = "d-search" placeholder = "Search..."></input>
		</div>
		<div id = "misc"></div>
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
	function displayMisc(keyword){
		var query = keyword;
		var data_type = "misc";
		$.ajax({
			method: "POST",
			url: "includes/displaymisc.inc.php",
			data: {query:query, data_type:data_type},
			success: function(data){
				$('#misc').html(data);
			}
		});
	}
	displayMisc('%');
	
	$('#search').keyup(function(){
		var query = $('#search').val();
		if(query != ''){
			displayMisc(query);
		} else {
			displayMisc('%');
		}
	});
});
</script>