<?php
header('Content-Type: text/html; charset=utf-8');

require("admin/includes/config.php");
require("admin/includes/translate.php");
require("admin/includes/functions.php");

if( isset($_GET["Lang"]) && !empty($_GET["Lang"]) ){
	$requestLang = $_GET["Lang"];
}elseif( isset($_COOKIE["CREATEkwLANG"]) && !empty($_COOKIE["CREATEkwLANG"]) ){
	$requestLang = $_COOKIE["CREATEkwLANG"];
}else{
	$requestLang = "EN"; 
}

$message = "";
$icon = "close";
$booking = array();
$statusClass = "text-gold";

if( isset($_GET["s"]) && !empty($_GET["s"]) && $booking = selectDBNew("fields_booking", [$_GET["s"]], "`gatewayId` = ?","") ){
    
    if ( isset($_POST["pay"]) ) {
        // If status is 4 (Failed), create a new attempt via API
        if ( $booking[0]["status"] == 4 ) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://myacad.app/requests/?a=BookingPayment',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'paymentMethod' => $booking[0]['paymentMethod'],
                    'isTbari'       => '1',
                    'userId'        => $booking[0]['userId'],
                    'fieldId'       => $booking[0]['fieldId'],
                    'periodId'      => $booking[0]['periodId'],
                    'bookingDate'   => substr($booking[0]['bookingDate'], 0, 10),
                    'startTime'     => $booking[0]['startTime'],
                    'endTime'       => $booking[0]['endTime'],
                    'levels'        => $booking[0]['levels'],
                    'ages'          => $booking[0]['ages'],
                    'notes'         => $booking[0]['notes'],
                    'voucher'       => $booking[0]['voucher'],
                    'bookingId'     => $booking[0]['bookingId'] // To keep it linked to the parent match
                ),
                CURLOPT_HTTPHEADER => array(
                    'myacadheader: myAcadAppCreate' // Replace with your actual header key if necessary
                ),
            ));
            
            $responseJSON = curl_exec($curl);
            curl_close($curl);
            
            $response = json_decode($responseJSON, true);
            
            if ( isset($response["status"]) && $response["status"] == true && isset($response["data"]["paymentURL"]) ) {
                header("Location: " . $response["data"]["paymentURL"]);
                die();
            } else {
                $message = direction("Error: " . ($response["msg"] ?? "Unable to create new payment"), "خطأ: " . ($response["msgAr"] ?? "تعذر إنشاء دفع جديد"));
            }
        }

        // Standard payment for status 5 or 0
        $postBody = json_decode($booking[0]["apiPayload"], true);
        $response = upaymentGateway($postBody);
        $response = upaymentGateway($postBody);
        if ( isset($response["status"]) && $response["status"] == true && isset($response["data"]["link"]) ) {
            $gatewayURL = $response["data"]["link"];
            updateDB("fields_booking", array("gatewayURL" => $gatewayURL), "`id` = '{$booking[0]["id"]}'");
            ?>
            <script>
                window.location.href = "<?php echo $gatewayURL ?>";
            </script>
            <?php
            die();
        } else {
            $message = direction("Error while processing payment", "خطأ في معالجة الدفع");
        }
    }

    $fieldData = selectDB("fields_list", "`id` = '{$booking[0]["fieldId"]}'");
    $title = $fieldData ? $fieldData[0]["enTitle"] : "Match Details";
    $price = $booking[0]["total"];
    $date = $booking[0]["bookingDate"];
    $startTime = $booking[0]["startTime"];
    $endTime = $booking[0]["endTime"];

    if ( $booking[0]["status"] == 2 ) {
        $message = direction("Booking is already fully paid", "الحجز مدفوع بالكامل بالفعل");
        $icon = "suc";
        $statusClass = "text-success";
    } elseif ( $booking[0]["status"] == 1 ) {
        $message = direction("You have paid. Waiting for the other player.", "لقد قمت بالدفع. بانتظار اللاعب الآخر.");
        $icon = "suc";
        $statusClass = "text-success";
    } elseif ( $booking[0]["status"] == 4 ) {
        $message = direction("Payment Failed. Please try again.", "فشل عملية الدفع. يرجى المحاولة مرة أخرى.");
        $icon = "close";
        $statusClass = "text-danger";
    } elseif ( $booking[0]["status"] == 5 ) {
        $message = direction("Match Ready! Please proceed to payment.", "المباراة جاهزة! يرجى إتمام عملية الدفع.");
        $icon = "suc";
        $statusClass = "text-gold";
    } else {
        $message = direction("Waiting for a player to join.", "بانتظار انضمام لاعب آخر.");
        $icon = "close";
        $statusClass = "text-info";
    }

} else {
    ?>
    <script>
        window.location.href = "index?v=Home"; 
    </script>
    <?php
    die();
}
?>
<!DOCTYPE html>
<html lang="en" dir="<?php echo $directionHTML ?>">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice - My Academy</title>
    <link rel="shortcut icon" href="logos/logoNew.png" />
    <style>
        [dir="rtl"] .details-grid {
            direction: rtl;
        }
        [dir="rtl"] .invoice-header {
            flex-direction: row-reverse;
        }
        [dir="rtl"] .price-row {
            flex-direction: row-reverse;
        }
        body {
            background-color: #011133;
            color: #fff;
            margin: 0;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: start;
        }
        .invoice-container {
            max-width: 500px;
            width: 100%;
            padding: 40px;
            background: #021b4d;
            border: 2px solid #dd9f22;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.6);
            position: relative;
        }
        .lang-switch {
            position: absolute;
            top: 15px;
            right: 15px;
        }
        .lang-switch a {
            color: #dd9f22;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            border: 1px solid #dd9f22;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .invoice-header {
            border-bottom: 1px solid rgba(221, 159, 34, 0.3);
            padding-bottom: 25px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .invoice-logo img {
            width: 70px;
        }
        .invoice-title {
            color: #dd9f22;
            font-size: 28px;
            font-weight: 800;
            text-align: inherit;
        }
        .invoice-title small {
            display: block;
            font-size: 14px;
            color: #aaa;
            font-weight: 400;
        }
        .status-box {
            padding: 20px;
            border-radius: 12px;
            background: rgba(255,255,255,0.03);
            text-align: center;
            margin-bottom: 30px;
            border: 1px dashed rgba(221, 159, 34, 0.5);
        }
        .status-box h5 {
            margin: 0 0 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 12px;
        }
        .status-box p {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        .text-gold { color: #dd9f22; }
        .text-success { color: #2ecc71; }
        .text-danger { color: #e74c3c; }
        .text-info { color: #3498db; }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 35px;
        }
        .detail-item h5 {
            color: #dd9f22;
            font-size: 12px;
            margin: 0 0 8px;
            text-transform: uppercase;
        }
        .detail-item p {
            margin: 0;
            font-size: 16px;
            font-weight: 500;
        }
        .price-table {
            margin-bottom: 40px;
        }
        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            flex-direction: row;
        }
        .price-row.total {
            border-top: 2px solid #dd9f22;
            border-bottom: none;
            margin-top: 15px;
            padding-top: 20px;
            font-size: 24px;
            font-weight: 800;
            color: #dd9f22;
        }
        .btn-pay {
            background: #dd9f22;
            color: #011133;
            width: 100%;
            border: none;
            padding: 18px;
            border-radius: 12px;
            font-size: 20px;
            font-weight: 800;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(221, 159, 34, 0.3);
        }
        .btn-pay:hover {
            background: #f1c40f;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(221, 159, 34, 0.5);
        }
        .footer-note {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="lang-switch">
            <a href="?s=<?php echo $_GET["s"] ?>&Lang=<?php echo ($requestLang == 'EN' ? 'AR' : 'EN') ?>">
                <?php echo ($requestLang == 'EN' ? 'العربية' : 'English') ?>
            </a>
        </div>

        <div class="invoice-header">
            <div class="invoice-logo">
                <img src="logos/logoNew.png" alt="My Academy">
            </div>
            <div class="invoice-title">
                <?php echo direction("INVOICE", "فاتورة") ?>
                <small>#<?php echo $booking[0]["id"] ?></small>
            </div>
        </div>

        <div class="status-box">
            <h5 class="<?php echo $statusClass ?>"><?php echo direction("Status", "الحالة") ?></h5>
            <p class="<?php echo $statusClass ?>"><?php echo $message ?></p>
        </div>

        <div class="details-grid">
            <div class="detail-item">
                <h5><?php echo direction("Field", "الملعب") ?></h5>
                <p><?php echo $title ?></p>
            </div>
            <div class="detail-item">
                <h5><?php echo direction("Date", "التاريخ") ?></h5>
                <p><?php echo substr($date, 0, 10) ?></p>
            </div>
            <div class="detail-item">
                <h5><?php echo direction("Time", "الوقت") ?></h5>
                <p><?php echo $startTime . " - " . $endTime ?></p>
            </div>
            <div class="detail-item">
                <h5><?php echo direction("Payment", "الدفع") ?></h5>
                <p>KNET / CC</p>
            </div>
        </div>

        <div class="price-table">
            <div class="price-row">
                <span><?php echo direction("Subtotal", "المجموع الفرعي") ?></span>
                <span><?php echo $price ?> KWD</span>
            </div>
            <div class="price-row total">
                <span><?php echo direction("Total", "الإجمالي") ?></span>
                <span><?php echo $price ?> KWD</span>
            </div>
        </div>

        <?php if ( $booking[0]["status"] == 5 || $booking[0]["status"] == 4 || ($booking[0]["status"] == 0 && $booking[0]["isTbari"] == 1) ) { ?>
        <form method="POST">
            <button type="submit" name="pay" class="btn-pay"><?php echo direction("PAY NOW", "إدفع الآن") ?></button>
        </form>
        <?php } ?>

        <div class="footer-note">
            &copy; <?php echo date("Y") ?> My Academy. All rights reserved.
        </div>
    </div>
</body>
</html>
<?php die(); ?>
