<?php
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$output = '';
	
	$output .= '<div class="month"> 
					<ul>
						<li>'.date('F').'<br><span style="font-size:18px">'.date('Y').'</span></li>
					</ul>
				</div>
				<ul class="weekdays">
					<li>Mo</li>
					<li>Tu</li>
					<li>We</li>
					<li>Th</li>
					<li>Fr</li>
					<li>Sa</li>
					<li>Su</li>
				</ul>
				<ul class="days">';
	for ($i = 1; $i < date('t')+1; $i++){
		if($i != date('d')){
			$output .= '<li>'.$i.'</li>';
		} else {
			$output .= '<li><span class="active">'.$i.'</span></li>';
		}
	}
	$output .= '</div>
		</div>';
	echo $output;
?>