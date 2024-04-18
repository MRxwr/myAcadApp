<?php
require ("config.php");
require ("translate.php");
require ("functions.php");
if ( isset($_COOKIE[$cookieSession."A"]) && !empty($_COOKIE[$cookieSession."A"]) ){
	session_start ();
	$svdva = $_COOKIE[$cookieSession."A"];
	if ( $user = selectDB("employees","`keepMeAlive` LIKE '%".$svdva."%' AND `status` = '0'") ){
		$userID = $user[0]["id"];
		$email = $user[0]["email"];
		$username = $user[0]["fullName"];
		$userType = $user[0]["empType"];
		$academiesList = ( is_array($user[0]["academyId"]) && empty($user[0]["academyId"]) ) ? array() : json_decode($user[0]["academyId"],true);
		$_SESSION[$cookieSession."A"] = $email;	
	}else{
		header("Location: logout.php");die();
	}
}else{
	header("Location: login.php");die();
}
?>