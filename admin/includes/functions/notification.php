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
            echo $endDate = date("Y-m-d H:i:s", strtotime($orders[$i]["date"] . " +{$numberOfDays} days"));
            $endDateTimestamp = strtotime($endDate);
			echo $todayDate = date("Y-m-d H:i:s");
            $todaysDate = strtotime($todayDate);
            if ($endDateTimestamp <= $todaysDate ) {
				$data = array(
					"title" => direction("Subscription End Soon","سينتهي الإشتراك قريبا"),
					"msg" => direction("Your subscription with {$orders[$i]["enAcademy"]} Will end soon. Please resubscribe and continue the fun.","سينتهي إشتراك قريبا مع {$orders[$i]["arAcademy"]}، الرجاء إعادة الإشتراك لتستمر المتعه."),
					"firebase" => $user[0]["firebase"]
				);
				sendNotification($data);
                updateDB("orders", array("isNotified" => 1), "`id` = '{$orders[$i]["id"]}'");
            }
        }
    }
}

function emailBody($order){
	if( $order[0]["paymentMethod"] == 1 ){
		$method = "KNET";
	}elseif( $order[0]["paymentMethod"] == 2 ){
		$method = "Credit Card";
	}else{
		$method = "WALLET";
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
	$body .= "<tr>
			<td>{$order[0]["subscriptionQuantity"]}x {$order[0]["enSession"]} - {$order[0]["enSubscription"]}</td>
			<td>".numTo3Float($order[0]["totalSubscriptionPrice"])."KD</td>
			</tr>";
	$body .= "<tr>
			<td>{$order[0]["jersyQuantity"]}x Jersey of {$order[0]["enAcademy"]}</td>
			<td>".numTo3Float($order[0]["totalJersyPrice"])."KD</td>
			</tr>";
	if ( isset($order[0]["voucher"]) && !empty($order[0]["voucher"]) ){
		$body .= '
				<tr>
				<td>Voucher<hr></td>
				<td>'.$order[0]["voucher"].'<hr></td>
				</tr>
				';
	}
	$body .= '<td>Total<hr></td>
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
?>