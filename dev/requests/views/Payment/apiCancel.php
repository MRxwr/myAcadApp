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
        updateDB2("orders",array("status" => 3),"`id` = '{$_GET["orderId"]}'");
        if( $orders[0]["isTournament"] == 1 ){
            $EmailSent = selectDB("tournaments","`id` = '{$orders[0]["tournamentId"]}'");
        }else{
            $EmailSent = selectDB("academies","`id` = '{$orders[0]["academyId"]}'");
        }
        $settingsEmail = selectDB("settings","`id` = '1'");
        sendMailsCancel($orders,$orders[0]["email"]);
        sendMailsCancel($orders,$EmailSent[0]["email"]);
        sendMailsCancel($orders,$settingsEmail[0]["email"]);
        $user = selectDB("users","`id` = '{$_GET["userId"]}'");
        updateDB2("users",array("wallet" => ( (float)$user[0]["wallet"]+(float)$orders[0]["total"]) ),"`id` = '{$_GET["userId"]}'");
        $response["msg"] = popupMsg($requestLang,"Order has been refunded successfully.","تم استرداد الطلب بنجاح");
    }else{
        $response["msg"] = popupMsg($requestLang,"we could not find any order with provided info.","لم يتم العثور على طلب بالمعلومات المدخلة");
	    echo outputError($response);die();
    }
}
echo outputData($response);
?>
