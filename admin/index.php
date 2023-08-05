<?php 
require_once("template/header.php");

// get viewed page from pages folder \\
if( isset($_GET["v"]) && searchFile("views","{$_GET["v"]}.php") ){
	require_once("views/".searchFile("views","{$_GET["v"]}.php"));
}else{
	require_once("views/home.php");
}

require("template/footer.php");
?>