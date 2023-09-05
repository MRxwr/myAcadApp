<?php
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://createkwservers.com/myacad1/requests?a=Academy&academyId={$_POST["id"]}",
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
?>

<style>
	input[type="number"]::-webkit-outer-spin-button,
	input[type="number"]::-webkit-inner-spin-button {
		-webkit-appearance: none;
		appearance: none;
		margin: 0;
	}
	input[type="number"] {
		-moz-appearance: textfield; /* Firefox */
	}
	input[type="text"],
	input[type="number"] {
		text-align: center;
	}
</style>

<div class="jersy_area mt_20">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row justify-content-between">
                    <div class="col-lg-5 order-lg-2 d-none d-lg-block mt_40">
                        <div class="detail_img_right">
                            <a href="logos/<?php echo $academy["clothesImage"] ?>"><img src="logos/<?php echo $academy["clothesImage"] ?>" alt="" class="w-100"></a>
                        </div>
                    </div>
                    <div class="col-lg-5 order-lg-1 mt_40">
                        <div class="jersy_top">
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
                        <div class="detail_img_right d-lg-none mt_20">
                            <a href="logos/<?php echo $academy["clothesImage"] ?>"><img src="logos/<?php echo $academy["clothesImage"] ?>" alt="" class="w-100"></a>
                        </div>
                        <h5><?php direction("CLOTHES","ملابس") ?></h5>
                        <div class="jersy_kd">
                            <p><?php echo direction($academy["enTitle"] . " jersy", "ملابس " . $academy["arTitle"]) ?></p>
                            <span><?php echo $academy["clothesPrice"] . "KD" ?></span>
                        </div>
                        <div class="jurs_input mt_45">
                            <input type="number" step="1" name="jersy" value="0" style="width: 82% !important;">
                        </div>
                        <a href="#" class="button mt_55"><?php echo direction("Checkout","إدفع") ?></a>
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
                <iframe src="<?php echo $academy["location"] ?>"style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>