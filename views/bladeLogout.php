<?php setcookie("createmyacad", "logged out", time() - (86400*30 ), "/");
//header("LOCATION: ?v=Home");
echo '<script>window.location.href = "?v=Home";</script>';
die();
?>