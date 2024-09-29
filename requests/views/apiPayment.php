<?php
if( !isset($_POST) ){
    $response["msg"] = popupMsg($requestLang,"Please make sure you send post data before submitting.","يرجى التأكد من ارسال بيانات POST قبل الارسال");
	echo outputError($response);die();
}else{
    $orderId = time();
    $wallet = 0;
    $freePayment = 0;
    $data = $_POST;
    unset($_POST);
    if( isset($data["academy"]) && !empty($data["academy"]) ){
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

        //preparing upayment payload and creating order
        $postBody = array(
            'language' => 'en',
            'paymentGateway[src]' => "{$paymentGateway}",
            'order[id]' => $orderId,
            'order[currency]' => 'KWD',
            'order[amount]' => (string)$fullAmount,
            'order[description]' => "order for {$academyData[0]["enTitle"]}, {$sessionData[0]["enTitle"]}, {$subscriptionQuantity}x {$subscriptionData[0]["enTitle"]} and {$jersyQuantity}x jersy",
            'reference[id]' => $orderId,
            'customer[name]' => "{$_POST["name"]}",
            'customer[email]' => "{$_POST["email"]}",
            'customer[mobile]' => "{$_POST["phone"]}",
            'returnUrl' => 'https://myacad.app/index.php',
            'cancelUrl' => 'https://myacad.app/index.php',
            'notificationUrl' => 'https://myacad.app/index.php',
            'extraMerchantData[0][amount]' => (string)$myacadDeposit,
            'extraMerchantData[0][knetCharge]' => '0.25',
            'extraMerchantData[0][knetChargeType]' => 'fixed',
            'extraMerchantData[0][ccCharge]' => '0.25',
            'extraMerchantData[0][ccChargeType]' => 'fixed',
            'extraMerchantData[0][ibanNumber]' => "{$AdminSettings[0]["mainIban"]}",
            'extraMerchantData[1][amount]' => (string)($newTotal+(float)$jersyPrice),
            'extraMerchantData[1][knetCharge]' => '0.25',
            'extraMerchantData[1][knetChargeType]' => 'fixed',
            'extraMerchantData[1][ccCharge]' => '0.25',
            'extraMerchantData[1][ccChargeType]' => 'fixed',
            'extraMerchantData[1][ibanNumber]' => "{$academyData[0]["iban"]}",
            );
            
    }else{
        $user = $data["user"];
        $tournament = $data["tournament"];
        $teamName = $data["teamName"];
        $players = $data["players"];
        $bench = $data["bench"];
        $quantity = $data["quantity"];
        $paymentMethod = $data["paymentMethod"];
        $voucher = $data["voucher"];
        
        //checking voucher
        $numberOfTimesAvalability = false;
        $tournamentAprroved = false;
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
                if( $orders = selectDB("orders","`voucher` = '{$voucher[0]["id"]}' AND `isTournament` = 1") ){
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
            
            if( $voucher[0]["tournamentId"] != 0 ){
                if( $voucher[0]["tournamentId"] == $tournament ){
                    $tournamentAprroved = true;
                }else{
                    $tournamentAprroved = false;
                }
            }elseif( $voucher[0]["tournamentId"] == 0 ){
                $tournamentAprroved = true;
            }
            
            if( $numberOfTimesAvalability && $tournamentAprroved && $dateApproved){
                $voucherType = ($voucher[0]["type"] == 0) ? 0 : 1;
                $voucherAmount = $voucher[0]["amount"];
            }
        }

        // checking user data
        if( $userData = selectDB("users","`id` LIKE '{$user}'") ){}

        //checking adamin settings for main IBAN
        if( $AdminSettings = selectDB("settings","`id` = '1'") ){}

        //checking tournament Inforamtion
        if( $tournamentData = selectDB("tournaments","`id` = '{$tournament}'")){}

        //checking payment method
        if( $paymentMethod == 3 ){
            $paymentMethod = 1;
            $wallet = 1;
        }

        //checking free payment
        if( $paymentMethod == 4 ){
            $paymentMethod = 1;
            $freePayment = 1;
        }

        //check tournemant Price
        if( $tournaments = selectDB("tournaments","`id` = '{$tournament}'") ){
            $price = $tournaments[0]["price"];
        }

        //calulation of total prices
        $newTotal = (float)$price;
        $fullAmount = (float)$price;
        if( $numberOfTimesAvalability && $tournamentAprroved ){
            $newTotal = ( $voucherType == 0 ) ? ($newTotal*(1-($voucherAmount/100))) : $newTotal - $voucherAmount;
            $fullAmount = ( $voucherType == 0 ) ? ($fullAmount*(1-($voucherAmount/100))) : $fullAmount - $voucherAmount;
        }

        $_POST["name"] = "{$userData[0]["firstName"]} {$userData[0]["lastName"]}";
        $_POST["phone"] = "{$userData[0]["phone"]}";
        $_POST["email"] = "{$userData[0]["email"]}";
        $_POST["userId"] = "{$userData[0]["id"]}";
        $_POST["tournamentId"] = $tournaments[0]["id"];
        $_POST["teamDetails"]["enTournament"] = $tournaments[0]["enTitle"];
        $_POST["teamDetails"]["arTournament"] = $tournaments[0]["arTitle"];
        $_POST["teamDetails"]["teamName"] = $teamName;
        $_POST["teamDetails"]["players"] = $players;
        $_POST["teamDetails"]["bench"] = $bench;
        $_POST["teamDetails"]["quantity"] = $quantity;
        $_POST["teamDetails"]["price"] = $price;
        $_POST["teamDetails"]["total"] = $newTotal;
        $_POST["paymentMethod"] = $paymentMethod;
        $_POST["voucher"] = $data["voucher"];

        $_POST["teamDetails"] = json_encode($_POST["teamDetails"]);

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

        //preparing upayment payload and creating order
        $postBody = array(
            'language' => 'en',
            'paymentGateway[src]' => "{$paymentGateway}",
            'order[id]' => $orderId,
            'order[currency]' => 'KWD',
            'order[amount]' => (string)$fullAmount,
            'order[description]' => "order for {$tournaments[0]["enTitle"]}, {$teamName}, {$quantity}x Players: {$players} and Bench: {$bench}",
            'reference[id]' => $orderId,
            'customer[name]' => "{$_POST["name"]}",
            'customer[email]' => "{$_POST["email"]}",
            'customer[mobile]' => "{$_POST["phone"]}",
            'returnUrl' => 'https://myacad.app/index.php',
            'cancelUrl' => 'https://myacad.app/index.php',
            'notificationUrl' => 'https://myacad.app/index.php',
            'extraMerchantData[0][amount]' => (string)$myacadDeposit,
            'extraMerchantData[0][knetCharge]' => '0.25',
            'extraMerchantData[0][knetChargeType]' => 'fixed',
            'extraMerchantData[0][ccCharge]' => '0.25',
            'extraMerchantData[0][ccChargeType]' => 'fixed',
            'extraMerchantData[0][ibanNumber]' => "{$AdminSettings[0]["mainIban"]}",
            'extraMerchantData[1][amount]' => (string)($newTotal),
            'extraMerchantData[1][knetCharge]' => '0.25',
            'extraMerchantData[1][knetChargeType]' => 'fixed',
            'extraMerchantData[1][ccCharge]' => '0.25',
            'extraMerchantData[1][ccChargeType]' => 'fixed',
            'extraMerchantData[1][ibanNumber]' => "{$tournamentData[0]["iban"]}",
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
            'Authorization: Bearer afmceR6nHQaIehhpOel036LBhC8hihuB8iNh9ACF',
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response,true);

    //saving info and redirecting to payment pages
    if( $response["status"] == true && isset($response["data"]["link"]) && !empty($response["data"]["link"]) ){
        $_POST["gatewayId"]     = $orderId;
        $_POST["gatewayURL"]    = $response["data"]["link"];
        $_POST["apiPayload"]    = json_encode($postBody);
        $_POST["apiResponse"]   = json_encode($response);
        $_POST["paymentMethod"] = ( $wallet == 1 ) ? 3 : $paymentMethod;
        $_POST["paymentMethod"] = ( $freePayment == 1 ) ? 4 : $_POST["paymentMethod"];
        $response["paymentURL"] = $response["data"]["link"];
        $response["data"] = array(
            "paymentURL" => $response["data"]["link"],
            "InvoiceId"  => $orderId
        );
        insertDB2("orders",$_POST);
        if( $wallet == 1 || $freePayment == 1){
            $response["data"] = array(
                "paymentURL"    => "index.php?v=Success&requested_order_id={$_POST["gatewayId"]}&result=CAPTURED",
                "InvoiceId"     => $orderId
            );
            if( $user = selectDB("users","`id` = {$_POST["userId"]}") ){
                $newWallet = $user[0]["wallet"] - $newTotal;
                updateDB("users",array("wallet" => $fullAmount),"`id` = {$_POST["userId"]}");
            }
            echo outputData($response);
        }else{
            echo outputData($response);
        }
    }else{
        $response["msg"] = popupMsg($requestLang,'Error while proccessing payment','خطأ في عملية الدفع');
        echo outputError($response);
    }
    
}
?>