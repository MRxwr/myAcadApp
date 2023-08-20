<?php 
if( $settings = selectDB2("`version`, `enTerms`, `arTerms`, `enPolicy`, `arPolicy`","settings","`id` != '0'" ) && $social = selectDB2("`whatsapp`, `instagram`, `tiktok`, `snapchat`, `location`, `email`","social_media","`id` = '1'") ){
	$settings[0]["social"] = $social[0];
	echo outputData($settings[0]);
}else{
	$error = array("msg"=>"Error while loading settings info");
	echo outputError($error);die();
}
?>