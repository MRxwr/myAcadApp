<?php 
if( !isset($_GET["tabId"]) || empty($_GET["tabId"]) ){
    $response["sports"] = array();
    echo outputError($response);die();
}else{
    $where = "";
    if( $_GET["tabId"] == "1" ){
        $table = "academies";
    }elseif( $_GET["tabId"] == "2" ){
        $table = "tournaments";
    }else{
        $table = "tabs_list";
        $where = "AND `tabId` = '{$_GET["tabId"]}'";
    }
}
if( !isset($_GET["countryCode"]) || empty($_GET["countryCode"]) ){
    $response["data"] = array(
        "msg" => "countryCode  is required"
    );
    echo json_encode($response);die();
}
if( $sports = selectDB2("`sport`","{$table}","`country` LIKE '{$_GET["countryCode"]}' AND `hidden` = '0' AND `status` = '0' {$where} GROUP BY `sport`") ){
    for( $i = 0; $i < sizeof($sports); $i++ ){
        $sport = selectDB("sports","`id` = '{$sports[$i]["sport"]}'");
        $response["sports"][] = array(
            "id" => $sport[0]["id"],
            "sportEn" => $sport[0]["enTitle"],
            "sportAr" => $sport[0]["arTitle"],
            "imageurl" => $sport[0]["imageurl"]
        );
    }
}else{
    $response["sports"] = array();
    $response["msg"] = popupMsg($requestLang,"No data found","لا توجد بيانات");
    echo outputError($response);die();
}
echo outputData($response);
?>