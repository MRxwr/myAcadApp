<?php
$cookieSession = "myAcad";
$settingsTitle = "MY ACAD";
$settingslogo = "logo.png";
if ( isset($_GET["Lang"]) ){
	$arrayLangs = ["ENG","AR"];
	if ( in_array($_GET["Lang"], $arrayLangs) ){
		setcookie("CREATEkwLANG","{$_GET["Lang"]}",(86400*30) + time(), "/");
		header("Refresh:0 , url=" . str_replace("?Lang={$_GET["Lang"]}", "" ,str_replace("&Lang={$_GET["Lang"]}", "", $_SERVER['REQUEST_URI'])) );
		$newLang = "ENG";
	}else{
		setcookie("CREATEkwLANG","ENG",(86400*30) + time(), "/");
		header("Refresh:0 , url=" . str_replace("?Lang=ENG", "" ,str_replace("&Lang=ENG", "", $_SERVER['REQUEST_URI'])) );
		$newLang = "AR";
	}
}elseif( !isset($_COOKIE["CREATEkwLANG"]) ){
	setcookie("CREATEkwLANG","ENG",(86400*30) + time(), "/");
	$newLang = "AR";
}
?>