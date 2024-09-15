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
            <h2 style="padding-top:10px"><?php echo direction("SELECT YOUR SPORT","إختر الرياضة الخاصة بك"); ?></h2>
            <a class="select_btn mb_20" data-toggle="modal" data-target="#sport">
				<img id="sportMainImage" src="img/select_1.svg" alt="">
				<label id="sportMainTitle" style="font-weight: bolder;"><?php echo direction("SELECT SPORT","إختر الرياضة") ?><label>
			</a>
            <div class="selet_wapper mb_20">
                <img src="img/select_2.svg" alt="">
                <select class="select_btn select" name="gender" disabled>
                    <option value="" disabled selected><?php echo direction("SELECT GENDER","إختر الجنس") ?></option>
                    <option value="1" ><?php echo direction("Man","رجل") ?></option>
                    <option value="2" ><?php echo direction("Woman","إمرأة") ?></option>
                    <option value="3" ><?php echo direction("Boy","ولد") ?></option>
                    <option value="4" ><?php echo direction("Girl","بنت") ?></option>
                </select> 
            </div>
            <div class="selet_wapper mb_20">
				<img src="img/select_3.svg" alt="">
				<select class="select_btn select governateSelect" name="governate" disabled>
					<option selected disabled value="0"><?php echo direction("SELECT GOVERNANT","إختر المحافظة") ?></option>
					<option value="0"><?php echo direction("Select All","إختر الكل") ?></option>
					<?php
					if ($governates = selectDB("governates", "`countryCode` LIKE '{$_COOKIE["createmyacadcountry"]}' AND `status` = '0' AND `hidden` = '0'")) {
						for ($i = 0; $i < sizeof($governates); $i++) {
							echo "<option value='{$governates[$i]["id"]}'>" . direction($governates[$i]["enTitle"], $governates[$i]["arTitle"]) . "</option>";
						}
					}
					?>
				</select>
			</div>
			<?php
			if ($areas = selectDB("countries", "`status` = '1' AND `hidden` = '0' AND `countryCode` LIKE '{$_COOKIE["createmyacadcountry"]}' ORDER BY `governateId` ASC")) {
				$governateId = $areas[0]["governateId"];
				for ($i = 0; $i < sizeof($areas); $i++) {
					if ($i == 0 || $governateId != $areas[$i]["governateId"]) {
						if ($i != 0) {
							echo "</div>";
						}
						echo "
								<div class='governate' id='governate{$areas[$i]["governateId"]}' style='display:none'>
									<option selected disabled value='0'>".direction("SELECT AREA","إختر المنطقة")."</option>
									<option selected value='0'>".direction("Select All","إختر الكل")."</option>
							";
					}
					echo "<option value='{$areas[$i]["id"]}'>" . direction($areas[$i]["areaEnTitle"], $areas[$i]["areaArTitle"]) . "</option>";
					$governateId = $areas[$i]["governateId"];
				}
				echo "</div>";
			}
			?>
			
			<input type="hidden" name="sport" value="">
            <button type="submit" class="button" id="homeBtnSubmit" disabled style="background: gray;color: black;">
				<?php echo direction("Search","إبحث") ?>
			</button>
        </form>
    </div>
</div>