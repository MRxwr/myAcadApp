<?php 
if( !isset($_GET["sessionId"]) || empty($_GET["sessionId"]) ){
	$response = array("msg"=>"Please set session id");
	echo outputError($response);die();
}else{
	if( $sessionSubscription = selectDB("session_subscription","`hidden` = '0' AND `status` = '0' AND `sessionId` = {$_GET["sessionId"]}") ){
        for ($i=0; $i < count($sessionSubscription); $i++) { 
            $subscriptions = selectDB2("`id`, `enTitle`, `arTitle`, `price`, `priceAfterDiscount`","subscriptions","`id` = '{$sessionSubscription[$i]["subscriptionId"]}' AND `status` = '0' AND `hidden` = '0' ORDER BY `price` ASC");
            $response["subscriptions"][] = $subscriptions[0];
        }
	}else{
		$response["msg"] = popupMsg($requestLang,"There is no subscriptions for this session","لا يوجد أشتراكات لهذا المحاضرة");
		echo outputError($response);die();
	}
}

echo outputData($response);
?>