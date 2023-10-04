<?php
if( isset($_GET["error"]) AND $_GET["error"] == 1 ){
    ?>
    <script>alert('<?php echo direction("Could not delete your profile, please try again.","لم يتم حذف حسابك، الرجاء المحاولة مجدداًُ") ?>')</script>
    <?php
}
if( isset($_POST["firstName"]) && !empty($_POST["firstName"]) ){
    if( updateDB("users",$_POST,"`keepMeAlive` LIKE '{$_COOKIE["createmyacad"]}' ") ){

    }else{
        ?>
        <script>alert('<?php echo direction("Could not update your profile, please try again.","حدث خطأ أثناء محاولة تحديث بياناتك،  الرجاء المحاولة مجدداً") ?>')</script>
        <?php
    }
}
if ( getLoginStatusResponse() == 0 ){
    ?>
    <script>window.location.href = "?v=Login&error=2";</script>
    <?php
}elseif( $user = selectDB("users","`keepMeAlive` LIKE '{$_COOKIE["createmyacad"]}'") ){

}
require_once("template/editProfileModal.php");
?>

<div class="home_area">
    <div class="left_side">
        <div class="profile_area">
            <h2><?php echo $user[0]["firstName"] . " " . $user[0]["lastName"] ?></h2>
            <ul>
                <li><a href="#"><img src="img/img_5.svg" alt=""><p><?php echo direction("Wallet amount","قيمة المحفظة") ?> (<span><?php echo $user[0]["wallet"] ?> KD</span>)</p></a></li>
                <li><a href="#profile" data-toggle="modal"><img src="img/img_6.svg" alt=""><p><?php echo direction("Profile","الملف الشخصي") ?></p></a></li>
                <li><a href="?v=Logout"><img src="img/img_7.svg" alt=""><p><?php echo direction("Log Out","تسجيل خروج") ?></p></a></li>
                <li><a href="?v=Delete" onclick="return confirm('<?php echo direction("Are you sure you want to delete your account?","هل أنت متأكد من حذف حسابك ؟") ?>')"><img src="img/img_8.svg" alt=""><p><?php echo direction("Delete my account","حذف حسابي") ?></p></a></li>
            </ul>
        </div>
    </div>
    <div class="play_spt">
        <img src="img/play.jpg" alt="" class="w-100">
    </div>
</div>