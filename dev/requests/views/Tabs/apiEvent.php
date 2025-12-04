<?php 
if( !isset($_GET["eventId"]) || empty($_GET["eventId"]) ){
	$response = array("msg"=>"Please set event id");
	echo outputError($response);die();
}else{
	if( $event = selectDB2("`id`, `imageurl`, `enTitle`, `arTitle`, `area`, `video`, `location`, `price`, `locationImage`, `enTerms`, `arTerms`, `gameDate`, `gameTime`","tabs_list","`hidden` = '0' AND `status` = '0' AND `id` = {$_GET["eventId"]}") ){
		$response["event"] = $event[0];
		$response["event"]["video"] = ( !empty($response["event"]["video"]) ) ? "https://www.youtube.com/embed/{$event[0]["video"]}" : "";
        $feildsToBeFilled = json_decode( $event[0]["fieldsIds"], true );
		if( $area = selectDB("countries","`id` = '{$event[0]["area"]}'") ){
			$response["event"]["enArea"] = $area[0]["areaEnTitle"];
			$response["event"]["arArea"] = $area[0]["areaArTitle"];
		}else{
			$response["event"]["enArea"] = "";
			$response["event"]["arArea"] = "";
		}
        $response["event"]["fieldsToBeFilled"] = array();
        if( !empty( $feildsToBeFilled ) ){
            foreach( $feildsToBeFilled as $fieldId ){
                if( $field = selectDB("tabs_fields","`id` = '{$fieldId}'") ){
                    $response["event"]["fieldsToBeFilled"][] = array(
                        "id" => $field[0]["id"],
                        "enTitle" => $field[0]["enTitle"],
                        "arTitle" => $field[0]["arTitle"],
                        "type" => $field[0]["type"],
                        "options" => json_decode( $field[0]["options"], true )
                    );
                }
            }
        }
	}else{
		$response["msg"] = popupMsg($requestLang,"there is no event with this id","لا يوجد حدث بهذا الرقم");
		echo outputError($response);die();
	}
}

echo outputData($response);
?>