<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Invoices", "قائمة الفواتير") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap">
<div class="table-responsive">

	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th>#</th>
		<th><?php echo direction("Date","التاريخ") ?></th>
		<th><?php echo direction("Name","الإسم") ?></th>
		<th><?php echo direction("Mobile","الهاتف") ?></th>
		<th><?php echo direction("Academy","الأكادميه") ?></th>
		<th><?php echo direction("Total","المجموع") ?></th>
		<th><?php echo direction("Status","الحالة") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $orders = selectDB("orders","`id` != '0' ORDER BY `date` DESC") ){
            for( $i = 0; $i < sizeof($orders); $i++ ){
                $status = [direction("Pending","إنتظار"),direction("Successful","ناجحه"),direction("Failed","فاشلة"),direction("Cancelled","ملغية"),direction("Ended","إنتهى")];
                $statusColor = ["default","success","info","danger","warning"];
                for( $y = 0; $y < sizeof($status); $y++ ){
                    if( $orders[$i]["status"] == $y ){
                        $orderStatus = $status[$y];
                        $orderBtnColor = $statusColor[$y];
                    }
                }
            ?>
                <tr>
                <td><?php echo sprintf("%05d", $orders[$i]["id"]) ?></td>
                <td><?php echo $orders[$i]["date"] ?></td>
                <td><?php echo $orders[$i]["name"] ?></td>
                <td><?php echo $orders[$i]["phone"] ?></td>
                <td><?php echo direction($orders[$i]["enAcademy"],$orders[$i]["arAcademy"]) ?></td>
                <td><?php echo $orders[$i]["total"] ?>KD</td>
                <td><button class="btn btn-<?php echo $orderBtnColor ?>" style="width: 100%;"><?php echo $orderStatus ?></button></td>
                <td class="text-nowrap">
                    <a class="btn btn-primary" href="?v=Order&id=<?php echo $orders[$i]["id"] ?>" target="_blank"><?php echo direction("View","عرض") ?></a>
                </td>
                </tr>
            <?php
            }
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