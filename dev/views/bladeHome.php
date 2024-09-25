<?php
require("template/selectSportModal.php");

require("template/bannersSlider.php");
?>
<style>
	.homeSelectButtons {
		background-color: white;
		color: black;
		border: 1px solid #ffa300;
		font-size: 18px;
		width: 100%;
		padding: 10px;
		border-radius: 5px;
		font-weight: 300;
	}
	.homeSelectButtons:hover {
		background-color: #ffa300;
	}
	.homeSelectButtons:active, .homeSelected{
		background-color: #ffa300;
	}
</style>

<div class="select_area">
    <div class="container">
        <form id="homeForm" action="?v=Listing" method="post">

			<input type="hidden" name="sport" value="0">
			<input type="hidden" name="gender" value="0">
			<input type="hidden" name="area" value="0">
			<input type="hidden" name="governate" value="0">
			<input type="hidden" name="isTournament" value="0">
			<input type="hidden" name="countryCode" value="<?php echo $_COOKIE["createmyacadcountry"] ?>">
			<input type="hidden" name="keyword" value="">

			<div class="row w-100 m-0 p-0">
				<div class="col-6 p-0 pr-4 text-center">
					<div id="homeAcadimes" class="homeSelectButtons homeSelected"><?php echo direction("Academies","الأكادميات") ?></div>
				</div>
				<div class="col-6 p-0 pl-4 text-center">
					<div id="homeTournaments" class="homeSelectButtons"><?php echo direction("Tournaments","البطولات") ?></div>
				</div>
			</div>
			
            <h2 style="padding-top:10px"></h2>

            <a class="select_btn mb_20" data-toggle="modal" data-target="#sport">
				<img id="sportMainImage" src="img/select_1.svg" alt="">
				<label id="sportMainTitle" style="font-weight: bolder;"><?php echo direction("SELECT SPORT","إختر الرياضة") ?><label>
			</a>

            <div class="selet_wapper mb_20">
                <img src="img/select_2.svg" alt="">
                <select class="select_btn select selectGender" name="gender" disabled>
                    <option value="" disabled selected><?php echo direction("SELECT GENDER","إختر الجنس") ?></option>
					<option value="0"><?php echo direction("Select All","إختر الكل") ?></option>
                </select> 
            </div>

            <div class="selet_wapper mb_20">
				<img src="img/select_3.svg" alt="">
				<select class="select_btn select governateSelect" name="governate" disabled>
					<option value="" disabled selected><?php echo direction("SELECT GOVERNANT","إختر المحافظة") ?></option>
					<option value="0"><?php echo direction("Select All","إختر الكل") ?></option>
				</select>
			</div>
			
            <button type="submit" class="button" id="homeBtnSubmit" disabled style="background: gray;color: black;">
				<?php echo direction("Search","إبحث") ?>
			</button>
        </form>
    </div>
</div>