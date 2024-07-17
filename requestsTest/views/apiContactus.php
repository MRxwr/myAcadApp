<?php 
if( 
( isset($_POST["title"]) && !empty($_POST["title"]) ) &&
( isset($_POST["email"]) && !empty($_POST["email"]) ) &&
( isset($_POST["phone"]) && !empty($_POST["phone"]) ) &&
( isset($_POST["message"]) && !empty($_POST["message"]) ) &&
insertDB("contact_us",$_POST) 
){
	$response["msg"] = popupMsg($requestLang,"message sent successfully","تم ارسال الرسالة بنجاح");
	echo outputData($response);
}else{
	$response["msg"] = popupMsg($requestLang,"Error while sending you message please try again.","خطأ في ارسال رسالتك الرجاء المحاولة مرة اخرى");
	echo outputError($response);die();
}
?>