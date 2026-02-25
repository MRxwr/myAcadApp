<?php
require_once("../admin/includes/config.php");
require_once("../admin/includes/translate.php");
require_once("../admin/includes/functions.php");

if (isset($_GET["requested_order_id"]) && !empty($_GET["requested_order_id"])) {
    if ($booking = selectDBNew("fields_booking", [$_GET["requested_order_id"]], "gatewayId = ?", "")) {
        $gatewayLink = json_encode($_GET);
        if (isset($_GET["result"]) && !empty($_GET["result"])) {
            if ($booking[0]["status"] == 0) {
                if ($_GET["result"] == "CAPTURED") {
                    if ($booking[0]["isTbari"] == 1) {
                        if ($bookingOriginal = selectDBNew("fields_booking", [$booking[0]["bookingId"]], "id = ?", "")) {
                            if ($bookingOriginal[0]["status"] == 0) {
                                updateDB("fields_booking", array("status" => 1, "gatewayLink" => $gatewayLink), "`id` = '{$bookingOriginal[0]["id"]}'");
                                $response = outputData(array("msg" => popupMsg($requestLang, "Payment Captured Successfully - Partially Paid", " مدفوع جزئياً / تم التقاط الدفع بنجاح")));
                            } elseif ($bookingOriginal[0]["status"] == 1) {
                                updateDB("fields_booking", array("status" => 2, "gatewayLink" => $gatewayLink), "`id` = '{$bookingOriginal[0]["id"]}'");
                                $response = outputData(array("msg" => popupMsg($requestLang, "Payment Captured Successfully - Fully Paid", "مدفوع بالكامل / تم التقاط الدفع بنجاح")));
                            }
                        } else {
                            $response = outputError(array("msg" => popupMsg($requestLang, "Original Booking Not Found", "الحجز الأصلي غير موجود")));
                        }
                    } else {
                        updateDB("fields_booking", array("status" => 2, "gatewayLink" => $gatewayLink), "`gatewayId` = '{$_GET["requested_order_id"]}'");
                        $response = outputData(array("msg" => popupMsg($requestLang, "Payment Captured Successfully - Fully Paid", "مدفوع بالكامل / تم التقاط الدفع بنجاح"))); 
                    }
                } else {
                    updateDB("fields_booking", array("status" => 4, "gatewayLink" => $gatewayLink), "`gatewayId` = '{$_GET["requested_order_id"]}'");
                    $response = outputData(array("msg" => popupMsg($requestLang, "Payment Failed", "فشل الدفع"))); 
                }
            } else {
                $response = outputError(array("msg" => popupMsg($requestLang, "Can Not Update Booking Status", "لا يمكن تحديث حالة الحجز"))); 
            }
        } else {
            $response = outputError(array("msg" => popupMsg($requestLang, "Result Not Found", "النتيجة غير موجودة"))); 
        }
    } else {
        $response = outputError(array("msg" => popupMsg($requestLang, "Booking Not Found", "الحجز غير موجود"))); 
    }
} else {
    $response = outputError(array("msg" => popupMsg($requestLang, "Requested Order ID Not Found", "معرف الطلب المطلوب غير موجود"))); 
}

echo $response;die();