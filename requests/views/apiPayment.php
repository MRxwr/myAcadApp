<?php

if( !isset($_POST) ){
    $response["msg"] = "Please make sure you send post data before submitting.";
	echo outputError($response);die();
}else{
    $data = $_POST;
    $user = $data["user"];
    $academy = $data["academy"];
    $session = $data["session"];
    $subscription = $data["subscription"];
    $subscriptionQuantity = $data["subscriptionQuantity"];
    $jersyQuantity = $data["jersyQuantity"];
    $paymentMethod = $data["paymentMethod"];

    if( $sessionData = selectDB("sessions","`id` = '{$session}'")){}
    if( $userData = selectDB("users","`id` LIKE '{$user}'") ){}
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
        $wallet = 1;
    }else{
        $wallet = 0;
    }
    $newTotal = (float)$jersyPrice+(float)$totalPrice;

    $_POST["client"]["name"] = "{$userData[0]["firstName"]} {$userData[0]["lastName"]}";
    $_POST["client"]["phone"] = "{$userData[0]["phone"]}";
    $_POST["client"]["email"] = "{$userData[0]["email"]}";
    $_POST["details"]["enAcademy"] = $academyData[0]["enTitle"];
    $_POST["details"]["arAcademy"] = $academyData[0]["arTitle"];
    $_POST["details"]["enSession"] = $sessionData[0]["enTitle"];
    $_POST["details"]["arSession"] = $sessionData[0]["arTitle"];
    $_POST["details"]["enSubscription"] = $subscriptionData[0]["enTitle"];
    $_POST["details"]["arSubscription"] = $subscriptionData[0]["arTitle"];
    $_POST["details"]["subscriptionQuantity"] = $subscriptionQuantity;
    $_POST["details"]["subscriptionPrice"] = $price;
    $_POST["details"]["jersyQuantity"] = $jersyQuantity;
    $_POST["details"]["jersyPrice"] = $academyData[0]["clothesPrice"];
    $_POST["checkout"]["totalSubscriptionPrice"] = $totalPrice;
    $_POST["checkout"]["jersyPrice"] = $jersyPrice;
    $_POST["checkout"]["total"] = $newTotal;

    $apiData = array(
        'endpoint' => 'PaymentRequestExicuteForVendorsTest',
        'apikey' => 'CKW-1623165837-1075',
        'PaymentMethodId' => "{$paymentMethod}",
        'CustomerName' => "{$_POST["client"]["name"]}",
        'CustomerMobile' => "{$_POST["client"]["phone"]}",
        'CustomerEmail' => "{$_POST["client"]["email"]}",
        'invoiceValue' => "{$newTotal}",
        'CallBackUrl' => 'https://createkwservers.com/myAcad1/?v=Success',
        'ErrorUrl' => 'https://createkwservers.com/myAcad1/?v=Fail',
        'extraMerchantsData[amounts][0]' => "{$newTotal}",
        'extraMerchantsData[charges][0]' => '0.250',
        'extraMerchantsData[chargeType][0]' => 'fixed',
        'extraMerchantsData[cc_charge][0]' => '0.250',
        'extraMerchantsData[cc_chargetype][0]' => 'fixed',
        'extraMerchantsData[ibans][0]' => 'KW84BBYN0000000000000411888006',
        'extraMerchantsData[amounts][1]' => "{$newTotal}",
        'extraMerchantsData[charges][1]' => "{$academyData[0]["charges"]}",
        'extraMerchantsData[chargeType][1]' => "{$academyData[0]["chargeType"]}",
        'extraMerchantsData[cc_charge][1]' => "{$academyData[0]["cc_charge"]}",
        'extraMerchantsData[cc_chargetype][1]' => "{$academyData[0]["cc_chargetype"]}",
        'extraMerchantsData[ibans][1]' => "{$academyData[0]["iban"]}"
    );

    if( $wallet == 1 ){
        print_r(payment($apiData));die() ;
        //header("LOCATION: https://createkwservers.com/myacad1/?v=Success");
        die();
    }else{
        print_r(payment($apiData));die();
    }
}

?>