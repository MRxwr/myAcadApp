<?php 
if( !isset($_GET["academyId"]) || empty($_GET["academyId"]) ){
	$response = array("msg"=>"Please set academy id");
	echo outputError($response);die();
}else{
	if( $academy = selectDB2("`id`, `imageurl`, `enTitle`, `arTitle`, `area`, `video`, `location`, `isClothes`, `clothesPrice`, `clothesImage`","academies","`hidden` = '0' AND `status` = '0' AND `id` = {$_GET["academyId"]}") ){
		$response["academy"] = $academy;
		if( $area = selectDB("countries","`id` = '{$academies[0]["area"]}'") ){
			$response["academy"]["enArea"] = $area[0]["areaEnTitle"];
			$response["academy"]["arArea"] = $area[0]["areaArTitle"];
		}else{
			$response["academy"]["enArea"] = "";
			$response["academy"]["arArea"] = "";
		}
		if( $sessions = selectDB("sessions","`academyId` = '{$academies[0]["area"]}'") ){
			$response["sessions"] = $sessions;
		}else{
			$response["sessions"] = array();
		}
		if( $subscriptions = selectDB("subscriptions","`academyId` = '{$academies[0]["area"]}'") ){
			$response["subscriptions"] = $subscriptions;
		}else{
			$response["subscriptions"] = array();
		}
	}else{
		$response["msg"] = "there is no academy with this id";
		echo outputError($response);die();
	}
}

echo outputData($response);
?>