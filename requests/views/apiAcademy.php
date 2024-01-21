<?php 
if( !isset($_GET["academyId"]) || empty($_GET["academyId"]) ){
	$response = array("msg"=>"Please set academy id");
	echo outputError($response);die();
}else{
	if( $academy = selectDB2("`id`, `imageurl`, `enTitle`, `arTitle`, `area`, `video`, `location`, `isClothes`, `clothesPrice`, `clothesImage`, `locationImage`","academies","`hidden` = '0' AND `status` = '0' AND `id` = {$_GET["academyId"]}") ){
		$response["academy"] = $academy[0];
		$response["academy"]["video"] = "https://www.youtube.com/embed/{$academy[0]["video"]}";
		if( $area = selectDB("countries","`id` = '{$academy[0]["area"]}'") ){
			$response["academy"]["enArea"] = $area[0]["areaEnTitle"];
			$response["academy"]["arArea"] = $area[0]["areaArTitle"];
		}else{
			$response["academy"]["enArea"] = "";
			$response["academy"]["arArea"] = "";
		}
		if( $sessions = selectDB2("`id`, `enTitle`, `arTitle`, `quantity`","sessions","`academyId` = '{$academy[0]["id"]}' AND `status` = '0' AND `hidden` = '0'") ){
			$response["academy"]["sessions"] = $sessions;
		}else{
			$response["academy"]["sessions"] = array();
		}
		if( $subscriptions = selectDB2("`id`, `enTitle`, `arTitle`, `price`, `priceAfterDiscount`","subscriptions","`academyId` = '{$academy[0]["id"]}'  AND `status` = '0' AND `hidden` = '0' ORDER BY `price` ASC") ){
			$response["academy"]["subscriptions"] = $subscriptions;
		}else{
			$response["academy"]["subscriptions"] = array();
		}
		$response["academy"]["rating"] = 0;
	}else{
		$response["msg"] = popupMsg($requestLang,"there is no academy with this id","لا يوجد اكادمية بهذا الرقم");
		echo outputError($response);die();
	}
}

echo outputData($response);
?>