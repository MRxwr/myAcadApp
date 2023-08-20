<?php 
if( !isset($_GET["sportId"]) && empty($_GET["sportId"]) ){
	$response = array("msg"=>"Please set sport id");
	echo outputError($response);die();
}else{
	if( isset($_GET["genderId"]) && !empty($_GET["genderId"]) ){
		
	}
	if( isset($_GET["governateId"]) && !empty($_GET["governateId"]) ){
		
	}
	if( isset($_GET["areaId"]) && !empty($_GET["areaId"]) ){
		
	}
	if( $academies = selectDB("academies","`hidden` = '0' AND `status` = '0'") ){
		$response["academies"] = $academies;
	}else{
		$response["academies"] = array();
		echo outputError($response);die();
	}
}

echo outputData($response);
?>