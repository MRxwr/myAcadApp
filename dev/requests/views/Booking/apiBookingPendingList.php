<?php 
$dataJoin = array(
    "select" => ["t.bookingDate","t.startTime","t.endTime","t1.enTitle as fieldEnTitle","t1.arTitle as fieldArTitle","t2.enTitle as ageEnTitle","t2.arTitle as ageArTitle","t3.enTitle as levelEnTitle","t3.arTitle as levelArTitle","t4.areaEnTitle as areaEnTitle","t4.areaArTitle as areaArTitle","t5.enTitle as sportEnTitle","t5.arTitle as sportArTitle"],
    "join" => ["fields_list","field_ages","field_levels","countries","sports"],
    "on" => ["t.feildId = t1.id","t.ageId = t2.id","t.levelId = t3.id","t1.area = t4.id","t1.sport = t5.id"],
);
if( $pendingBookings = selectJoinDB("fields_booking", $dataJoin, "`hidden` = '0' AND `status` = '0' AND `isTbari` = '1'") ){
    $response["pendingBookings"] = $pendingBookings;
}else{
    $response["msg"] = popupMsg($requestLang,"No Bookings available","لا يوجد مباريات متاحة");
    echo outputError($response);die();
}
echo outputData($response);
?>