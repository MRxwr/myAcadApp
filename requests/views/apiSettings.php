<?php 
if( $settings = selectDB("settings","`id` != '0'" ) ){
	echo outputData($settings[0]);
}else{
	$error = array("msg"=>"Error while loading settings info");
	echo outputError($error);die();
}
?>