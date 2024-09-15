<?php
require("template/selectSportModal.php");

require("template/bannersSlider.php");
?>

<div class="select_area">
    <div class="container">
        <form action="?v=Listing" method="post">

			<input type="hidden" name="sport" value="0">
			<input type="hidden" name="gender" value="0">
			<input type="hidden" name="area" value="0">
			<input type="hidden" name="governate" value="0">
			<input type="hidden" name="countryCode" value="<?php echo $_COOKIE["createmyacadcountry"] ?>">

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
            <button type="submit" class="button" id="homeBtnSubmit" disabled style="background: gray;color: black;">
				<?php echo direction("Search","إبحث") ?>
			</button>
        </form>
    </div>
</div>