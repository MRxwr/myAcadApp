<?php
if( $country = selectDB("countries","`countryCode` LIKE '{$_GET["code"]}' LIMIT 1") ){
	
}else{
	$country = array();
}
if( isset($_GET["delIdArea"]) && !empty($_GET["delIdArea"]) && updateDB("countries",array('status'=> '0'),"`id` = '{$_GET["delIdArea"]}'") ){

}
?>
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Area Details","تفاصيل المنطقة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			
			<div class="col-md-4">
			<label><?php echo direction("Governate","المحافظة") ?></label>
			<select name="governateId" class="form-control" required>
				<?php
				if( $governates = selectDB("governates","`countryCode` LIKE '{$_GET["code"]}' AND `status` = '0'") ){
					for( $i = 0; $i < sizeof($governates); $i++ ){
						$title = direction($governates[$i]["enTitle"],$governates[$i]["arTitle"]);
						echo "<option value='{$governates[$i]["id"]}'>{$title}</option>";
					}
				}
				?>
			</select>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="areaEnTitle" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="areaArTitle" class="form-control" required>
			</div>
			
			<div class="col-md-12" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="0">
			<input type="hidden" name="countryCode" value="<?php echo $country[0]["countryCode"] ?>">
			<input type="hidden" name="countryEnTitle" value="<?php echo $country[0]["countryEnTitle"] ?>">
			<input type="hidden" name="countryArTitle" value="<?php echo $country[0]["countryArTitle"] ?>">
			<input type="hidden" name="areaCode" value="<?php echo $country[0]["areaCode"] ?>">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
				
				<!-- Bordered Table -->
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Areas","قائمة المناظق") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
		<th><?php echo direction("Governate","المحافظة") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		$orderBy = direction("areaEnTitle","areaArTitle");
		if( $areas = selectDB("countries","`status` = '1' AND `countryCode` LIKE '{$_GET["code"]}' ORDER BY `{$orderBy}` ASC") ){
			for( $i = 0; $i < sizeof($areas); $i++ ){
				if( $governate = selectDB("governates","`id` = '{$areas[$i]["governateId"]}'") ){
					$governateTitle = direction($governate[0]["enTitle"],$governate[0]["arTitle"]);
				}else{
					$governateTitle = "";
				}
				if ( $areas[$i]["hidden"] == 1 ){
					$icon = "fa fa-eye";
					$link = "?show={$areas[$i]["id"]}";
					$hide = direction("Show","أظهر");
				}else{
					$icon = "fa fa-eye-slash";
					$link = "?hide={$areas[$i]["id"]}";
					$hide = direction("Hide","إخفاء");
				}
				?>
				<tr>
				<td id="enTitle<?php echo $areas[$i]["id"]?>" ><?php echo $areas[$i]["areaEnTitle"] ?></td>
				<td id="arTitle<?php echo $areas[$i]["id"]?>" ><?php echo $areas[$i]["areaArTitle"] ?></td>
				<td><?php echo $governateTitle ?><label id="governateId<?php echo $areas[$i]["id"]?>" style="display:none"><?php echo $areas[$i]["governateId"] ?></label></td>
				<td class="text-nowrap">
					<a id="<?php echo $areas[$i]["id"] ?>" class="edit btn btn-warning" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
					</a>
					<a href="<?php echo $link . "&v={$_GET["v"]}&code={$_GET["code"]}" ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i></a>
					<a href="?delIdArea=<?php echo $areas[$i]["id"] . "&v={$_GET["v"]}&code={$_GET["code"]}"  ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف")  ?>" class="btn btn-danger"><i class="fa fa-close text-inverse"></i>
					</a>		
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
	<!-- JavaScript -->
	
	<script>
		$(document).on("click",".edit", function(){
			var id = $(this).attr("id");
			var enTitle = $("#enTitle"+id).html();
			var arTitle = $("#arTitle"+id).html();
			var governateId = $("#governateId"+id).html();
			$("input[name=areaEnTitle]").val(enTitle);
			$("select[name=governateId]").val(governateId);
			$("input[name=update]").val(id);
			$("input[name=areaArTitle]").val(arTitle);
			$("input[name=areaEnTitle]").focus()
		})
	</script>