<?php
if( isset($_POST["email"]) && !empty($_POST["email"]) ){
    if ( userLogin($_POST) ){
        header("?v=Home");
    }else{
        header("?v=Login&error=1");
    }
    die();
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
                    <input type="email" name="email" placeholder="Email Address">
                </div>
                <div class="input_wapp">
                    <img src="img/img_2.svg" alt="">
                    <input type="password" name="password" placeholder="Password">
                </div>
                <button class="button" type="submit">LOGIN</button>
            </form>
            <ul>
                <li><a href="?v=Register">Register</a></li>
                <li><a href="?v=ForgetPassword">Forget Password?</a></li>
            </ul>
        </div>
    </div>
    <div class="play_spt">
        <img src="img/play.jpg" alt="" class="w-100">
    </div>
</div>