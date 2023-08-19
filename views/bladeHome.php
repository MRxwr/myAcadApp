<?php
require("template/selectSportModal.php");

require("template/bannersSlider.php");
?>

<div class="select_area">
    <div class="container">
        <form action="#">
            <h2>SELECT YOUR ACADEMY!</h2>
            <button class="select_btn mb_20" data-toggle="modal" data-target="#sport"><img id="sportMainImage" src="img/select_1.svg" alt=""><label id="sportMainTitle">SELECT SPORT<label></button>
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