<?php 
if( $order = selectDBNew("orders",[$_GET["orderId"]],"`id` = ?","" ) ){
    /*
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://createid.link/api/v1/generate/qrcode',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
        'url' => 'https://myacad.app/?v=Success&requested_order_id='.$order[0]["gatewayId"],
        'logo_url' => ""//'https://myacad.app/img/logo.png',
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response,true);
	*/
    $url = urlencode('https://myacad.app/?v=Success&requested_order_id='.$order[0]["gatewayId"]);
    $response["data"] = "https://api.qrserver.com/v1/create-qr-code/?size=450x450&data={$url}";
    echo outputData($response);die();
}else{
    $error["msg"] = popupMsg($requestLang,"Error while generating QrCode","خطأ أثناء إنشاء رمز الكيو آر");
	echo outputError($error);die();
}
?>