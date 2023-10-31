<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Report Details","تفاصيل التقرير") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="form-wrap mt-10">
<form action="" method="POST">
<div class="row">

	<div class="col-md-4">
	<div class="form-group">
	<label class="control-label mb-10 text-left">Start Date</label>
	<input type="date" name="startDate" class="form-control" required >
	</div>
	</div>		
	
	<div class="col-md-4">
	<div class="form-group">
	<label class="control-label mb-10 text-left">End Date</label>
	<input type="date" name="endDate" class="form-control" required >
	</div>
	</div>	

	<div class="col-md-4">
	<div class="form-group">
	<label class="control-label mb-10">Select Academy</label>
	<select class="form-control" name="academyId" required>
		<option value="0" selected><?php echo direction("All","الكل") ?></option>
		<?php
			if( $academies = selectDB("academies","`id` != '0'")){
				for( $i = 0; $i < sizeof($academies); $i++ ){
					echo "<option value='{$academies[$i]["id"]}'>".direction($academies[$i]["enTitle"],$academies[$i]["arTitle"])."</option>";
				}
			}
		?>
	</select>
	</div>	
	</div>

	<div class="col-md-4">
	<div class="form-group">
	<label class="control-label mb-10"><?php echo direction("Status","الحالة") ?></label>
	<select class="form-control" name="status" required>
		<?php
            $status = [direction("Pending","إنتظار"),direction("Successful","ناجحه"),direction("Failed","فاشلة"),direction("Cancelled","ملغية"),direction("Ended","إنتهى")];
            for( $y = 0; $y < sizeof($status); $y++ ){
				$selected = ( $y == 1 ) ? "selected" : "" ;
				echo "<option value='{$y}' {$selected}>{$status[$y]}</option>";
            }
        ?>
	</select>
	</div>	
	</div>

	<div class="col-md-4">
	<div class="form-group">
	<label class="control-label mb-10"><?php echo direction("Payment Method","طريقة الدفع") ?></label>
	<select class="form-control" name="paymentMethod" required>
		<option value="0"><?php echo direction("All","الكل") ?></option>
		<option value="1">K-NET</option>
		<option value="2">Visa/Master</option>
		<option value="3">Wallet</option>
	</select>
	</div>	
	</div>

	<div class="col-md-4">
	<div class="form-group">
	<label class="control-label mb-10">Select Voucher</label>
	<select class="form-control" name="voucher" required>
		<option value="0" selected><?php echo direction("None","لا يوجد") ?></option>
		<?php
			if( $vouchers = selectDB("vouchers","`id` != '0'")){
				for( $i = 0; $i < sizeof($vouchers); $i++ ){
					echo "<option value='{$vouchers[$i]["code"]}'>{$vouchers[$i]["code"]}</option>";
				}
			}
		?>
	</select>
	</div>	
	</div>
	
	<div class="col-md-12">
	<div class="form-group">
	<button class="btn  btn-success">Submit</button>
	</div>
	</div>
<?php
if ( isset($_POST["endDate"]) ){
	$where = " 
			`date` BETWEEN '{$_POST["startDate"]}' AND '{$_POST["endDate"]}'
			";
			if ( !empty($_POST["voucher"]) ){
				$where .= " AND JSON_UNQUOTE(JSON_EXTRACT(voucher,'$.id')) LIKE '%{$_POST["voucher"]}%'";
			}
			if ( !empty($_POST["productId"]) ){
				$where .= " AND JSON_UNQUOTE(JSON_EXTRACT(items,'$[*].productId')) LIKE '%{$_POST["productId"]}%'";
			}
			if ( !empty($_POST["size"]) ){
				$where .= " AND JSON_UNQUOTE(JSON_EXTRACT(items,'$[*].subId')) LIKE '%{$_POST["size"]}%'";
			}
			if ( !empty($_POST["pMethod"]) ){
				$where .= " AND `paymentMethod` = '{$_POST["pMethod"]}'";
			}
			if ( $_POST["status"] != "" ){
				$where .= " AND `status` = '{$_POST["status"]}'";
			}
	if( $orderIds = selectDB("orders2",$where . " GROUP BY `orderId`") ){
	}else{
		$orderIds = array();
	}
	$orderIds = array_filter($orderIds);
}
?>
</div>
</form>
</div>
</div>
</div>
</div>

