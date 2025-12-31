<?php 
if( !isset($_POST["id"]) || empty($_POST["id"]) ){
    $response["msg"] = popupMsg($requestLang,"Please make sure you send post data before submitting.","يرجى التأكد من ارسال بيانات POST قبل الارسال");
    echo outputError($response);die();
}
$data = $_POST;
unset($_POST);
$dataJoin = array(
    "select" => ["t.id","t.bookingDate","t.startTime","t.endTime","t.notes", "t1.enTitle as fieldEnTitle","t1.arTitle as fieldArTitle","t1.imageurl as fieldLogo","t1.header as fieldHeader","t1.location as fieldLocation","t2.enTitle as ageEnTitle","t2.arTitle as ageArTitle","t3.enTitle as levelEnTitle","t3.arTitle as levelArTitle","t4.areaEnTitle as areaEnTitle","t4.areaArTitle as areaArTitle","t5.enTitle as sportEnTitle","t5.arTitle as sportArTitle", "(CASE WHEN t.status = 0 THEN 'Pending' WHEN t.status = 1 THEN 'Partialy Paid' WHEN t.status = 2 THEN 'Fully Paid' ELSE '' END) as enStatus", "(CASE WHEN t.status = 0 THEN 'إنتظار' WHEN t.status = 1 THEN 'مدفوع نص المبلغ' WHEN t.status = 2 THEN 'مدفوع كامل' ELSE '' END) as arStatus", "t1.facilitiesIds"],
    "join" => ["fields_list","field_ages","field_levels","countries","sports"],
    "on" => ["t.fieldId = t1.id","t.ages = t2.id","t.levels = t3.id","t1.area = t4.id","t1.sport = t5.id"],
);
if( $pendingBooking = selectJoinDB("fields_booking", $dataJoin, "t.id = '{$data["id"]}'") ){
    $facilities = json_decode($pendingBooking[0]["facilitiesIds"], true);
    $pendingBooking[0]["facilities"] = array();
    if( !empty($facilities) && is_array($facilities) ){
        $facilitiesIds = implode(',', array_map('intval', $facilities));
        $pendingBooking[0]["facilities"] = selectDB2("enTitle, arTitle, icon","field_facilities","`id` IN ({$facilitiesIds})");
    }
    unset($pendingBooking[0]["facilitiesIds"]);
    $response["pendingBooking"] = $pendingBooking[0];
}else{
    $response["msg"] = popupMsg($requestLang,"No Bookings available","لا يوجد مباريات متاحة");
    echo outputError($response);die();
}
echo outputData($response);
?>