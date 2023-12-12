<?php 
// 1 live subscriptions
// 2 cancelled 
// 3 refunded
// 4 ended
if( !isset($_GET["userId"]) || empty($_GET["userId"]) ){
	$response = array("msg"=>"Please set user id");
	echo outputError($response);die();
}elseif( !isset($_GET["orderId"]) || empty($_GET["orderId"]) ){
	$response = array("msg"=>"Please set order id");
	echo outputError($response);die();
}else{
	if( $orders = selectDB("orders","`id` = '{$_GET["orderId"]}' AND `userId` = '{$_GET["userId"]}' AND `status` = '1'") ){
        updateDB("orders",array("status" => 3),"`id` = '{$_GET["orderId"]}'");
        $academyEmail = selectDB("academies","`id` = '{$order2[0]["academyId"]}'");
        $settingsEmail = selectDB("settings","`id` = '1'");
        sendMailsCancel($orders,$orders[0]["email"]);
        sendMailsCancel($orders,$academyEmail[0]["email"]);
        sendMailsCancel($orders,$settingsEmail[0]["email"]);
        $user = selectDB("users","`id` = '{$_GET["userId"]}'");
        updateDB("users",array("wallet" => ( (float)$user[0]["wallet"]+(float)$orders[0]["total"]) ),"`id` = '{$_GET["userId"]}'");
        $response["msg"] = "Order has been refunded successfully.";
    }else{
        $response = array("msg"=>"we could not find any order with provided info.");
	    echo outputError($response);die();
    }
}
echo outputData($response);
?>