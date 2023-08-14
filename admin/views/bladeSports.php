<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Sport Details","تفاصيل الرياضة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			
			<div class="col-md-6">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Logo","الشعار") ?></label>
			<input type="file" name="imageurl" class="form-control" required>
			</div>
			
			<div id="images" style="margin-top: 10px; display:none">
				<div class="col-md-6">
				<img id="logoImg" src="" style="width:250px;height:250px">
				</div>
			</div>
			
			<div class="col-md-6" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="0">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
				
				<!-- Bordered Table -->
<form method="post" action="">
<input name="updateRank" type="hidden" value="1">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Sports", "قائمة الرياضات") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<button class="btn btn-primary">
<?php echo direction("Submit rank","أرسل الترتيب") ?>
</button>  
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th>#</th>
		<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $sports = selectDB("sports","`status` = '0' ORDER BY `order` ASC") ){
		for( $i = 0; $i < sizeof($sports); $i++ ){
		$counter = $i + 1;
		if ( $sports[$i]["hidden"] == 1 ){
		$icon = "fa fa-eye";
		$link = "?show={$sports[$i]["id"]}";
		$hide = direction("Show","أظهر");
		}else{
		$icon = "fa fa-eye-slash";
		$link = "?hide={$sports[$i]["id"]}";
		$hide = direction("Hide","إخفاء");
		}
		?>
		<tr>
		<td>
		<input name="order[]" class="form-control" type="number" value="<?php echo $sports[$i]["order"] ?>">
		<input name="id[]" class="form-control" type="hidden" value="<?php echo $sports[$i]["id"] ?>">
		</td>
		<td id="enTitle<?php echo $sports[$i]["id"]?>" ><?php echo $sports[$i]["enTitle"] ?></td>
		<td id="arTitle<?php echo $sports[$i]["id"]?>" ><?php echo $sports[$i]["arTitle"] ?></td>
		<td class="text-nowrap">
		
		<a id="<?php echo $sports[$i]["id"] ?>" class="edit btn btn-warning" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل")  ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo $link . "&v={$_GET["v"]}" ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
		</a>
		<a href="?delId=<?php echo $sports[$i]["id"] . "&v={$_GET["v"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف")  ?>" class="btn btn-danger"><i class="fa fa-close text-inverse"></i>
		</a>
		<div style="display:none"><label id="hidden<?php echo $sports[$i]["id"]?>"><?php echo $sports[$i]["hidden"] ?></label></div>
		<div style="display:none"><label id="logo<?php echo $sports[$i]["id"]?>"><?php echo $sports[$i]["imageurl"] ?></label></div>		
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
</form>
	
	<script>
		$(document).on("click",".edit", function(){
			var id = $(this).attr("id");
			var arTitle = $("#arTitle"+id).html();
			var enTitle = $("#enTitle"+id).html();
			var hidden = $("#hidden"+id).html();
			var logo = $("#logo"+id).html();
			$("input[type=file]").prop("required",false);
			$("input[name=arTitle]").val(arTitle).focus();
			$("input[name=update]").val(id);
			$("input[name=enTitle]").val(enTitle);
			$("#logoImg").attr("src","../logos/"+logo);
			$("#images").attr("style","margin-top:10px;display:block");
		})
	</script>