<style>
input[name="keyword"] {
    width: 100%;
    border-radius: 30px;
    text-align: center;
    height: 40px;
    font-size: 15px;
    border: 1px solid #dedede;
    position: relative;
}

.search-input {
    position: relative;
}

.search-input .fa-search {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
}

.fa-search {
    font-size: 20px;
    color: #b0b0b0;
}
</style>
<?php 
//require("template/bannersSlider.php");

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "{$baseURL}?a=SearchTournament&sportId={$_POST["sport"]}&genderId={$_POST["gender"]}&governateId={$_POST["governate"]}&areaId={$_POST["area"]}&countryCode={$_POST["countryCode"]}&keyword={$_POST["keyword"]}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'myacadheader: myAcadAppCreate'
  ),
));
$response = curl_exec($curl);
curl_close($curl);
$response = json_decode($response,true);

if( $sportTitle = selectDB("sports","`id` = '{$_POST["sport"]}'") ){
	$sportTitle = direction($sportTitle[0]["enTitle"],$sportTitle[0]["arTitle"]);
}else{
	$sportTitle = "";
}
?>
<div class="s_football_area">
    <div class="container">

        <div class="row">
            <div class="col-lg-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-sm-8 mt-5 mb-5">
                <div class="search-input">
                    <form action="" method="post">
                        <input type="text" name="keyword" placeholder="<?php echo direction("Search Tournaments","بحث عن البطولات") ?>">
                        <input type="hidden" name="sport" value="<?php echo $_POST["sport"] ?>">
                        <input type="hidden" name="gender" value="<?php echo $_POST["gender"] ?>">
                        <input type="hidden" name="governate" value="<?php echo $_POST["governate"] ?>">
                        <input type="hidden" name="area" value="<?php echo $_POST["area"] ?>">
                        <input type="hidden" name="countryCode" value="<?php echo $_POST["countryCode"] ?>">
                        <input type="hidden" name="isTournament" value="1">
                        <span class="fa fa-search" onclick="this.parentNode.submit()"></span>
                    </form>
                </div>
            </div>
            <div class="col-lg-2 col-sm-2">
            </div>
        </div>

        <h5><?php echo $sportTitle ?></h5>
        <div class="row" class="listOfAcademies">
		<?php
		if( isset($response["data"]["academies"]) && $response["data"]["academies"] > 0 ){
			$academies = $response["data"]["academies"];
			for( $i = 0; $i < sizeof($academies); $i++ ){
				$counter = $i + 1;
				$areaTitle = direction($academies[$i]["enArea"],$academies[$i]["arArea"]);
		?>
            <div class="col-lg-4 col-sm-6 mt_50">
                <div class="foott_box">
				<?php 
                $inIndoor = ($academies[$i]["isIndoor"] == 1) ? direction("Indoor","داخلي") : direction("Outdoor","خارجي");
				?>
                    <a href="?v=Details&id=<?php echo $academies[$i]["id"] ?>" class="s_foot_img" alt="link_<?php echo $academies[$i]["enTitle"]?>">
                        <img src="logos/<?php echo $academies[$i]["header"] ?>" alt="header_<?php echo $academies[$i]["enTitle"]?>" class="w-100" style="height: 250px;">
                    </a>
                    <div class="foott_cont">
                        <div class="kuwat">
                            <?php 
                                $backgorudColor = ( $counter <= 3 ) ? "#FFA300" : "#cacaca";
                            ?>
                            <span style="background-color:<?php echo $backgorudColor ?> !important;" ><?php echo $counter ?></span>
                            <div class="kuwat_items">
                                <img src="logos/<?php echo $academies[$i]["imageurl"] ?>" alt="logo_<?php echo $academies[$i]["enTitle"]?>" style="width: 60px;height: 60px;">
                                <div>
                                    <h2><?php echo direction($academies[$i]["enTitle"],$academies[$i]["arTitle"]) ?></h2>
                                    <h3><?php echo $areaTitle ?></h3>
                                    <h3><?php ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="last_rate">
                            <?php echo "<div class='promotion_box_reverse'><p>{$inIndoor}</p></div>" ?>
                            <?php echo "<div class='promotion_box_reverse'><p>{$academies[$i]["price"]}KD</p></div>" ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
			}
		}else{
			?>
			<div class="col-lg-12 col-sm-12 text-center" style="height: 100px;margin-top: 50px;">
				<?php echo direction("No data avaialbe","لا يوجد معلومات") ?>
			</div>
			<?php
		}
		?>
        </div>
    </div>
</div>