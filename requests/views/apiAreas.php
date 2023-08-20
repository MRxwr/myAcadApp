<?php 
if( $areas = selectDB2("`id`, `areaEnTitle`,`areaArTitle`","countries","`hidden` = '0' AND `status` = '1' AND `governateId` = '{$_GET["governateId"]}' ORDER BY `areaEnTitle` ASC") ){
    $response["areas"] = $areas;
}else{
    $response["areas"] = array();
    echo outputError($response);die();
}

echo outputData($response);
?>