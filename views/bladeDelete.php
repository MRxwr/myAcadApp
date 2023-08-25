<?php
if( updateDB("users",array("status" => 2),"`keepMeAlive` LIKE '{$_COOKIE["createmyacad"]}'") ){
    setcookie("createmyacad", "logged out", time() - (86400*30 ), "/");
    header("LOCATION: ?v=Home");die();
}else{
    header("LOCATION: ?v=Profile&error=1");die();
}

?>