<?php 
if( !isset($_GET["fieldId"]) || empty($_GET["fieldId"]) ){
	$response = array("msg"=>"Please set field id");
	echo outputError($response);die();
}

if( !isset($_GET["date"]) || empty($_GET["date"]) ){
	$response = array("msg"=>"Please set date");
	echo outputError($response);die();
}

if( !isset($_GET["periodId"]) || empty($_GET["periodId"]) ){
	$response = array("msg"=>"Please set period id");
	echo outputError($response);die();
}

$fieldId = intval($_GET["fieldId"]);
$date = $_GET["date"];
$periodId = intval($_GET["periodId"]);

// Get day of week from date (0 = Sunday, 6 = Saturday)
$dayOfWeek = date('w', strtotime($date));

// Get field times for this day
$fieldTimes = selectDB("field_times", "`fieldId` = '{$fieldId}' AND `day` = '{$dayOfWeek}' AND `status` = '0' AND `hidden` = '0'");

if( !$fieldTimes ){
	$response = array("msg"=>popupMsg($requestLang,"No working hours for this day","لا توجد ساعات عمل في هذا اليوم"));
	echo outputError($response);die();
}

// Get period details
$period = selectDB("field_periods", "`id` = '{$periodId}' AND `fieldId` = '{$fieldId}' AND `status` = '0' AND `hidden` = '0'");

if( !$period ){
	$response = array("msg"=>popupMsg($requestLang,"Invalid period","فترة غير صالحة"));
	echo outputError($response);die();
}

$periodMinutes = intval($period[0]["period"]);
$openTime = $fieldTimes[0]["openTime"];
$closeTime = $fieldTimes[0]["closeTime"];

// Generate all time slots
$response["timeSlots"] = array();
$currentTime = strtotime($openTime);
$endTime = strtotime($closeTime);

while( $currentTime < $endTime ){
	$slotStart = date('H:i:s', $currentTime);
	$slotEnd = date('H:i:s', $currentTime + ($periodMinutes * 60));
	
	// Don't add slot if it extends beyond closing time
	if( strtotime($slotEnd) > $endTime ){
		break;
	}
	
	// Check if this slot is already booked
	$booking = selectDB("bookings", "`fieldId` = '{$fieldId}' AND `date` = '{$date}' AND `startTime` = '{$slotStart}' AND `status` = '0'");
	
	$isAvailable = empty($booking);
	
	$response["timeSlots"][] = array(
		"startTime" => $slotStart,
		"endTime" => $slotEnd,
		"isAvailable" => $isAvailable
	);
	
	$currentTime += ($periodMinutes * 60);
}

echo outputData($response);
?>
