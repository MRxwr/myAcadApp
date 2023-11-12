<?php

if( $order = selectDB("orders","`id` = '{$_GET["id"]}'") ){

}else{
    ?>
    <script>
        window.onload = function() {
            alert("<?php echo direction("Wrong order number","رقم طلب خاطئ") ?>");
            window.location.href = "?v=Invoices";
        }
    </script>
    <?php
}

?>
<style>
td{
	font-weight: 600;
}
</style>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">

</div>
<div class="pull-right">

</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body" class="printBill">
<table style="width:100%">
	<tr>
		<td style="text-align: center">
			<img src="../img/logo.png" style="width:150px; height:150px">
		</td>
	</tr>
	<tr>
		<td style="text-align: center" class="txt-dark">
		<?php echo direction("Order","طلب") ?> #<?php echo $order[0]["id"]; ?>
		</td>
	</tr>
</table>

<table style="width:100%">
<tr>
    <td style="text-align: right;">
    <address>
        <span class="txt-dark head-font capitalize-font mb-5"><?php echo direction("Date","التاريخ") ?>: <?php echo $order[0]["date"] ?></span><br>
        <span class="address-head mb-5"><?php echo direction("Phone","الهاتف") ?>: <?php echo $order[0]["phone"] ?></span><br>
        <span class="address-head mb-5"><?php echo direction("Name","الإسم") ?>: <?php echo $order[0]["name"] ?></span>
    </address>
    </td>
</tr>
	<tr>
		<td colspan="2" style="width: 100%;text-align: right;"class="txt-dark"><span class="address-head mb-5"><?php echo direction("Email","البريد الإلكتروني") ?>: <?php echo $order[0]["email"] ?></span></td>
	</tr>
</table>

<div class="invoice-bill-table">
<div class="table-responsive">
<table class="table table-hover" style="width:100%">
    <tr>
    <td style="text-align: left;" class="txt-dark"><?php echo direction("Items","المنتجات") ?></td>
    <td style="text-align: left;" class="txt-dark"><?php echo direction("Price","السعر") ?></td>
    </tr>
    <tbody>
        <tr>
            <td class='txt-dark' style='white-space: break-spaces;'>
                <?php echo "{$order[0]["subscriptionQuantity"]}x " . direction($order[0]["enSession"],$order[0]["arSession"]) . " / " . direction($order[0]["enSubscription"],$order[0]["arSubscription"])?>
            </td>
            <td>
                <span class='Price txt-dark'><?php echo numTo3Float($order[0]["totalSubscriptionPrice"]) ?>KD</span>
            </td>
        </tr>
        <tr>
            <td class='txt-dark' style='white-space: break-spaces;'>
                <?php echo "{$order[0]["jersyQuantity"]}x Jersey of " . direction($order[0]["enAcademy"],$order[0]["arAcademy"]) ?>
            </td>
            <td>
                <span class='Price txt-dark'><?php echo numTo3Float($order[0]["totalJersyPrice"]) ?>KD</span>
            </td>
        </tr>
            
        <tr class='txt-dark'>
            <td><?php echo direction("Voucher","كود الخصم") ?></td>
            <td><?php echo $order[0]["voucher"] ?>
            </td>
        </tr>

        <tr class="txt-dark">
            <td><?php echo direction("Payment Method","وسيلة الدفع") ?></td>
            <td><?php
                if( $order[0]["paymentMethod"] == 1 ){
                    $paymentMethod = "KNET";
                }elseif( $order[0]["paymentMethod"] == 2 ){
                    $paymentMethod = "VISA";
                }else{
                    $paymentMethod = "Wallet";
                }
                echo $paymentMethod ?>
            </td>
        </tr>
            
        <tr class="txt-dark">
            <td><?php echo direction("Total","المجموع") ?>:</td>
            <td><?php echo numTo3Float($order[0]["total"]); ?>KD</td>
        </tr>

        <?php
            $status = [direction("Pending","إنتظار"),direction("Successful","ناجحه"),direction("Failed","فاشلة"),direction("Cancelled","ملغية"),direction("Ended","إنتهى")];
            for( $y = 0; $y < sizeof($status); $y++ ){
                if( $order[0]["status"] == $y ){
                    $orderStatus = $status[$y];
                }
            }
        ?>
        <tr class="txt-dark">
            <td><?php echo direction("Status","الحالة") ?>:</td>
            <td><?php echo $orderStatus; ?></td>
        </tr>
    </tbody>
</table>
</div>

<div class="clearfix"></div>
</div>
</div>
</div>
</div>
</div>
</div>