<?php 
if( $user = selectDB2("`wallet`","users","`id` = '{$_GET["userId"]}' " ) ){
	echo outputData($user[0]);
}else{
	$error["msg"] = popupMsg($requestLang,"No user with this id","لا يوجد مستخدم بهذا الرقم");
	echo outputError($error);die();
}
?>