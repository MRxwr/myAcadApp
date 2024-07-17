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
	if( $order = selectDB2("`id`, `date`, `paymentMethod`, `enAcademy`, `arAcademy`, `enSession`, `arSession`, `enSubscription`, `arSubscription`, `subscriptionQuantity`, `jersyQuantity`, `totalSubscriptionPrice`, `totalJersyPrice`,`voucher`, `total`","orders","`gatewayId` = '{$_POST["invoiceId"]}'") ){
        $order2 = selectDB("orders","`gatewayId` = '{$_POST["invoiceId"]}'");
        if( $order2[0]["status"] == 0 ){
            var_dump($_POST["url"]);
            /*
            if( isset($_GET["Result"]) ){
                if( $_GET["Result"] == "CANCELED" || $_GET["Result"] == "ERROR" ){
                    $_GET["v"] = "Fail";
                }elseif( $_GET["Result"] == "CAPTURED" ){
                    sleep(5);
                    $_GET["v"] = "Success";
                }
            }
            */
            updateDB("orders",array("gatewayLink"=>json_encode($_POST["url"]),"status"=>1),"`gatewayId` = '{$_POST["invoiceId"]}'");
            $session = selectDB("sessions","`id` = '{$order2[0]["sessionId"]}'");
            $quantity = $session[0]["quantity"] - $order2[0]["subscriptionQuantity"];
            updateDB("sessions",array("quantity"=>$quantity),"`id` = '{$order2[0]["sessionId"]}'");
            $subscription = selectDB("subscriptions","`id` = '{$order2[0]["subscriptionId"]}'");
            $order[0]["endDate"] = date("Y-m-d H:i:s", strtotime($order[0]["date"] . " +{$subscription[0]["numberOfDays"]} days"));
            $response = $order;
            $academyEmail = selectDB("academies","`id` = '{$order2[0]["academyId"]}'");
            $settingsEmail = selectDB("settings","`id` = '1'");
            sendMails($order2,$order2[0]["email"]);
            sendMails($order2,$academyEmail[0]["email"]);
            sendMails($order2,$settingsEmail[0]["email"]);
        }else{
            $response = $order;
        }
    }else{
        $response["msg"] = popupMsg($requestLang,"we could not find this invoice id in out db.","لم يتم العثور على هذا الرقم في قاعدة بياناتنا");
	    echo outputError($response);die();
    }
}
echo outputData($response);
?>