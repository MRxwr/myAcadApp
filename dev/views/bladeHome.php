<?php
require("template/selectSportModal.php");

require("template/bannersSlider.php");
?>
<style>
	.homeSelectButtons {
		background-color: white;
		color: black;
		border: 1px solid #ffa300;
		font-size: 20px;
		width: 100px;
	}
	.homeSelectButtons :hover {
		background-color: #ffa300;
		color: black;
		border: 1px solid #ffa300;
		font-size: 20px;
		width: 100px;
	}
</style>

<div class="select_area">
    <div class="container">
        <form action="?v=Listing" method="post">

			<input type="hidden" name="sport" value="0">
			<input type="hidden" name="gender" value="0">
			<input type="hidden" name="area" value="0">
			<input type="hidden" name="governate" value="0">
			<input type="hidden" name="countryCode" value="<?php echo $_COOKIE["createmyacadcountry"] ?>">

			<div class="row w-100 m-0 p-0">
				<div class="col-5 text-center">
					<div id="homeAcadimes" class="homeSelectButtons"><?php echo direction("Academies","الأكادميات") ?></div>
				</div>
				<div class="col-2"></div>
				<div class="col-5 text-center">
					<button id="homeTournaments" class="homeSelectButtons"><?php echo direction("Tournaments","البطولات") ?></button>
				</div>
			</div>
            <h2 style="padding-top:10px"><?php echo direction("SELECT YOUR SPORT","إختر الرياضة الخاصة بك"); ?></h2>
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
			
			<input type="hidden" name="sport" value="">
			<input type="hidden" name="keyword" value="">
            <button type="submit" class="button" id="homeBtnSubmit" disabled style="background: gray;color: black;">
				<?php echo direction("Search","إبحث") ?>
			</button>
        </form>
    </div>
</div>