<?php
if ( !empty($orderIds) ){
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap">
<div class="table-responsive">
<table id="example" class="table table-hover display  pb-30" >
<thead>
	<tr>
		<th><?php echo $DateTime ?></th>
		<th><?php echo $OrderID ?></th>
		<th><?php echo $Mobile ?></th>
		<th><?php echo $Voucher ?></th>
		<th><?php echo $Discount ?></th>
		<th><?php echo $deliveryText ?></th>
		<th><?php echo $paymentMethodText ?></th>
		<th><?php echo direction("Profit","الأرباح") ?></th>
		<th><?php echo $Cost ?></th>
		<th><?php echo $Price ?></th>
		<th><?php echo direction("Status","الحاله") ?></th>
	</tr>
</thead>
<tbody>
<?php
$totalKwInvoices = 0;
$totalIntInvoices = 0;
	for( $i = 0; $i < sizeof($orderIds); $i++ ){
		$info = json_decode($orderIds[$i]["info"],true);
		$voucher = json_decode($orderIds[$i]["voucher"],true);
		$address = json_decode($orderIds[$i]["address"],true);
		$items = json_decode($orderIds[$i]["items"],true);
		for( $y = 0; $y < sizeof($items); $y++ ){
			$item = selectDB("attributes_products","`id` = '{$items[$y]["subId"]}'");
			$cost[] = (isset($item[0]["cost"]) && $item[0]["cost"] != 0) ? $item[0]["cost"]*$items[$y]["quantity"] : 0;
		}
		$profit = $orderIds[$i]["price"] - array_sum($cost);
		$totalPrice[] = $orderIds[$i]["price"];
		$totalCost[] = array_sum($cost);
		$totalProfit[] = $profit;
		if( $address["country"] == "KW" ){
			$totalDelivery[] = $address["shipping"];
			$totalShipping[] = 0;
			$totalKwInvoices++;
		}else{
			$totalDelivery[] = 0;
			$totalShipping[] = $address["shipping"];
			$totalIntInvoices++;
		}
		$statusText = [direction("Pending","انتظار"),direction("Success","ناجح"),direction("Preparing","جاري التجهيز"), direction("On Delivery","جاري التوصيل"), direction("Delivered","تم تسليمها"), direction("Failed","فاشلة"),direction("Returned","مسترجعه")];
	?>
	<tr>
		<td><?php echo $orderIds[$i]["date"] ?></td>
		<td class="txt-dark"><a href="product-orders.php?info=view&orderId=<?php echo $orderIds[$i]["orderId"] ?>" target="_blank"><?php echo $orderIds[$i]["orderId"] ?></a></td>
		<td class="txt-dark"><?php echo $info["phone"] ?></td>
		<td><?php echo $voucher["voucher"] ?></td>
		<td><?php echo $voucher["percentage"] ?>%</td>
		<td><?php echo $address["shipping"] ?>KD</td>
		<td><?php
		if( $paymentMethod = selectDB("p_methods","`paymentId` = '{$orderIds[$i]["paymentMethod"]}'") ){
			echo $method = direction($paymentMethod[0]["enTitle"],$paymentMethod[0]["arTitle"]);
		}else{
			echo $method = "";
		}
		?></td>
		<td><?php echo numTo3Float($profit) ?>KD</td>
		<td><?php echo numTo3Float(array_sum($cost)) ?>KD</td>
		<td><?php echo numTo3Float($orderIds[$i]["price"]) ?>KD</td>
		<td><?php echo $statusText[$orderIds[$i]["status"]] ?></td>
	</tr>
	<?php
		unset($cost);
	}
?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>	
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap">
<div class="table-responsive">
<button class="btn btn-primary printMeNow">Print</button>
<div class="printable">
<table class="table table-hover display pb-30" >
<thead>
	<tr>
		<th><?php echo "Earned" ?></th>
		<th><?php echo "Delivery" ?></th>
		<th><?php echo "Shipping" ?></th>
		<th><?php echo "Cost" ?></th>
		<th><?php echo "Profit" ?></th>
		<th><?php echo "Kuwait Bills" ?></th>
		<th><?php echo "International Bills" ?></th>
	</tr>
</thead>
<tbody>
	<tr>
		<td><?php echo numTo3Float(array_sum($totalPrice)+array_sum($totalShipping)+array_sum($totalDelivery)) ?>KD</td>
		<td><?php echo numTo3Float(array_sum($totalDelivery)) ?>KD</td>
		<td><?php echo numTo3Float(array_sum($totalShipping)) ?>KD</td>
		<td><?php echo numTo3Float(array_sum($totalCost)) ?>KD</td>
		<td><?php echo numTo3Float(array_sum($totalProfit)) ?>KD</td>
		<td><?php echo $totalKwInvoices ?></td>
		<td><?php echo $totalIntInvoices ?></td>
	</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>	
</div>
</div>
<?php
}
?>