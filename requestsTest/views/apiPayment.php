<?php
if( !isset($_POST) ){
    $response["msg"] = popupMsg($requestLang,"Please make sure you send post data before submitting.","يرجى التأكد من ارسال بيانات POST قبل الارسال");
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
    $voucherType = 0;
    $voucherAmount = 0;
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
        $response["msg"] = popupMsg($requestLang,'No sessions available anymore.','لا يوجد كلاسات متاحة.');
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
        $myacadDeposit = ( $academyData[0]["chargeType"] == "fixed" ) ? $academyData[0]["charges"] : $newTotal * ( $academyData[0]["charges"] / 100 );
        $newTotal = $newTotal - $myacadDeposit;
        $paymentGateway = "knet";
    }elseif( $data["paymentMethod"] == 2 ){
        $myacadDeposit = ( $academyData[0]["cc_chargetype"] == "fixed" ) ? $academyData[0]["cc_charge"] : $newTotal * ( $academyData[0]["cc_charge"] / 100 );
        $newTotal = $newTotal - $myacadDeposit;
        $paymentGateway = "cc";
    }else{
        $myacadDeposit = 1;
        $newTotal = $newTotal - $myacadDeposit;
        $paymentGateway = "knet";
    }

    //preparing upayment payload
    $extraMerchantData[] =  array(
        'amount' => $myacadDeposit,
        'knetCharge' => 0.250,
        'knetChargeType' => 'fixed',
        'ccCharge' => 0.250,
        'ccChargeType' => 'fixed',
        'ibanNumber' => "{$AdminSettings[0]["mainIban"]}"
    );
    $extraMerchantData[] =  array(
        'amount' => ($newTotal+(float)$jersyPrice),
        'knetCharge' => 0,
        'knetChargeType' => 'fixed',
        'ccCharge' => 0,
        'ccChargeType' => 'percentage',
        'ibanNumber' => "{$academyData[0]["iban"]}"
    );
    
    $comon_array = array(
        "paymentGateway" => array("src" => "{$paymentGateway}"),
        'returnUrl'=>'https://myacad.app/index.php',
        'cancelUrl'=>'https://myacad.app/index.php',
        'notificationUrl'=>'https://myacad.app/index.php',
        "language" => "en",
        "order" => array(
            "id" => time(),
            "description" => "order for {$academyData[0]["enTitle"]}, {$sessionData[0]["enTitle"]}, {$subscriptionData[0]["enTitle"]} with quantity {$subscriptionQuantity} and jersy quantity {$jersyQuantity}",
            "currency" => "KWD",
            "amount"=> $fullAmount
        ),
        "reference" => array(
            "id"=> time(),
        ),
        'customer' => array(
            "name" => "{$_POST["name"]}",
            "email" => "{$_POST["email"]}",
            "mobile" => "{$_POST["phone"]}"
        ),
        'extraMerchantData' => $extraMerchantData,//Optional for multivendor API
    );

    $postBody = array(
        'language' => 'en',
        'order[id]' => '123321123321',
        'order[currency]' => 'KWD',
        'order[amount]' => '10',
        'reference[id]' => '123321123321',
        'returnUrl' => 'https://google.com',
        'cancelUrl' => 'https://yahoo.com',
        'notificationUrl' => 'https://msn.com',
        'paymentGateway[src]' => 'knet',
        'extraMerchantData[0][amount]' => '10',
        'extraMerchantData[0][knetCharge]' => '0.25',
        'extraMerchantData[0][knetChargeType]' => 'fixed',
        'extraMerchantData[0][ccCharge]' => '3',
        'extraMerchantData[0][ccChargeType]' => 'percentage',
        'extraMerchantData[0][ibanNumber]' => 'KW91KFHO0000000000051010173254'
        );
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sandboxapi.upayments.com/api/v1/charge',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postBody,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer e66a94d579cf75fba327ff716ad68c53aae11528',
        ),
    ));

$response = curl_exec($curl);

curl_close($curl);
echo $response;die();
    
    
    //print_r(json_encode($comon_array));die();
    $headers = array(
        'Authorization: Bearer e66a94d579cf75fba327ff716ad68c53aae11528',
    );
    $fields_string = json_encode($comon_array);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_URL,"https://sandboxapi.upayments.com/api/v1/charge");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	var_dump($server_output = curl_exec($ch));
	curl_close ($ch);
	$response = json_decode($server_output,true);

    //saving info and redirecting to payment pages
    if( $response["status"] === true && isset($response["link"]) && !empty($response["link"]) ){
        $_POST["gatewayId"] = $comon_array["order_id"];
        $_POST["gatewayURL"] = $response["link"];
        $_POST["apiPayload"] = json_encode($comon_array);
        $_POST["apiResponse"] = json_encode($response);
        $_POST["paymentMethod"] = ( $wallet == 1 ) ? 3 : $paymentMethod;
        $response["data"] = array(
            "paymentURL" => $response["link"],
            "InvoiceId"  => $comon_array["order_id"]
        );
        insertDB2("orders",$_POST);
        if( $wallet == 1 ){
            $array["data"] = array(
                "paymentURL" => "index.php?v=Success&OrderID={$_POST["gatewayId"]}&Result=CAPTURED",
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
        $response["msg"] = popupMsg($requestLang,'Error while proccessing payment','خطأ في عملية الدفع');
        echo outputError($response);
    }
    
}
?>