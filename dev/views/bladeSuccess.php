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
        }elseif($order[0]["paymentMethod"] == 3 ){
            $paymentMethod = "WALLET";
        }else{
            $paymentMethod = "FREE";
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
                    <?php
                    if( $order[0]["isTournament"] == 0 ){
                        ?>
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
                    <?php
                    }else{
                        $teamDetails = json_decode($order[0]["teamDetails"],true);
                        $tournament = selectDB("tournaments","`id` = '{$order[0]["tournamentId"]}'");
                        $area = selectDB("countries","`id` = '{$tournament[0]["area"]}'");
                        ?>
                    <div class="col-lg-5 mt_40">
                        <div class="left_succes">
                            <h2><?php echo direction("Your Subscription is Confirmed ","تم تأكيد إشتراكك ") ?><img src="img/suc.svg" alt=""></h2>
                            <h3><?php echo direction("Order Id: ","رقم الطلب: ") . " {$order[0]["id"]}" ?></h3>
                        </div>
                    </div>

                    <div class="col-12 p-3"><h5 style="font-size: 20px;"><?php echo direction("ORDER INFO","معلومات الحجز") ?></h5></div>  

                    <div class="col-12 p-3">
                        <div class="row m-0 w-100" style="border:1px solid #e2e2e2">
                            <div class="col-6 text-left p-3"><h5 style="font-size: 15px;color: #ffa300;"><?php echo direction("Tournament Name","اسم البطولة") ?></h5></div>
                            <div class="col-6 text-left p-3"><h5 style="color: black;font-size: 15px;"><?php echo direction($teamDetails["enTournament"],$teamDetails["arTournament"]) ?></h5></div>
                        </div>
                    </div>

                    <div class="col-12 p-3">
                        <div class="row m-0 w-100" style="border:1px solid #e2e2e2">
                            <div class="col-6 text-left p-3"><h5 style="font-size: 15px;color: #ffa300;"><?php echo direction("Location","المكان") ?></h5></div>
                            <div class="col-6 text-left p-3"><h5 style="color: black;font-size: 15px;"><?php echo direction($area[0]["areaEnTitle"],$area[0]["areaArTitle"]) ?></h5></div>
                        </div>
                    </div>

                    <div class="col-12 p-3">
                        <div class="row m-0 w-100" style="border:1px solid #e2e2e2">
                            <div class="col-6 text-left p-3"><h5 style="font-size: 15px;color: #ffa300;"><?php echo direction("Date","التاريخ") ?></h5></div>
                            <div class="col-6 text-left p-3"><h5 style="color: black;font-size: 15px;"><?php echo $tournament[0]["gameDate"] ?></h5></div>
                        </div>
                    </div>

                    <div class="col-12 p-3">
                        <div class="row m-0 w-100" style="border:1px solid #e2e2e2">
                            <div class="col-6 text-left p-3"><h5 style="font-size: 15px;color: #ffa300;"><?php echo direction("Time","الوقت") ?></h5></div>
                            <div class="col-6 text-left p-3"><h5 style="color: black;font-size: 15px;"><?php echo $tournament[0]["gameTime"] ?></h5></div>
                        </div>
                    </div>

                    <div class="col-12 p-3">
                        <div class="row m-0 w-100" style="border:1px solid #e2e2e2">
                            <div class="col-6 text-left p-3"><h5 style="font-size: 15px;color: #ffa300;"><?php echo direction("Price","السعر") ?></h5></div>
                            <div class="col-6 text-left p-3"><h5 style="color: black;font-size: 15px;"><?php echo $price = ( $teamDetails["price"] != 0 ) ? $teamDetails["price"] . " KD" : " Free"; ?></h5></div>
                        </div>
                    </div>

                    <div class="col-12 p-3">
                        <div class="row m-0 w-100" style="border:1px solid #e2e2e2">
                            <div class="col-6 text-left p-3"><h5 style="font-size: 15px;color: #ffa300;"><?php echo direction("Team name","اسم الفريق") ?></h5></div>
                            <div class="col-6 text-left p-3"><h5 style="color: black;font-size: 15px;"><?php echo $teamDetails["teamName"] ?></h5></div>
                        </div>
                    </div>

                    <div class="col-12 p-3">
                        <div class="row m-0 w-100" style="border:1px solid #e2e2e2">
                            <div class="col-12 text-left p-3"><h5 style="font-size: 15px;color: #ffa300;"><?php echo direction("Team Members","اعضاء الفريق") ?></h5></div>
                            <?php
                            for( $i = 0; $i < count($teamDetails["players"]); $i++){
                                ?>
                                <div class="col-12 p-3"><h5 style="color: black;font-size: 15px;"><?php echo $teamDetails["players"][$i] ?></h5></div>
                                <?php
                            }
                            ?>
                            <div class="col-12 text-left p-3"><h5 style="font-size: 15px;color: #ffa300;"><?php echo direction("Bench","الإحتياط") ?></h5></div>
                            <?php
                            for( $i = 0; $i < count($teamDetails["bench"]); $i++){
                                ?>
                                <div class="col-12 p-3"><h5 style="color: black;font-size: 15px;"><?php echo $teamDetails["bench"][$i] ?></h5></div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-12"><p><?php echo direction("YOU WILL RECIVE A CONFIRMATION EMAIL SOON !<br>THANK YOU FOR USING <span style='color: #ffa300;'>MY ACAD</span>","سوف يصلكم تأكيد الإشتراك على بريدكم الإلكتروني قريبا!<br>شكراً لأستخدامكم<span  style='color: #ffa300;'>MY ACAD</span>") ?></p>
                    <a href="?v=Home" class="button" style="width: 100%;text-align: center;font-size: 18px;margin: 10px 0px 0px 0px;"><?php echo direction("HOME","الرئيسية") ?></a></div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>