<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Academy Details","تفاصيل الأكادمية") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("English Title","الإسم الإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Arabic Title","الإسم العربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Video","الفيديو") ?></label>
			<input type="text" name="video" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Promotion","العرض") ?></label>
			<input type="text" name="promotion" class="form-control" required>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Costume? ","ملابس؟") ?></label>
			<select name="isClothes" class="form-control" required>
				<option value="0" ><?php echo direction("No","لا") ?></option>
				<option value="1" ><?php echo direction("Yes","نعم") ?></option>
			</select>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Costume Price","سعر الملابس") ?></label>
			<input type="float" name="clothesPrice" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Logo","الشعار") ?></label>
			<input type="file" name="imageurl" class="form-control" >
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Header","الصورة الكبيرة") ?></label>
			<input type="file" name="header" class="form-control" >
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Costume Image","صورة الملابس") ?></label>
			<input type="file" name="clothesImage" class="form-control" >
			</div>

			<div id="images" style="margin-top: 10px; display:none">
				<div class="col-md-4">
				<img id="logoImg" src="" style="width:250px;height:250px">
				</div>

				<div class="col-md-4">
				<img id="headerImg" src="" style="width:250px;height:250px">
				</div>

				<div class="col-md-4">
				<img id="clothesImg" src="" style="width:250px;height:250px">
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
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Academies","قائمة الأكاديمات") ?></h6>
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
		<th><?php echo direction("English Title","الإسم الإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","الإسم العربي") ?></th>
		<th><?php echo direction("Video","الفيديو") ?></th>
		<th><?php echo direction("Promotion","العرض") ?></th>
		<th><?php echo direction("Costume? ","ملابس؟") ?></th>
		<th><?php echo direction("Costume Price","سعر الملابس") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $academies = selectDB("academies","`status` = '0'") ){
			for( $i = 0; $i < sizeof($academies); $i++ ){
				$videoText = ( !empty($academies[$i]["video"]) ) ? direction("Watch","شاهد") : "";
				$isClothesText = ( empty($academies[$i]["isClothes"]) )? direction("No","لا") : direction("Yes","نعم");
				if ( $academies[$i]["hidden"] == 1 ){
					$icon = "fa fa-eye";
					$link = "?show={$academies[$i]["id"]}";
					$hide = direction("Show","أظهر");
				}else{
					$icon = "fa fa-eye-slash";
					$link = "?hide={$academies[$i]["id"]}";
					$hide = direction("Hide","إخفاء");
				}
				?>
				<tr>
				<td id="enTitle<?php echo $academies[$i]["id"]?>" ><?php echo $academies[$i]["enTitle"] ?></td>
				<td id="arTitle<?php echo $academies[$i]["id"]?>" ><?php echo $academies[$i]["arTitle"] ?></td>
				<td><a href="<?php echo $academies[$i]["video"] ?>" target="_blank"><?php echo $videoText ?></a><label id="video<?php echo $academies[$i]["id"]?>" style="display:none" ><?php echo $academies[$i]["video"] ?></label></td>
				<td id="promotion<?php echo $academies[$i]["id"]?>" ><?php echo $academies[$i]["promotion"] ?></td>
				<td><?php echo $isClothesText ?><label style="display:none" id="isClothes<?php echo $academies[$i]["id"]?>"  ><?php echo $academies[$i]["isClothes"] ?></label></td>
				<td id="clothesPrice<?php echo $academies[$i]["id"]?>" ><?php echo $academies[$i]["clothesPrice"] ?>KD</td>
				<td class="text-nowrap">
					<a id="<?php echo $academies[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
					</a>
					<a href="<?php echo $link . "&v={$_GET["v"]}" ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i></a>
					<a href="?delId=<?php echo $academies[$i]["id"] . "&v={$_GET["v"]}" ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
					</a>
					<div style="display:none"><label id="clothes<?php echo $academies[$i]["id"]?>"><?php echo $academies[$i]["clothesImage"] ?></label></div>
					<div style="display:none"><label id="logo<?php echo $academies[$i]["id"]?>"><?php echo $academies[$i]["imageurl"] ?></label></div>
					<div style="display:none"><label id="header<?php echo $academies[$i]["id"]?>"><?php echo $academies[$i]["header"] ?></label></div>
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
	<script>
		$(document).on("click",".edit", function(){
			var id = $(this).attr("id");
			var enTitle = $("#enTitle"+id).html();
			var arTitle = $("#arTitle"+id).html();
			var video = $("#video"+id).html();
			var promotion = $("#promotion"+id).html();
			var isClothes = $("#isClothes"+id).html();
			var clothesPrice = $("#clothesPrice"+id).html();
			var logo = $("#logo"+id).html();
			var header = $("#header"+id).html();
			var clothes = $("#clothes"+id).html();
			$("input[name=enTitle]").val(enTitle).focus();
			$("input[name=arTitle]").val(arTitle);
			$("input[name=video]").val(video);
			$("input[name=promotion]").val(promotion);
			$("select[name=isClothes]").val(isClothes);
			$("input[name=clothesPrice]").val(clothesPrice);
			$("#logoImg").attr("src","../logos/"+logo);
			$("#headerImg").attr("src","../logos/"+header);
			$("#clothesImg").attr("src","../logos/"+clothes);
			$("#images").attr("style","margin-top:10px;display:block");
			$("input[name=update]").val(id);
		})
	</script>