<?php
if( !isset($_POST) ){
    $response["msg"] = "Please make sure you send post data before submitting.";
	echo outputError($response);die();
}else{
    $data = $_POST;
    unset($_POST);
    $user = $data["user"];
    $academy = $data["academy"];
    $session = $data["session"];
    $subscription = $data["subscription"];
    $subscriptionQuantity = $data["subscriptionQuantity"]; 
    $jersyQuantity = $data["jersyQuantity"];
    $paymentMethod = $data["paymentMethod"];

    if( $sessionData = selectDB("sessions","`id` = '{$session}' AND `quantity` >= '{$subscriptionQuantity}'")){}else{
        $response = array(
            "msg" => 'No sessions available anymore.',
        );
        echo outputError($response);die();
    }
    if( $userData = selectDB("users","`id` LIKE '{$user}'") ){}
    if( $AdminSettings = selectDB("settings","`id` = '1'") ){}
    if( $academyData = selectDB("academies","`id` = '{$academy}'")){
        $jersyPrice = ( $jersyQuantity != 0 ) ? (float)$academyData[0]["clothesPrice"]*(float)$data["jersyQuantity"] : 0 ;
    }
    if( $subscriptionData = selectDB("subscriptions","`id` = '{$subscription}'")){
        $price = ($subscriptionData[0]["priceAfterDiscount"] != 0 ) ? $subscriptionData[0]["priceAfterDiscount"] : $subscriptionData[0]["price"] ;
        $totalPrice = (float)$price*(float)$subscriptionQuantity;
    }else{
        $totalPrice = 0;
        $price = 0;
    }
    if( $paymentMethod == 3 ){
        $paymentMethod = 1;
        $wallet = 1;
    }else{
        $wallet = 0;
    }
    $newTotal = (float)$jersyPrice+(float)$totalPrice;
    $fullAmount = (float)$jersyPrice+(float)$totalPrice;

    $_POST["name"] = "{$userData[0]["firstName"]} {$userData[0]["lastName"]}";
    $_POST["phone"] = "{$userData[0]["phone"]}";
    $_POST["email"] = "{$userData[0]["email"]}";
    $_POST["userId"] = "{$userData[0]["id"]}";
    $_POST["academyId"] = $academyData[0]["id"];
    $_POST["enAcademy"] = $academyData[0]["enTitle"];
    $_POST["arAcademy"] = $academyData[0]["arTitle"];
    $_POST["sessionId"] = $sessionData[0]["id"];
    $_POST["enSession"] = $sessionData[0]["enTitle"];
    $_POST["arSession"] = $sessionData[0]["arTitle"];
    $_POST["subscriptionId"] = $subscriptionData[0]["id"];
    $_POST["enSubscription"] = $subscriptionData[0]["enTitle"];
    $_POST["arSubscription"] = $subscriptionData[0]["arTitle"];
    $_POST["subscriptionQuantity"] = $subscriptionQuantity;
    $_POST["subscriptionPrice"] = $price;
    $_POST["jersyQuantity"] = $jersyQuantity;
    $_POST["jersyPrice"] = $academyData[0]["clothesPrice"];
    $_POST["totalSubscriptionPrice"] = $totalPrice;
    $_POST["totalJersyPrice"] = $jersyPrice;
    $_POST["total"] = $newTotal;
    $_POST["paymentMethod"] = $paymentMethod;

    // calculate totals 
    if( $data["paymentMethod"] == 1 ){
        $myacadDeposit = $academyData[0]["charges"];
        $newTotal = $newTotal - $myacadDeposit;
    }elseif( $data["paymentMethod"] == 2 ){
        $myacadDeposit = $newTotal * ( $academyData[0]["cc_charge"] / 100 );
        $newTotal = $newTotal - $myacadDeposit;
    }
    /*
    // 0 take charges with 0 commission, 1 take rest with commission
    $apiData = array(
        'endpoint' => 'PaymentRequestExicuteForVendorsTest',
        'apikey' => 'CKW-1623165837-1075',
        'PaymentMethodId' => "{$paymentMethod}",
        'CustomerName' => "{$_POST["name"]}",
        'CustomerMobile' => "{$_POST["phone"]}",
        'CustomerEmail' => "{$_POST["email"]}",
        'invoiceValue' => "{$fullAmount}",
        'CallBackUrl' => 'https://myacad.app/index.php',
        'ErrorUrl' => 'https://myacad.app/index.php',
        'extraMerchantsData[amounts][0]' => "{$myacadDeposit}",
        'extraMerchantsData[charges][0]' => '0.100',
        'extraMerchantsData[chargeType][0]' => 'fixed',
        'extraMerchantsData[cc_charge][0]' => '0.100',
        'extraMerchantsData[cc_chargetype][0]' => 'fixed',
        'extraMerchantsData[ibans][0]' => 'KW63KWIB0000000000262010024008',
        'extraMerchantsData[amounts][1]' => "{$newTotal}",
        'extraMerchantsData[charges][1]' => "0",
        'extraMerchantsData[chargeType][1]' => "fixed",
        'extraMerchantsData[cc_charge][1]' => "0",
        'extraMerchantsData[cc_chargetype][1]' => "fixed",
        'extraMerchantsData[ibans][1]' => "{$academyData[0]["iban"]}"
    );
    */
    $extraMerchantData =  array(
        'amounts' => array($myacadDeposit,$newTotal),
        'charges' => array(0.100,0),
        'chargeType' => array('fixed','fixed'),
        'cc_charges' => array(0.100,0),
        'cc_chargeType' => array('percentage','percentage'),
        'ibans' => array("{$AdminSettings[0]["mainIban"]}","{$academyData[0]["iban"]}")
    );
    $comon_array = array(
        "merchant_id"=> "24072",
        "username"=> "create_lwt",
        "password"=> stripslashes('sJg@Q9N6ysvP'),
        "api_key"=> password_hash('afmceR6nHQaIehhpOel036LBhC8hihuB8iNh9ACF',PASSWORD_BCRYPT),
        "order_id"=> time(),
        'total_price'=>$fullAmount,
        'success_url'=>'https://myacad.app/index.php',
        'error_url'=>'https://myacad.app/index.php',
        'notifyURL'=>'https://myacad.app/index.php',
        'test_mode'=>0,
        'CurrencyCode'=>'KWD',			
        'CstFName'=>"{$_POST["name"]}",			
        'Cstemail'=>"{$_POST["email"]}",
        'CstMobile'=>"{$_POST["phone"]}",
        'ExtraMerchantsData'=> json_encode($extraMerchantData),//Optional for multivendor API
    );

    $fields_string = http_build_query($comon_array);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_URL,"https://api.upayments.com/payment-request");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close ($ch);
	$response = json_decode($server_output,true);

    //$response = json_decode(payment($apiData),true);
    if( $response["status"] == "success" && isset($response["paymentURL"]) && !empty($response["paymentURL"]) ){
        $_POST["gatewayId"] = $comon_array["order_id"];
        $_POST["gatewayURL"] = $response["paymentURL"];
        $_POST["apiPayload"] = json_encode($comon_array);
        $_POST["apiResponse"] = json_encode($response);
        $_POST["paymentMethod"] = ( $wallet == 1 ) ? 3 : $paymentMethod;
        insertDB2("orders",$_POST);
        if( $wallet == 1 ){
            $array["data"] = array(
                "paymentURL" => "index.php?v=Success&OrderID={$_POST["gatewayId"]}",
                "InvoiceId" => $comon_array["order_id"]
            );
            if( $user = selectDB("users","`id` = {$_POST["userId"]}") ){
                $newWallet = $user[0]["wallet"] - $_POST["total"];
                updateDB("users",array("wallet" => $newWallet),"`id` = {$_POST["userId"]}");
            }
            echo outputData($array);
        }else{
            echo outputData($response);
        }
    }else{
        $response = array(
            "msg" => 'Error while proccessing payment',
        );
        echo outputError($response);
    }
    
}
?>