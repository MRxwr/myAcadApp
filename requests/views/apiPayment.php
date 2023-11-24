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
    $voucher = $data["voucher"];
    
    //checking voucher
    $numberOfTimesAvalability = false;
    $academyAprroved = false;
    $dateApproved = false;
    if( isset($voucher) && !empty($voucher) && $voucher = selectDB("vouchers","`code` = '{$data["voucher"]}' AND `hidden` = '0' AND `status` = '0'")){
        $currentDate = date("Y-m-d");
        if( (substr($voucher[0]["startDate"],0,10) <= $currentDate) && (substr($voucher[0]["endDate"],0,10) >= $currentDate) ){
            $dateApproved = true;
        }
        
        if( $voucher[0]["numberOfTimes"] == 0 ){
            $numberOfTimesAvalability = true;
        }elseif( $voucher[0]["numberOfTimes"] != 0 ){
            if( $orders = selectDB("orders","`voucher` = '{$voucher[0]["id"]}'")){
                $numberOfUsage = sizeof($orders);
                if( $voucher[0]["numberOfTimes"] > $numberOfUsage ){
                    $numberOfTimesAvalability = true;
                }else{
                    $numberOfTimesAvalability = false;
                }
            }else{
                $numberOfTimesAvalability = true;
            }
        }
        
        if( $voucher[0]["academyId"] != 0 ){
            if( $voucher[0]["academyId"] == $academy ){
                $academyAprroved = true;
            }else{
                $academyAprroved = false;
            }
        }elseif( $voucher[0]["academyId"] == 0 ){
            $academyAprroved = true;
        }
        
        if( $numberOfTimesAvalability && $academyAprroved && $dateApproved){
            $voucherType = ($voucher[0]["type"] == 0) ? 0 : 1;
            $voucherAmount = $voucher[0]["amount"];
        }
    }

    //checking session information
    if( $sessionData = selectDB("sessions","`id` = '{$session}' AND `quantity` >= '{$subscriptionQuantity}'")){}else{
        $response = array(
            "msg" => 'No sessions available anymore.',
        );
        echo outputError($response);die();
    }

    // checking user data
    if( $userData = selectDB("users","`id` LIKE '{$user}'") ){}

    //checking adamin settings for main IBAN
    if( $AdminSettings = selectDB("settings","`id` = '1'") ){}

    //checking jersy Inforamtion
    if( $academyData = selectDB("academies","`id` = '{$academy}'")){
        $jersyPrice = ( $jersyQuantity != 0 ) ? (float)$academyData[0]["clothesPrice"]*(float)$data["jersyQuantity"] : 0 ;
    }

    //checking subscription information
    if( $subscriptionData = selectDB("subscriptions","`id` = '{$subscription}'")){
        $price = ($subscriptionData[0]["priceAfterDiscount"] != 0 ) ? $subscriptionData[0]["priceAfterDiscount"] : $subscriptionData[0]["price"] ;
        if( $numberOfTimesAvalability && $academyAprroved ){
            $price = $subscriptionData[0]["price"];
        }
        $totalPrice = (float)$price*(float)$subscriptionQuantity;
    }else{
        $totalPrice = 0;
        $price = 0;
    }

    //checking payment method
    if( $paymentMethod == 3 ){
        $paymentMethod = 1;
        $wallet = 1;
    }else{
        $wallet = 0;
    }

    //calulation of total prices
    $newTotal = (float)$totalPrice;
    $fullAmount = (float)$jersyPrice+(float)$totalPrice;
    if( $numberOfTimesAvalability && $academyAprroved ){
        $newTotal = ( $voucherType == 0 ) ? ($newTotal*(1-($voucherAmount/100))) : $newTotal - $voucherAmount;
        $fullAmount = ( $voucherType == 0 ) ? ($fullAmount*(1-($voucherAmount/100))) : $fullAmount - $voucherAmount;
    }

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
    $_POST["total"] = $fullAmount;
    $_POST["paymentMethod"] = $paymentMethod;
    $_POST["voucher"] = $data["voucher"];

    //calculate totals prices that should be sent to upayments 
    if( $data["paymentMethod"] == 1 ){
        $myacadDeposit = $academyData[0]["charges"];
        $newTotal = $newTotal - $myacadDeposit;
        $paymentGateway = "Knet";
    }elseif( $data["paymentMethod"] == 2 ){
        $myacadDeposit = $newTotal * ( $academyData[0]["cc_charge"] / 100 );
        $newTotal = $newTotal - $myacadDeposit;
        $paymentGateway = "cc";
    }else{
        $myacadDeposit = 1;
        $newTotal = $newTotal - $myacadDeposit;
        $paymentGateway = "Knet";
    }

    //preparing upayment payload
    $extraMerchantData =  array(
        'amounts' => array($myacadDeposit,$newTotal),
        'charges' => array(0.250,0),
        'chargeType' => array('fixed','fixed'),
        'cc_charges' => array(0.250,0),
        'cc_chargeType' => array('fixed','percentage'),
        'ibans' => array("{$AdminSettings[0]["mainIban"]}","{$academyData[0]["iban"]}")
    );
    $comon_array = array(
        "merchant_id"=> "24072",
        "username"=> "create_lwt",
        "password"=> stripslashes('sJg@Q9N6ysvP'),
        "api_key"=> password_hash('afmceR6nHQaIehhpOel036LBhC8hihuB8iNh9ACF',PASSWORD_BCRYPT),
        "payment_gateway" => "{$paymentGateway}",
        "order_id"=> time(),
        'total_price'=>$fullAmount,
        'success_url'=>'https://myacad.app/index.php',
        'error_url'=>'https://myacad.app/index.php',
        'notifyURL'=>'https://myacad.app/index.php',
        'test_mode'=>0,
        "whitelabled" => 1,
        'CurrencyCode'=>'KWD',			
        'CstFName'=>"{$_POST["name"]}",			
        'Cstemail'=>"{$_POST["email"]}",
        'CstMobile'=>"{$_POST["phone"]}",
        'ExtraMerchantsData'=> json_encode($extraMerchantData),//Optional for multivendor API
    );
    
    //print_r($comon_array);die();

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

    //saving info and redirecting to payment pages
    if( $response["status"] == "success" && isset($response["paymentURL"]) && !empty($response["paymentURL"]) ){
        $_POST["gatewayId"] = $comon_array["order_id"];
        $_POST["gatewayURL"] = $response["paymentURL"];
        $_POST["apiPayload"] = json_encode($comon_array);
        $_POST["apiResponse"] = json_encode($response);
        $_POST["paymentMethod"] = ( $wallet == 1 ) ? 3 : $paymentMethod;
        $response["data"] = array(
            "paymentURL" => $response["paymentURL"],
            "InvoiceId"  => $comon_array["order_id"]
        );
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