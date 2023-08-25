<?php
setcookie("createmyacad", "logged out", time() - (86400*30 ), "/");
header("LOCATION: ?v=Home");die();
?>