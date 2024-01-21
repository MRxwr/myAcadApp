<?php 
if( !isset($_POST["orderId"]) || empty($_POST["orderId"]) ){
	$response = array("msg"=>"Please set order id");
	echo outputError($response);die();
}else{
	if( $order = selectDB2("`id`, `date`, `paymentMethod`, `enAcademy`, `arAcademy`, `enSession`, `arSession`, `enSubscription`, `arSubscription`, `subscriptionQuantity`, `jersyQuantity`, `totalSubscriptionPrice`, `totalJersyPrice`, `voucher`, `total`","orders","`id` = '{$_POST["orderId"]}'") ){
        $order2 = selectDB("orders","`id` = '{$_POST["orderId"]}'");
        $subscription = selectDB("subscriptions","`id` = '{$order2[0]["subscriptionId"]}'");
        $order[0]["endDate"] = date("Y-m-d H:i:s", strtotime($order[0]["date"] . " +{$subscription[0]["numberOfDays"]} days"));
        $response = $order;
    }else{
        $response["msg"] = popupMsg($requestLang,"we could not find this invoice id in out db.","لم يتم العثور على هذا الرقم في قاعدة بياناتنا");
	    echo outputError($response);die();
    }
}
echo outputData($response);
?>