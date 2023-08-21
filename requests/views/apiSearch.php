<?php 
if( !isset($_GET["sportId"]) || empty($_GET["sportId"]) ){
	$response = array("msg"=>"Please set sport id");
	echo outputError($response);die();
}else{
	$where = " AND `sport` = '{$_GET["sportId"]}'";
	if( isset($_GET["genderId"]) && !empty($_GET["genderId"]) ){
		$where .= " AND `gender` = '{$_GET["genderId"]}'";
	}
	if( isset($_GET["governateId"]) && !empty($_GET["governateId"]) ){
		$where .= " AND `governate` = '{$_GET["governateId"]}'";
	}
	if( isset($_GET["areaId"]) && !empty($_GET["areaId"]) ){
		$where .= " AND `area` = '{$_GET["areaId"]}'";
	}
	if( $academies = selectDB2("`id`, `imageurl`, `header`, `enTitle`, `arTitle`, `area`, `isPromotion`","academies","`hidden` = '0' AND `status` = '0' {$where}") ){
		for( $i = 0; $i < sizeof($academies); $i++){
			$response["academies"][$i] = $academies[$i];
			if( $area = selectDB("countries","`id` = '{$academies[$i]["area"]}'") ){
				$response["academies"][$i]["enArea"] = $area[0]["areaEnTitle"];
				$response["academies"][$i]["arArea"] = $area[0]["areaArTitle"];
			}else{
				$response["academies"][$i]["enArea"] = "";
				$response["academies"][$i]["arArea"] = "";
			}
			$response["academies"][$i]["rating"] = 0;
		}
	}else{
		$response["academies"] = array();
		echo outputError($response);die();
	}
}

echo outputData($response);
?>