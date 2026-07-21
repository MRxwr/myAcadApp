<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Trainer Details","تفاصيل المدرب") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			
			<div class="col-md-6">
			<label><?php echo direction("English Name","الإسم بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Arabic Name","الإسم بالعربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("English Details","التفاصيل بالإنجليزي") ?></label>
			<input type="text" name="enDetails" class="form-control" required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("Arabic Details","التفاصيل بالعربي") ?></label>
			<input type="text" name="arDetails" class="form-control" required>
			</div>

            <div class="col-md-12">
			<label><?php echo direction("Trainer Image","صورة المدرب") ?></label>
			<input type="file" name="trainerImage" class="form-control" >
			</div>

            <div id="images" style="margin-top: 10px; display:none">
				<div class="col-md-12"><img id="logoImg" src="" style="width:250px;height:250px"></div>
			</div>
			
			<div class="col-md-12" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="0">
			<input type="hidden" name="academyId" value="<?php echo $_GET["code"] ?>">
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Trainers","قائمة المدربين") ?></h6>
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
		<th>#</th>
		<th><?php echo direction("English Name","الإسم بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Name","الإسم بالعربي") ?></th>
		<th><?php echo direction("English Details","التفاصيل بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Details","التفاصيل بالعربي") ?></th>
		<th><?php echo direction("Logo","الشعار") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		$orderBy = direction("enTitle","arTitle");
		if( $trainers = selectDB("trainers","`status` = '0' AND `academyId` LIKE '{$_GET["code"]}' ORDER BY `{$orderBy}` ASC") ){
			for( $i = 0; $i < sizeof($trainers); $i++ ){
				if ( $trainers[$i]["hidden"] == 1 ){
					$icon = "fa fa-eye";
					$link = "?show={$trainers[$i]["id"]}";
					$hide = direction("Show","أظهر");
				}else{
					$icon = "fa fa-eye-slash";
					$link = "?hide={$trainers[$i]["id"]}";
					$hide = direction("Hide","إخفاء");
				}
				?>
				<tr>
				<td><?php echo $counter = $i + 1 ?></td>
				<td id="enTitle<?php echo $trainers[$i]["id"]?>" ><?php echo $trainers[$i]["enTitle"] ?></td>
				<td id="arTitle<?php echo $trainers[$i]["id"]?>" ><?php echo $trainers[$i]["arTitle"] ?></td>
				<td id="enDetails<?php echo $trainers[$i]["id"]?>" ><?php echo $trainers[$i]["enDetails"] ?></td>
				<td id="arDetails<?php echo $trainers[$i]["id"]?>" ><?php echo $trainers[$i]["arDetails"] ?></td>
				<td><label id="trainerImage<?php echo $trainers[$i]["id"]?>" style="display:none"><?php echo $trainers[$i]["trainerImage"] ?></label><img src="../logos/trainers/<?php echo $trainers[$i]["trainerImage"] ?>" style="width:50px;height:50px"></td>
				<td class="text-nowrap">
					<a id="<?php echo $trainers[$i]["id"] ?>" class="edit btn btn-warning" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
					</a>
					<a href="<?php echo $link . "&v={$_GET["v"]}&code={$_GET["code"]}" ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i></a>			
					<a href="<?php echo "?delId={$trainers[$i]["id"]}&v={$_GET["v"]}&code={$_GET["code"]}" ?>" class="btn btn-danger" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"> <i class="fa fa-times text-inverse m-r-10"></i></a>			
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
            $("input[name=update]").val(id);
            $("input[name=enTitle]").val($("#enTitle"+id).html()).focus();
			$("input[name=arTitle]").val($("#arTitle"+id).html());
			$("input[name=enDetails]").val($("#enDetails"+id).html());
			$("input[name=arDetails]").val($("#arDetails"+id).html());
            $("#images").show();
            $("#logoImg").attr("src","../logos/trainers/"+$("#trainerImage"+id).html());
		})
	</script>