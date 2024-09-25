<?php 
if( !isset($_GET["tournamentId"]) || empty($_GET["tournamentId"]) ){
	$response = array("msg"=>"Please set tournament id");
	echo outputError($response);die();
}else{
	if( $tournament = selectDB2("`id`, `imageurl`, `enTitle`, `arTitle`, `area`, `video`, `location`, `price`, `players`, `bench`, `locationImage`, `enTerms`, `arTerms`","tournaments","`hidden` = '0' AND `status` = '0' AND `id` = {$_GET["tournamentId"]}") ){
		$response["tournament"] = $tournament[0];
		$response["tournament"]["video"] = "https://www.youtube.com/embed/{$tournament[0]["video"]}";
		if( $area = selectDB("countries","`id` = '{$tournament[0]["area"]}'") ){
			$response["tournament"]["enArea"] = $area[0]["areaEnTitle"];
			$response["tournament"]["arArea"] = $area[0]["areaArTitle"];
		}else{
			$response["tournament"]["enArea"] = "";
			$response["tournament"]["arArea"] = "";
		}
	}else{
		$response["msg"] = popupMsg($requestLang,"there is no tournament with this id","لا يوجد بطولة بهذا الرقم");
		echo outputError($response);die();
	}
}

echo outputData($response);
?>