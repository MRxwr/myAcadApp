<?php
date_default_timezone_set("Asia/Kuwait");
if (!isset($_GET["fieldId"]) || empty($_GET["fieldId"])) {
	$response = array("msg" => "Please set field id");
	echo outputError($response);
	die();
}

if (!isset($_GET["date"]) || empty($_GET["date"])) {
	$response = array("msg" => "Please set date");
	echo outputError($response);
	die();
}

// Validate date format (YYYY-MM-DD)
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET["date"])) {
	$response = array("msg" => "Invalid date format. Use YYYY-MM-DD (e.g., 2025-12-16)");
	echo outputError($response);
	die();
}



if (!isset($_GET["periodId"]) || empty($_GET["periodId"])) {
	$response = array("msg" => "Please set period id");
	echo outputError($response);
	die();
}

// Get client/device current time (timestamp)
if (!isset($_GET["currentTime"]) || empty($_GET["currentTime"])) {
	$response = array("msg" => "Please set current device time (timestamp)");
	echo outputError($response);
	die();
}
$fieldId = intval($_GET["fieldId"]);
$date = $_GET["date"];
$periodId = intval($_GET["periodId"]);

// Use server time as the absolute source of truth to prevent spoofing
// and ensure the 15 vs 17 timezone discrepancy is resolved.
$serverNow = time();
$serverToday = date('Y-m-d');
$isToday = ($date === $serverToday);

// Validate date is today or in the future (based on actual server date)
if ($date < $serverToday) {
	$response = array("msg" => popupMsg($requestLang, "Date must be today or in the future", "يجب أن يكون التاريخ اليوم أو في المستقبل"));
	echo outputError($response);
	die();
}

// Get day of week from date (0 = Sunday, 6 = Saturday)
$dayOfWeek = date('w', strtotime($date));

// Get field times for this day
$fieldTimes = selectDB("field_times", "`fieldId` = '{$fieldId}' AND `day` = '{$dayOfWeek}' AND `status` = '0' AND `hidden` = '0'");

if (!$fieldTimes) {
	$response = array("msg" => popupMsg($requestLang, "No working hours for this day", "لا توجد ساعات عمل في هذا اليوم"));
	echo outputError($response);
	die();
}

// Get period details
$period = selectDB("field_periods", "`id` = '{$periodId}' AND `fieldId` = '{$fieldId}' AND `status` = '0' AND `hidden` = '0'");

if (!$period) {
	$response = array("msg" => popupMsg($requestLang, "Invalid period", "فترة غير صالحة"));
	echo outputError($response);
	die();
}

$periodMinutes = intval($period[0]["period"]);
$openTime = $fieldTimes[0]["openTime"];
$closeTime = $fieldTimes[0]["closeTime"];

// Generate all time slots
$response["timeSlots"] = array();
$currentTime = strtotime($openTime);
$endTime = strtotime($closeTime);

// If closeTime is earlier than openTime (e.g., 00:00:00), it means next day
if ($endTime <= $currentTime) {
	$endTime += 86400; // Add 24 hours
}

while ($currentTime < $endTime) {
	$slotStart = date('H:i:s', $currentTime);
	$slotEnd = date('H:i:s', $currentTime + ($periodMinutes * 60));

	// Don't add slot if it extends beyond closing time
	if (strtotime($slotEnd) > $endTime) {
		break;
	}

	// If booking is for today, check if slot is at least 2 hours from now
	$isAvailable = true;
	if ($isToday) {
		// Get current hour and minute from server
		$serverHour = date('G', $serverNow);
		$serverMinute = date('i', $serverNow);
		$serverSecondsSinceMidnight = ($serverHour * 3600) + ($serverMinute * 60);

		// Get slot's hour and minute
		$slotParts = explode(':', $slotStart);
		$slotHour = intval($slotParts[0]);
		$slotMinute = intval($slotParts[1]);
		$slotSecondsSinceMidnight = ($slotHour * 3600) + ($slotMinute * 60);

		// Check if slot is at least 2 hours (7200 seconds) from server time
		$timeDifference = $slotSecondsSinceMidnight - $serverSecondsSinceMidnight;
		if ($timeDifference < 7200) {
			$isAvailable = false;
		}
	}

	// Check if this slot is already booked (only if initially available)
	if ($isAvailable) {
		$booking = selectDB("fields_booking", "`fieldId` = '{$fieldId}' AND `bookingDate` = '{$date}' AND `startTime` = '{$slotStart}' AND `status` IN ('0','1','2') AND `hidden` = '0'");
		$isAvailable = empty($booking);
	}

	$response["timeSlots"][] = array(
		"startTime" => $slotStart,
		"endTime" => $slotEnd,
		"isAvailable" => $isAvailable
	);

	$currentTime += ($periodMinutes * 60);
}

echo outputData($response);
