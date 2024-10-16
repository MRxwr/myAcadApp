<?php
$id = "";
$listOfAcademies = "";
$count = (is_array($academiesList) && !empty($academiesList)) ? count($academiesList) : 0;
for( $z = 0; $z < $count; $z++ ){
	$listOfAcademies .= "'{$academiesList[$z]}'";
	if( isset($academiesList[$z+1]) && !empty($academiesList[$z+1]) ){
		$listOfAcademies .= ",";
	}
}
$id .= ( isset($academiesList[0]) && !empty($academiesList[0]) ) ? "AND `academyId` IN ($listOfAcademies)" : "";
if( $order = selectDB("orders","`id` = '{$_GET["id"]}' {$id}") ){
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
<div class="row" id="takeMeToPrint">
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
        <?php 
        if( $order[0]["isTournament"] == 0 ){
            ?> 
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
        <?php
        }else{
            $tournament = selectDB("tournaments","`id` = '{$order[0]["tournamentId"]}'");
            $teamData = json_decode($order[0]["teamDetails"],true);
            ?>
            <tr>
                <td class='txt-dark' style='white-space: break-spaces;'>
                    <?php echo "1x" . direction($tournament[0]["enTitle"],$tournament[0]["arTitle"]) . " / {$teamData["teamName"]}<br>" ?>
                    <?php
                    echo "Players: <br>";
                    for( $i = 0; $i < sizeof($teamData["players"]); $i++ ){
                        echo "- " . $teamData["players"][$i] . "<br>";
                    }
                    echo "Bench: <br>";
                    for( $i = 0; $i < sizeof($teamData["bench"]); $i++ ){
                        echo "- " . $teamData["bench"][$i] . "<br>";
                    }
                    ?>
                </td>
                <td>
                    <span class='Price txt-dark'><?php echo numTo3Float($order[0]["total"]) ?>KD</span>
                </td>
            </tr>
            <?php
        }
        ?> 
        <tr class='txt-dark'>
            <td><?php echo direction("Voucher","كود الخصم") ?></td>
            <td><?php echo $order[0]["voucher"] ?>
            </td>
        </tr>

        <tr class="txt-dark">
            <td><?php echo direction("Payment Method","وسيلة الدفع") ?></td>
            <td><?php
                if( $order[0]["paymentMethod"] == 1 ){
                    $paymentMethod = "ONLINE PAYMENT";
                }elseif( $order[0]["paymentMethod"] == 3 ){
                    $paymentMethod = "WALLET";
                }else{
                    $paymentMethod = "FREE";
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

<div class="row">
    <div class="col-4"><button id="print" class="btn btn-primary btn-rounded btn-block"><i class="fa fa-print"></i> <?php echo direction("Print","طباعة") ?></button></div></div>
</div>

<script>
    $(document).ready(function() {
        $('#print').click(function() {
            //get takeMeToPrint data and print it directly
            var printContents = document.getElementById('takeMeToPrint').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        });
    });
</script>