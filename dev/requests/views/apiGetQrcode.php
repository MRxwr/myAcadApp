<?php 
if( $settings = selectDBNew("orders",[$_GET["orderId"]],"`gatewayId` = ?","" ) ){
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
        'url' => 'createkw-0.com',
        'logo_url' => '../../img/logo.png',
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response,true);
	$response["qrcode"] = $response["data"];
	echo outputData($response);
}else{
    $error["msg"] = popupMsg($requestLang,"Error while generating QrCode","خطأ أثناء إنشاء رمز الكيو آر");
	echo outputError($error);die();
}
?>