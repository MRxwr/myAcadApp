<?php 
if( !isset($_GET["fieldId"]) || empty($_GET["fieldId"]) ){
	$response = array("msg"=>"Please set field id");
	echo outputError($response);die();
}else{
	if( $field = selectDB2("`id`, `imageurl`, `enTitle`, `arTitle`, `area`, `video`, `location`, `price`, `locationImage`, `enTerms`, `arTerms`, `openDate`, `closeDate`, `facilitiesIds`","fields_list","`hidden` = '0' AND `status` = '0' AND `id` = {$_GET["fieldId"]}") ){
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
                        "icon" => $facility["icon"]
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
		
		// Get field times
		$response["field"]["times"] = array();
		if( $times = selectDB("field_times","`fieldId` = '{$_GET["fieldId"]}' AND `status` = '0' AND `hidden` = '0'") ){
			foreach( $times as $time ){
				$dayNames = array(
					direction("Sunday","الأحد"),
					direction("Monday","الإثنين"),
					direction("Tuesday","الثلاثاء"),
					direction("Wednesday","الأربعاء"),
					direction("Thursday","الخميس"),
					direction("Friday","الجمعة"),
					direction("Saturday","السبت")
				);
				$response["field"]["times"][] = array(
					"id" => $time["id"],
					"day" => $time["day"],
					"dayName" => $dayNames[$time["day"]],
					"openTime" => $time["openTime"],
					"closeTime" => $time["closeTime"]
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
	}else{
		$response["msg"] = popupMsg($requestLang,"there is no field with this id","لا يوجد ملعب بهذا الرقم");
		echo outputError($response);die();
	}
}

echo outputData($response);
?>