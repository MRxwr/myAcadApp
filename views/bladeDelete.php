<?php
if( updateDB("users",array("status" => 2),"`keepMeAlive` LIKE '{$_COOKIE["createmyacad"]}'") ){
    setcookie("createmyacad", "logged out", time() - (86400*30 ), "/");
    echo '<script>window.location.href = "?v=Logout";</script>';
}else{
    echo '<script>window.location.href = "?v=Profile&error=1";</script>';
}

?>