<?php 
if( !isset($_POST["orderId"]) || empty($_POST["orderId"]) ){
	$response = array("msg"=>"Please set order id");
	echo outputError($response);die();
}else{
	if( $order = selectDB2("`id`, `date`, `isTournament`, `paymentMethod`, `enAcademy`, `arAcademy`, `enSession`, `arSession`, `enSubscription`, `arSubscription`, `subscriptionQuantity`, `jersyQuantity`, `totalSubscriptionPrice`, `totalJersyPrice`, `voucher`, `total`, `tournamentId`, `teamDetails`","orders","`id` = '{$_POST["orderId"]}'") ){
        if( $order[0]["isTournament"] == 1 ){
            $order[0]["teamDetails"] = json_decode($order[0]["teamDetails"],true);
            $area = selectDB("countries","`id` = '{$tournament[0]["area"]}'");
            $tournaments = selectDB("tournaments","`id` = '{$order[0]["tournamentId"]}'");
            $data["id"] = $order[0]["id"];
            $data["date"] = $order[0]["date"];
            $data["enTournament"] = $tournaments[0]["enTitle"];
            $data["arTournament"] = $tournaments[0]["arTitle"];
            $data["areaEnTitle"] = $area[0]["areaEnTitle"];
            $data["areaArTitle"] = $area[0]["areaArTitle"];
            $data["gameDate"] = $tournaments[0]["gameDate"];
            $data["gameTime"] = $tournaments[0]["gameTime"];
            $data["teamName"] = $order[0]["teamDetails"]["teamName"];
            $data["players"] = $order[0]["teamDetails"]["players"];
            $data["bench"] = $order[0]["teamDetails"]["bench"];
            $data["quantity"] = $order[0]["teamDetails"]["quantity"];
            $data["price"] = $order[0]["teamDetails"]["price"];
            $data["total"] = $order[0]["teamDetails"]["total"];            $response = $data;
        }else{
            unset($order[0]["tournamentId"],$order[0]["teamDetails"]);
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