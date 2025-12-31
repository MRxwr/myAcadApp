<?php
if( !isset($_POST) ){
    $response["msg"] = popupMsg($requestLang,"Please make sure you send post data before submitting.","يرجى التأكد من ارسال بيانات POST قبل الارسال");
	echo outputError($response);die();
}else{
    $orderId = time();
    $freePayment = 0;
    $wallet = 0;
    $data = $_POST;
    unset($_POST);
    if( isset($data["bookingId"]) && !empty($data["bookingId"]) ){
        $bookingData = selectDB("fields_booking","`id` LIKE '{$data["bookingId"]}'");
        if( $bookingData ){
            $data["fieldId"] = $bookingData[0]["fieldId"];
            $data["periodId"] = $bookingData[0]["periodId"];
            $data["bookingDate"] = $bookingData[0]["bookingDate"];
            $data["startTime"] = $bookingData[0]["startTime"];
            $data["endTime"] = $bookingData[0]["endTime"];
            $data["levels"] = $bookingData[0]["levels"];
            $data["ages"] = $bookingData[0]["ages"];
            $data["notes"] = $bookingData[0]["notes"];
            $data["isTbari"] = $bookingData[0]["isTbari"];
            $data["total"] = $bookingData[0]["total"];
        }
    }else{
        $data["bookingId"] = 0;
    }
    if( isset($data["fieldId"]) && !empty($data["fieldId"]) ){
        $user = $data["userId"];
        $paymentMethod = $data["paymentMethod"];
    
        // checking user data
        if( $userData = selectDB("users","`id` LIKE '{$user}'") ){}

        //checking adamin settings for main IBAN
        if( $AdminSettings = selectDB("settings","`id` = '1'") ){}

        //checking field Information
        if( $fieldData = selectDB("fields_list","`id` = '{$data["fieldId"]}'") ){
            $data["price"] = (float)$fieldData[0]["price"];
            if( $data["bookingId"] != 0 ){
                $data["price"] = (float)$bookingData[0]["total"] / 2;
            }else{
                $data["price"] = (float)$data["total"];
            }
        }
            
        //checking payment method
        if( $paymentMethod == 3 ){
            $paymentMethod = 1;
            $wallet = 1;
        }

        //trabi payment method
        if( $paymentMethod == 4 ){
            $paymentMethod = 1;
            $freePayment = 1;
        }

        //calulation of total prices
        $newTotal = (float)$data["price"];
        $fullAmount = (float)$data["price"];

        $_POST["bookingId"] = $data["bookingId"];
        $_POST["name"] = "{$userData[0]["firstName"]} {$userData[0]["lastName"]}";
        $_POST["phone"] = "{$userData[0]["phone"]}";
        $_POST["email"] = "{$userData[0]["email"]}";
        $_POST["userId"] = "{$userData[0]["id"]}";
        $_POST["fieldId"] = $data["fieldId"];
        $_POST["periodId"] = $data["periodId"];
        $_POST["bookingDate"] = $data["bookingDate"];
        $_POST["startTime"] = $data["startTime"];
        $_POST["endTime"] = $data["endTime"];
        $_POST["levels"] = $data["levels"];
        $_POST["ages"] = $data["ages"];
        $_POST["notes"] = $data["notes"];
        $_POST["isTbari"] = $data["isTbari"];
        $_POST["total"] = $fullAmount;
        $_POST["paymentMethod"] = $paymentMethod;

        //calculate totals prices that should be sent to upayments 
        if( $data["paymentMethod"] == 1 ){
            $myacadDeposit = ( $fieldData[0]["chargeType"] == "fixed" ) ? $fieldData[0]["charges"] : $newTotal * ( $fieldData[0]["charges"] / 100 );
            $newTotal = $newTotal - $myacadDeposit;
            $paymentGateway = "knet";
        }elseif( $data["paymentMethod"] == 2 ){
            $myacadDeposit = ( $fieldData[0]["cc_chargetype"] == "fixed" ) ? $fieldData[0]["cc_charge"] : $newTotal * ( $fieldData[0]["cc_charge"] / 100 );
            $newTotal = $newTotal - $myacadDeposit;
            $paymentGateway = "cc";
        }else{
            $myacadDeposit = 1;
            $newTotal = $newTotal - $myacadDeposit;
            $paymentGateway = "knet";
        }

        //preparing upayment payload and creating order
        $postBody = array(
            'language' => 'en',
            'paymentGateway[src]' => "{$paymentGateway}",
            'order[id]' => $orderId,
            'order[currency]' => 'KWD',
            'order[amount]' => (string)$fullAmount,
            'order[description]' => "order for {$fieldData[0]["enTitle"]}, {$data["bookingDate"]}, {$data["startTime"]} to {$data["endTime"]}",
            'reference[id]' => $orderId,
            'customer[name]' => "{$_POST["name"]}",
            'customer[email]' => "{$_POST["email"]}",
            'customer[mobile]' => "{$_POST["phone"]}",
            'returnUrl' => 'https://dev.myacad.app/index.php',
            'cancelUrl' => 'https://dev.myacad.app/index.php',
            'notificationUrl' => 'https://dev.myacad.app/index.php',
            'extraMerchantData[0][amount]' => (string)($fullAmount),
            'extraMerchantData[0][knetCharge]' => "{$fieldData[0]["charges"]}",
            'extraMerchantData[0][knetChargeType]' => "{$fieldData[0]["chargeType"]}",
            'extraMerchantData[0][ccCharge]' => "{$fieldData[0]["cc_charge"]}",
            'extraMerchantData[0][ccChargeType]' => "{$fieldData[0]["cc_chargetype"]}",
            'extraMerchantData[0][ibanNumber]' => "{$fieldData[0]["iban"]}",
            );
    }

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
            'Authorization: Bearer 779475522c0938b3c0774da98197e0727fefe464',
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response,true);

    //saving info and redirecting to payment pages
    if( isset($response["status"]) && $response["status"] == true && isset($response["data"]["link"]) && !empty($response["data"]["link"]) ){
        $_POST["gatewayId"]     = $orderId;
        $_POST["gatewayURL"]    = $response["data"]["link"];
        $_POST["apiPayload"]    = json_encode($postBody);
        $_POST["apiResponse"]   = json_encode($response);
        $_POST["paymentMethod"] = ( $wallet == 1 ) ? 3 : $data["paymentMethod"];
        $_POST["paymentMethod"] = ( $freePayment == 1 ) ? 4 : $data["paymentMethod"];
        $response["data"] = array(
            "paymentURL" => $response["data"]["link"],
            "InvoiceId"  => $orderId
        );
        insertDB2("fields_booking",$_POST);
        if( $wallet == 1 || $freePayment == 1){
            $response["data"] = array(
                "paymentURL"    => "index.php?v=Success&requested_order_id={$_POST["gatewayId"]}&result=CAPTURED",
                "InvoiceId"     => $orderId
            );
        }
        echo outputData($response);
    }else{
        $response["msg"] = popupMsg($requestLang,'Error while proccessing payment','خطأ في عملية الدفع');
        echo outputError($response);
    }
}
?>