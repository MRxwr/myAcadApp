<?php
// Set headers before any output
header('Content-Type: text/html; charset=utf-8');

require("template/header.php");
require("template/navbar.php");

$message = "";
$icon = "close";
$booking = array();

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
    } elseif ( $booking[0]["status"] == 1 ) {
        $message = direction("You have paid. Waiting for the other player.", "لقد قمت بالدفع. بانتظار اللاعب الآخر.");
        $icon = "suc";
    } elseif ( $booking[0]["status"] == 4 ) {
        $message = direction("Payment Failed. Please try again.", "فشل عملية الدفع. يرجى المحاولة مرة أخرى.");
        $icon = "close";
    } elseif ( $booking[0]["status"] == 5 ) {
        $message = direction("Match Ready! Please proceed to payment.", "المباراة جاهزة! يرجى إتمام عملية الدفع.");
        $icon = "suc";
    } else {
        $message = direction("Waiting for a player to join.", "بانتظار انضمام لاعب آخر.");
        $icon = "close";
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

<div class="success_area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row justify-content-between">
                    <div class="col-lg-5 mt_40">
                        <div class="left_succes">
                            <h2><?php echo $message ?><img src="img/<?php echo $icon ?>.svg" alt=""></h2>
                            <h3><?php echo direction("Booking Id: ","رقم الحجز: ") . " {$booking[0]["id"]}" ?></h3>
                            <div class="wap_date">
                                <h4><?php echo direction("Date: ","التاريخ: ") . $date ?></h4>
                                <p><?php echo $startTime . " - " . $endTime ?></p>
                            </div>
                            <?php if ( $booking[0]["status"] == 5 || $booking[0]["status"] == 4 || ($booking[0]["status"] == 0 && $booking[0]["isTbari"] == 1) ) { ?>
                            <form method="POST">
                                <button type="submit" name="pay" class="button border-0 w-100"><?php echo direction("PAY NOW", "إدفع الآن") ?></button>
                            </form>
                            <?php } ?>
                            <a href="?v=Home" class="button"><?php echo direction("HOME","الرئيسية") ?></a>
                        </div>
                    </div>
                    <div class="col-lg-5 mt_40">
                        <div class="right_succes">
                            <h2><?php echo $title ?></h2>
                            <div class="suc_item">
                                <div class="suc_child">
                                    <span>!</span>
                                    <h3><?php echo direction("Tbari Match", "مباراة تباري") ?></h3>
                                </div>
                                <p><?php echo $price ?> KWD</p>
                            </div>
                            
                            <h4><?php echo direction("PAYMENT METHOD", "طريقة الدفع" ) ?></h4>
                            <h5><?php echo "KNET / CC" ?></h5>
                            <div class="d-flex justify-content-between">
                                <h6><strong><?php echo direction("Total", "المجموع") ?></strong></h6>
                                <p><?php echo $price ?> KWD</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require("template/footer.php");
?>
