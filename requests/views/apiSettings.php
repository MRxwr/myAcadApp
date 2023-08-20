<?php 
if( $settings = selectDB2("`version`, `enTerms`, `arTerms`, `enPolicy`, `arPolicy`","settings","`id` != '0'" ) ){
	echo outputData($settings[0]);
}else{
	$error = array("msg"=>"Error while loading settings info");
	echo outputError($error);die();
}
?>