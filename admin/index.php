<?php 
require_once("template/header.php");

// get viewed page from pages folder \\
if( isset($_GET["v"]) && searchFile("views","blade.{$_GET["v"]}.php") ){
	require_once("views/blade".searchFile("views","{$_GET["v"]}.php"));
}else{
	require_once("views/bladeHome.php");
}

require("template/footer.php");
?>