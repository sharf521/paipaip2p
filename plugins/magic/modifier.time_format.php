<?php

function magic_modifier_time_format($time, $format = ''){
	$stime = time()-$time;
	if ($stime<60){
		$display = round($stime)."��ǰ";
	}elseif ($stime<60*60){
		$display = round($stime/60)."����ǰ";
	}elseif ($stime<60*60*24){
		$display = round($stime/3600)."Сʱǰ";
	}else{
		$display = round($stime/(3600*24))."��ǰ";
	}
	
	return $display;
	
}

?>
