<?php 
// 1 live subscriptions
// 2 cancelled 
// 3 refunded
// 4 ended
if( !isset($_GET["userId"]) || empty($_GET["userId"]) ){
	$response = array("msg"=>"Please set user id");
	echo outputError($response);die();
}else{
    if( !isset($_GET["type"]) || empty($_GET["type"]) ){
        $_GET["type"] = 1;
    }else{
        $_GET["type"] = $_GET["type"];
    }
    if ($orders = selectDB("orders", "`userId` = '{$_GET["userId"]}' AND `status` = '1'")) {
        for ($i = 0; $i < sizeof($orders); $i++) {
            $subscriptions = selectDB("subscriptions", "`id` = '{$orders[$i]["subscriptionId"]}'");
            $numberOfDays = $subscriptions[0]["numberOfDays"];
            $endDate = date("Y-m-d H:i:s", strtotime($orders[$i]["date"] . " +{$numberOfDays} days"));
            $endDateTimestamp = strtotime($endDate);
            $todaysDate = strtotime(date("Y-m-d H:i:s"));
            if ($endDateTimestamp <= $todaysDate ) {
                updateDB("orders", array("status" => 4), "`id` = '{$orders[$i]["id"]}'");
            }
        }
    }
	if( $orders = selectDB2("`id`,`date`,`academyId`,`gatewayId`","orders","`userId` = '{$_GET["userId"]}' AND `status` = '{$_GET["type"]}'") ){
        for( $i = 0; $i < sizeof($orders); $i++ ){
            $academy = selectDB2("`area`,`enTitle`,`arTitle`,`imageurl`,`location`,`sport`","academies","`id` = '{$orders[$i]["academyId"]}'");
            $sport = selectDB2("`imageurl`","sports","`id` = '{$academy[0]["sport"]}'");
            $area = selectDB2("`areaEnTitle`, `areaArTitle`","countries","`id` = '{$academy[0]["area"]}'");
            $response[] = array(
                "id" => $orders[$i]["id"],
                "date" => $orders[$i]["date"],
                "orderId" => $orders[$i]["gatewayId"],
                "enTitle" => $academy[0]["enTitle"],
                "arTitle" => $academy[0]["arTitle"],
                "location" => $academy[0]["location"],
                "enArea" => $area[0]["areaEnTitle"],
                "arArea" => $area[0]["areaArTitle"],
                "academyLogo" => $academy[0]["imageurl"],
                "sportLogo" => $sport[0]["imageurl"],
            );
        }
    }else{
        $response["msg"] = popupMsg($requestLang,"we could not find any order for this user id.","لم يتم العثور على طلبات لهذا المستخدم");
	    echo outputError($response);die();
    }
}
echo outputData($response);
?>