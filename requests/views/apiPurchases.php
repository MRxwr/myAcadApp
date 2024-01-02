<?php
if( !isset($_POST) ){
    $response["msg"] = "Please make sure you send post data before submitting.";
	echo outputError($response);die();
}else{
    $data = $_POST;
    unset($_POST);

    if( $purchase = selectDB("purchases","`id` = '{$data["id"]}'") ){
        if( $socialMedia = selectDB("social_media","`id` = '1'") ){}
        if( $AdminSettings = selectDB("settings","`id` = '1'") ){
            $fullAmount = $purchase[0]["price"];
            $iban = $AdminSettings[0]["mainIban"];
            $title = "MYACAD";
        }
        if ( $purchase[0]["isMyacad"] == 1 ) {
            if( $academyData = selectDB("academies","`id` = '{$purchase[0]["academyId"]}'")){
                $iban = $academyData[0]["iban"];
                $fullAmount = $purchase[0]["price"] + 0.250;
                $title = $academyData[0]["enTitle"];
            }
        }
    }
    
    //preparing upayment payload
    $extraMerchantData =  array(
        'amounts' => array($fullAmount),
        'charges' => array(0.250),
        'chargeType' => array('fixed'),
        'cc_charges' => array(0.250),
        'cc_chargeType' => array('fixed'),
        'ibans' => array("{$iban}")
    );
    $comon_array = array(
        "merchant_id"=> "24072",
        "username"=> "create_lwt",
        "password"=> stripslashes('sJg@Q9N6ysvP'),
        "api_key"=> password_hash('afmceR6nHQaIehhpOel036LBhC8hihuB8iNh9ACF',PASSWORD_BCRYPT),
        "payment_gateway" => "knet",
        "order_id"=> time(),
        'total_price'=>$fullAmount,
        'success_url'=>'https://myacad.app/Purchase.php',
        'error_url'=>'https://myacad.app/Purchase.php',
        'notifyURL'=>'https://myacad.app/Purchase.php',
        'test_mode'=>0,
        "whitelabled" => 1,
        'CurrencyCode'=>'KWD',			
        'CstFName'=>"PURCHASE {$title}",
        'ExtraMerchantsData'=> json_encode($extraMerchantData),
        'ProductTitle' => "Checkout List",
        'ProductName' => json_encode(array( 0 => "Purchase {$title}")),
        'ProductPrice' => json_encode(array( 0 => $fullAmount)),
        'ProductQty' => json_encode(array( 0 => 1)),
    );

    $fields_string = http_build_query($comon_array);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_URL,"https://api.upayments.com/payment-request");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close ($ch);
	$response = json_decode($server_output,true);

    if( $response["status"] == "success" && isset($response["paymentURL"]) && !empty($response["paymentURL"]) ){
        $_POST["gatewayId"] = $comon_array["order_id"];
        $_POST["gatewayURL"] = $response["paymentURL"];
        $_POST["apiPayload"] = json_encode($comon_array);
        $_POST["apiResponse"] = json_encode($response);
        $response["data"] = array(
            "paymentURL" => $response["paymentURL"],
            "InvoiceId"  => $comon_array["order_id"]
        );
        updateDB("purchases",$_POST,"`id` = '{$data["id"]}'");
        echo outputData($response);
    }else{
        $response = array(
            "msg" => 'Error while proccessing payment',
        );
        echo outputError($response);
    }
    
}
?>