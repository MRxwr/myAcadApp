<?php
if( isset($_GET["requested_order_id"]) && !empty($_GET["requested_order_id"]) ){
    if( $order = selectDB("orders","`gatewayId` = '{$_GET["requested_order_id"]}'") ){
        $order2 = selectDB("orders","`gatewayId` = '{$_GET["requested_order_id"]}'");
        if( $order2[0]["status"] == 0 ){
            $session = selectDB("sessions","`id` = '{$order2[0]["sessionId"]}'");
            $quantity = $session[0]["quantity"] - $order2[0]["subscriptionQuantity"];
            updateDB("orders",array("gatewayLink"=>json_encode($_GET),"status"=>1),"`gatewayId` = '{$_GET["requested_order_id"]}'");
            updateDB("sessions",array("quantity"=>$quantity),"`id` = '{$order2[0]["sessionId"]}'");
            $academyEmail = selectDB("academies","`id` = '{$order2[0]["academyId"]}'");
            $settingsEmail = selectDB("settings","`id` = '1'");
            sendMails($order2,$order2[0]["email"]);
            sendMails($order2,$academyEmail[0]["email"]);
            sendMails($order2,$settingsEmail[0]["email"]);
        }
        if($order[0]["paymentMethod"] == 1 ){
            $paymentMethod = "Knet";
        }elseif( $order[0]["paymentMethod"] == 2 ){
            $paymentMethod = "VISA";
        }else{
            $paymentMethod = "WALLET";
        }
        $subscription = selectDB("subscriptions","`id` = '{$order[0]["subscriptionId"]}'");
    }else{
        ?>
        <script>
        window.onload = function() {
            alert("<?php echo direction("Error, Your subscription order could not be completed. Please try again.","خطأ، لم نستطع تأكيد إشتراكك، الرجاء المحاولة مجدداً") ?>");
            window.location.href = "?v=Home";
        };
        </script>
        <?php
        die();
    }
}else{
    ?>
    <script>
    window.onload = function() {
        alert("<?php echo direction("Error, Your subscription order could not be completed. Please try again.","خطأ، لم نستطع تأكيد إشتراكك، الرجاء المحاولة مجدداً") ?>");
        window.location.href = "?v=Home";
    };
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
                            <h2><?php echo direction("Your Subscription is Confirmed ","تم تأكيد إشتراكك ") ?><img src="img/suc.svg" alt=""></h2>
                            <h3><?php echo direction("Order Id: ","رقم الطلب: ") . " {$order[0]["id"]}" ?></h3>
                            <div class="wap_date">
                                <h4><?php echo direction("Start: ","البدايه: ") . substr($order[0]["date"],0,11)?></h4>
                                <h4><?php echo direction("End: ","النهاية: ") . substr(date("Y-m-d H:i:s", strtotime($order[0]["date"] . " +{$subscription[0]["numberOfDays"]} days")),0,11)?></h4>
                            </div>
                            <p><?php echo direction("YOU WILL RECIVE A CONFIRMATION EMAIL SOON !<br>THANK YOU FOR USING <span>MY ACAD</span>","سوف يصلكم تأكيد الإشتراك على بريدكم الإلكتروني قريبا!<br>شكراً لأستخدامكم<span>MY ACAD</span>") ?></p>
                            <a href="?v=Home" class="button"><?php echo direction("HOME","الرئيسية") ?></a>
                        </div>
                    </div>
                    <div class="col-lg-5 mt_40">
                        <div class="right_succes">
                            <h2><?php echo direction($order[0]["enAcademy"],$order[0]["arAcademy"]) ?></h2>
                            <div class="suc_item">
                                <div class="suc_child">
                                    <span><?php echo $order[0]["subscriptionQuantity"] ?></span>
                                    <h3><?php echo direction($order[0]["enSubscription"],$order[0]["arSubscription"]) ?></h3>
                                </div>
                                <p><?php echo $order[0]["totalSubscriptionPrice"] ?>KD</p>
                            </div>
                            <?php
                            if( $order[0]["jersyQuantity"] != 0 ){
                                ?>
                                <div class="suc_item">
                                    <div class="suc_child">
                                        <span><?php echo $order[0]["jersyQuantity"] ?></span>
                                        <h3><?php echo direction($order[0]["enAcademy"] . " Jersy","ملابس " . $order[0]["arAcademy"]) ?></h3>
                                    </div>
                                    <p><?php echo $order[0]["totalJersyPrice"] ?>KD</p>
                                </div>
                                <?php
                            }
                            if( !empty($order[0]["voucher"]) ){
                            ?>
                                <h4><?php echo direction("Voucher", "كود الخصم" ) ?></h4>
                                <h5><?php echo $order[0]["voucher"] ?></h5>
                            <?php
                            }
                            ?>
                            
                            <h4><?php echo direction("PAYMENT METHOD", "طريقة الدفع" ) ?></h4>
                            <h5><?php echo $paymentMethod ?></h5>
                            <div class="d-flex justify-content-between">
                                <h6><strong><?php echo direction("Total", "المجموع") ?></strong></h6>
                                <p><?php echo $order[0]["total"] ?>KD</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>