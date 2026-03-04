<?php 
// 1 live subscriptions
// 2 cancelled 
// 3 refunded
// 4 ended
if( !isset($_GET["userId"]) || empty($_GET["userId"]) ){
	$response = array("msg"=>"Please set user id");
	echo outputError($response);die();
}else{
    $page = ( isset($_GET["page"]) && !empty($_GET["page"]) ) ? intval($_GET["page"]) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;
    if ($orders = selectDB("orders", "`userId` = '{$_GET["userId"]}' AND `status` = '1' AND `isTournament` = '0'")) {
        for ($i = 0; $i < sizeof($orders); $i++) {
            $subscriptions = selectDB("subscriptions", "`id` = '{$orders[$i]["subscriptionId"]}'");
            $numberOfDays = $subscriptions[0]["numberOfDays"];
            $endDate = date("Y-m-d H:i:s", strtotime($orders[$i]["date"] . " +{$numberOfDays} days"));
            $endDateTimestamp = strtotime($endDate);
            $todaysDate = strtotime(date("Y-m-d H:i:s"));
            if( $orders[0]["isTournament"] == 0 ){
                if ($endDateTimestamp <= $todaysDate ) {
                    updateDB2("orders", array("status" => 4), "`id` = '{$orders[$i]["id"]}'");
                }
            }
        }
    }
	if( $orders = selectDB2("`id`, `date`, `academyId`, `gatewayId`, `isTournament`, `tournamentId`, `teamName`, `teamDetails`, `eventId`, `status`","orders","`userId` = '{$_GET["userId"]}' ORDER BY `id` DESC LIMIT {$limit} OFFSET {$offset}") ){
        for( $i = 0; $i < sizeof($orders); $i++ ){
            if( $orders[$i]["isTournament"] == 0 ){
                if($academy = selectDB2("`area`,`enTitle`,`arTitle`,`imageurl`,`location`,`sport`","academies","`id` = '{$orders[$i]["academyId"]}'")){
                    $sport = selectDB2("`imageurl`","sports","`id` = '{$academy[0]["sport"]}'");
                    $area = selectDB2("`areaEnTitle`, `areaArTitle`","countries","`id` = '{$academy[0]["area"]}'");
                    $response[] = array(
                        "id" => $orders[$i]["id"],
                        "date" => $orders[$i]["date"],
                        "isTournament" => 0,
                        "orderId" => $orders[$i]["gatewayId"],
                        "enTitle" => $academy[0]["enTitle"],
                        "arTitle" => $academy[0]["arTitle"],
                        "location" => $academy[0]["location"],
                        "enArea" => $area[0]["areaEnTitle"],
                        "arArea" => $area[0]["areaArTitle"],
                        "academyLogo" => $academy[0]["imageurl"],
                        "sportLogo" => $sport[0]["imageurl"],
                        "type" => popupMsg($requestLang,"Subscription","اشتراك"),
                        "status" => $orders[$i]["status"],
                        "statusText" => ( $orders[$i]["status"] == 1 ) ? popupMsg($requestLang,"Live","مفعلة") : ( ( $orders[$i]["status"] == 2 ) ? popupMsg($requestLang,"Cancelled","ملغاة") : ( ( $orders[$i]["status"] == 3 ) ? popupMsg($requestLang,"Refunded","مستردة") : ( ( $orders[$i]["status"] == 4 ) ? popupMsg($requestLang,"Ended","منتهية") : popupMsg($requestLang,"Pending","قيد الانتظار") ) ) )
                    );
                }
            }elseif( $orders[$i]["isTournament"] == 1 ){
                if($tournaments = selectDB("tournaments","`id` = '{$orders[$i]["tournamentId"]}'")){
                    $sport = selectDB2("`imageurl`","sports","`id` = '{$tournaments[0]["sport"]}'");
                    $area = selectDB("countries","`id` = '{$tournaments[0]["area"]}'");
                    $response[] = array(
                        "id" => $orders[$i]["id"],
                        "date" => $orders[$i]["date"],
                        "isTournament" => 1,
                        "orderId" => $orders[$i]["gatewayId"],
                        "enTitle" => $tournaments[0]["enTitle"],
                        "arTitle" => $tournaments[0]["arTitle"],
                        "location" => $tournaments[0]["location"],
                        "enArea" => $area[0]["areaEnTitle"],
                        "arArea" => $area[0]["areaArTitle"],
                        "academyLogo" => $tournaments[0]["imageurl"],
                        "sportLogo" => $sport[0]["imageurl"],
                        "type" => popupMsg($requestLang,"Tournament","بطولة"),
                        "status" => $orders[$i]["status"],
                        "statusText" => ( $orders[$i]["status"] == 1 ) ? popupMsg($requestLang,"Successful","ناجحة") : popupMsg($requestLang,"Cancelled","ملغاة")
                    );
                }
            }elseif( $orders[$i]["isTournament"] == 2 ){
                if($event = selectDB("tabs_list","`id` = '{$orders[$i]["eventId"]}'")){
                    $sport = selectDB2("`imageurl`","sports","`id` = '{$event[0]["sport"]}'");
                    $area = selectDB("countries","`id` = '{$event[0]["area"]}'");
                    $tab = selectDB("tabs","`id` = '{$event[0]["tabId"]}'");
                    $response[] = array(
                        "id" => $orders[$i]["id"],
                        "date" => $orders[$i]["date"],
                        "isTournament" => 0,
                        "orderId" => $orders[$i]["gatewayId"],
                        "enTitle" => $event[0]["enTitle"],
                        "arTitle" => $event[0]["arTitle"],
                        "location" => $event[0]["location"],
                        "enArea" => $area[0]["areaEnTitle"],
                        "arArea" => $area[0]["areaArTitle"],
                        "academyLogo" => $event[0]["imageurl"],
                        "sportLogo" => $sport[0]["imageurl"],
                        "type" => popupMsg($requestLang,$tab[0]["enTitle"],$tab[0]["arTitle"]),
                        "status" => $orders[$i]["status"],
                        "statusText" => ( $orders[$i]["status"] == 1 ) ? popupMsg($requestLang,"Successful","ناجحة") : popupMsg($requestLang,"Cancelled","ملغاة")
                    );
                }
            }
        }
    }else{
        $response["msg"] = popupMsg($requestLang,"we could not find any order for this user id.","لم يتم العثور على طلبات لهذا المستخدم");
	    echo outputError($response);die();
    }
}
echo outputData($response);
?>