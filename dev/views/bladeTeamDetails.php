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

<style>
    .textInput{
        border: 1px #e2e2e2 solid;
        width: 100% !important;
    }
</style>
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
                                    <h2><?php echo direction($tournament["enTitle"],$tournament["arTitle"]) ?></h2>
                                    <h3><?php echo direction($tournament["enArea"],$tournament["arArea"]) ?></h3>
                                </div>
                            </div>
                        </div>
                        <form id="teamInitForm" action="<?php echo "?v=Payment&id={$_GET["id"]}" ?>" method="POST" class="cup_area">
                            <div class="row">
                                <div class="col-12 p-3"><h5><?php echo direction("ORDER INFO","معلومات الحجز") ?></h5></div>  

                                <div class="col-12 p-3">
                                    <div class="row m-0 w-100" style="border:1px solid #e2e2e2">
                                        <div class="col-6 text-left p-3"><h5><?php echo direction("Tournament Name","اسم البطولة") ?></h5></div>
                                        <div class="col-6 text-right p-3"><h5 style="color: black"><?php echo direction($tournament["enTitle"],$tournament["arTitle"]) ?></h5></div>
                                    </div>
                                </div>

                                <div class="col-12 p-3">
                                    <div class="row m-0 w-100" style="border:1px solid #e2e2e2">
                                        <div class="col-6 text-left p-3"><h5><?php echo direction("Location","المكان") ?></h5></div>
                                        <div class="col-6 text-right p-3"><h5 style="color: black"><?php echo direction($tournament["enArea"],$tournament["arArea"]) ?></h5></div>
                                    </div>
                                </div>

                                <div class="col-12 p-3">
                                    <div class="row m-0 w-100" style="border:1px solid #e2e2e2">
                                        <div class="col-6 text-left p-3"><h5><?php echo direction("Date","التاريخ") ?></h5></div>
                                        <div class="col-6 text-right p-3"><h5 style="color: black"><?php echo $tournament["gameDate"] ?></h5></div>
                                    </div>
                                </div>
                                
                                <div class="col-12 p-3">
                                    <div class="row m-0 w-100" style="border:1px solid #e2e2e2">
                                        <div class="col-6 text-left p-3"><h5><?php echo direction("Time","الوقت") ?></h5></div>
                                        <div class="col-6 text-right p-3"><h5 style="color: black"><?php echo $tournament["gameTime"] ?></h5></div>
                                    </div>
                                </div>

                                <div class="col-12 p-3">
                                    <div class="row m-0 w-100" style="border:1px solid #e2e2e2">
                                        <div class="col-6 text-left p-3"><h5><?php echo direction("Team name","اسم الفريق") ?></h5></div>
                                        <div class="col-6 text-right p-3"><h5 style="color: black"><?php echo $_POST["teamName"] ?></h5></div>
                                    </div>
                                </div>

                                <div class="col-12 p-3">
                                    <div class="row m-0 w-100" style="border:1px solid #e2e2e2">
                                        <div class="col-12 text-left p-3"><h5><?php echo direction("Team Members","اعضاء الفريق") ?></h5></div>
                                        <?php
                                        for( $i = 0; $i < count($_POST["players"]); $i++){
                                            ?>
                                            <div class="col-12 p-3"><h5 style="color: black"><?php echo $_POST["players"][$i] ?></h5></div>
                                            <?php
                                        }
                                        ?>
                                        <div class="col-12 text-left p-3"><h5><?php echo direction("Bench","الإحتياط") ?></h5></div>
                                        <?php
                                        for( $i = 0; $i < count($_POST["bench"]); $i++){
                                            ?>
                                            <div class="col-12 p-3"><h5 style="color: black"><?php echo $_POST["bench"][$i] ?></h5></div>
                                            <?php
                                        }
                                        $price = ( $tournament["price"] != 0 ) ? $tournament["price"] . " KD" : "";
                                        ?>
                                    </div>
                                </div>

                                <div class="col-12 p-3 mb-5">
                                    <input type="hidden" name="tournamentId" value="<?php echo $_GET["id"] ?>">
                                    <input type="hidden" name="teamName" value="<?php echo $_POST["teamName"] ?>">
                                    <input type="hidden" name="players" value="<?php echo $_POST["players"] ?>">
                                    <input type="hidden" name="bench" value="<?php echo $_POST["bench"] ?>">
                                    <button class="button mt_55"><?php echo direction("Checkout","تاكيد") . " " . $price ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>