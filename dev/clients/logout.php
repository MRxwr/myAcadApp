<?php
include_once ("../admin/includes/config.php");
require("../admin/includes/translate.php");
setcookie($cookieSession."C", "", time() - (86400*30 ), "/");
session_start ();
if ( session_destroy() )
{
	header("Location: login.php");
}
?>