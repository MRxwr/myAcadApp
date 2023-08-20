<?php 
if( 
( isset($_POST["title"]) && !empty($_POST["title"]) ) &&
( isset($_POST["email"]) && !empty($_POST["email"]) ) &&
( isset($_POST["phone"]) && !empty($_POST["phone"]) ) &&
( isset($_POST["message"]) && !empty($_POST["message"]) ) &&
insertDB("contact_us",$_POST) 
){
	$response["msg"] = "message sent successfully";
	echo outputData($response);
}else{
	$error = array("msg"=>"Error while sending you message please try again.");
	echo outputError($error);die();
}
?>