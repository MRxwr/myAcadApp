<?php
// email \\

//Notification through Create Pay \\
function sendNotification($data){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://createpay.link/api/CreateInvoice.php',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array(
		'name' => $data["name"],
		'email' => $data["email"],
		'mobile' => $data["mobile"],
		'price' => $data["price"],
		'details' => $data["details"],
		'refference' => $data["refference"],
		'noti' => $data["noti"]
		),
	  CURLOPT_HTTPHEADER => array(
		'APPKEY: API123'
	  ),
	));
	$response = curl_exec($curl);
	curl_close($curl);
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