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
        $response = array("msg"=>"we could not find any order for this user id.");
	    echo outputError($response);die();
    }
}
echo outputData($response);
?>