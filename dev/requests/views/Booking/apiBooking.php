<?php 
if( !isset($_GET["fieldId"]) || empty($_GET["fieldId"]) ){
	$response = array("msg"=>"Please set field id");
	echo outputError($response);die();
}else{
	if( $field = selectDB2("`id`, `imageurl`, `enTitle`, `arTitle`, `area`, `video`, `location`, `price`, `locationImage`, `enTerms`, `arTerms`, `gameDate`, `gameTime`, `fieldsIds`","fields_list","`hidden` = '0' AND `status` = '0' AND `id` = {$_GET["fieldId"]}") ){
		$response["field"] = $field[0];
		$response["field"]["video"] = ( !empty($response["field"]["video"]) ) ? "https://www.youtube.com/embed/{$field[0]["video"]}" : "";
        $fieldsToBeFilled = json_decode( $field[0]["fieldsIds"], true );
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