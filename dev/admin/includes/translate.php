<?php
$cookieSession = "myAcad";
$settingsTitle = "MY ACAD";
$settingslogo = "logo.png";
if ( isset($_GET["Lang"]) ){
	$arrayLangs = ["EN","AR"];
	if ( in_array($_GET["Lang"], $arrayLangs) ){
		setcookie("CREATEkwLANG","{$_GET["Lang"]}",(86400*30) + time(), "/");
		header("Refresh:0 , url=" . str_replace("?Lang={$_GET["Lang"]}", "" ,str_replace("&Lang={$_GET["Lang"]}", "", $_SERVER['REQUEST_URI'])) );die();
	}else{
		setcookie("CREATEkwLANG","EN",(86400*30) + time(), "/");
		header("Refresh:0 , url=" . str_replace("?Lang=EN", "" ,str_replace("&Lang=EN", "", $_SERVER['REQUEST_URI'])) );die();
	}
}elseif( isset($_COOKIE["CREATEkwLANG"]) && $_COOKIE["CREATEkwLANG"] == "EN" ){
	$newLang = "AR";
	$langDirection = "en";
	$directionHTML = "";
	$sliderDirection = "slider1";
}elseif( isset($_COOKIE["CREATEkwLANG"]) && $_COOKIE["CREATEkwLANG"] == "AR" ){
	$newLang = "EN";
	$langDirection = "ar";
	$directionHTML = "rtl";
	$sliderDirection = "slider2";
}else{
	setcookie("CREATEkwLANG","EN",(86400*30) + time(), "/");
	$newLang = "AR";
	$langDirection = "en";
	$directionHTML = "";
	$sliderDirection = "slider1";
}
?>