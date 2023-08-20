<?php 
if( $user = selectDB2("`wallet`","users","`id` = '{$_GET["userId"]}' " ) ){
	echo outputData($user[0]);
}else{
	$error = array("msg"=>"No user with this id");
	echo outputError($error);die();
}
?>