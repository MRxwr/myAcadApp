<?php 
if( !isset($_GET["sportId"]) || empty($_GET["sportId"]) ){
    $response["error"] = array(
        "msg" => "sportId is required"
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
if( !isset($_GET["countryCode"]) || empty($_GET["countryCode"]) ){
    $response["data"] = array(
        "msg" => "countryCode  is required"
    );
    echo json_encode($response);die();
}
if( $academies = selectDB2("`gender`","{$table}","`sport` = '{$_GET["sportId"]}' AND `country` LIKE '{$_GET["countryCode"]}' AND `hidden` = '0' AND `status` = '0' AND `isTournament` = '{$_GET["isTournament"]}' GROUP BY `gender`") ){
    $gendersEn = ["SELECT GENDER","Man","Woman","Boy","Girl","Mix Adults","Mix Kids"];
    $gendersAr = ["إختيار الجنس","رجل","إمرأة","ولد","بنت","مختلط كبار","مختلط الاطفال"];
    $response["genders"][0] = array(
        "id" => 0,
        "genderEn" => $gendersEn[0],
        "genderAr" => $gendersAr[0]
    );
    for( $i = 0; $i < sizeof($academies); $i++ ){
        $response["genders"][] = array(
            "id" => $academies[$i]["gender"],
            "genderEn" => $gendersEn[$academies[$i]["gender"]],
            "genderAr" => $gendersAr[$academies[$i]["gender"]]
        );
    }
}else{
    $response["genders"] = array();
    echo outputError($response);die();
}
echo outputData($response);
?>