<?php 

if( $banners = selectDB2("`id`, `type`, `imageurl`, `link`","banners","`hidden` = '0' AND `status` = '0' ORDER BY `order` ASC") ){
    $response["banners"] = $banners;
}else{
    $response["banners"] = array();
}

$response["genders"] = array(
    1 => ["Man","رجل"],
    2 => ["Woman","إمرأة"],
    3 => ["Boy","ولد"],
    4 => ["Girl","بنت"]
);

if( isset($_GET["countryCode"]) && $governates = selectDB2("`id`, `enTitle`, `arTitle`","governates","`hidden` = '0' AND `status` = '0' AND `countryCode` LIKE '{$_GET["countryCode"]}' ORDER BY `enTitle` ASC") ){
    $response["governates"] = $governates;
}else{
    $response["governates"] = array();
}

echo outputData($response);

?>