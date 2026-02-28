<?php 
if( !isset($_POST["userId"]) || empty($_POST["userId"]) ){
    $response["msg"] = popupMsg($requestLang,"Please make sure you send post data before submitting.","يرجى التأكد من ارسال بيانات POST قبل الارسال");
    echo outputError($response);die();
}
$data = $_POST;
unset($_POST);
if( $bookingList = selectDBNew("fields_booking",[$data["userId"]], "(`userId` = '{$data["userId"]}' OR `id` IN (SELECT `bookingId` FROM `fields_booking` WHERE `userId` = '{$data["userId"]}' AND `bookingId` != '0'))","") ){
    $response["totalBookings"] = count($bookingList);
}else{
    $response["totalBookings"] = 0;
    $response["msg"] = popupMsg($requestLang,"No Bookings available","لا يوجد مباريات متاحة");
    echo outputError($response);die();
}
echo outputData($response);
?>