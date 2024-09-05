<?php 
if( $areas = selectDB2("`id`, `areaEnTitle`,`areaArTitle`","countries","`hidden` = '0' AND `status` = '1' AND `governateId` = '{$_GET["governateId"]}' ORDER BY `areaEnTitle` ASC") ){
    $response["areas"] = $areas;
    $array1 = array(
        "id" => -1,
        "areaEnTitle" => "SELECT AREA",
        "areaArTitle" => "إختر المنطقة"
    );
    $array0 = array(
        "id" => 0,
        "areaEnTitle" => "SELECT ALL",
        "areaArTitle" => "إختيار الكل"
    );
    array_unshift($response["areas"], $array1, $array0);
}else{
    $response["areas"] = array();
    echo outputError($response);die();
}

echo outputData($response);
?>