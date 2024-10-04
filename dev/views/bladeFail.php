<?php
if( isset($_GET["requested_order_id"]) && !empty($_GET["requested_order_id"]) ){
    if( $order = selectDB("orders","`gatewayId` = '{$_GET["requested_order_id"]}'")){
        if( $order[0]["status"] == 0 ){
            $academyId = $order[0]["academyId"];
            updateDB2("orders",array("gatewayLink"=>json_encode($_GET),"status"=>2),"`gatewayId` = '{$_GET["requested_order_id"]}'");
        }
    }else{
        $academyId = "";
    }
}else{
    $academyId = "";
}
?>
<div class="fail_area">
    <h2><?php echo direction("There were a problem proccessing your Payment","حصل خطأ أثناء عملية الدفع ") ?><img src="img/close.svg" alt=""></h2>
    <a href="?v=Details&id=<?php echo $academyId ?>" class="button color_can"><?php echo direction("TRY AGAIN","المحاولة مجدداً") ?></a>
    <a href="?v=Home" class="button"><?php echo direction("HOME","الرئيسية") ?></a>
</div>