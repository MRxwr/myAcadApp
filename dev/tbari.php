<?php
// Set headers before any output
header('Content-Type: text/html; charset=utf-8');

require("template/header.php");
require("template/navbar.php");

$message = "";
$icon = "close";
$booking = array();
$statusClass = "text-danger";

if( isset($_GET["s"]) && !empty($_GET["s"]) && $booking = selectDBNew("fields_booking", [$_GET["s"]], "`gatewayId` = ?","") ){
    
    if ( isset($_POST["pay"]) ) {
        $postBody = json_decode($booking[0]["apiPayload"], true);
        $response = upaymentGateway($postBody);
        if ( isset($response["status"]) && $response["status"] == true && isset($response["data"]["link"]) ) {
            updateDB("fields_booking", array("gatewayURL" => $response["data"]["link"]), "`id` = '{$booking[0]["id"]}'");
            ?>
            <script>
                window.location.href = "<?php echo $response["data"]["link"] ?>";
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
        $statusClass = "text-warning";
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

<style>
    body {
        background-color: #011133 !important;
        color: #fff !important;
    }
    .invoice-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        background: #021b4d;
        border: 1px solid #d4af37;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }
    .invoice-header {
        border-bottom: 2px solid #d4af37;
        padding-bottom: 20px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .invoice-logo img {
        width: 80px;
    }
    .invoice-title {
        color: #d4af37;
        font-size: 24px;
        font-weight: bold;
        text-transform: uppercase;
    }
    .invoice-body h5 {
        color: #d4af37;
        font-size: 14px;
        margin-bottom: 5px;
        text-transform: uppercase;
    }
    .invoice-body p {
        font-size: 18px;
        margin-bottom: 20px;
    }
    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }
    .status-box {
        padding: 15px;
        border-radius: 8px;
        background: rgba(255,255,255,0.05);
        text-align: center;
        margin-bottom: 30px;
        border-left: 5px solid #d4af37;
    }
    .price-table {
        width: 100%;
        margin-bottom: 30px;
    }
    .price-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid rgba(212, 175, 55, 0.2);
    }
    .price-row.total {
        border-top: 2px solid #d4af37;
        border-bottom: none;
        margin-top: 10px;
        padding-top: 15px;
        font-size: 22px;
        font-weight: bold;
        color: #d4af37;
    }
    .btn-gold {
        background-color: #d4af37 !important;
        color: #011133 !important;
        font-weight: bold !important;
        border: none !important;
        padding: 15px !important;
        border-radius: 30px !important;
        transition: all 0.3s !important;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .btn-gold:hover {
        background-color: #f1c40f !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
    }
    .btn-outline-gold {
        border: 1px solid #d4af37 !important;
        color: #d4af37 !important;
        background: transparent !important;
        padding: 10px 20px !important;
        border-radius: 30px !important;
        text-decoration: none !important;
        display: inline-block;
        margin-top: 10px;
        transition: all 0.3s;
    }
    .btn-outline-gold:hover {
        background: #d4af37 !important;
        color: #011133 !important;
    }
</style>

<div class="container pb-5">
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="invoice-logo">
                <img src="logos/logoNew.png" alt="My Academy">
            </div>
            <div class="text-right">
                <div class="invoice-title"><?php echo direction("INVOICE", "فاتورة") ?></div>
                <div style="color: #ccc; font-size: 14px;">#<?php echo $booking[0]["id"] ?></div>
            </div>
        </div>

        <div class="invoice-body">
            <div class="status-box">
                <h5 class="<?php echo $statusClass ?>"><?php echo direction("Status", "الحالة") ?></h5>
                <p class="mb-0"><?php echo $message ?></p>
            </div>

            <div class="details-grid">
                <div>
                    <h5><?php echo direction("Field", "الملعب") ?></h5>
                    <p><?php echo $title ?></p>
                </div>
                <div>
                    <h5><?php echo direction("Date & Time", "التاريخ والوقت") ?></h5>
                    <p><?php echo $date ?><br><small><?php echo $startTime . " - " . $endTime ?></small></p>
                </div>
            </div>

            <div class="price-table">
                <div class="price-row">
                    <span><?php echo direction("Booking Fee", "رسوم الحجز") ?></span>
                    <span><?php echo $price ?> KWD</span>
                </div>
                <!-- You can add more rows here if needed -->
                <div class="price-row total">
                    <span><?php echo direction("Grand Total", "الإجمالي") ?></span>
                    <span><?php echo $price ?> KWD</span>
                </div>
            </div>

            <?php if ( $booking[0]["status"] == 5 || $booking[0]["status"] == 4 || ($booking[0]["status"] == 0 && $booking[0]["isTbari"] == 1) ) { ?>
            <form method="POST">
                <button type="submit" name="pay" class="btn btn-gold w-100"><?php echo direction("PAY NOW", "إدفع الآن") ?></button>
            </form>
            <?php } ?>
            
            <div class="text-center mt-3">
                <a href="index?v=Home" class="btn-outline-gold"><?php echo direction("Back to Home", "الرئيسية") ?></a>
            </div>
        </div>
    </div>
</div>

<?php
require("template/footer.php");
?>
