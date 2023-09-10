<?php 
if( !isset($_GET["userId"]) || empty($_GET["userId"]) ){
	$response = array("msg"=>"Please set user id");
	echo outputError($response);die();
}else{
    if( !isset($_GET["status"]) || empty($_GET["status"]) ){
        $_GET["status"] = 1;
    }else{
        $_GET["status"] = $_GET["status"];
    }
	if( $orders = selectDB2("`id`,`date`,`academyId`","orders","`userId` = '{$_GET["userId"]}' AND `status` = '{$_GET["status"]}'") ){
        for( $i = 0; $i < sizeof($orders); $i++ ){
            $academy = selectDB2("`enTitle`,`arTitle`,`imageurl`,`location`,`sport`","academies","`id` = '{$orders[$i]["academyId"]}'");
            $sport = selectDB2("`imageurl`","sports","`id` = '{$academy[0]["sport"]}'");
            $response[] = array(
                "id" => $orders[$i]["id"],
                "date" => $orders[$i]["date"],
                "enTitle" => $academy[0]["enTitle"],
                "arTitle" => $academy[0]["arTitle"],
                "location" => $academy[0]["location"],
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