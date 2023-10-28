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
        echo outputError($response);
    }
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
        $paymentMethod = 1;
        $wallet = 1;
    }else{
        $wallet = 0;
    }
    $newTotal = (float)$jersyPrice+(float)$totalPrice;

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

    // 0 take charges with 0 commission, 1 take rest with commission
    $apiData = array(
        'endpoint' => 'PaymentRequestExicuteForVendorsTest',
        'apikey' => 'CKW-1623165837-1075',
        'PaymentMethodId' => "{$paymentMethod}",
        'CustomerName' => "{$_POST["name"]}",
        'CustomerMobile' => "{$_POST["phone"]}",
        'CustomerEmail' => "{$_POST["email"]}",
        'invoiceValue' => "{$newTotal}",
        'CallBackUrl' => 'https://createkwservers.com/myacad1/index.php',
        'ErrorUrl' => 'https://createkwservers.com/myacad1/index.php',
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

    $response = json_decode(payment($apiData),true);
    if( isset($response["data"]["InvoiceId"]) && !empty($response["data"]["InvoiceId"]) ){
        $_POST["gatewayId"] = $response["data"]["InvoiceId"];
        $_POST["gatewayURL"] = $response["data"]["paymentURL"];
        $_POST["apiPayload"] = json_encode($apiData);
        $_POST["apiResponse"] = json_encode($response);
        $_POST["paymentMethod"] = ( $wallet == 1 ) ? 3 : $paymentMethod;
        insertDB2("orders",$_POST);
        if( $wallet == 1 ){
            $array["data"] = array(
                "paymentURL" => "index.php?v=Success&OrderID={$_POST["gatewayId"]}",
                "InvoiceId" => $response["data"]["InvoiceId"]
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