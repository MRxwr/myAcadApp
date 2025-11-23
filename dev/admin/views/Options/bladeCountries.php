<?php
if ( isset($_GET['idon']) ){
	updateDB(strtolower($_GET["v"]),array("status"=>"1"),"`countryCode` LIKE '{$_GET['idon']}'");
	header("LOCATION: ?v={$_GET["v"]}");
}elseif ( isset($_GET['idoff']) ){
	updateDB(strtolower($_GET["v"]),array("status"=>"0"),"`countryCode` LIKE '{$_GET['idoff']}'");
	header("LOCATION: ?v={$_GET["v"]}");
}

if( isset($_POST["updateCountryTitle"]) && !empty($_POST["updateCountryTitle"]) ){
	$updateData = array(
		"countryEnTitle" => $_POST["countryEnTitle"],
		"countryArTitle" => $_POST["countryArTitle"]
	);
	updateDB("countries",$updateData,"`countryCode` LIKE '{$_POST["countryCode"]}'");
}
?>
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Country Details","تفاصيل الدولة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">

			<div class="col-md-4">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="countryEnTitle" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="countryArTitle" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Currency","العملة") ?></label>
			<input type="text" name="currencyCode" class="form-control" required>
			</div>
			
			<div class="col-md-12" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="updateCountryTitle" value="0">
			<input type="hidden" name="countryCode" value="0">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>

<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Countiries","قائمة الدول") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body row">
<div class="table-wrap">
<div class="table-responsive">
<table class="table display responsive product-overview mb-30" id="myTable">
	<thead>
	<tr>
	<th>#</th>
	<th><?php echo direction("Country English","البلد بالإنجليزي") ?></th>
	<th><?php echo direction("Country Arabic","البلد بالعربي") ?></th>
	<th><?php echo direction("Currency","العملة") ?></th>
	<th><?php echo direction("Status","الحالة") ?></th>
	<th><?php echo direction("Actions", "الخيارات") ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	$orderBy = direction("countryEnTitle","countryArTitle");
	if( $countries = selectDB("countries","`id` != '0' GROUP BY `countryCode` ORDER BY `{$orderBy}` ASC") ){
		for( $i = 0; $i < sizeof($countries); $i++){
			if ( $countries[$i]["status"] == '0' ){
				$link = "?idon={$countries[$i]["countryCode"]}";
				$button = "btn-success";
				$action = direction("On","تفعيل");
			}else{
				$link = "?idoff={$countries[$i]["countryCode"]}";
				$button = "btn-danger";
				$action = direction("Off","إيقاف");
			}
			?>
			<tr>
			<td class="txt-dark"><?php echo str_pad($i,3,"0",STR_PAD_LEFT) ?></td>
			<td id="enTitle<?php echo $countries[$i]["id"] ?>"><?php echo $countries[$i]["countryEnTitle"]; ?></td>
			<td id="arTitle<?php echo $countries[$i]["id"] ?>"><?php echo $countries[$i]["countryArTitle"]; ?></td>
			<td id="currencyCode<?php echo $countries[$i]["id"] ?>"><?php echo $countries[$i]["currencyCode"]; ?></td>
			<td><?php if ( $countries[$i]["status"] == '1' ){ echo direction("On","تفعيل");}else{ echo direction("Off","إيقاف");} ?></td>
			<td>
				<label style="display:none" id="countryCode<?php echo $countries[$i]["id"] ?>"><?php echo $countries[$i]["countryCode"] ?></label>
				<a id="<?php echo $countries[$i]["id"] ?>" class="btn btn-warning rounded edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل")  ?>"><i class="fa fa-pencil text-inverse m-r-10"></i></a>
				<a href="<?php echo $link . "&v={$_GET["v"]}"; ?>" class="btn <?php echo $button; ?> rounded"><?php echo $action; ?></a>
				<a href="?v=Governates&code=<?php echo $countries[$i]["countryCode"];?>" class="btn btn-info rounded"><?php echo direction("Governates","المحافظات"); ?></a>
				<a href="?v=Areas&code=<?php echo $countries[$i]["countryCode"];?>" class="btn btn-primary rounded"><?php echo direction("Areas","المناطق"); ?></a>
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

<script>
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		var enTitle = $("#enTitle"+id).html();
		var arTitle = $("#arTitle"+id).html();
		var currencyCode = $("#currencyCode"+id).html();
		var governateId = $("#countryCode"+id).html();
		$("input[name=countryEnTitle]").val(enTitle).focus();
		$("input[name=countryCode]").val(governateId);
		$("input[name=updateCountryTitle]").val(id);
		$("input[name=countryArTitle]").val(arTitle);
		$("input[name=currencyCode]").val(currencyCode);
	})
</script>