<?php
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "{$baseURL}?a=Tournament&tournamentId={$_GET["id"]}",
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
		alert("<?php echo direction("Erorr while loading Tournament data.","حدث خطأ اثناء تحميل بيانات البطولة.") ?>");
		window.history.back();
	};
	</script>
	<?php
}else{
	$tournament = $response["data"]["tournament"];
}
?>

<div class="jersy_area mt_20">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row justify-content-between">
                    <div class="col-lg-6 order-lg-2 d-none d-lg-block mt_40">
                        <iframe width="100%" height="400" src="<?php echo $tournament["video"] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                    <div class="col-lg-5 order-lg-1 mt_40">
                        <div class="jersy_top mb_45">
                            <div class="jersy_cont">
                                <img src="logos/<?php echo $tournament["imageurl"] ?>" alt="logo_<?php echo $tournament["enTitle"]?>">
                                <div>
                                    <h2 id="academyTitle"><?php echo direction($tournament["enTitle"],$tournament["arTitle"]) ?></h2>
                                    <h3><?php echo direction($tournament["enArea"],$tournament["arArea"]) ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="d-lg-none mt_20 mb_20">
                            <iframe width="100%" height="400" src="<?php echo $tournament["video"] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                        <form action="<?php echo "?v=TeamInit&id={$_GET["id"]}" ?>" method="POST" class="cup_area">
                            <h5><?php echo direction("Terms & Conditions","الشروط والاحكام") ?></h5>
                            <p>
                                <?php echo direction($tournament["enTerms"],$tournament["arTerms"]) ?>
                            </p>
                            <input type="checkbox" id="checkTerms" ><span><?php echo direction("I agree to the terms and conditions","أوافق على الشروط والاحكام") ?></span>
							
                            <div class="row m-0 mt-5">
                                <div class="col-10 p-0"><button class="button" id="goToTeamInit" disabled style="background: gray;color: black;"><?php echo direction("Choose","إختر") ?></button></div>
                                <div class="col-2 p-0 w-100 " style="text-align: -webkit-center;"><div class="shareButton" id="<?php echo $tournament["id"] ?>" style="background-color: #ffa300;font-size: 2.4rem;border: 0px;width: 90%;height: 100%;border-radius: 2px;align-content: center;"><img src="img/share.svg" style="width: 15px;height: 15px;"></div></div>
                            </div>
                            <input type="hidden" id="academyOrTournament" value="1">
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
                <a href="<?php echo $tournament["location"] ?>">
                    <img src="<?php echo "logos/{$tournament["locationImage"]}" ?>" style="width: 100%;height: 250px;" alt="">
                </a>
            </div>
        </div>
    </div>
</div>