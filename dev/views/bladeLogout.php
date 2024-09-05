<?php 
if(getLogOut()){
    echo '<script>window.location.href = "?v=Home";</script>';
    die();
}
//setcookie("createmyacad", "", time() - (86400*30 ), "/");
//header("LOCATION: ?v=Home");
?>