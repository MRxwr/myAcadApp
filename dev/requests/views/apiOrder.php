<?php 
if( !isset($_POST["invoiceId"]) || empty($_POST["invoiceId"]) ){
	$response = array("msg"=>"Please set invoice id");
	echo outputError($response);die();
}elseif( !isset($_POST["status"]) || empty($_POST["status"])){
    $response = array("msg"=>"Please set status");
	echo outputError($response);die();
}elseif( !isset($_POST["url"]) || empty($_POST["url"])){
    $response = array("msg"=>"Please set url");
	echo outputError($response);die();
}else{
	if( $order = selectDB2("`id`, `date`, `isTournament`, `paymentMethod`, `enAcademy`, `arAcademy`, `enSession`, `arSession`, `enSubscription`, `arSubscription`, `subscriptionQuantity`, `jersyQuantity`, `totalSubscriptionPrice`, `totalJersyPrice`,`voucher`, `total`, `tournamentId`, `teamDetails`","orders","`gatewayId` = '{$_POST["invoiceId"]}'") ){
        $order2 = selectDB("orders","`gatewayId` = '{$_POST["invoiceId"]}'");
        if( $order2[0]["status"] == 0 ){
            updateDB("orders",array("gatewayLink"=>json_encode($_POST["url"]),"status"=>$_POST["status"]),"`gatewayId` = '{$_POST["invoiceId"]}'");
            if ( $_POST["status"] == 1 ){
                if( $order2[0]["isTournament"] == 1 ){
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
                    $targetEmail = selectDB("tournaments","`id` = '{$order2[0]["tournamentId"]}'");
                    $response = $data;
                }else{
                    $session = selectDB("sessions","`id` = '{$order2[0]["sessionId"]}'");
                    $quantity = $session[0]["quantity"] - $order2[0]["subscriptionQuantity"];
                    updateDB("sessions",array("quantity"=>$quantity),"`id` = '{$order2[0]["sessionId"]}'");
                    $subscription = selectDB("subscriptions","`id` = '{$order2[0]["subscriptionId"]}'");
                    $order[0]["endDate"] = date("Y-m-d H:i:s", strtotime($order[0]["date"] . " +{$subscription[0]["numberOfDays"]} days"));
                    $targetEmail = selectDB("academies","`id` = '{$order2[0]["academyId"]}'");
                    $response = $order;
                }
            }
            $settingsEmail = selectDB("settings","`id` = '1'");
            sendMails($order2,$order2[0]["email"]);
            sendMails($order2,$targetEmail[0]["email"]);
            sendMails($order2,$settingsEmail[0]["email"]);
        }else{
            if( $order2[0]["isTournament"] == 1 ){
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
                $targetEmail = selectDB("tournaments","`id` = '{$order2[0]["tournamentId"]}'");
                $response = $data;
            }else{
                $session = selectDB("sessions","`id` = '{$order2[0]["sessionId"]}'");
                $quantity = $session[0]["quantity"] - $order2[0]["subscriptionQuantity"];
                updateDB("sessions",array("quantity"=>$quantity),"`id` = '{$order2[0]["sessionId"]}'");
                $subscription = selectDB("subscriptions","`id` = '{$order2[0]["subscriptionId"]}'");
                $order[0]["endDate"] = date("Y-m-d H:i:s", strtotime($order[0]["date"] . " +{$subscription[0]["numberOfDays"]} days"));
                $targetEmail = selectDB("academies","`id` = '{$order2[0]["academyId"]}'");
                $response = $order;
            }
        }
    }else{
        $response["msg"] = popupMsg($requestLang,"we could not find this invoice id in out db.","لم يتم العثور على هذا الرقم في قاعدة بياناتنا");
	    echo outputError($response);die();
    }
}
echo outputData($response);
?>