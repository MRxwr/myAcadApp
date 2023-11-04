<?php 

if( $banners = selectDB2("`id`, `type`, `imageurl`, `link`","banners","`hidden` = '0' AND `status` = '0' ORDER BY `order` ASC") ){
    $response["banners"] = $banners;
}else{
    $response["banners"] = array();
}

if( $sports = selectDB2("`id`, `enTitle`, `arTitle`, `imageurl`","sports","`hidden` = '0' AND `status` = '0' ORDER BY `order` ASC") ){
    $response["sports"] = $sports;
}else{
    $response["sports"] = array();
}

$gendersEn = ["SELECT GENDER","Man","Woman","Boy","Girl"];
$gendersAr = ["إختيار الجنس","رجل","إمرأة","ولد","بنت"];
for( $i = 0; $i < sizeof($gendersEn); $i++ ){
    $response["genders"][] = array("genderEn" => $gendersEn[$i], "genderAr" => $gendersAr[$i]);
}

if( isset($_GET["countryCode"]) && $governates = selectDB2("`id`, `enTitle`, `arTitle`","governates","`hidden` = '0' AND `status` = '0' AND `countryCode` LIKE '{$_GET["countryCode"]}' ORDER BY `enTitle` ASC") ){
    $response["governates"] = $governates;
    $array1 = array(
        "id" => -1,
        "enTitle" => "SELECT GOVERNATE",
        "arTitle" => "إختر المحافظة"
    );
    $array0 = array(
        "id" => 0,
        "enTitle" => "SELECT ALL",
        "arTitle" => "إختيار الكل"
    );
    array_unshift($response["governates"], $array1, $array0);
}else{
    $response["governates"] = array();
}

echo outputData($response);

?>