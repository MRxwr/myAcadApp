<?php 
if( !isset($_GET["academyId"]) || empty($_GET["academyId"]) ){
	$response = array("msg"=>"Please set academy id");
	echo outputError($response);die();
}else{
	if( $academy = selectDB2("`id`, `imageurl`, `enTitle`, `arTitle`, `area`, `video`, `location`, `isClothes`, `clothesPrice`, `clothesImage`","academies","`hidden` = '0' AND `status` = '0' AND `id` = {$_GET["academyId"]}") ){
		$response["academy"] = $academy[0];
		if( $area = selectDB("countries","`id` = '{$academy[0]["area"]}'") ){
			$response["academy"]["enArea"] = $area[0]["areaEnTitle"];
			$response["academy"]["arArea"] = $area[0]["areaArTitle"];
		}else{
			$response["academy"]["enArea"] = "";
			$response["academy"]["arArea"] = "";
		}
		if( $sessions = selectDB2("`id`, `enTitle`, `arTitle`","sessions","`academyId` = '{$academy[0]["id"]}'") ){
			$response["academy"]["sessions"] = $sessions;
		}else{
			$response["academy"]["sessions"] = array();
		}
		if( $subscriptions = selectDB2("`id`, `enTitle`, `arTitle`, `price`, `priceAfterDiscount`","subscriptions","`academyId` = '{$academy[0]["id"]}'") ){
			$response["academy"]["subscriptions"] = $subscriptions;
		}else{
			$response["academy"]["subscriptions"] = array();
		}
	}else{
		$response["msg"] = "there is no academy with this id";
		echo outputError($response);die();
	}
}

echo outputData($response);
?>