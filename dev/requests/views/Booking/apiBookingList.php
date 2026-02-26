<?php 
if( !isset($_POST["userId"]) || empty($_POST["userId"]) ){
    $response["msg"] = popupMsg($requestLang,"Please make sure you send post data before submitting.","يرجى التأكد من ارسال بيانات POST قبل الارسال");
    echo outputError($response);die();
}
$data = $_POST;
unset($_POST);
$page = ( isset($_GET["page"]) && !empty($_GET["page"]) ) ? intval($_GET["page"]) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$dataJoin = array(
    "select" => ["t.id","t.bookingDate","t.startTime","t.endTime","t1.enTitle as fieldEnTitle","t1.arTitle as fieldArTitle","t1.imageurl as fieldLogo","t2.enTitle as ageEnTitle","t2.arTitle as ageArTitle","t3.enTitle as levelEnTitle","t3.arTitle as levelArTitle","t4.areaEnTitle as areaEnTitle","t4.areaArTitle as areaArTitle","t5.enTitle as sportEnTitle","t5.arTitle as sportArTitle", "(CASE WHEN t.status = 0 THEN 'Pending' WHEN t.status = 1 THEN 'Partialy Paid' WHEN t.status = 2 THEN 'Fully Paid' ELSE '' END) as enStatus", "(CASE WHEN t.status = 0 THEN 'إنتظار' WHEN t.status = 1 THEN 'مدفوع نص المبلغ' WHEN t.status = 2 THEN 'مدفوع كامل' ELSE '' END) as arStatus"],
    "join" => ["fields_list","field_ages","field_levels","countries","sports"],
    "on" => ["t.fieldId = t1.id","t.ages = t2.id","t.levels = t3.id","t1.area = t4.id","t1.sport = t5.id"],
    "type" => ["left","left","left","left","left","left"],
);
if( $bookingList = selectJoinDB("fields_booking", $dataJoin, "t.bookingId = '0' AND (t.userId = '{$data["userId"]}' OR t.id IN (SELECT bookingId FROM fields_booking WHERE userId = '{$data["userId"]}' AND bookingId != '0')) ORDER BY t.id DESC LIMIT {$limit} OFFSET {$offset}") ){
    $response["bookingList"] = $bookingList;
}else{
    $response["msg"] = popupMsg($requestLang,"No Bookings available","لا يوجد مباريات متاحة");
    echo outputError($response);die();
}
echo outputData($response);
?>