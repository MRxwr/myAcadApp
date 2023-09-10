<?php 
if( !isset($_GET["userId"]) || empty($_GET["userId"]) ){
	$response = array("msg"=>"Please set user id");
	echo outputError($response);die();
}else{
	if( $orders = selectDB("`id`,`date`,`academyId`","orders","`userId` = '{$_GET["userId"]}' AND `status` = '1'") ){
        for( $i = 0; $i < sizeof($orders); $i++ ){
            $academy = selectDB2("`enTitle`,`arTitle`,`imageurl`,`location`","academies","`id` = '{$orders[$i]["academyId"]}'");
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