<?php 
if( $academies = selectDB2("`gender`","academies","`sport` = '{$_GET["sportId"]}' AND `country` LIKE '{$_GET["countryCode"]}' AND `hidden` = '0' AND `status` = '0' GROUP BY `gender`") ){
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