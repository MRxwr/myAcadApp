<?php 
if( $settings = selectDB2("`version`, `enTerms`, `arTerms`, `enPolicy`, `arPolicy`","settings","`id` = '1'" ) ){
	if( $social = selectDB2("`whatsapp`, `instagram`, `tiktok`, `snapchat`, `location`, `email`","social_media","`id` = '1'") ){
		$response["social"] = $social[0];
	}
	$response["settings"] = $settings[0];
	echo outputData($response);
}else{
	$error = array("msg"=>"Error while loading settings info");
	echo outputError($error);die();
}
?>