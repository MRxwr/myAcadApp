<?php
require_once("../admin/includes/config.php");
require_once("../admin/includes/translate.php");
require_once("../admin/includes/functions.php");

if (isset($_GET["requested_order_id"]) && !empty($_GET["requested_order_id"])) {
    if ($booking = selectDBNew("fields_booking", [$_GET["requested_order_id"]], "gatewayId = ?", "")) {
        if (isset($_GET["result"]) && !empty($_GET["result"])) {
            if ($_GET["result"] == "CAPTURED" and $booking[0]["status"] == 0) {
                updateDB("fields_booking", array("status" => 2), "`gatewayId` = '{$_GET["requested_order_id"]}'");
                if ($booking[0]["isTbari"] == 1) {
                    if ($bookingOriginal = selectDBNew("fields_booking", [$booking[0]["bookingId"]], "id = ?", "")) {
                        if ($bookingOriginal[0]["status"] == 0) {
                            updateDB("fields_booking", array("status" => 1), "`id` = '{$bookingOriginal[0]["id"]}'");
                        } elseif ($bookingOriginal[0]["status"] == 1) {
                            updateDB("fields_booking", array("status" => 2), "`id` = '{$bookingOriginal[0]["id"]}'");
                        }
                    } else {
                        die("404 Not Found [ Original Booking Not Found ]");
                    }
                } else {
                    updateDB("fields_booking", array("status" => 2), "`gatewayId` = '{$_GET["requested_order_id"]}'");
                }
            } else {
                updateDB("fields_booking", array("status" => 4), "`gatewayId` = '{$_GET["requested_order_id"]}'");
            }
        } else {
            die("404 Not Found [ Result Not Found ]");
        }
    } else {
        die("404 Not Found [ Booking Not Found ]");
    }
} else {
    die("404 Not Found [ Requested Order ID Not Found ]");
}
