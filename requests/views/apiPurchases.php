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

        var_dump($postBody);die();

	$curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://uapi.upayments.com/api/v1/charge',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postBody,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer afmceR6nHQaIehhpOel036LBhC8hihuB8iNh9ACF',
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response,true);

    if( $response["status"] == "true" && isset($response["data"]["link"]) && !empty($response["data"]["link"]) ){
        $_POST["gatewayId"] = $postBody["order_id"];
        $_POST["gatewayURL"] = $response["data"]["link"];
        $_POST["apiPayload"] = json_encode($postBody);
        $_POST["apiResponse"] = json_encode($response);
        $response["data"] = array(
            "paymentURL" => $response["data"]["link"],
            "InvoiceId"  => $postBody["order_id"]
        );
        updateDB("purchases",$_POST,"`id` = '{$data["id"]}'");
        echo outputData($response);
    }else{
        $response["msg"] = popupMsg($requestLang,'Error while proccessing payment','خطأ في عملية الدفع');
        echo outputError($response);
    }
    
}
?>