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
    for( $i = 0; $i < sizeof($sports); $i++ ){
        $sport = selectDB("sports","`id` = '{$sports[$i]["sports"]}'");
        $response["sports"][] = array(
            "id" => $sport[0]["id"],
            "sportEn" => $sport[0]["enTitle"],
            "sportAr" => $sport[0]["arTitle"],
            "imageurl" => $sport[0]["imageurl"]
        );
    }
}else{
    $response["sports"] = array();
    echo outputError($response);die();
}
echo outputData($response);
?>