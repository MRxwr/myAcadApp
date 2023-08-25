<?php
if( isset($_POST["email"]) && !empty($_POST["email"]) ){
    if ( userLogin($_POST) ){
        header("LOCATION: ?v=Home");
    }else{
        header("LOCATION: ?v=Login&error=1");
    }
    die();
}
if( isset($_GET["error"]) && !empty($_GET["error"]) ){
    if ( $_GET["error"] == 1 ){
        ?>
        <script>alert('<?php echo direction("Wrong email/ password, Please try again!","بريد إلكتروني / كلمة مرور خاطئه ، الرجاء المحاولة مجدداً") ?>')</script>
        <?php
    }elseif( $_GET["error"] == 2 ){
        ?>
        <script>alert('<?php echo direction("Please login before viewing profile.","الرجاء تسجيل الدخول قبل عرض الملف الشخصي") ?>')</script>
        <?php
    }
}
?>
<div class="home_area">
    <div class="left_side">
        <div class="hero_input">
            <a href="#" class="hero_logo">
                <img src="img/hero_logo.png" alt="">
            </a>
            <form action="?v=Login" method="post" class="wapper_form">
                <div class="input_wapp">
                    <img src="img/img_1.svg" alt="">
                    <input type="email" name="email" placeholder="<?php echo direction("Email Address", "البريد الإلكتروني") ?>">
                </div>
                <div class="input_wapp">
                    <img src="img/img_2.svg" alt="">
                    <input type="password" name="password" placeholder="<?php echo direction("Password","كلمة المرور") ?>">
                </div>
                <button class="button" type="submit"><?php echo direction("LOGIN","تسجيل الدخول") ?></button>
            </form>
            <ul>
                <li><a href="?v=Register"><?php echo direction("Register","تسجيل حساب جديد") ?></a></li>
                <li><a href="?v=ForgetPassword"><?php echo direction("Forget Password","نسيت كلمة المرور؟") ?></a></li>
            </ul>
        </div>
    </div>
    <div class="play_spt">
        <img src="img/play.jpg" alt="" class="w-100">
    </div>
</div>