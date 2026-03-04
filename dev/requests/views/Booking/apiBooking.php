<?php 
if( !isset($_GET["fieldId"]) || empty($_GET["fieldId"]) ){
	$response = array("msg"=>"Please set field id");
	echo outputError($response);die();
}else{
	if( $field = selectDB2("`id`, `imageurl`, `enTitle`, `arTitle`, `area`, `video`, `location`, `price`, `locationImage`, `enTerms`, `arTerms`, `openDate`, `closeDate`, `facilitiesIds`, `header`","fields_list","`hidden` = '0' AND `status` = '0' AND `id` = {$_GET["fieldId"]}") ){
		$header = json_decode($field[0]["header"], true);
		if( is_array($header) ){
			$field[0]["header"] = $header;
		}else{
			$field[0]["header"] = ( !empty($field[0]["header"]) ) ? [$field[0]["header"]] : [];
		}
		$response["field"] = $field[0];
		$response["field"]["video"] = ( !empty($response["field"]["video"]) ) ? "https://www.youtube.com/embed/{$field[0]["video"]}" : "";
        $facilities = json_decode( $field[0]["facilitiesIds"], true );
        unset( $response["field"]["facilitiesIds"] );
        $response["field"]["facilities"] = array();
        if( !empty( $facilities ) && is_array( $facilities ) ){
            $facilityIds = implode(',', array_map('intval', $facilities));
            if( $facilitiesList = selectDB("field_facilities","`id` IN ({$facilityIds}) AND `status` = '0'") ){
                foreach( $facilitiesList as $facility ){
                    $response["field"]["facilities"][] = array(
                        "id" => $facility["id"],
                        "enTitle" => $facility["enTitle"],
                        "arTitle" => $facility["arTitle"],
                        "icon" => "facilities/".$facility["icon"]
                    );
                }
            }
        }
		
		// Get field periods
		$response["field"]["periods"] = array();
		if( $periods = selectDB("field_periods","`fieldId` = '{$_GET["fieldId"]}' AND `status` = '0' AND `hidden` = '0'") ){
			foreach( $periods as $period ){
				$response["field"]["periods"][] = array(
					"id" => $period["id"],
					"enTitle" => $period["enTitle"],
					"arTitle" => $period["arTitle"],
					"period" => $period["period"]
				);
			}
		}
		
		if( $area = selectDB("countries","`id` = '{$field[0]["area"]}'") ){
			$response["field"]["enArea"] = $area[0]["areaEnTitle"];
			$response["field"]["arArea"] = $area[0]["areaArTitle"];
		}else{
			$response["field"]["enArea"] = "";
			$response["field"]["arArea"] = "";
		}

		// Calculate fully booked dates (blocked dates)
		$response["field"]["blockedDates"] = array();
		if (!empty($field[0]["openDate"]) && !empty($field[0]["closeDate"])) {
			$startDate = new DateTime($field[0]["openDate"]);
			$endDate = new DateTime($field[0]["closeDate"]);
			$interval = new DateInterval('P1D');
			$dateRange = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

			foreach ($dateRange as $dateObj) {
				$checkDate = $dateObj->format('Y-m-d');
				$dayOfWeek = date('w', strtotime($checkDate));

				// Check if field has working hours on this day
				$fieldTimes = selectDB("field_times", "`fieldId` = '{$_GET["fieldId"]}' AND `day` = '{$dayOfWeek}' AND `status` = '0' AND `hidden` = '0'");
				if (!$fieldTimes) {
					continue;
				}

				// Check available periods for the field
				$fieldPeriods = selectDB("field_periods", "`fieldId` = '{$_GET["fieldId"]}' AND `status` = '0' AND `hidden` = '0'");
				if (!$fieldPeriods) {
					continue;
				}

				$isFullyBooked = true;
				foreach ($fieldPeriods as $period) {
					$periodMinutes = intval($period["period"]);
					$openTime = $fieldTimes[0]["openTime"];
					$closeTime = $fieldTimes[0]["closeTime"];

					$currentTime = strtotime($openTime);
					$endTime = strtotime($closeTime);
					if ($endTime <= $currentTime) {
						$endTime += 86400; // Next day
					}

					while ($currentTime < $endTime) {
						$slotStart = date('H:i:s', $currentTime);
						$slotEnd = date('H:i:s', $currentTime + ($periodMinutes * 60));

						if (strtotime($slotEnd) > $endTime) {
							break;
						}

						// Check if this specific slot is available
						$booking = selectDB("fields_booking", "`fieldId` = '{$_GET["fieldId"]}' AND `bookingDate` = '{$checkDate}' AND `startTime` = '{$slotStart}' AND `status` IN ('0','1','2') AND `hidden` = '0'");
						if (empty($booking)) {
							$isFullyBooked = false;
							break 2; // Not fully booked for this date
						}
						$currentTime += ($periodMinutes * 60);
					}
				}

				if ($isFullyBooked) {
					$response["field"]["blockedDates"][] = $checkDate;
				}
			}
		}
	}else{
		$response["msg"] = popupMsg($requestLang,"there is no field with this id","لا يوجد ملعب بهذا الرقم");
		echo outputError($response);die();
	}
}

echo outputData($response);
?>