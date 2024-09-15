<?php
if( isset($_GET["result"]) ){
	if( $_GET["result"] == "CANCELED" || $_GET["result"] == "ERROR" ){
		$_GET["v"] = "Fail";
	}elseif( $_GET["result"] == "CAPTURED" ){
		sleep(5);
		$_GET["v"] = "Success";
	}
}
// Set headers before any output
header('Content-Type: text/html; charset=utf-8');

require("template/header.php");
require("template/navbar.php");

// get viewed page from pages folder \\
if( isset($_GET["v"]) && searchFile("views","blade{$_GET["v"]}.php") ){
	require_once("views/".searchFile("views","blade{$_GET["v"]}.php"));
}else{
	require_once("views/bladeHome.php");
}

require("template/footer.php");
?>