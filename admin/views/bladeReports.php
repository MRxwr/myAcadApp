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
	<select class="form-control" name="academyId">
		<option value="0" selected><?php echo direction("All","الكل") ?></option>
		<?php
			if( $academies = selectDB("academies","`id` != '0' AND `status` = '0'")){
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
	<select class="form-control" name="status">
		<?php
			echo "<option selected value=''>".direction("All","الكل")."</option>";
            $status = [direction("Pending","إنتظار"),direction("Successful","ناجحه"),direction("Failed","فاشلة"),direction("Cancelled","ملغية"),direction("Ended","إنتهى")];
            for( $y = 0; $y < sizeof($status); $y++ ){
				echo "<option value='{$y}'>{$status[$y]}</option>";
            }
        ?>
	</select>
	</div>	
	</div>

	<div class="col-md-4">
	<div class="form-group">
	<label class="control-label mb-10"><?php echo direction("Payment Method","طريقة الدفع") ?></label>
	<select class="form-control" name="paymentMethod">
		<option value="0"><?php echo direction("All","الكل") ?></option>
		<option value="1">KNET</option>
		<option value="2">VISA</option>
		<option value="3">WALLET</option>
	</select>
	</div>	
	</div>

	<div class="col-md-4">
	<div class="form-group">
	<label class="control-label mb-10">Select Voucher</label>
	<select class="form-control" name="voucher">
		<option value="0" selected><?php echo direction("None","لا يوجد") ?></option>
		<?php
			if( $vouchers = selectDB("vouchers","`id` != '0' AND `status` = '0'")){
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
	$where = " `date` BETWEEN '{$_POST["startDate"]}' AND '{$_POST["endDate"]}'";
	if ( !empty($_POST["voucher"]) ){
		$where .= " AND `voucher` LIKE '%{$_POST["voucher"]}%'";
	}
	if ( !empty($_POST["academyId"]) ){
		$where .= " AND `academyId` LIKE '%{$_POST["academyId"]}%'";
	}
	if ( !empty($_POST["paymentMethod"]) ){
		$where .= " AND `paymentMethod` = '{$_POST["paymentMethod"]}'";
	}
	if ( isset($_POST["status"]) && !empty($_POST["status"]) ){
		$where .= " AND `status` = '{$_POST["status"]}'";
	}
}
?>
</div>
</form>
</div>
</div>
</div>
</div>

<?php
if ( isset($_POST["endDate"]) && $orders = selectDB("orders",$where) ){
?>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap">
<div class="table-responsive">
<table id="example" class="table table-hover display  pb-30" >
<thead>
	<tr>
	<th>#</th>
		<th><?php echo direction("Date","التاريخ") ?></th>
		<th><?php echo direction("Name","الإسم") ?></th>
		<th><?php echo direction("Mobile","الهاتف") ?></th>
		<th><?php echo direction("Academy","الأكادميه") ?></th>
		<th><?php echo direction("Voucher","كود الخصم") ?></th>
		<th><?php echo direction("Total","المجموع") ?></th>
		<th><?php echo direction("Payment","الدفع") ?></th>
		<th><?php echo direction("Status","الحالة") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
	</tr>
</thead>
<tbody>
<?php
	for( $i = 0; $i < sizeof($orders); $i++ ){
		$status = [direction("Pending","إنتظار"),direction("Successful","ناجحه"),direction("Failed","فاشلة"),direction("Cancelled","ملغية"),direction("Ended","إنتهى")];
        $statusColor = ["default","success","info","danger","warning"];
		$paymentMethods = ["","KNET","VISA","WALLET"];
		for( $y = 0; $y < sizeof($status); $y++ ){
			if( $orders[$i]["status"] == $y ){
				$orderStatus = $status[$y];
				$orderBtnColor = $statusColor[$y];
			}
		}
		for( $y = 0; $y < sizeof($paymentMethods); $y++ ){
			if( $orders[$i]["paymentMethod"] == $y ){
				$paymentMethod = $paymentMethods[$y];
			}
		}
	?>
	<tr>
	<td><?php echo sprintf("%05d", $orders[$i]["id"]) ?></td>
	<td><?php echo $orders[$i]["date"] ?></td>
	<td><?php echo $orders[$i]["name"] ?></td>
	<td><?php echo $orders[$i]["phone"] ?></td>
	<td><?php echo direction($orders[$i]["enAcademy"],$orders[$i]["arAcademy"]) ?></td>
	<td><?php echo $orders[$i]["voucher"] ?></td>
	<td><?php echo $orders[$i]["total"] ?>KD</td>
	<td><?php echo $paymentMethod ?></td>
	<td><button class="btn btn-<?php echo $orderBtnColor ?>" style="width: 100%;"><?php echo $orderStatus ?></button></td>
	<td class="text-nowrap">
		<a class="btn btn-primary" href="?v=Order&id=<?php echo $orders[$i]["id"] ?>" target="_blank"><?php echo direction("View","عرض") ?></a>
	</td>
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
<?php
}
?>