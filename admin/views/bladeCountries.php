<?php
if ( isset($_GET['idon']) ){
	updateDB(strtolower($_GET["v"]),array("status"=>"1"),"`CountryCode` LIKE '{$_GET['idon']}'");
	header("LOCATION: ?v={$_GET["v"]}");
}elseif ( isset($_GET['idoff']) ){
	updateDB(strtolower($_GET["v"]),array("status"=>"0"),"`CountryCode` LIKE '{$_GET['idoff']}'");
	header("LOCATION: ?v={$_GET["v"]}");
}
?>
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Countiries","قائمة الدول") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body row">
<div class="table-wrap">
<div class="table-responsive">
<table class="table display responsive product-overview mb-30" id="myTable">
	<thead>
	<tr>
	<th>#</th>
	<th><?php echo direction("Country","البلد") ?></th>
	<th><?php echo direction("Status","الحالة") ?></th>
	<th><?php echo direction("Actions", "الخيارات") ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if( $countries = selectDB("countries","`id` != '0' GROUP BY `CountryCode` ORDER BY `CountryName` ASC") ){
		for( $i = 0; $i < sizeof($countries); $i++){
			if ( $countries[$i]["status"] == '0' ){
				$link = "?idon={$countries[$i]["CountryCode"]}";
				$button = "btn-success";
				$action = direction("On","تفعيل");
			}else{
				$link = "?idoff={$countries[$i]["CountryCode"]}";
				$button = "btn-danger";
				$action = direction("Off","إيقاف");
			}
			?>
			<tr>
			<td class="txt-dark"><?php echo str_pad($i,3,"0",STR_PAD_LEFT) ?></td>
			<td><?php echo $countries[$i]["CountryName"]; ?></td>
			<td><?php if ( $countries[$i]["status"] == '1' ){ echo direction("On","تفعيل");}else{ echo direction("Off","إيقاف");} ?></td>
			<td><a href="<?php echo $link . "&v={$_GET["v"]}"; ?>" class="btn <?php echo $button; ?> rounded"><?php echo $action; ?></a>
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