<?php
if ( isset($_GET["lang"]) ){
	$arrayLangs = ["ENG","AR"];
	if ( in_array($_GET["lang"], $arrayLangs) ){
		setcookie("CREATEkwLANG","{$_GET["lang"]}",(86400*30) + time(), "/");
		header("Refresh:0 , url=" . str_replace("?lang={$_GET["lang"]}", "" ,str_replace("&lang={$_GET["lang"]}", "", $_SERVER['REQUEST_URI'])) );
	}else{
		setcookie("CREATEkwLANG","{$settingsLang}",(86400*30) + time(), "/");
		header("Refresh:0 , url=" . str_replace("?lang={$settingsLang}", "" ,str_replace("&lang={$settingsLang}", "", $_SERVER['REQUEST_URI'])) );
	}
}elseif( !isset($_COOKIE["CREATEkwLANG"]) ){
	$_COOKIE["CREATEkwLANG"] = $settingsLang;
}
?>