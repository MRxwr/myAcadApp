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
if( isset($_POST["changePass"]) && !empty($_POST["changePass"]) ){
    if( $user = selectDB("users","`keepMeAlive` LIKE '{$_COOKIE["createmyacad"]}'") ){
    }else{
        $user[0]["id"] = 0;
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "{$baseURL}/index.php?a=User&type=changePassword&userId={$user[0]["id"]}",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
        'oldPassword' => $_POST["oldPassword"],
        'newPassword' => $_POST["newPassword"],
        'confirmPassword' => $_POST["confirmPassword"]
    ),
    CURLOPT_HTTPHEADER => array(
        'myacadheader: myAcadAppCreate'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response,true);
    ?>
    <script>alert('<?php echo direction($response["data"]["msg"],$response["data"]["msg"]) ?>')</script>
    <?php
}
if ( getLoginStatusResponse() == 0 ){
    ?>
    <script>window.location.href = "?v=Login&error=2";</script>
    <?php
}elseif( $user = selectDB("users","`keepMeAlive` LIKE '{$_COOKIE["createmyacad"]}'") ){

}
require_once("template/editProfileModal.php");
require_once("template/changePassword.php");
?>

<div class="home_area">
    <div class="left_side">
        <div class="profile_area">
            <h2><?php echo $user[0]["firstName"] . " " . $user[0]["lastName"] ?></h2>
            <input type="hidden" name="userId" value="<?php echo getLoginStatusResponse() ?>" id="userIdProfile">
            <ul>
                <li>
                    <div class="row">
                        <div class="col-8"><a href="#"><img src="img/points.svg" alt=""><p><?php echo direction("Points","النقاط") ?> (<span><?php echo $user[0]["points"] ?></span>)</p></a></div>
                        <div class="col-4"><a id="redeemBtn" class="button" style="border-radius: 10px;font-size: 12px;padding: 10px;"><?php echo direction("Redeem Poitns","استبدال النقاط") ?></a></div>
                    </div>
                </li>
                <li><a href="#"><img src="img/img_5.svg" alt=""><p><?php echo direction("Wallet amount","قيمة المحفظة") ?> (<span><?php echo $user[0]["wallet"] ?> KD</span>)</p></a></li>
                <li><a href="#profile" data-toggle="modal"><img src="img/img_6.svg" alt=""><p><?php echo direction("Profile","الملف الشخصي") ?></p></a></li>
                <li><a href="#changePassword" data-toggle="modal"><img src="img/img_6.svg" alt=""><p><?php echo direction("Change Password","تغيير كلمة المرور") ?></p></a></li>
                <li><a href="?v=Logout"><img src="img/img_7.svg" alt=""><p><?php echo direction("Log Out","تسجيل خروج") ?></p></a></li>
                <li><a href="?v=Delete" onclick="return confirm('<?php echo direction("Are you sure you want to delete your account?","هل أنت متأكد من حذف حسابك ؟") ?>')"><img src="img/img_8.svg" alt=""><p><?php echo direction("Delete my account","حذف حسابي") ?></p></a></li>
            </ul>
        </div>
    </div>
    <div class="play_spt">
        <img src="img/play.jpg" alt="" class="w-100">
    </div>
</div>