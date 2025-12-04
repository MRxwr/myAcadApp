<?php 
if( !isset($_GET["eventId"]) || empty($_GET["eventId"]) ){
	$response = array("msg"=>"Please set event id");
	echo outputError($response);die();
}else{
	if( $event = selectDB2("`id`, `imageurl`, `enTitle`, `arTitle`, `area`, `video`, `location`, `price`, `locationImage`, `enTerms`, `arTerms`, `gameDate`, `gameTime`","tabs_list","`hidden` = '0' AND `status` = '0' AND `id` = {$_GET["eventId"]}") ){
		$response["event"] = $event[0];
		$response["event"]["video"] = ( !empty($response["event"]["video"]) ) ? "https://www.youtube.com/embed/{$event[0]["video"]}" : "";
		if( $area = selectDB("countries","`id` = '{$event[0]["area"]}'") ){
			$response["event"]["enArea"] = $area[0]["areaEnTitle"];
			$response["event"]["arArea"] = $area[0]["areaArTitle"];
		}else{
			$response["event"]["enArea"] = "";
			$response["event"]["arArea"] = "";
		}
	}else{
		$response["msg"] = popupMsg($requestLang,"there is no event with this id","لا يوجد حدث بهذا الرقم");
		echo outputError($response);die();
	}
}

echo outputData($response);
?>