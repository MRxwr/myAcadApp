<?php 
require("template/bannersSlider.php");

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://createkwservers.com/myacad1/requests?a=Search&sportId={$_POST["sport"]}&genderId={$_POST["gender"]}&governateId={$_POST["governate"]}&areaId={$_POST["area"]}",
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
        <h5><?php echo $sportTitle ?></h5>
        <div class="row">
		<?php
		$academies = $response["data"]["academies"];
		if( $academies > 0 ){
			for( $i = 0; $i < sizeof($academies); $i++ ){
				$counter = $i + 1;
				if( $area = selectDB("countries","`id` = '{$academies[$i]["area"]}'") ){
					$areaTitle = direction($area[0]["areaEnTitle"],$area[0]["arTitle"];
				}else{
					$areaTitle = "";
				}
		?>
            <div class="col-lg-4 col-sm-6 mt_50">
                <div class="foott_box">
				<?php 
				if( $academies[$i]["isPromotion"] == 1 ){
					echo "<div class='promotion_box'><p>".direction("Promotion","خصم")."</p></div>";
				}
				?>
                    <a href="?v=Details&id=<?php echo $academies[$i]["id"] ?>" class="s_foot_img" alt="link_<?php echo $academies[$i]["enTitle"]?>">
                        <img src="logos/<?php echo $academies[$i]["header"] ?>" alt="header_<?php echo $academies[$i]["enTitle"]?>" class="w-100">
                    </a>
                    <div class="foott_cont">
                        <div class="kuwat">
                            <span><?php echo $counter ?></span>
                            <div class="kuwat_items">
                                <img src="logos/<?php echo $academies[$i]["imageurl"] ?>" alt="logo_<?php echo $academies[$i]["enTitle"]?>">
                                <div>
                                    <h2><?php echo direction($academies[$i]["enTitle"],$academies[$i]["arTitle"]) ?></h2>
                                    <h3><?php echo $areaTitle ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="last_rate">
                            <h4><?php echo direction("Rate","التقيم") ?></h4>
                            <div class="star_box">
                                <img src="img/f_star.svg" alt="">
                                <span><?php echo $academies[$i]["قشفهىل"]?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
			}
		}
		?>
        </div>
    </div>
</div>