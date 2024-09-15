<?php
if( !isset($_COOKIE["createmyacadcountry"]) ){
    setcookie("createmyacadcountry", "KW", time() + (86400*30 ), "/");
    header("location: ?v=Home");die();
}
if( isset($_GET["country"]) && !empty($_GET["country"]) ){
    setcookie("createmyacadcountry", $_GET["country"], time() + (86400*30 ), "/");
    header("location: ?v=Home");die();
}
?>

<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 col-4">
                <div class="header_lang">
                    <div id="JLang" class="lang_flag">
                    <?php
                    
                    if( $countires = selectDB("countries","`status` = '1' GROUP BY `countryCode`") ){
                        for( $i = 0; $i < sizeof($countires); $i++ ){
                            $ccode=$countires[$i]["countryCode"];
                            $cname=ucfirst(strtolower($countires[$i]["countryEnTitle"]));
                            $cimage='img/32/'.str_replace(" ","-",ucwords(strtolower($countires[$i]["countryEnTitle"]))).'.png';
                            $clabel=direction($countires[$i]["countryEnTitle"],$countires[$i]["countryArTitle"]);
                            echo "<div data-lang-code='{$ccode}' data-lang-name='{$cname}' data-src='{$cimage}'>".$clabel."</div>";
                        }
                    }
                    
                    ?>
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
                <?php
                $pageView = ( isset($_SERVER["QUERY_STRING"]) && !empty($_SERVER["QUERY_STRING"]) ) ? $_SERVER["QUERY_STRING"] : "v=Home" ;
                if( !isset($_GET["v"]) || (isset($_GET["v"]) && $_GET["v"] == "Home") ){
                ?>
                    <a href="<?php echo "?{$pageView}&Lang={$newLang}" ?>" class="button rtl_btn"><?php echo $newLang ?></a>
                <?php
                }
                ?>
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

<?php
$pageArray = ["Login","Register","ForgetPassword","Profile"];
$_GET["v"] = ( !isset($_GET["v"]) ) ? "Home" : $_GET["v"];
if( !in_array($_GET["v"], $pageArray) ){
    ?>
    <div class="menu_area">
        <div class="container text-center">
            <div id="menu">
                <ul>
                    <li class="nav-item">
                        <a href="?v=Home" class="nav-link active"><?=direction("Home","الرئيسية"); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="?v=Subscriptions" class="nav-link"><?=direction("Subscriptions","الإشتراكات"); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="?v=Profile" class="nav-link"><?=direction("Profile","الملف الشخصي"); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="?v=Contact" class="nav-link"><?=direction("Contact us","إتصل بنا"); ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <?php
    echo '<img src="img/shad.png" alt="" class="shad">';
}
?>

