<?php 
if( !isset($_POST["orderId"]) || empty($_POST["orderId"]) ){
	$response = array("msg"=>"Please set order id");
	echo outputError($response);die();
}else{
	if( $order = selectDB2("`id`, `date`, `isTournament`, `paymentMethod`, `enAcademy`, `arAcademy`, `enSession`, `arSession`, `enSubscription`, `arSubscription`, `subscriptionQuantity`, `jersyQuantity`, `totalSubscriptionPrice`, `totalJersyPrice`, `voucher`, `total`, `tournamentId`, `teamDetails`","orders","`id` = '{$_POST["orderId"]}'") ){
        if( $order[0]["isTournament"] == 1 ){
            $order[0]["teamDetails"] = json_decode($order[0]["teamDetails"],true);
            $tournaments = selectDB("tournaments","`id` = '{$order[0]["tournamentId"]}'");
            $data[0]["teamDetails"]["enTournament"] = $tournaments[0]["enTitle"];
            $data[0]["teamDetails"]["arTournament"] = $tournaments[0]["arTitle"];
            $data[0]["teamDetails"]["teamName"] = $order[0]["teamDetails"]["teamName"];
            $data[0]["teamDetails"]["players"] = json_decode($order[0]["teamDetails"]["players"],true);
            $data[0]["teamDetails"]["bench"] = json_decode($order[0]["teamDetails"]["bench"],true);
            $data[0]["teamDetails"]["quantity"] = $order[0]["teamDetails"]["quantity"];
            $data[0]["teamDetails"]["price"] = $order[0]["teamDetails"]["price"];
            $data[0]["teamDetails"]["total"] = $order[0]["teamDetails"]["total"];
            $data[0]["total"] = $order[0]["teamDetails"]["total"];
            $response = $data;
        }else{
            unset($order[0]["isTournament"],$order[0]["tournamentId"],$order[0]["teamDetails"]);
            $order2 = selectDB("orders","`id` = '{$_POST["orderId"]}'");
            $subscription = selectDB("subscriptions","`id` = '{$order2[0]["subscriptionId"]}'");
            $order[0]["endDate"] = date("Y-m-d H:i:s", strtotime($order[0]["date"] . " +{$subscription[0]["numberOfDays"]} days"));
            $response = $order;
        }
        
    }else{
        $response["msg"] = popupMsg($requestLang,"we could not find this invoice id in out db.","لم يتم العثور على هذا الرقم في قاعدة بياناتنا");
	    echo outputError($response);die();
    }
}
echo outputData($response);
?>