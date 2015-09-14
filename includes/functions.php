<?php 
function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function output_message($message = ""){
	if(!empty($message)){
		return "<p class=\"message\">{$message}</p>";
	} else {
		return "";
	}
}

function days_left($date1, $date2){	
$date_diff=(strtotime($date1)-strtotime($date2)) / 86400;
if($date_diff > 0) {
	echo " Days left: " . round($date_diff);
} else {
	echo " Days overdue: " . abs(round($date_diff));
	}
}