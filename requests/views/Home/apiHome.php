<?php 

expiredSubscription();
if( isset($_GET["userId"]) && !empty($_GET["userId"]) ){
    if( $user = selectDBNew("users", [$_GET["userId"]], "`id` = ?", "") ){
        if( $user[0]["isVerified"] == 0 ){
            $response["isVerified"] = 0; // not verified
        }else{
            $response["isVerified"] = 1; // verified
        }
    }else{
        $response["isVerified"] = 2; // guest user
    }
}else{
    $response["isVerified"] = 2; // guest user
}

if( $banners = selectDB2("`id`, `type`, `imageurl`, `link`","banners","`hidden` = '0' AND `status` = '0' ORDER BY `order` ASC") ){
    $response["banners"] = $banners;
}else{
    $response["banners"] = array();
}

if( $tabs = selectDB2("`id`, `enTitle`, `arTitle`","tabs","`hidden` = '0' AND `status` = '0' ORDER BY `rank` ASC") ){
    $response["tabs"] = $tabs;
}else{
    $response["tabs"] = array();
}

if( $sports = selectDB2("`id`, `enTitle`, `arTitle`, `imageurl`","sports","`hidden` = '0' AND `status` = '0' ORDER BY `order` ASC") ){
    $response["sports"] = $sports;
}else{
    $response["sports"] = array();
}

$gendersEn = ["SELECT Gender","Men","Women","Boys","Girls","Mix Adults","Mix Kids"];
$gendersAr = ["إختيار الجنس","رجال","سيدات","أولاد","بنات","مختلط كبار","مختلط الاطفال"];
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