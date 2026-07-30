<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Banner Details","تفاصيل البنر") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("Title","العنوان") ?></label>
			<input type="text" name="title" class="form-control" required>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Type","النوع") ?></label>
			<select name="type" class="form-control" required>
				<option value="0"><?php echo direction("Photo","صورة") ?></option>
				<option value="1"><?php echo direction("Video","فيديو") ?></option>
			</select>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Link","رابط") ?></label>
			<input type="text" name="link" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Hide Banner","أخفي البنر") ?></label>
			<select name="hidden" class="form-control">
				<option value="0">No</option>
				<option value="1">Yes</option>
			</select>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Banner","البنر") ?> 400x400</label>
			<input type="file" name="imageurl" class="form-control" required>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Banner","البنر") ?> 600x300</label>
			<input type="file" name="imageurl600" class="form-control" required>
			</div>
			
			<div id="images" style="margin-top: 10px; display:none">
				<div class="col-md-6">
				<img id="logoImg" src="" style="width:250px;height:250px">
				</div>
				<div class="col-md-6">
				<img id="logo600Img" src="" style="width:250px;height:250px">
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Banners","قائمة البنرات") ?></h6>
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
		<th><?php echo direction("Title","العنوان") ?></th>
		<th><?php echo direction("Type","النوع") ?></th>
		<th><?php echo direction("Link","الرابط") ?></th>
		<th><?php echo direction("Banner","الصورة") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $banners = selectDB("banners","`status` = '0' ORDER BY `order` ASC") ){
		for( $i = 0; $i < sizeof($banners); $i++ ){
		$counter = $i + 1;
		$typeText = ( empty($banners[$i]["type"]) ) ? direction("Photo","صورة") : direction("Video","فيديو") ;
		if ( $banners[$i]["hidden"] == 1 ){
			$icon = "fa fa-eye";
			$link = "?show={$banners[$i]["id"]}";
			$hide = direction("Show","أظهر");
		}else{
			$icon = "fa fa-eye-slash";
			$link = "?hide={$banners[$i]["id"]}";
			$hide = direction("Hide","إخفاء");
		}
		?>
		<tr>
		<td>
		<input name="order[]" class="form-control" type="number" value="<?php echo $counter ?>">
		<input name="id[]" class="form-control" type="hidden" value="<?php echo $banners[$i]["id"] ?>">
		</td>
		<td id="title<?php echo $banners[$i]["id"]?>" ><?php echo $banners[$i]["title"] ?></td>
		<td><?php echo $typeText ?><label id="type<?php echo $banners[$i]["id"]?>" style="display:none"><?php echo $banners[$i]["type"] ?></label></td>
		<td id="link<?php echo $banners[$i]["id"]?>" ><?php echo $banners[$i]["link"] ?></td>
		<td><img src="../logos/<?php echo $banners[$i]["imageurl"] ?>" style="width:150px"></td>
		<td class="text-nowrap">
		
		<a id="<?php echo $banners[$i]["id"] ?>" class="edit btn btn-warning" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل")  ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo $link . "&v={$_GET["v"]}" ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
		</a>
		<a href="?delId=<?php echo $banners[$i]["id"] . "&v={$_GET["v"]}"  ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف")  ?>" class="btn btn-danger"><i class="fa fa-close text-inverse"></i>
		</a>
		<div style="display:none"><label id="hidden<?php echo $banners[$i]["id"]?>"><?php echo $banners[$i]["hidden"] ?></label></div>
		<div style="display:none"><label id="logo<?php echo $banners[$i]["id"]?>"><?php echo $banners[$i]["imageurl"] ?></label></div>
		<div style="display:none"><label id="logo600<?php echo $banners[$i]["id"]?>"><?php echo $banners[$i]["imageurl600"] ?></label></div>
		<div style="display:none"><label id="header<?php echo $banners[$i]["id"]?>"><?php echo $banners[$i]["header"] ?></label></div>
		
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
			var link = $("#link"+id).html();
			var title = $("#title"+id).html();
			var hidden = $("#hidden"+id).html();
			var type = $("#type"+id).html();
			var logo = $("#logo"+id).html();
			var logo600 = $("#logo600"+id).html();
			$("input[type=file]").prop("required",false);
			$("input[name=link]").val(link);
			$("input[name=update]").val(id);
			$("input[name=title]").val(title);
			$("select[name=hidden]").val(hidden);
			$("select[name=type]").val(type);
			$("#logoImg").attr("src","../logos/"+logo);
			$("#logo600Img").attr("src","../logos/"+logo600);
			$("#images").attr("style","margin-top:10px;display:block");
		})
	</script>