<?php 
$_GET["type"] = ( isset($_GET["type"]) ) ? $_GET["type"] : 1 ;
?>
<div class="row m-0">
    <div class="col-sm-12">
        <div class="btn-group btn-group-justified">
            <a href="?v=<?php echo $_GET["v"] ?>&type=0" class="btn btn-<?php echo ($_GET["type"] == 0) ? "primary" : "default" ?>"><?php echo direction("Pending", "انتظار") ?></a>
            <a href="?v=<?php echo $_GET["v"] ?>&type=1" class="btn btn-<?php echo ($_GET["type"] == 1) ? "primary" : "default" ?>"><?php echo direction("Partially Paid", "مدفوع جزئيا") ?></a>
            <a href="?v=<?php echo $_GET["v"] ?>&type=2" class="btn btn-<?php echo ($_GET["type"] == 2) ? "primary" : "default" ?>"><?php echo direction("Fully Paid", "مدفوع بالكامل") ?></a>
            <a href="?v=<?php echo $_GET["v"] ?>&type=3" class="btn btn-<?php echo ($_GET["type"] == 3) ? "primary" : "default" ?>"><?php echo direction("Cancelled", "ملغية") ?></a>
            <a href="?v=<?php echo $_GET["v"] ?>&type=4" class="btn btn-<?php echo ($_GET["type"] == 4) ? "primary" : "default" ?>"><?php echo direction("Failed", "فاشلة") ?></a>
        </div>
    </div>
</div>

<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Bookings", "قائمة الحجوزات") ?></h6>
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
		<th><?php echo direction("Booking Date","تاريخ الحجز") ?></th>
		<th><?php echo direction("Time","الوقت") ?></th>
		<th><?php echo direction("Name","الإسم") ?></th>
		<th><?php echo direction("Mobile","الهاتف") ?></th>
		<th><?php echo direction("Field","الملعب") ?></th>
		<th><?php echo direction("Price","السعر") ?></th>
		<th><?php echo direction("Status","الحالة") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
        $fieldIds = "";
        if( isset($_GET["code"]) && !empty($_GET["code"]) ){
            $fieldIds = "AND `fieldId` = '{$_GET["code"]}'";
        }elseif( $userType != 0 && !empty($fieldsList) ){
            $fieldIds = "AND `fieldId` IN (" . implode(",", $fieldsList) . ")";
        }

        if( $bookings = selectDB("fields_booking","`id` != '0' {$fieldIds} AND `status` = '{$_GET["type"]}' ORDER BY `bookingDate` DESC, `startTime` ASC") ){
            for( $i = 0; $i < sizeof($bookings); $i++ ){
                $statusArr = [
                    direction("Pending","إنتظار"),
                    direction("Partially Paid","مدفوع جزئيا"),
                    direction("Fully Paid","مدفوع بالكامل"),
                    direction("Cancelled","ملغية"),
                    direction("Failed","فاشلة")
                ];
                $statusColor = ["default","warning","success","danger","info"];
                
                $orderStatus = isset($statusArr[$bookings[$i]["status"]]) ? $statusArr[$bookings[$i]["status"]] : "Unknown";
                $orderBtnColor = isset($statusColor[$bookings[$i]["status"]]) ? $statusColor[$bookings[$i]["status"]] : "default";

                $field = selectDB("fields_list", "`id` = '{$bookings[$i]["fieldId"]}'");
                $fieldName = ($field) ? direction($field[0]["enTitle"], $field[0]["arTitle"]) : "N/A";
            ?>
                <tr>
                <td><?php echo sprintf("%05d", $bookings[$i]["id"]) ?></td>
                <td><?php echo $bookings[$i]["bookingDate"] ?></td>
                <td><?php echo $bookings[$i]["startTime"] . " - " . $bookings[$i]["endTime"] ?></td>
                <td><?php echo $bookings[$i]["name"] ?></td>
                <td><a href="https://wa.me/<?php echo $bookings[$i]["phone"] ?>" target="_blank"><?php echo $bookings[$i]["phone"] ?></a></td>
                <td><?php echo $fieldName ?></td>
                <td><?php echo $bookings[$i]["total"] ?>KD</td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-<?php echo $orderBtnColor ?> dropdown-toggle" data-toggle="dropdown" aria-hasid="true" aria-expanded="false" style="width:100%">
                            <?php echo $orderStatus ?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <?php
                            for($y=0; $y<count($statusArr); $y++){
                                if($y != $bookings[$i]["status"]){
                                    echo "<li><a href='?v={$_GET["v"]}&delId={$bookings[$i]["id"]}&delStatus={$y}&type={$_GET["type"]}'>{$statusArr[$y]}</a></li>";
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </td>
                <td class="text-nowrap">
                    <a href="?delId=<?php echo $bookings[$i]["id"] . "&v={$_GET["v"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف")  ?>" class="btn btn-danger"><i class="fa fa-close text-inverse"></i></a>
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