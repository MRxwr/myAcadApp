<?php 
if( !isset($_POST["orderId"]) || empty($_POST["orderId"]) ){
	$response = array("msg"=>"Please set order id");
	echo outputError($response);die();
}else{
	if( $order = selectDB2("`id`, `date`, `isTournament`, `paymentMethod`, `enAcademy`, `arAcademy`, `enSession`, `arSession`, `enSubscription`, `arSubscription`, `subscriptionQuantity`, `jersyQuantity`, `totalSubscriptionPrice`, `totalJersyPrice`, `voucher`, `total`, `tournamentId`, `teamDetails`, `eventId`, `eventDetails`","orders","`id` = '{$_POST["orderId"]}'") ){
        if( $order[0]["isTournament"] == 1 ){
            $order[0]["teamDetails"] = json_decode($order[0]["teamDetails"],true);
            $tournaments = selectDB("tournaments","`id` = '{$order[0]["tournamentId"]}'");
            $area = selectDB("countries","`id` = '{$tournaments[0]["area"]}'");
            $data[0]["id"] = $order[0]["id"];
            $data[0]["date"] = $order[0]["date"];
            $data[0]["isTournament"] = 1;
            $data[0]["enTournament"] = $tournaments[0]["enTitle"];
            $data[0]["arTournament"] = $tournaments[0]["arTitle"];
            $data[0]["areaEnTitle"] = $area[0]["areaEnTitle"];
            $data[0]["areaArTitle"] = $area[0]["areaArTitle"];
            $data[0]["gameDate"] = $tournaments[0]["gameDate"];
            $data[0]["gameTime"] = $tournaments[0]["gameTime"];
            $data[0]["teamName"] = $order[0]["teamDetails"]["teamName"];
            $data[0]["quantity"] = $order[0]["teamDetails"]["quantity"];
            $data[0]["price"] = $order[0]["teamDetails"]["price"];
            $data[0]["total"] = $order[0]["teamDetails"]["total"];   
            $data[0]["players"] = $order[0]["teamDetails"]["players"];
            $data[0]["bench"] = $order[0]["teamDetails"]["bench"];
            $response = $data;
        }elseif($order[0]["isTournament"] == 2){
            unset($order[0]["tournamentId"],$order[0]["teamDetails"]);
            $event = selectDB("tabs_list","`id` = '{$_POST["eventId"]}'");
            $eventDetails = json_decode( $order[0]["eventDetails"], true );
            $data[0]["id"] = $order[0]["id"];
            $data[0]["date"] = $order[0]["date"];
            $data[0]["enTitle"] = $eventDetails["enEvent"];
            $data[0]["arTitle"] = $eventDetails["arEvent"];
            $data[0]["gateDate"] = $event[0]["gameDate"];
            $data[0]["gateTime"] = $event[0]["gameTime"];
            $data[0]["price"] = $eventDetails["price"];
            $data[0]["total"] = $eventDetails["total"];
            $data[0]["voucher"] = $order[0]["voucher"];
            $data[0]["fields"] = $eventDetails["fields"];
            $data[0]["arena"] = ( empty($event[0]["isIndoor"]) || $event[0]["isIndoor"] == 0 ) ? popupMsg($requestLang,"Outdoor","خارجي") : popupMsg($requestLang,"Indoor","داخلي");
            $response = $data;
        }else{
            unset($order[0]["tournamentId"],$order[0]["teamDetails"],$order[0]["eventId"],$order[0]["eventDetails"]));
            $order2 = selectDB("orders","`id` = '{$_POST["orderId"]}'");
            $subscription = selectDB("subscriptions","`id` = '{$order2[0]["subscriptionId"]}'");
            $order[0]["isTournament"] = 0;
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