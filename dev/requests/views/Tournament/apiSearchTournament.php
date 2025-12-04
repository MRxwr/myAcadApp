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
	if( isset($_GET["keyword"]) && !empty($_GET["keyword"]) ){
		$where .= " AND ( `enTitle` LIKE '%".$_GET["keyword"]."%' OR `arTitle` LIKE '%".$_GET["keyword"]."%')";
	}
	if( isset($_GET["countryCode"]) && !empty($_GET["countryCode"]) ){
		$where .= " AND `country` = '{$_GET["countryCode"]}'";
	}else{
		$where .= " AND `country` = 'KW'";
	}
	if( $tournaments = selectDB2("`id`, `imageurl`, `header`, `enTitle`, `arTitle`, `area`, `price`, `isIndoor`","tournaments","`hidden` = '0' AND `status` = '0' {$where}") ){
		for( $i = 0; $i < sizeof($tournaments); $i++){
			$response["tournaments"][$i] = $tournaments[$i];
			if( $area = selectDB("countries","`id` = '{$tournaments[$i]["area"]}'") ){
				$response["tournaments"][$i]["enArea"] = $area[0]["areaEnTitle"];
				$response["tournaments"][$i]["arArea"] = $area[0]["areaArTitle"];
			}else{
				$response["tournaments"][$i]["enArea"] = "";
				$response["tournaments"][$i]["arArea"] = "";
			}
		}
	}else{
		$response["msg"] = popupMsg($requestLang,"No tournaments found","لا يوجد بطولات");
		$response["tournaments"] = array();
		echo outputError($response);die();
	}
}

echo outputData($response);
?>