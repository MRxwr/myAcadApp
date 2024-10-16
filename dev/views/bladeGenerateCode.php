<?php
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "{$baseURL}?a=GetQrcode&orderId={$_GET["id"]}",
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
	$code = $response["data"]["data"];
    $order = selectDBNew("orders",[$_GET["id"]],"`id` = ?","" );
    $academy = selectDBNew("academies",[$order[0]["academyId"]],"`id` = ?","" );
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
        appearance: textfield;
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
                    <div class="col-lg-12 order-lg-1 mt_40">
                        <div class="detail_img_right d-lg-none mt_20">
                            <img src="<?php echo $code ?>" alt="" class="w-100">
                        </div>
                        <div>
                            <h2><?php echo direction($academy[0]["enTitle"],$academy[0]["arTitle"]) ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>