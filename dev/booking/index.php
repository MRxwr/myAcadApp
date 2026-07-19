<?php
require_once("../admin/includes/config.php");
require_once("../admin/includes/translate.php");
require_once("../admin/includes/functions.php");

if( isset($_GET["lang"]) && !empty($_GET["lang"]) ){
	$requestLang = $_GET["lang"];
}else{
	$requestLang = "en"; 
}

if (isset($_GET["requested_order_id"]) && !empty($_GET["requested_order_id"])) {
    if ($booking = selectDBNew("fields_booking", [$_GET["requested_order_id"]], "gatewayId = ?", "")) {
        $gatewayLink = json_encode($_GET);
        if (isset($_GET["result"]) && !empty($_GET["result"])) {
            if ($booking[0]["status"] == 0 || $booking[0]["status"] == 5 || $booking[0]["status"] == 1) {
                if ($_GET["result"] == "CAPTURED") {
                    if ($booking[0]["isTbari"] == 1) {
                        if ( $booking[0]["bookingId"] == 0 ) {
                            // User 1 paid
                            updateDB("fields_booking", array("status" => 1, "gatewayLink" => $gatewayLink), "`id` = '{$booking[0]["id"]}'");
                            // Find User 2 who joined
                            if ( $booking2 = selectDB("fields_booking", "`bookingId` = '{$booking[0]["id"]}'") ) {
                                // Send WhatsApp to User 2
                                $paymentLink = "{$paymentReturnURL}/tbari.php?s={$booking2[0]["gatewayId"]}";
                                $msg = popupMsg($requestLang, "User 1 has paid! Now it's your turn to confirm the match: {$paymentLink}", "قام اللاعب الأول بالدفع! الآن دورك لتأكيد المباراة: {$paymentLink}");
                                whatsappUltraMsg($booking2[0]["phone"], $msg);
                            }
                            $response = outputData(array("msg" => popupMsg($requestLang, "Payment Captured Successfully - Partially Paid", " مدفوع جزئياً / تم التقاط الدفع بنجاح")));
                        } else {
                            // User 2 paid
                            // Find User 1
                            if ( $booking1 = selectDB("fields_booking", "`id` = '{$booking[0]["bookingId"]}'") ) {
                                if ( $booking1[0]["status"] == 1 ) {
                                    // Both paid
                                    updateDB("fields_booking", array("status" => 2, "gatewayLink" => $gatewayLink), "`id` = '{$booking[0]["id"]}'");
                                    updateDB("fields_booking", array("status" => 2, "gatewayLink" => $gatewayLink), "`id` = '{$booking1[0]["id"]}'");
                                    
                                    // Send WhatsApp to both
                                    $msg = popupMsg($requestLang, "Match confirmed! Both players paid. Enjoy your game!", "تم تأكيد المباراة! دفع كلا اللاعبين. استمتع بمباراتك!");
                                    whatsappUltraMsg($booking[0]["phone"], $msg);
                                    whatsappUltraMsg($booking1[0]["phone"], $msg);
                                    
                                    $response = outputData(array("msg" => popupMsg($requestLang, "Payment Captured Successfully - Fully Paid", "مدفوع بالكامل / تم التقاط الدفع بنجاح")));
                                } else {
                                    // User 2 paid but User 1 hasn't
                                    updateDB("fields_booking", array("status" => 1, "gatewayLink" => $gatewayLink), "`id` = '{$booking[0]["id"]}'");
                                    $response = outputData(array("msg" => popupMsg($requestLang, "Payment Captured Successfully - Partially Paid", " مدفوع جزئياً / تم التقاط الدفع بنجاح")));
                                }
                            } else {
                                $response = outputError(array("msg" => popupMsg($requestLang, "Original Booking Not Found", "الحجز الأصلي غير موجود")));
                            }
                        }
                    } else {
                        updateDB("fields_booking", array("status" => 2, "gatewayLink" => $gatewayLink), "`gatewayId` = '{$_GET["requested_order_id"]}'");
                        whatsappUltraMsg($booking[0]["phone"], popupMsg($requestLang, "Your payment for booking ID {$booking[0]["id"]} has been fully captured. Your booking is now confirmed.", "تم التقاط دفعتك بالكامل للحجز رقم {$booking[0]["id"]}. تم تأكيد حجزك."));
                        $response = outputData(array("msg" => popupMsg($requestLang, "Payment Captured Successfully - Fully Paid", "مدفوع بالكامل / تم التقاط الدفع بنجاح"))); 
                    }
                } else {
                    updateDB("fields_booking", array("status" => 4, "gatewayLink" => $gatewayLink), "`gatewayId` = '{$_GET["requested_order_id"]}'");
                    $response = outputData(array("msg" => popupMsg($requestLang, "Payment Failed", "فشل الدفع"))); 
                }
                if ($booking[0]["isTbari"] == 1) {
                    header("Location: ../tbari.php?s=".$_GET["requested_order_id"]);
                    die();
                }
            } else {
                if ($booking[0]["isTbari"] == 1) {
                    header("Location: ../tbari.php?s=".$_GET["requested_order_id"]);
                    die();
                }
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

//echo $response;
die();