<?php
//Notification through Create Pay \\
function sendNotification($data){
	$server_key = 'AAAAbnnBXmc:APA91bG-NRW9C4ljOlrTfpyrEfiTP1foDG8EDMjvAUyakHzC2N0kMLhvIZx1WpAehpCCppnY3yIKGh81mk11NV9YNO3xt8khV194ql83RMsOsbui6qo6iO51AwQscjwluoqe3Bk9_qJ6';
	$url = 'https://fcm.googleapis.com/fcm/send';
	$headers = array(
		'Content-Type:application/json',
		'Authorization:key='.$server_key
	);
	$json_data = array(
		"to" => "{$data["firebase"]}",
		"notification" => array(
			"body" => "{$data["msg"]}",
			"text" => "{$data["msg"]}",
			"title" => "{$data["title"]}",
			"sound" => "default",
			"content_available" => "true",
			"priority" => "high",
			"badge" => "1"
		),
		"data" => array(
			"body" => "{$data["msg"]}",
			"title" => "{$data["title"]}",
			"text" => "{$data["msg"]}",
			"sound" => "default",
			"content_available" => "true",
			"priority" => "high",
			"badge" => "1"
		)
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json_data));
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}

function expiredSubscription(){
	/*
	if ( $getSubscriptions = selectDB2("`userId`,`enAcademy`,`arAcademy`, `id`","orders","DATEDIFF( DATE_SUB(DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH), INTERVAL 2 DAY), DATE_SUB(DATE_ADD(`date`, INTERVAL 1 MONTH), INTERVAL 2 DAY) ) <= 2 AND `isNotified` = '0'") ){
		for( $i = 0; $i < sizeof($getSubscriptions); $i++ ){
			$user = selectDB2("firebase","users","`id` = '{$getSubscriptions[$i]["userId"]}'");
			$data = array(
				"title" => direction("Subscription End Soon","سينتهي الإشتراك قريبا"),
				"msg" => direction("Your subscription with {$getSubscriptions[$i]["enAcademy"]} Will end soon. Please resubscribe and continue the fun.","سينتهي إشتراك قريبا مع {$getSubscriptions[$i]["arAcademy"]}، الرجاء إعادة الإشتراك لتستمر المتعه."),
				"firebase" => $user[0]["firebase"]
			);
			sendNotification($data);
			updateDB("orders",array("isNotified"=>1),"`id` = '{$getSubscriptions[$i]["id"]}}'");
		}
	}
	*/
	if ($orders = selectDB("orders", "`status` = '1' AND `isNotified` = '0'")) {
        for ($i = 0; $i < sizeof($orders); $i++) {
            $subscriptions = selectDB("subscriptions", "`id` = '{$orders[$i]["subscriptionId"]}'");
			$user = selectDB2("firebase","users","`id` = '{$orders[$i]["userId"]}'");
            $numberOfDays = ($subscriptions[0]["numberOfDays"]-2);
            $endDate = date("Y-m-d H:i:s", strtotime($orders[$i]["date"] . " +{$numberOfDays} days"));
            $endDateTimestamp = strtotime($endDate);
			$todayDate = date("Y-m-d H:i:s");
            $todaysDate = strtotime($todayDate);
            if ($endDateTimestamp <= $todaysDate ) {
				$data = array(
					"title" => direction("Subscription End Soon","سينتهي الإشتراك قريبا"),
					"msg" => direction("Your subscription with {$orders[$i]["enAcademy"]} Will end soon. Please resubscribe and continue the fun.","سينتهي إشتراك قريبا مع {$orders[$i]["arAcademy"]}، الرجاء إعادة الإشتراك لتستمر المتعه."),
					"firebase" => $user[0]["firebase"]
				);
				sendNotification($data);
                updateDB2("orders", array("isNotified" => 1), "`id` = '{$orders[$i]["id"]}'");
            }
        }
    }
}

function emailBody($order){
	if( $order[0]["paymentMethod"] == 1 || $order[0]["paymentMethod"] == 2 ){
		$method = "Online Payment";
	}elseif( $order[0]["paymentMethod"] == 3 ){
		$method = "WALLET";
	}else{
		$method = "FREE";
	}
	$body = '<table style="width:100%">
			<tr>
			<td colspan="2" style="text-align:center"><img src="https://myacad.app/img/logo.png" style="width:100px; height:100px"></td>
			</tr>
			<tr>
			<td colspan="2">
			You have a new order #'.$order[0]["id"].'<br>
			Name: '.$order[0]["name"].'<br>
			Mobile: '.$order[0]["phone"].'<br></td>
			</tr>
			<tr>
			<td><hr>Item<hr></td>
			<td><hr>Price<hr></td>
			</tr>';
		if( $order[0]["isTournament"] == 0 ){
			$body .= "<tr>
			<td>{$order[0]["subscriptionQuantity"]}x {$order[0]["enSession"]} - {$order[0]["enSubscription"]}</td>
			<td>".numTo3Float($order[0]["totalSubscriptionPrice"])."KD</td>
			</tr>";
			$body .= "<tr>
			<td>{$order[0]["jersyQuantity"]}x Jersey of {$order[0]["enAcademy"]}</td>
			<td>".numTo3Float($order[0]["totalJersyPrice"])."KD</td>
			</tr>";
		}else{
			$tournament = json_decode($order[0]["teamDetails"],true);
			$body .= "<tr>
			<td>1x {$tournament["enTournament"]} - {$order[0]["teamName"]}</td>
			<td>".numTo3Float($order[0]["total"])."KD</td>
			</tr>";
		}
	
	if ( isset($order[0]["voucher"]) && !empty($order[0]["voucher"]) ){
		$body .= '
				<tr>
				<td>Voucher<hr></td>
				<td>'.$order[0]["voucher"].'<hr></td>
				</tr>
				';
	}
	$body .= '<tr><td>Total<hr></td>
	<td>'.numTo3Float($order[0]["total"]).'KD<hr></td>
	</tr>
	<tr>
	<td>Method<hr></td>
	<td>'.$method.'</td>
	</tr>';
	return $body;
}

