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
if( $response["error"] == 1 ){
	?>
	<script>
	window.onload = function() {
		alert("<?php echo direction("Erorr while loading academy data.","حدث خطأ اثناء تحميل بيانات الأكادمية.") ?>");
		window.history.back();
	};
	</script>
	<?php
}else{
	$academy = $response["data"]["academy"];
}

$redirect = ($academy["isClothes"] == 1 ) ? "Jersy" : "Checkout" ;

?>

<style>
	input[type="number"]::-webkit-outer-spin-button,
	input[type="number"]::-webkit-inner-spin-button {
		-webkit-appearance: none;
		appearance: none;
		margin: 0;
	}
	input[type="number"] {
        appearance: textfield;
		-moz-appearance: textfield; /* Firefox */
	}
	input[type="text"],
	input[type="number"] {
		text-align: center;
	}
    /* Add strike-through style to Nice Select option text */
    .nice-select .strike-through {
        display: block;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        text-decoration: line-through;
    }

    /* Style the non-strikethrough part of the option */
    .nice-select .strike-through:not([data-display]) {
        text-decoration: none;
    }
</style>

<div class="jersy_area mt_20">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row justify-content-between">
                    <div class="col-lg-6 order-lg-2 d-none d-lg-block mt_40">
                        <iframe width="100%" height="400" src="https://www.youtube.com/embed/<?php echo $academy["video"] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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
                        <form action="<?php echo "?v={$redirect}&id={$_GET["id"]}" ?>" method="POST" class="cup_area">
                            <h5><img src="img/cup_1.svg" alt=""><?php echo direction("Select Age & Session Time","إختر العمر و وقت الكلاس") ?></h5>
							<?php
							if( $academy["sessions"] > 0 ){
								for( $i = 0; $i < sizeof($academy["sessions"]); $i++ ){
									$checked = ( $i == 0 ) ? "checked=''" : "" ;
									$number = ( $i == 0 ) ? "1" : "0" ;
									echo "
									<div class='radi_wap'>
										<div class='red_items'>
											<input type='radio' {$checked} name='session' id='sty_{$i}' value='{$academy["sessions"][$i]["id"]}'>
											<label for='sty_{$i}'><span></span>".direction($academy["sessions"][$i]["enTitle"],$academy["sessions"][$i]["arTitle"])."</label>
										</div>
										<input type='number' step='1' class='sty_{$i}' name='quantity[]' value='{$number}'  min='0' readonly>
									</div>
									";
								}
							}
							?>
                            <h5><img src="img/ca.svg" alt=""><?php echo direction("Select Subsicription Period","إختر مدة الإتشراك") ?></h5>
                            <select name="subscription" required>
							<?php 
                            if ($academy["subscriptions"] > 0) {
                                for ($s = 0; $s < sizeof($academy["subscriptions"]); $s++) {
                                    $subscription = $academy["subscriptions"][$s];
                                    $title = direction($subscription["enTitle"], $subscription["arTitle"]);
                                    $price = $subscription["price"];
                                    $priceAfterDiscount = $subscription["priceAfterDiscount"];

                                    $optionText = $priceAfterDiscount > 0
                                        ? "{$title} &lt;del&gt;({$price}KD)&lt;/del&gt; / ({$priceAfterDiscount}KD)"
                                        : "{$title} ({$price}KD)";

                                    echo "<option class='strike-through' value='{$subscription["id"]}' data-display='{$optionText}'>{$optionText}</option>";
                                }
                            }
                            ?>
                            </select>
							<input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET["id"]) ?>">
							<button class="button mt_55"><?php echo direction("Choose","إختر") ?></button>
                        </form>
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
                <h2><img src="img/map.svg" alt=""><?php echo direction("Location","الموقع") ?></h2>
                <a href="<?php echo $academy["location"] ?>">
                    <img src="<?php echo "logos/{$academy["locationImage"]}" ?>" style="width: 100%;height: 250px;" alt="">
                </a>
            </div>
        </div>
    </div>
</div>

