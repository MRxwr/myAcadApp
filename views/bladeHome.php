<?php
require("template/selectSportModal.php");
?>

<div class="carousel_area">
    <div class="container">
        <div class="owl-carousel slider1">
            <div class="item">
                <img src="img/ca_1.jpg" alt="">
            </div>
            <div class="item">
                <img src="img/ca_2.jpg" alt="">
            </div>
            <div class="item">
                <div class="play_video">
                    <a href="https://www.youtube.com/watch?v=D0UnqGm_miA" class="watch_btn"><i class="fal fa-play-circle"></i></a>
                </div>
            </div>
            <div class="item">
                <img src="img/ca_1.jpg" alt="">
            </div>
            <div class="item">
                <img src="img/ca_2.jpg" alt="">
            </div>
            <div class="item">
                <div class="play_video">
                    <a href="https://www.youtube.com/watch?v=D0UnqGm_miA" class="watch_btn"><i class="fal fa-play-circle"></i></a>
                </div>
            </div>
        </div>
    </div>
</div> 

<div class="select_area">
    <div class="container">
        <form action="#">
            <h2>SELECT YOUR ACADEMY!</h2>
            <button class="select_btn mb_20" data-toggle="modal" data-target="#sport"><img src="img/select_1.svg" alt="">SELECT SPORT</button>
            <div class="selet_wapper mb_20">
                <img src="img/select_2.svg" alt="">
                <select class="select_btn select">
                    <option>SELECT GENDER</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>
            <div class="selet_wapper mb_20">
                <img src="img/select_3.svg" alt="">
                <select class="select_btn select">
                    <option>SELECT GOVERNANT</option>
                    <option>SELECT GOVERNANT</option>
                    <option>SELECT GOVERNANT</option>
                </select>
            </div>
            <div class="selet_wapper mb_20">
                <img src="img/select_4.svg" alt="">
                <select class="select_btn select">
                    <option>SELECT AREA</option>
                    <option>SELECT AREA</option>
                    <option>SELECT AREA</option>
                </select>
            </div>
            <button type="submit" class="button">SEARCH</button>
        </form>
    </div>
</div>