function sendMails($order, $email){
	$msg = emailBody($order);
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://createid.link/api/v1/send/notify',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => array(
			'site' => "MYACAD",
			'subject' => "NEW SUBSCRIPTION #{$order[0]["id"]}",
			'body' => $msg,
			'from_email' => "noreply@mycad.app",
			'to_email' => $email
		),
	));
	$response = curl_exec($curl);
	curl_close($curl);
}

function sendMailsCancel($order, $email){
	$msg = emailBody($order);
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://createid.link/api/v1/send/notify',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => array(
			'site' => "MYACAD",
			'subject' => "CANCLLED SUBSCRIPTION #{$order[0]["id"]}",
			'body' => $msg,
			'from_email' => "noreply@mycad.app",
			'to_email' => $email
		),
	));
	$response = curl_exec($curl);
	curl_close($curl);
}

function sendMailsAdmin($orderId, $email){
	GLOBAL $settingsEmail, $settingsTitle, $settingsWebsite, $settingslogo;
			$sendEmail = $settingsEmail;
			$title = "New order - {$settingsTitle}";
			$msg = emailBody($orderId);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://createid.link/api/v1/send/notify',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array(
				'site' => $title,
				'subject' => "Order #{$orderId}",
				'body' => $msg,
				'from_email' => $settingsEmail,
				'to_email' => $sendEmail
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
}

function getCountryCodeFromNumber($phoneNumber) {
    // Remove any non-digit characters
    $phoneNumber = preg_replace('/\D/', '', $phoneNumber);
    
    // Common country codes (sorted by length, longest first to match correctly)
    $codes = [
        // 4 digits
        '1246', '1264', '1268', '1284', '1340', '1345', '1441', '1473', '1649', '1664', '1670', '1671', '1684', '1721', '1758', '1767', '1784', '1809', '1829', '1849', '1868', '1869', '1876',
        // 3 digits - Middle East & Common
        '971', '973', '974', '968', '967', '966', '965', '964', '963', '962', '961', '960',
        '998', '996', '995', '994', '993', '992', '977', '976', '975', '972', '970',
        '387', '386', '385', '383', '382', '381', '380', '378', '377', '376', '375', '374', '373', '372', '371', '370',
        '359', '358', '357', '356', '355', '354', '353', '352', '351', '350',
        '423', '421', '420',
        '389', '388',
        '298', '297', '291', '290',
        '269', '268', '267', '266', '265', '264', '263', '262', '261', '260',
        '258', '257', '256', '255', '254', '253', '252', '251', '250',
        '249', '248', '246', '245', '244', '243', '242', '241', '240',
        '239', '238', '237', '236', '235', '234', '233', '232', '231', '230',
        '229', '228', '227', '226', '225', '224', '223', '222', '221', '220',
        '218', '216', '213', '212',
        // 2 digits
        '98', '95', '94', '93', '92', '91', '90',
        '86', '84', '82', '81',
        '77', '76', '75', '74', '73', '72', '70',
        '69', '68', '66', '65', '64', '63', '62', '61', '60',
        '58', '57', '56', '55', '54', '53', '52', '51',
        '49', '48', '47', '46', '45', '44', '43', '41', '40',
        '39', '36', '34', '33', '32', '31', '30',
        '27', '20',
        // 1 digit
        '7', '1'
    ];
    
    foreach ($codes as $code) {
        if (strpos($phoneNumber, $code) === 0) {
            return $code;
        }
    }
    
    return null; // No country code found
}

function whatsappUltraMsgVerify($to, $code){
	if( $whatsappNoti = selectDB("settings","`id` = '1'") ){
		$data = array(
			'token' => "{$whatsappNoti[0]["whatsappToken"]}",
			'to' => "{$to}",
			'image' => 'https://dev.myacad.app/img/logoNew.png',
			'caption' => "Hello, your verification code is: {$code}. Please use it to complete your profile verification in My Academy. \n\nThis is an automated message from My Academy.\n\nBest Regards, \nhttps://myacad.app/",
		);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.ultramsg.com/{$whatsappNoti[0]["InstanceId"]}/messages/image",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => http_build_query($data),
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded"
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}else{
		$data = array();
		return $data;
	}
}

function whatsappUltraMsg($to, $message){
	if( $whatsappNoti = selectDB("settings","`id` = '1'") ){
		$data = array(
			'token' => "{$whatsappNoti[0]["whatsappToken"]}",
			'to' => "{$to}",
			'image' => 'https://dev.myacad.app/img/logoNew.png',
			'caption' => "{$message} \n\nThis is an automated message from My Academy.\n\nBest Regards, \nhttps://myacad.app/",
		);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.ultramsg.com/{$whatsappNoti[0]["InstanceId"]}/messages/image",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => http_build_query($data),
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded"
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}else{
		$data = array();
		return $data;
	}
}
?>