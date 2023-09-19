<?php
if( isset($_GET["country"]) && !empty($_GET["country"]) ){
    setcookie("createmyacadcountry", $_GET["country"], time() + (86400*30 ), "/");
}else{
    setcookie("createmyacadcountry", "KW", time() + (86400*30 ), "/");
}
?>
<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 col-4">
                <div class="header_lang">
                    <div id="JLang" class="lang_flag">
                    <?php
                    /*
                    if( $countires = selectDB("countries","`status` = '1' GROUP BY `countryCode`") ){
                        for( $i = 0; $i < sizeof($countires); $i++ ){
                            echo "<div data-lang-code='{$countires[$i]["countryCode"]}' data-src='{$countires[$i]["flag"]}'>".direction($countires[$i]["countryEnTitle"],$countires[$i]["countryArTitle"])."</div>";
                        }
                    }
                    */
                    ?>
                        <div data-lang-code="en-GB" data-src="img/32/Kuwait.png">English</div>
                        <div data-lang-code="es-ES" data-src="img/32/Spain.png">Español</div>
                        <div data-lang-code="it-IT" data-src="img/32/Italy.png">Italian</div>
                        <div data-lang-code="de-DE" data-src="img/32/Germany.png">Deutsche</div>
                        <div data-lang-code="fr-FR" data-src="img/32/France.png">French</div>
                    </div>
                    <?php echo getLoginStatus() ?>
                </div>
            </div>
            <div class="col-lg-4 col-4 text-center">
                <a href="?v=Home" class="logo">
                    <img src="img/logo.png" alt="">
                </a>
            </div>
            <div class="col-lg-4 col-4 d-flex align-items-center justify-content-end hum_gap">
                <a href="<?php echo "{$_SERVER['REQUEST_URI']}&Lang={$newLang}" ?>" class="button rtl_btn"><?php echo $newLang ?></a>
                <!-- menu toggler -->
                <div class="hamburger-menu">
                    <span class="line-top"></span>
                    <span class="line-center"></span>
                    <span class="line-bottom"></span>
                </div>
            </div>  
        </div>
    </div>
</header>
<main class="overflow-hidden">

<div class="menu_area">
    <div class="container text-center">
        <div id="menu">
            <ul>
                <li class="nav-item">
                    <a href="?v=Home" class="nav-link active"><?php echo direction("Home","الرئيسية") ?></a>
                </li>
                <li class="nav-item">
                    <a href="?v=Subscriptions" class="nav-link"><?php echo direction("Subscriptions","الإشتراكات") ?></a>
                </li>
                <li class="nav-item">
                    <a href="?v=Profile" class="nav-link"><?php echo direction("Profile","الملف الشخصي") ?></a>
                </li>
                <li class="nav-item">
                    <a href="?v=Contact" class="nav-link"><?php echo direction("Contact us","إتصل بنا") ?></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<img src="img/shad.png" alt="" class="shad">

