<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 col-4">
                <div class="header_lang">
                    <div id="JLang" class="lang_flag">
                        <div data-lang-code="en-GB" data-src="img/32/kuwait.png">English</div>
                        <div data-lang-code="es-ES" data-src="img/32/spain.png">Español</div>
                        <div data-lang-code="it-IT" data-src="img/32/Italy.png">Italian</div>
                        <div data-lang-code="de-DE" data-src="img/32/Germany.png">Deutsche</div>
                        <div data-lang-code="fr-FR" data-src="img/32/France.png">French</div>
                    </div>
                    <a href="?v=Login" class="button">Login</a>
                </div>
            </div>
            <div class="col-lg-4 col-4 text-center">
                <a href="?v=Home" class="logo">
                    <img src="img/logo.png" alt="">
                </a>
            </div>
            <div class="col-lg-4 col-4 d-flex align-items-center justify-content-end hum_gap">
                <a href="?v=<?php echo "{$_GET["v"]}&Lang={$newLang}" ?>" class="button rtl_btn">Ar</a>
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
                    <a href="?v=Home" class="nav-link active">Home</a>
                </li>
                <li class="nav-item">
                    <a href="?v=Subscriptions" class="nav-link">SUBSICRIPTIONS</a>
                </li>
                <li class="nav-item">
                    <a href="?v=Profile" class="nav-link">PROFILE</a>
                </li>
                <li class="nav-item">
                    <a href="?v=Contact" class="nav-link">Contact us</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<img src="img/shad.png" alt="" class="shad">

