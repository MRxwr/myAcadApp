<?php
//$_GET["result"] == "CANCELED" || $_GET["result"] == "ERROR" || $_GET["result"] == "NOT CAPTURED"
if( isset($_GET["result"]) ){
	if( $_GET["result"] == "CAPTURED"){
		$_GET["v"] = "Success";
	}else{
		$_GET["v"] = "Fail";
	}
}
// Set headers before any output
header('Content-Type: text/html; charset=utf-8');

// get viewed page from pages folder \\
require_once("views/bladeMainView.php");
?>