<?php
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://createkwservers.com/myacad1/requests?a=Academy&academyId={$_POST["checkout"]["id"]}",
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

if( !isset($_COOKIE["createmyacad"]) || empty($_COOKIE["createmyacad"]) ){
	?>
	<script>
	window.onload = function() {
		alert("<?php echo direction("Please login, to continue subscribing.","الرجاء التسجيل أولا لمتابعة الحجز.") ?>");
		window.location.href = "?v=Login" ;
	};
	</script>
	<?php
}

if( isset($_POST["checkout"]["jersy"]) && !empty($_POST["checkout"]["jersy"]) ){
    $jersyPrice = (float)$academy["clothesPrice"]*(float)$_POST["checkout"]["jersy"];
}else{
    $_POST["checkout"]["jersy"] = 0;
    $jersyPrice = 0;
}

if( $session = selectDB("sessions","`id` = '{$_POST["checkout"]["session"]}'")){}
if( $subscription = selectDB("subscriptions","`id` = '{$_POST["checkout"]["subscription"]}'")){
    $price = ($subscription[0]["priceAfterDiscount"] != 0 ) ? $subscription[0]["priceAfterDiscount"] : $subscription[0]["price"] ;
    $totalPrice = (float)$price*(float)$_POST["checkout"]["quantity"];
}else{
    $totalPrice = 0;
}

if( isset($_COOKIE["createmyacad"]) && $user = selectDB("users","`keepMeAlive` LIKE '{$_COOKIE["createmyacad"]}'") ){}

$newTotal = (float)$jersyPrice+(float)$totalPrice;

$_POST["checkout"]["enAcademy"] = $academy["enTitle"];
$_POST["checkout"]["arAcademy"] = $academy["arTitle"];
$_POST["checkout"]["enSession"] = $session[0]["enTitle"];
$_POST["checkout"]["arSession"] = $session[0]["arTitle"];
$_POST["checkout"]["enSubscription"] = $subscription[0]["enTitle"];
$_POST["checkout"]["arSubscription"] = $subscription[0]["arTitle"];
$_POST["checkout"]["totalPrice"] = $totalPrice;
$_POST["checkout"]["jersyPrice"] = $jersyPrice;
$_POST["checkout"]["total"] = $newTotal;

$checkout = json_encode($_POST, JSON_UNESCAPED_UNICODE);
?>
<div class="checkout_area mt_20 pb_50">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row justify-content-between">
                    <div class="col-lg-5 order-lg-2 mt_40">
                        <div class="right_succes chek_right">
                            <h3><?php echo direction("ORDER INFO","معلومات الإشتراك") ?></h3>
                            <h2><?php echo direction($academy["enTitle"],$academy["arTitle"]) ?></h2>
                            <div class="suc_item">
                                <div class="suc_child">
                                    <span><?php echo $_POST["checkout"]["quantity"] ?></span>
                                    <h3><?php echo direction($session[0]["enTitle"],$session[0]["arTitle"]) ?></h3>
                                </div>
                                <p><?php echo $totalPrice ?>KD</p>
                            </div>
                            <?php 
                            if ( !empty($_POST["checkout"]["jersy"]) ){
                        ?>
                            <div class="suc_item">
                                <div class="suc_child">
                                    <span><?php echo $_POST["checkout"]["jersy"] ?></span>
                                    <h3><?php echo direction($academy["enTitle"] . " Jersy","ملابس " . $academy["arTitle"]) ?></h3>
                                </div>
                                <p><?php echo $jersyPrice ?>KD</p>
                            </div>
                        <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-5 order-lg-1 mt_40">
                        <div class="check_out">
                            <h2><?php echo direction("PAYMENT METHOD", "طرق الدفع" ) ?></h2>
                            <form action="?v=Payment" method="post" >
                                <div class="shape_items">
                                    <input type="radio" checked="" name="payment" id="out_1">
                                    <label for="out_1"><span></span>Knet</label>
                                </div>
                                <div class="shape_items">
                                    <input type="radio" name="payment" id="out_2">
                                    <label for="out_2"><span></span>Visa / Master Card</label>
                                </div>
                                <div class="shape_items">
                                    <input type="radio" name="payment" id="out_3" <?php echo $disabled = ( $user[0]["wallet"] > ($jersyPrice + $totalPrice)) ? "" : "disabled" ; ?>>
                                    <label for="out_3"><span></span><?php echo direction("Wallet","المحفظة") ?> <p>  ( <?php echo $user[0]["wallet"] ?>KD )</p></label>
                                </div>
                                <input type="hidden" name="data" value='<?php echo $checkout ?>'>
                                <div class="d-flex justify-content-between mt_50 extre_h6">
                                    <h6><strong><?php echo direction("Total", "المجموع") ?></strong></h6>
                                    <span><?php echo $newTotal ?>KD</span>
                                </div>
                                <p>By clicking Pay Now, you agree to our <a href="#">Terms & Conditions</a></p>
                                <button class="button"><?php echo direction("CHECKOUT","تابع للدفع") ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>