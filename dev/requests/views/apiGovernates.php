<?php 
if( !isset($_GET["sportId"]) || empty($_GET["sportId"]) ){
    $response["error"] = array(
        "msg" => "sportId is required"
    );
    echo json_encode($response);die();
}
if( !isset($_GET["countryCode"]) || empty($_GET["countryCode"]) ){
    $response["data"] = array(
        "msg" => "countryCode  is required"
    );
    echo json_encode($response);die();
}
if( !isset($_GET["isTournament"]) || empty($_GET["isTournament"]) ){
    $_GET["isTournament"] = 0;
    $table = "academies";
}else{
    $_GET["isTournament"] = 1;
    $table = "tournaments";
}
if( !isset($_GET["genderId"]) || empty($_GET["genderId"]) ){
    $response["data"] = array(
        "msg" => "genderId  is required"
    );
    echo json_encode($response);die();
}
if( $academies = selectDB2("`governate`","{$table}","`sport` = '{$_GET["sportId"]}' AND `country` LIKE '{$_GET["countryCode"]}' AND `gender` = '{$_GET["genderId"]}' AND `hidden` = '0' AND `status` = '0' AND `isTournament` = '{$_GET["isTournament"]}' GROUP BY `governate`") ){
    $response["governates"][0] = array(
        "id" => 0,
        "enGovernates" => "SELECT GOVERNATE",
        "arGovernates" => "إختر المحافظة"
    );
    for( $i = 0; $i < sizeof($academies); $i++ ){
        $governate = selectDB("governates","`id` = '{$academies[$i]["governate"]}'");
        $response["governates"][] = array(
            "id" => $governate[0]["id"],
            "enGovernate" => $governate[0]["enTitle"],
            "arGovernate" => $governate[0]["arTitle"]
        );
    }
}else{
    $response["governates"] = array();
    echo outputError($response);die();
}
echo outputData($response);
?>