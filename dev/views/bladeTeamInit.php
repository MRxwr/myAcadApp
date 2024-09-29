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
                        <div class="d-lg-none mt_20 mb_20">
                            <iframe width="100%" height="400" src="<?php echo $tournament["video"] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                        <form action="<?php echo "?v=TeamDetails&id={$_GET["id"]}" ?>" method="POST" class="cup_area">
                            <div class="row">
                                <div class="col-12 p-1"><h5><?php echo direction("Team name","اسم الفريق") ?></h5></div>
                                <div class="col-12 p-1"><input type="text" name="teamName" id="teamName" class="textInput" placeholder="Team Name"></div>
                                <div class="col-12 p-1"><h5><?php echo direction("Players","اللاعبين") ?></h5></div>
                                <?php
                                for( $i = 0; $i < $tournament["players"]; $i++){
                                    ?>
                                    <div class="col-12 p-1"><input type="text" name="players[]" class="textInput" placeholder="Player Name"></p></div>
                                    <?php
                                }
                                ?>
                                <div class="col-12 p-1">
                                    <h5><?php echo direction("Bench","الإحتياط") ?></h5>
                                </div>
                                <?php
                                for( $i = 0; $i < $tournament["bench"]; $i++){
                                    ?>
                                    <div class="col-12 p-1"><input type="text" name="bench[]" class="textInput" placeholder="Player Name"></div>
                                    <?php
                                }
                                ?>
                                <div class="col-12 p-1"><button class="button mt_55" id="submitTeam" ><?php echo direction("Continue","تابع") ?></button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>