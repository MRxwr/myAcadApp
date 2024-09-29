<?php
if( isset($_POST["data"]) && !empty($_POST["data"]) ){
    if( isset($_POST["academy"]) && !empty($_POST["academy"]) ){
        $incommingData = json_decode($_POST["data"],true);
        $data = array(
            'user' => "{$incommingData["user"]}",
            'academy' => "{$incommingData["academy"]}",
            'session' => "{$incommingData["session"]}",
            'subscription' => "{$incommingData["subscription"]}",
            'subscriptionQuantity' => "{$incommingData["subscriptionQuantity"]}",
            'jersyQuantity' => "{$incommingData["jersyQuantity"]}",
            'voucher' => "{$_POST["voucher"]}",
            'paymentMethod' => "{$_POST["paymentMethod"]}"
        );
    }elseif( isset($_POST["tournamentId"]) && !empty($_POST["tournamentId"]) ){
        $user = selectDB("users","`keepMeAlive` LIKE '{$_COOKIE["createmyacad"]}'");
        $data = array(    
            "user" => $user[0]["user"],
            "tournament" => $_POST["tournamentId"],
            "teamName" => $_POST["teamName"],
            "players" => $_POST["players"],
            "bench" => $_POST["bench"],
            "quantity" => 1,
            "paymentMethod" => $_POST["paymentMethod"],
            "voucher" => "",
        );
    }
    var_dump($data);die();
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "{$baseURL}/index.php?a=Payment",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $data,
      CURLOPT_HTTPHEADER => array(
        'myacadheader: myAcadAppCreate'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response,true);
    if( $response["error"] == 0 ){
        ?>
        <script>
        window.onload = function() {
            window.location.href = "<?php echo "{$response["data"]["data"]["paymentURL"]}" ?>";
        };
        </script>
        <?php
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
die();
?>