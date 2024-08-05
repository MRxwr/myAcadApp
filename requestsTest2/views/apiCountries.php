<?php 
if( $countries = selectDB2("`id`, `countryCode`, `currencyCode`, `countryEnTitle`,`countryArTitle`, `areaCode`, `flag`","countries","`hidden` = '0' AND `status` = '1' GROUP BY `countryCode` ORDER BY `countryCode` ASC") ){
    $response["countries"] = $countries;
}else{
    $response["countries"] = array();
    echo outputError($response);die();
}

echo outputData($response);

?>