<?php 
if( $settings = selectDB2("`version`, `enTerms`, `arTerms`, `enPolicy`, `arPolicy`","settings","`id` = '1'" ) ){
	if( $social = selectDB2("`youtube`,`whatsapp`, `instagram`, `tiktok`, `snapchat`, `location`, `email`","social_media","`id` = '1'") ){
		$response["social"]["youtube"] = "https://youtube.com/{$social[0]["youtube"]}";
		$response["social"]["whatsapp"] = "https://wa.me/{$social[0]["whatsapp"]}";
		$response["social"]["instagram"] = "https://instagram.com/{$social[0]["instagram"]}";
		$response["social"]["tiktok"] = $social[0]["tiktok"];
		$response["social"]["snapchat"] = $social[0]["snapchat"];
		$response["social"]["location"] = $social[0]["location"];
		$response["social"]["email"] = $social[0]["email"];
	}
	$response["settings"] = $settings[0];
	echo outputData($response);
}else{
	$error = array("msg"=>"Error while loading settings info");
	echo outputError($error);die();
}
?>