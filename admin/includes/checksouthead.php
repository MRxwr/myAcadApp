<?php
require ("config.php");
require ("translate.php");
require ("functions.php");
$allowedEmpolyees = array(0,8);
if ( isset($_COOKIE[$cookieSession."A"]) && !empty($_COOKIE[$cookieSession."A"]) ){
	session_start ();
	$svdva = $_COOKIE[$cookieSession."A"];
	if ( $user = selectDBNew("employees",[$svdva],"`keepMeAlive` LIKE ? AND `status` = '0'","") ){
		$userID = $user[0]["id"];
		$email = $user[0]["email"];
		$username = $user[0]["fullName"];
		$userType = ( $user[0]["empType"] == 16 || $user[0]["empType"] == 19 ) ? 0 : $user[0]["empType"];
		$academiesList = ( is_array($user[0]["academyId"]) && empty($user[0]["academyId"]) ) ? array() : json_decode($user[0]["academyId"],true);
		$tournamentsList = ( is_array($user[0]["tournamentId"]) && empty($user[0]["tournamentId"]) ) ? array() : json_decode($user[0]["tournamentId"],true);
		$eventsList = ( is_array($user[0]["eventId"]) && empty($user[0]["eventId"]) ) ? array() : json_decode($user[0]["eventId"],true);
		$fieldsList = ( is_array($user[0]["fieldId"]) && empty($user[0]["fieldId"]) ) ? array() : json_decode($user[0]["fieldId"],true);
		$_SESSION[$cookieSession."A"] = $email;	
		$isTournamentUser = ( empty($user[0]["tournamentId"]) ) ? 0 : 1;
	}else{
		header("Location: logout.php");die();
	}
}else{
	header("Location: login.php");die();
}
?>