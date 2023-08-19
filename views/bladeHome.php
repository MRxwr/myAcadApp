<?php
require("template/selectSportModal.php");

require("template/bannersSlider.php");
?>

<div class="select_area">
    <div class="container">
        <form action="?v=Listing">
            <h2><?php echo direction("SELECT YOUR ACADEMY!","إختر الأكادمية"); ?></h2>
            <a class="select_btn mb_20" data-toggle="modal" data-target="#sport"><img id="sportMainImage" src="img/select_1.svg" alt=""><label id="sportMainTitle" style="font-weight: bolder;"><?php echo direction("SELECT SPORT","إختر الرياضة") ?><label></a>
            <div class="selet_wapper mb_20">
                <img src="img/select_2.svg" alt="">
                <select class="select_btn select" name="gender" disabled>
                    <option selected disabled value="0"><?php echo direction("SELECT GENDER","إختر الجنس") ?></option>
                    <option value="1" ><?php echo direction("Man","رجل") ?></option>
                    <option value="2" ><?php echo direction("Woman","إمرأة") ?></option>
                    <option value="3" ><?php echo direction("Boy","ولد") ?></option>
                    <option value="4" ><?php echo direction("Girl","بنت") ?></option>
                </select>
            </div>
            <div class="selet_wapper mb_20">
                <img src="img/select_3.svg" alt="">
                <select class="select_btn select" name="governate" disabled >
					<option selected disabled value="0"><?php echo direction("SELECT GOVERNANT","إختر المحافظة") ?></option>
					<?php
					$_COOKIES["myAcad"]["countryCode"] = "KW";
					if( $governates = selectDB("governates","`countryCode` LIKE '{$_COOKIES["myAcad"]["countryCode"]}' AND `status` = '0' AND `hidden` = '0'") ){
						for( $i = 0; $i < sizeof($governates); $i++){
							echo "<option value='{$governates[$i]["id"]}'>".direction($governates[$i]["enTitle"],$governates[$i]["arTitle"])."</option>";
						}
					}
					?>
                </select>
            </div>
            <div class="selet_wapper mb_20">
                <img src="img/select_4.svg" alt="">
                <select class="select_btn select" name="area" disabled>
					<option selected disabled value="0"><?php echo direction("SELECT AREA","إختر المنظقة") ?></option>
                </select>
            </div>
			
			<?php
			if ($areas = selectDB("countries", "`status` = '1' AND `hidden` = '0' AND `countryCode` LIKE '{$_COOKIES["myAcad"]["countryCode"]}' ORDER BY `governateId` ASC")) {
				$governateId = $areas[0]["governateId"];
				for ($i = 0; $i < sizeof($areas); $i++) {
					if ($i == 0 || $governateId != $areas[$i]["governateId"]) {
						if ($i != 0) {
							echo "</div>";
						}
						echo "<div id='governate{$areas[$i]["governateId"]}' style='display:none'>";
					}
					echo "<option value='{$areas[$i]["id"]}'>" . direction($areas[$i]["areaEnTitle"], $areas[$i]["areaArTitle"]) . "</option>";
					$governateId = $areas[$i]["governateId"];
				}
				echo "</div>";
			}
			?>
			
			<input type="hidden" name="sport" value="">
            <button type="submit" class="button">SEARCH</button>
        </form>
    </div>
</div>