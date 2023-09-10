<?php 
if( !isset($_GET["invoiceId"]) || empty($_GET["invoiceId"]) ){
	$response = array("msg"=>"Please set invoice id");
	echo outputError($response);die();
}elseif( !isset($_GET["status"]) || empty($_GET["status"])){
    $response = array("msg"=>"Please set status");
	echo outputError($response);die();
}elseif( !isset($_GET["url"]) || empty($_GET["url"])){
    $response = array("msg"=>"Please set status");
	echo outputError($response);die();
}else{
	if( $order = selectDB2("`id`, `date`, `paymentMethod`, `enAcademy`, `arAcademy`, `enSession`, `arSession`, `enSubscription`, `arSubscription`, `subscriptionQuantity`, `jersyQuantity`, `totalSubscriptionPrice`, `totalJersyPrice`, `total`","orders","`gatewayId` = '{$_GET["invoiceId"]}'") ){
        if( $order[0]["status"] == 0 ){
            updateDB("orders",array("gatewayLink"=>json_encode($_GET["url"]),"status"=>1),"`gatewayId` = '{$_GET["invoiceId"]}'");
            $subscription = selectDB("subscriptions","`id` = '{$order[0]["subscriptionId"]}'");
            $order[0]["endDate"] = date("Y-m-d H:i:s", strtotime($order[0]["date"] . " +{$subscription[0]["numberOfDays"]} days"));
            $response = $order;
        }else{
            $response = $order;
        }
    }else{
        $response = array("msg"=>"we could not find this invoice id in out db.");
	    echo outputError($response);die();
    }
}

echo outputData($response);
?>