<style>
.centered {
    position: absolute;
    top: 13px;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    background-color: #135fad;
}
.centered1 {
    position: absolute;
    top: 13px;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    background-color: #2853a8;
}
.centered2 {
    position: absolute;
    top: 131px;
    left: 52%;
    min-height: 25px;
    transform: translate(-50%, -50%);
    color: black;
    background-color: #ffffff;
}
@media only screen and (max-width: 600px) {
	.centered2 {
		position: absolute;
		top: 118px;
		left: 52%;
		min-height: 25px;
		transform: translate(0%, 0%);
		color: black;
		background-color: #ffffff;
	}
}
.tabHead{
	padding: 15px;
    color: black;
    font-weight: 700;
    font-size: 16px;
	width: 100%;
    background-color: #f2f2f2;
}
.card-view.panel .panel-body {
    padding: 0px 0 0px;
}
.card-view{
	padding: 0px 15px 0;
}
.statsHeading{
	background-color: #f2f2f2;
	font-size:22px;
	font-weight:700;
	border-radius: 10px;
    margin-bottom: 10px;
}
</style>
<div class="row" style="padding:16px">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Subscriptions","الإشتراكات") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<canvas id="chart_6" height="350"></canvas>
				</div>
			</div>
		</div>	
	</div>

	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("ًWeekley Subscriptions","إشتراكات الإسبوع") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div id="morris_bar_chart" class="morris-chart"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center statsHeading"><?php echo direction("Earnings","الإيرادات") ?></div>
<?php 

for ( $y =0; $y < 3; $y++){
	$statsDate = [
	"AND `date` LIKE '%".date("Y-m-d")."%'",
	"AND (`date` BETWEEN '".date("Y-m-d",mktime(0, 0, 0, date("m")-1, date("d"), date("Y")))."' AND '".date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+1, date("Y")))."')",
	""
	];
	$statTitle = [direction("Daily","يومية"),direction("Monthly","شهرية"),direction("All time Stats","أحصائيات الكل")];

	$size = 0;
	$sql = "SELECT SUM(f.total) as totalPrice FROM ( SELECT * FROM `orders` WHERE `status` = '1' {$statsDate[$y]}) as f;";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();

	$size = $row["totalPrice"] == '' ?  numTo3Float(0) : numTo3Float($row["totalPrice"]);
	$title = $statTitle[$y];
	$icon = "fa fa-money text-success";
	?>
	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
	<div class="panel panel-default card-view pa-0">
	<div class="panel-wrapper collapse in">
	<div class="panel-body pa-0">
	<div class="sm-data-box">
	<div class="container-fluid">
	<div class="row">
	<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
																				
		<span class="txt-dark block counter"><span class="counter-anim"><?php echo $size ?>KD</span></span>
		<span class="weight-500 uppercase-font block"><?php echo strtoupper($title) ?></span>
													
	</div>
	<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-right">
	<i class="<?php echo $icon ?> data-right-rep-icon "></i>
	</div>
	</div>	
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	<?php
	$size = 0;
}

?>	

