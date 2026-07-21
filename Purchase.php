<?php
// Set headers before any output
header('Content-Type: text/html; charset=utf-8');

require("template/header.php");
require("template/navbar.php");
$link = array();
if( isset($_GET["s"]) && !empty($_GET["s"]) && $link = selectDBNew("purchases", [$_GET["s"]], "`gatewayId` = ?","") ){
    ?>
    <script>
        window.location.href = "<?php echo $link[0]["gatewayURL"] ?>";
    </script>
    <?php
    die();
}elseif( !isset($_GET["requested_order_id"]) ){
    ?>
    <script>
        window.location.href = "index?v=Home"; 
    </script>
    <?php
    die();
}

if( isset($_GET["result"]) && !empty($_GET["result"]) && isset($_GET["requested_order_id"]) && !empty($_GET["requested_order_id"]) ){
    $link = selectDBNew("purchases", [$_GET["requested_order_id"]], "`gatewayId` = ?","");
    if( $link[0]["status"] == 0 ){
        if( $_GET["result"] == "CAPTURED" ){
            $message = direction("Your payment is Confirmed ","تم تأكيد عملية الدفع بنجاح ");
            $icon = "suc";
            updateDB("purchases",array("status"=>1,"gatewayResponse"=>json_encode($_GET)),"`gatewayId` = '{$_GET["requested_order_id"]}'");
        }else{
            $message = direction("Your payment has failed","عملية دفع فاشلة");
            $icon = "close";
            updateDB("purchases",array("status"=>2,"gatewayResponse"=>json_encode($_GET)),"`gatewayId` = '{$_GET["requested_order_id"]}'");
        }
    }elseif( $link[0]["status"] == 1 ){
        $message = direction("Your payment is Confirmed ","تم تأكيد عملية الدفع بنجاح ");
        $icon = "suc";
    }elseif( $link[0]["status"] == 2 ){
        $message = direction("Your payment has failed","عملية دفع فاشلة");
        $icon = "close";
    }
}else{
    $title = "MYACAD";
    if ( $link[0]["isMyacad"] == 1 ) {
        if( $academyData = selectDB("academies","`id` = '{$link[0]["academyId"]}'")){
            $title = $academyData[0]["enTitle"];
        }
    }
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
                            <h3><?php echo direction("Order Id: ","رقم الطلب: ") . " {$link[0]["id"]}" ?></h3>
                            <div class="wap_date">
                                <h4><?php echo direction("Date: ","البدايه: ") . substr($link[0]["date"],0,11)?></h4>
                            </div>
                            <a href="?v=Home" class="button"><?php echo direction("HOME","الرئيسية") ?></a>
                        </div>
                    </div>
                    <div class="col-lg-5 mt_40">
                        <div class="right_succes">
                            <h2><?php echo $title ?></h2>
                            <div class="suc_item">
                                <div class="suc_child">
                                    <span>1</span>
                                    <h3><?php echo $link[0]["note"] ?></h3>
                                </div>
                                <p><?php echo $link[0]["price"] ?>KD</p>
                            </div>
                            
                            <h4><?php echo direction("PAYMENT METHOD", "طريقة الدفع" ) ?></h4>
                            <h5><?php echo "KNET" ?></h5>
                            <div class="d-flex justify-content-between">
                                <h6><strong><?php echo direction("Total", "المجموع") ?></strong></h6>
                                <p><?php echo $link[0]["price"] ?>KD</p>
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