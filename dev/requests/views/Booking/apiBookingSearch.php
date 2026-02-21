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
	if( $events = selectDB2("`id`, `imageurl`, (CASE WHEN JSON_VALID(`header`) THEN JSON_UNQUOTE(JSON_EXTRACT(`header`, '$[0]')) ELSE `header` END) as `header`, `enTitle`, `arTitle`, `area`, `price`, `isIndoor`","fields_list","`hidden` = '0' AND `status` = '0' {$where}") ){
		for( $i = 0; $i < sizeof($events); $i++){
			$response["fields"][$i] = $events[$i];
			if( $area = selectDB("countries","`id` = '{$events[$i]["area"]}'") ){
				$response["fields"][$i]["enArea"] = $area[0]["areaEnTitle"];
				$response["fields"][$i]["arArea"] = $area[0]["areaArTitle"];
			}else{
				$response["fields"][$i]["enArea"] = "";
				$response["fields"][$i]["arArea"] = "";
			}
		}
	}else{
		$response["msg"] = popupMsg($requestLang,"No fields found","لا يوجد ملاعب");
		$response["fields"] = array();
		echo outputError($response);die();
	}
}

echo outputData($response);
?>