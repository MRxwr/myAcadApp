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
	.comparison-container {
        display: flex;
        width: 100%;
    }
    .comparison-column {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        margin: 5px;
    }
    .comparison-column h4 {
        margin-bottom: 15px;
        border-bottom: 1px solid #eee;
        padding-bottom: 5px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .control-label {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }
    .modal-body {
        max-height: 500px;
        overflow-y: auto;
    }
</style>
<?php
$id = "";
$listOfAcademies = "";
$listOfTournaments = "";
if ( $isTournamentUser ){
	$count = (is_array($tournamentsList) && !empty($tournamentsList)) ? count($tournamentsList) : 0;
	for( $z = 0; $z < $count; $z++ ){
		$listOfTournaments .= "'{$tournamentsList[$z]}'";
		if( isset($tournamentsList[$z+1]) && !empty($tournamentsList[$z+1]) ){
			$listOfTournaments .= ",";
		}
	}
	$id .= ( isset($tournamentsList[0]) && !empty($tournamentsList[0]) ) ? "AND `tournamentId` IN ($listOfTournaments)" : "";
}else{
	$count = (is_array($academiesList) && !empty($academiesList)) ? count($academiesList) : 0;
	for( $z = 0; $z < $count; $z++ ){
		$listOfAcademies .= "'{$academiesList[$z]}'";
		if( isset($academiesList[$z+1]) && !empty($academiesList[$z+1]) ){
			$listOfAcademies .= ",";
		}
	}
	$id .= ( isset($academiesList[0]) && !empty($academiesList[0]) ) ? "AND `academyId` IN ($listOfAcademies)" : "";
}
if( isset($_GET["hideModification"]) && !empty($_GET["hideModification"]) ){
	$data = array(
		"hidden" => $_GET["hideModification"],
	);
	updateDB("modifications",$data,"id = '{$_GET["id"]}'");
	?>
	<script>
		window.location.href = "?v=Home";
	</script>
	<?php
}
?>
<div class="row" style="padding:16px">

<?php
$dataJoin = array(
	"select" => ["t.*","t1.fullName"],
	"join" => ["employees"],
	"on" => ["t.empId = t1.id"],
);
if( $modifications = selectJoinDB("modifications",$dataJoin,"t.hidden = '0' AND t1.id = '{$userID}' ORDER BY t.id DESC") ){
?>
<div class="col-sm-12" style="padding-bottom: 20px;">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Updates", "قائمة التحديثات") ?></h6>
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
		<th><?php echo direction("Username","اسم المستخدم") ?></th>
		<th><?php echo direction("Type","النوع") ?></th>
		<th><?php echo direction("Where","من") ?></th>
		<th><?php echo direction("Action","العملية") ?></th>
		</tr>
		</thead>
		<tbody>
		<?php 
			for( $i = 0; $i < sizeof($modifications); $i++ ){
				$type = ( $modifications[$i]["postId"] == "0" ) ? "New" : "Update";
				if( $modifications[$i]["status"] == 0 ){
					$statusText = direction("Pending","إنتظار");
					$statusColor = "default";
					$link = "#";
				}elseif( $modifications[$i]["status"] == 1 ){
					$statusText = direction("Approved","موافقة");
					$statusColor = "success";
					$link = "?v={$_GET["v"]}&id={$modifications[$i]["id"]}&hideModification=1";
				}elseif( $modifications[$i]["status"] == 2 ){
					$statusText = direction("Cancelled","ملغية");
					$statusColor = "danger";
					$link = "?v={$_GET["v"]}&id={$modifications[$i]["id"]}&hideModification=2";
				}
			?>
				<tr>
				<td><?php echo sprintf("%05d", $modifications[$i]["id"]) ?></td>
				<td><?php echo $modifications[$i]["date"] ?></td>
				<td><?php echo $modifications[$i]["fullName"] ?></td>
				<td><?php echo $type ?></td>
				<td><?php echo $modifications[$i]["tableTitle"] ?></td>
				<td>
					<a onclick='showUpdate(<?php echo $modifications[$i]["id"] ?>)' class="btn btn-warning"><?php echo direction("Show","اظهار") ?></a>
					<a href="<?php echo $link ?>" class="btn btn-<?php echo $statusColor ?>"><?php echo $statusText ?></a>
					<div style="display: none;" id="new<?php echo $modifications[$i]["id"]?>">
						<div class="comparison-column old-data">
							<h4><?php echo direction("Previous Data", "البيانات السابقة") ?></h4>
							<?php
							$data = json_decode($modifications[$i]["oldContents"], true);
							ksort($data);unset($data["status"]);unset($data["hidden"]);
							foreach ($data as $key => $value) {
								echo "<div class='form-group'>";
								if (is_array($value)) {
									echo "<label class='control-label'><strong>$key</strong></label>";
									foreach ($value as $item) {
										echo "<input type='text' readonly value='$item' class='form-control'>";
									}
								} else {
									echo "<label class='control-label'><strong>$key</strong></label>";
									if ($key == 'arTerms' || $key == 'enTerms') {
										echo "<div class='form-control' style='height:auto;min-height:34px;'>$value</div>";
									} elseif ($key == 'imageurl' || $key == 'locationImage' || $key == 'header' || $key == 'clothesImage') {
										echo "<img src='../logos/$value' alt='$key' class='img-responsive' style='max-width: 100%; height: auto;'>";
									} else {
										echo "<input type='text' readonly value='$value' class='form-control'>";
									}
								}
								echo "</div>";
							}
							?>
						</div>
						<div class="comparison-column new-data">
							<h4><?php echo direction("New Data", "البيانات الجديدة") ?></h4>
							<?php
							$data = json_decode($modifications[$i]["contents"], true);
							ksort($data);
							foreach ($data as $key => $value) {
								echo "<div class='form-group'>";
								if (is_array($value)) {
									echo "<label class='control-label'><strong>$key</strong></label>";
									foreach ($value as $item) {
										echo "<input type='text' readonly value='$item' class='form-control'>";
									}
								} else {
									echo "<label class='control-label'><strong>$key</strong></label>";
									if ($key == 'arTerms' || $key == 'enTerms') {
										echo "<div class='form-control' style='height:auto;min-height:34px;'>$value</div>";
									} elseif ($key == 'imageurl' || $key == 'locationImage' || $key == 'header' || $key == 'clothesImage') {
										echo "<img src='../logos/$value' alt='$key' class='img-responsive' style='max-width: 100%; height: auto;'>";
									} else {
										echo "<input type='text' readonly value='$value' class='form-control'>";
									}
								}
								echo "</div>";
							}
							?>
						</div>
					</div>
				</td>
				</tr>
			<?php
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
<?php
}
?>

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
					<h6 class="panel-title txt-dark"><?php echo direction("Weekly Subscriptions","إشتراكات الإسبوع") ?></h6>
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
	$sql = "SELECT COALESCE(SUM(f.total), 0) as totalPrice FROM ( SELECT * FROM `orders` WHERE `status` = '1' {$id} {$statsDate[$y]}) as f;";
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
	for( $i=0; $i < 3 ; $i++){
		if ( $i == 0 ){
			if ($call = selectDB("orders","`status` = '1' {$statsDate[$y]} {$id}")){
				$size = sizeof($call);
			}
			$title = direction("Success","ناجحه");
			$icon = "fa fa-money text-success";
		}elseif( $i == 1 ){
			if ($call = selectDB("orders","`status` = '2' {$statsDate[$y]} {$id}")){
				$size = sizeof($call);
			}
			$title = direction("Failed","فاشلة");
			$icon = "fa fa-close text-info";
		}elseif( $i == 2 ){
			if ($call = selectDB("orders","`status` = '3' {$statsDate[$y]} {$id}")){
				$size = sizeof($call);
			}
			$title = direction("Cancelled","ملغية");
			$icon = "fa fa-undo text-danger";
		}elseif( $i == 3 ){
			if ($call = selectDB("orders","`status` = '4' {$statsDate[$y]} {$id}")){
				$size = sizeof($call);
			}
			$title = direction("Ended","إنتهى");
			$icon = "pe-7s-clock text-warning";
		}
	?>
	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
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
			if( $orders = selectDB("orders","`id` != '0' {$id} ORDER BY `date` DESC LIMIT 5") ){
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
if ($call = selectDB("orders","`status` = '1' {$id}")){
	$size1 = sizeof($call);
}else{
	$size1 = 0;
}

$title2 = direction("Failed","فاشلة");
if ($call = selectDB("orders","`status` = '2' {$id}")){
	$size2 = sizeof($call);
}else{
	$size2 = 0;
}

$title3 = direction("Cancelled","ملغية");
if ($call = selectDB("orders","`status` = '3' {$id}")){
	$size3 = sizeof($call);
}else{
	$size3 = 0;
}

$title4 = direction("Ended","إنتهى");
if ($call = selectDB("orders","`status` = '4' {$id}")){
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
		if( $orders = selectDB("orders","`status` = '1' AND `date` LIKE '%{$statsDate[$i]}%' {$id}") ){
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo direction("Comparison", "مقارنة") ?></h4>
      </div>
      <div class="modal-body">
        <table id="modal-example-1" class="table" data-paging="true" data-filtering="true" data-sorting="true"></table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
function showUpdate(id){
    var newContent = document.getElementById("new"+id).innerHTML;
    document.querySelector(".modal-body").innerHTML = '<div class="row comparison-container">' + newContent + '</div>';
    $('#myModal').modal('show');
}
</script>