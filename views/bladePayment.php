<?php
if( isset($_POST["data"]) && !empty($_POST["data"]) ){
    $incommingData = json_decode($_POST["data"],true);
    $data = array(
        'user' => "{$incommingData["user"]}",
        'academy' => "{$incommingData["academy"]}",
        'session' => "{$incommingData["session"]}",
        'subscription' => "{$incommingData["subscription"]}",
        'subscriptionQuantity' => "{$incommingData["subscriptionQuantity"]}",
        'jersyQuantity' => "{$incommingData["jersyQuantity"]}",
        'paymentMethod' => "{$_POST["paymentMethod"]}"
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://createkwservers.com/myacad1/requests?a=Payment',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $data,
      CURLOPT_HTTPHEADER => array(
        'myacadheader: myAcadAppCreate',
        'Cookie: CREATEkwLANG=EN'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response,true);
    print_r($response);
    if( $response["error"] == 0 ){
        header("LOCATION: {$response["data"]["data"]["paymentURL"]}");
    }else{
        ?>
        <script>
        window.onload = function() {
            alert("<?php echo direction("Erorr while loading payment data.","حدث خطأ اثناء تحميل بيانات الدفع.") ?>");
            window.location.href = "?v=Home";
        };
        </script>
        <?php
    }
}else{
    ?>
	<script>
	window.onload = function() {
		alert("<?php echo direction("Erorr while loading payment data.","حدث خطأ اثناء تحميل بيانات الدفع.") ?>");
		window.location.href = "?v=Home";
	};
	</script>
	<?php
}
?>