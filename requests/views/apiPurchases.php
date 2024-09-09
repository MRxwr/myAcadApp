<?php
if( !isset($_POST) ){
    $response["msg"] = popupMsg($requestLang,"Please make sure you send post data before submitting.","يرجى التأكد من ارسال بيانات POST قبل الارسال");
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

    $postBody = array(
        'language' => 'en',
        'paymentGateway[src]' => "knet",
        'order[id]' => time(),
        'order[currency]' => 'KWD',
        'order[amount]' => (string)$fullAmount,
        'order[description]' => "Checkout List for 1x " . json_encode(array( 0 => "Purchase {$title}")),
        'reference[id]' => $orderId,
        'customer[name]' => "PURCHASE MYACAD",
        'customer[email]' => "{$AdminSettings[0]["email"]}",
        'customer[mobile]' => "00{$socialMedia[0]["whatsapp"]}",
        'returnUrl' => 'https://myacad.app/Purchase.php',
        'cancelUrl' => 'https://myacad.app/Purchase.php',
        'notificationUrl' => 'https://myacad.app/Purchase.php',
        'extraMerchantData[0][amount]' => (string)$fullAmount,
        'extraMerchantData[0][knetCharge]' => '0.25',
        'extraMerchantData[0][knetChargeType]' => 'fixed',
        'extraMerchantData[0][ccCharge]' => '0.25',
        'extraMerchantData[0][ccChargeType]' => 'fixed',
        'extraMerchantData[0][ibanNumber]' => "{$iban}",
        );

    $fields_string = http_build_query($postBody);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_URL,"https://uapi.upayments.com/api/v1/charge");
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
        $response["msg"] = popupMsg($requestLang,'Error while proccessing payment','خطأ في عملية الدفع');
        echo outputError($response);
    }
    
}
?>