<?php 
if( !isset($_GET["isTournament"]) || empty($_GET["isTournament"]) ){
    $table = "academies";
}else{
    $table = "tournaments";
}
if( !isset($_GET["countryCode"]) || empty($_GET["countryCode"]) ){
    $response["data"] = array(
        "msg" => "countryCode  is required"
    );
    echo json_encode($response);die();
}
if( $sports = selectDB2("`sports`","{$table}","`country` LIKE '{$_GET["countryCode"]}' AND `hidden` = '0' AND `status` = '0' GROUP BY `sport`") ){
    for( $i = 0; $i < sizeof($academies); $i++ ){
        $sports = selectDB("sports","`id` = '{$academies[$i]["sport"]}'");
        $response["sports"][] = array(
            "id" => $sports[0]["id"],
            "sportEn" => $sports[0]["enTitle"],
            "sportAr" => $sports[0]["arTitle"],
            "icon" => $sports[0]["imageurl"]
        );
    }
}else{
    $response["sports"] = array();
    echo outputError($response);die();
}
echo outputData($response);
?>