<?php 
for ( $y = 1; $y < 2; $y++){
	$statsDate = ["AND `date` LIKE '%".date("Y-m-d")."%'","AND `date` BETWEEN '".date("Y-m-d",mktime(0, 0, 0, date("m")-1, date("d"), date("Y")))."' AND '".date("Y-m-d")."'",""];
	$statTitle = [direction("Daily Stats","أحصائيات يومية"),direction("Monthly Stats","أحصائيات شهرية"),direction("All time Stats","أحصائيات الكل")];
?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center statsHeading"><?php echo $statTitle[$y] ?></div>
	<?php
	$size = 0;
	for( $i=0; $i < 4 ; $i++){
		if ( $i == 0 ){
			if ($call = selectDB("orders","`status` = '1' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$title = direction("Success","ناجحه");
			$icon = "fa fa-money text-success";
		}elseif( $i == 1 ){
			if ($call = selectDB("orders","`status` = '2' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$title = direction("Failed","فاشلة");
			$icon = "fa fa-close text-info";
		}elseif( $i == 2 ){
			if ($call = selectDB("orders","`status` = '3' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$title = direction("Cancelled","ملغية");
			$icon = "fa fa-undo text-danger";
		}elseif( $i == 3 ){
			if ($call = selectDB("orders","`status` = '4' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$title = direction("Ended","إنتهى");
			$icon = "pe-7s-clock text-warning";
		}
	?>
	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
	<div class="panel panel-default card-view pa-0">
	<div class="panel-wrapper collapse in">
	<div class="panel-body pa-0">
	<div class="sm-data-box">
	<div class="container-fluid">
	<div class="row">
	<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
																				
		<span class="txt-dark block counter"><span class="counter-anim"><?php echo $size ?></span></span>
		<span class="weight-500 uppercase-font block"><?php echo strtoupper($title) ?></span>
													
	</div>
	<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-right">
	<i class="<?php echo $icon ?> data-right-rep-icon "></i>
	</div>
	</div>	
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	<?php
		$size = 0;
	}
}
?>		
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default card-view">
		<div class="panel-wrapper collapse in">
		<div class="panel-body row">
		<div class="table-wrap">
		<div class="table-responsive">
		<table id="myTable" class="table table-hover display  pb-30" >
		<label class="tabHead"><?php echo direction("Latest Subscriptions","أخر إشتراكات") ?>
		</label>
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
			if( $orders = selectDB("orders","`id` != '0' ORDER BY `date` DESC LIMIT 5") ){
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
				<td><a target="_blank" href="?v=Order&id=<?php echo $orders[$i]["id"] ?>">Details</a></td>
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
</div>

<?php 
$title1 = direction("Success","ناجحه");
if ($call = selectDB("orders","`status` = '1'")){
	$size1 = sizeof($call);
}else{
	$size1 = 0;
}

$title2 = direction("Failed","فاشلة");
if ($call = selectDB("orders","`status` = '2'")){
	$size2 = sizeof($call);
}else{
	$size2 = 0;
}

$title3 = direction("Cancelled","ملغية");
if ($call = selectDB("orders","`status` = '3'")){
	$size3 = sizeof($call);
}else{
	$size3 = 0;
}

$title4 = direction("Ended","إنتهى");
if ($call = selectDB("orders","`status` = '4'")){
	$size4 = sizeof($call);
}else{
	$size4 = 0;
}

$statsDate = [
	date("Y-m-d"),
	date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")-1, date("Y"))),
	date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")-2, date("Y"))),
	date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")-3, date("Y"))),
	date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")-4, date("Y"))),
	date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")-5, date("Y"))),
	date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")-6, date("Y"))),
];
?>
<div style="display:none">
	<input id="success" value="<?php echo $size1 ?>">
	<input id="successText" value="<?php echo $title1 ?>">
	<input id="failed" value="<?php echo $size2 ?>">
	<input id="failedText" value="<?php echo $title2 ?>">
	<input id="cancelled" value="<?php echo $size3 ?>">
	<input id="cancelledText" value="<?php echo $title3 ?>">
	<input id="ended" value="<?php echo $size4 ?>">
	<input id="endedText" value="<?php echo $title4 ?>">
	<?php
	for( $i = 0; $i < sizeof($statsDate); $i++){
		if( $orders = selectDB("orders","`status` = '1' AND `date` LIKE '%{$statsDate[$i]}%'") ){
			$ordersDate = $statsDate[$i];
			$ordersTotal = sizeof($orders);
		}else{
			$ordersDate = $statsDate[$i];
			$ordersTotal = 0;
		}
		echo "<input id='day{$i}' value='{$ordersTotal}'><input id='day{$i}Text' value='{$ordersDate}'>";
	}
	?>
</div>