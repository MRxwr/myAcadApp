<?php
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://createkwservers.com/myacad1/requests?a=Academy&academyId={$_GET["id"]}",
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
$academy = $response["data"]["academy"];
?>
<div class="jersy_area mt_20">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row justify-content-between">
                    <div class="col-lg-6 order-lg-2 d-none d-lg-block mt_40">
                        <iframe width="100%" height="400" src="<?php echo $academy["video"] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                    <div class="col-lg-5 order-lg-1 mt_40">
                        <div class="jersy_top mb_45">
                            <div class="jersy_cont">
                                <img src="logos/<?php echo $academy["imageurl"] ?>" alt="logo_<?php echo $academy["enTitle"]?>">
                                <div>
                                    <h2><?php echo direction($academy["enTitle"],$academy["arTitle"]) ?></h2>
                                    <h3><?php echo direction($academy["enArea"],$academy["arArea"]) ?></h3>
                                </div>
                            </div>
                            <div class="jersy_rate">
                                <h4><?php echo direction("Rate","التقيم") ?></h4>
                                <div class="star_box">
                                    <img src="img/f_star.svg" alt="">
                                    <span><?php echo $academy["rating"]?></span>
                                </div>
                            </div>
                        </div>
                        <div class="d-lg-none mt_20 mb_20">
                            <iframe width="100%" height="400" src="<?php echo $academy["video"] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                        <form action="#" class="cup_area">
                            <h5><img src="img/cup_1.svg" alt=""><?php echo direction("Select Age & Session Time","إختر العمر و وقت الكلاس") ?></h5>
							<?php
							if( $academy["sessions"] > 0 ){
								for( $i = 0; $i < sizeof($academy["sessions"]); $i++ ){
									echo "
									<div class='radi_wap'>
										<div class='red_items'>
											<input type='radio' checked='' name='session' id='sty_{$i}' value='{$academy["sessions"][$i]["id"]}'>
											<label for='sty_{$i}'><span></span>".direction($academy["sessions"][$i]["enTitle"],$academy["sessions"][$i]["arTitle"])."</label>
										</div>
										<input type='number' name='total' value='0'>
									</div>
									";
								}
							}
							?>
                            <h5><img src="img/ca.svg" alt=""><?php echo direction("Select Subsicription Period","إختر مدة الإتشراك") ?></h5>
                            <select name="subscription">
							<?php 
							if( $academy["subscriptions"] > 0 ){
								for( $s = 0; $s < sizeof($academy["subscriptions"]); $s ++){
									if( $academy["subscriptions"][$s]["priceAfterDiscount"] > 0 ){
										echo "<option>".direction($academy["subscriptions"][$s]["enTitle"],$academy["subscriptions"][$s]["arTitle"])." <del>( {$academy["subscriptions"][$s]["price"]} KD )</del> ( {$academy["subscriptions"][$s]["priceAfterDiscount"]} KD )</option>";
									}else{
										echo "<option>".direction($academy["subscriptions"][$s]["enTitle"],$academy["subscriptions"][$s]["arTitle"])." ( {$academy["subscriptions"][$s]["price"]} KD )</option>";
									}
								}
							}
							?>
                            </select>
                        </form>
                        <a href="#" class="button mt_55">CHOOSE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- map_area -->
<div class="map_area mt_30">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2><img src="img/map.svg" alt="">Location</h2>
                <iframe src="<?php echo $academy["location"] ?>"style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>