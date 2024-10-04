<?php
session_start ();
require("../../admin/includes/config.php");
require("../../admin/includes/functions.php");
require("../../admin/includes/translate.php");
if( $employee = selectDBNew("employees",[$_POST["email"],sha1($_POST["password"])],"`email` LIKE ? AND `password` LIKE ? AND `hidden` != '1' AND `status` = '0'","") ){
	$GenerateNewCC = md5(rand());
	if( updateDB("employees",array("keepMeAlive"=>$GenerateNewCC),"`id` = '{$employee[0]["id"]}'") ){
		$_SESSION[$cookieSession."C"] = $email;
		header("Location: ../index.php");
		setcookie($cookieSession."C", $GenerateNewCC, time() + (86400*30 ), "/");die();
	}
}else{
	header("Location: ../login.php?error=p");die();
}
?>