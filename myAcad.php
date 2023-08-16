<?php
require_once("admin/includes/config.php");
require_once("admin/includes/functions.php");

if( isset($_GET["a"]) && searchFile("requests","api{$_GET["a"]}.php") ){
	require_once("requests/".searchFile("requests","api{$_GET["a"]}.php"));
}else{
	return false;
}

?>