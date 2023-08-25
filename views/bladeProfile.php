<?php
if ( getLoginStatusResponse() == 0 ){
    header("LOCATION: ?v=Login&error=2");
}elseif( $user = selectDB("users","`keepMeAlive` LIKE '{$_COOKIE["createmyacad"]}'") ){

}
require_once("template/editProfileModal.php");
?>

<div class="home_area">
    <div class="left_side">
        <div class="profile_area">
            <h2><?php echo $user[0]["firstName"] . " " . $user[0]["lastName"] ?></h2>
            <ul>
                <li><a href="#"><img src="img/img_5.svg" alt=""><p>Wallet Amount (<span><?php echo $user[0]["wallet"] ?> KD</span>)</p></a></li>
                <li><a href="#profile" data-toggle="modal"><img src="img/img_6.svg" alt=""><p><?php echo direction("Profile","الملف الشخصي") ?></p></a></li>
                <li><a href="?v=Logout"><img src="img/img_7.svg" alt=""><p><?php echo direction("Log Out","تسجيل خروج") ?></p></a></li>
                <li><a href="?v=Delete"><img src="img/img_8.svg" alt=""><p><?php echo direction("Delete my account","حذف حسابي") ?></p></a></li>
            </ul>
        </div>
    </div>
    <div class="play_spt">
        <img src="img/play.jpg" alt="" class="w-100">
    </div>
</div>