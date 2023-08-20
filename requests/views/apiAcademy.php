<?php 
if( !isset($_GET["academyId"]) || empty($_GET["academyId"]) ){
	$response = array("msg"=>"Please set sport id");
	echo outputError($response);die();
}else{
	if( $academy = selectDB2("`id`, `imageurl`, `enTitle`, `arTitle`, `area`, `video`, `location`, `isClothes`, `clothesPrice`, `clothesImage`","academies","`hidden` = '0' AND `status` = '0' AND `id` = {$_GET["academyId"]}") ){
		$response["academy"][0] = $academy[$i];
		if( $area = selectDB("countries","`id` = '{$academies[0]["area"]}'") ){
			$response["academy"][0]["enArea"] = $area[0]["areaEnTitle"];
			$response["academy"][0]["arArea"] = $area[0]["areaArTitle"];
		}else{
			$response["academy"][0]["enArea"] = "";
			$response["academy"][0]["arArea"] = "";
		}
		if( $sessions = selectDB("sessions","`academyId` = '{$academies[0]["area"]}'") ){
			$response["sessions"][0] = $sessions;
		}else{
			$response["sessions"][0] = array();
		}
		if( $subscriptions = selectDB("subscriptions","`academyId` = '{$academies[0]["area"]}'") ){
			$response["subscriptions"][0] = $subscriptions;
		}else{
			$response["subscriptions"][0] = array();
		}
	}else{
		$response["msg"] = "there is no academy with this id";
		echo outputError($response);die();
	}
}

echo outputData($response);
?>