<div class="col-sm-12" id="editDetails" style="<?php echo $userType = ( $userType == 0 ) ? "display:block" : "display:none" ?>">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Field Details","تفاصيل الملعب") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("Tab","التحويله") ?></label>
			<select id="mySelect4" name="tabId" class="form-control" required>
				<?php
				if( $TabsList = selectDB("tabs","`status` = '0' AND `hidden` = '0' AND `id` NOT IN (1,2) ORDER BY `enTitle` ASC") ){
					for( $i =0; $i < sizeof($TabsList); $i++ ){
						echo "<option value='{$TabsList[$i]["id"]}'>{$TabsList[$i]["enTitle"]}</option>";
					}
				}
				?>
			</select>
			</div> 

            <div class="col-md-6">
			<label><?php echo direction("Sports","الرياضات") ?></label>
			<select id="mySelect3" name="sport" class="form-control" required>
				<?php
				if( $sportsList = selectDB("sports","`status` = '0' AND `hidden` = '0' ORDER BY `enTitle` ASC") ){
					for( $i =0; $i < sizeof($sportsList); $i++ ){
						echo "<option value='{$sportsList[$i]["id"]}'>{$sportsList[$i]["enTitle"]}</option>";
					}
				}
				?>
			</select>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("English Title","الإسم الإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-3">
			<label><?php echo direction("Arabic Title","الإسم العربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>
			
			<div class="col-md-3">
			<label><?php echo direction("Email","البريد الإكتروني") ?></label>
			<input type="text" name="email" class="form-control" required>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Is Indoor? ","هل الأكادمية داخليه؟") ?></label>
			<select name="isIndoor" class="form-control" required>
				<option value="1" ><?php echo direction("Yes","نعم") ?></option>
				<option value="0" ><?php echo direction("No","لا") ?></option>
			</select>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Country","البلد") ?></label>
			<select id="mySelect" name="country" class="form-control countrySelect" required>
				<option selected disabled value="0"><?php echo direction("SELECT COUNTRY","إختر البلد") ?></option>
				<option value='KW'>KUWAIT</option>
				<?php
				if( $countries = selectDB("countries","`id` != '0' AND `countryEnTitle` NOT LIKE 'KUWAIT' AND `status` = '1' GROUP BY `countryCode` ORDER BY `countryEnTitle` ASC") ){
					for( $i =0; $i < sizeof($countries); $i++ ){
						echo "<option value='{$countries[$i]["countryCode"]}'>{$countries[$i]["countryEnTitle"]}</option>";
					}
				}
				?>
			</select>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Governates","المحافظات") ?></label>
			<select id="mySelect1" class="form-control governateSelect" name="governate" required>
				<option selected disabled value="0"><?php echo direction("SELECT GOVERNATE","إختر المحافظة") ?></option>
			</select>
			</div>

			<?php
			if ($governates = selectDB("governates", "`status` = '0' AND `hidden` = '0'") ) {
				$countryCode = $governates[0]["countryCode"];
				for ($i = 0; $i < sizeof($governates); $i++) {
					if ($i == 0 || $countryCode != $governates[$i]["countryCode"]) {
						if ($i != 0) {
							echo "</div>";
						}
						echo "<div class='governate' id='country{$governates[$i]["countryCode"]}' style='display:none'>";
					}
					echo "<option value='{$governates[$i]["id"]}'>" . direction($governates[$i]["enTitle"], $governates[$i]["arTitle"]) . "</option>";
					$countryCode = $governates[$i]["countryCode"];
				}
				echo "</div>";
			}
			?>

			<div class="col-md-4">
			<label><?php echo direction("Areas","المناطق") ?></label>
			<select id="mySelect2" class="select areaSelect" name="area" required>
				<option selected disabled value="0"><?php echo direction("SELECT AREA","إختر المنطقة") ?></option>
			</select>
			</div>

			<?php
			if ($areas = selectDB("countries", "`status` = '1' AND `hidden` = '0' AND `governateId` != '' ORDER BY `governateId` ASC")) {
				$governateId = $areas[0]["governateId"];
				for ($i = 0; $i < sizeof($areas); $i++) {
					if ($i == 0 || $governateId != $areas[$i]["governateId"]) {
						if ($i != 0) {
							echo "</div>";
						}
						echo "<div class='governate' id='governate{$areas[$i]["governateId"]}' style='display:none'>";
					}
					echo "<option value='{$areas[$i]["id"]}'>" . direction($areas[$i]["areaEnTitle"], $areas[$i]["areaArTitle"]) . "</option>";
					$governateId = $areas[$i]["governateId"];
				}
				echo "</div>";
			}
			?>
			
			<div class="col-md-12">
			<label><?php echo direction("Gender","الجنس") ?></label>
			<select name="gender" class="form-control" required>
				<option value="1" ><?php echo direction("Man","رجال") ?></option>
				<option value="2" ><?php echo direction("Woman","سيدات") ?></option>
				<option value="3" ><?php echo direction("Boy","أولاد") ?></option>
				<option value="4" ><?php echo direction("Girl","بنات") ?></option>
				<option value="5" ><?php echo direction("Mix Adults","مختلط كبار") ?></option>
				<option value="6" ><?php echo direction("Mix Kids","مختلط الاطفال") ?></option>
			</select>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Location","الموقع") ?></label>
			<input type="text" name="location" class="form-control" required>
			</div>
			
			<div class="col-md-3">
			<label><?php echo direction("Price","سعر") ?></label>
			<input type="number" step="any" name="price" class="form-control" required>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Quantity","الكمية") ?></label>
			<input type="number" step="any" name="quantity" class="form-control" required>
			</div>

			<div class="col-md-3" style="<?php echo $userType ?>">
			<label><?php echo direction("IBAN","الأيبان") ?></label>
			<input type="text" name="iban" class="form-control" required>
			</div>

			<div class="col-md-3" style="<?php echo $userType ?>">
			<label><?php echo direction("KNET Charge","عمولة الكي نت") ?></label>
			<input type="number" step="any" name="charges" class="form-control" required>
			</div>

			<div class="col-md-3" style="<?php echo $userType ?>">
			<label><?php echo direction("KNET charge type","نوع خصم الكي نت") ?></label>
			<select name="chargeType" class="form-control" required>
				<option value='fixed'>fixed</option>
				<option value='percentage'>percentage</option>
			</select>
			</div>

			<div class="col-md-3" style="<?php echo $userType ?>">
			<label><?php echo direction("Visa Charge","عمولة الفيزا") ?></label>
			<input type="number" step="any" name="cc_charge" class="form-control" required>
			</div>

			<div class="col-md-3" style="<?php echo $userType ?>">
			<label><?php echo direction("VISA charge type","نوع خصم الفيزا") ?></label>
			<select name="cc_chargetype" class="form-control" required>
				<option value='fixed'>fixed</option>
				<option value='percentage'>percentage</option>
			</select>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("English Terms","الشروط الإنجليزية") ?></label>
            <textarea name="enTerms" class="tinymce"></textarea>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("Arabic Terms","الشروط العربية") ?></label>
            <textarea name="arTerms" class="tinymce"></textarea>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Map View","صورة الخريطة") ?></label>
			<input type="file" name="locationImage" class="form-control" >
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Logo","الشعار") ?></label>
			<input type="file" name="imageurl" class="form-control" >
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Header","الصورة الكبيرة") ?></label>
			<input type="file" name="header" class="form-control" >
			</div>

			<div id="images" style="margin-top: 10px; display:none">
				<div class="col-md-4">
				<img id="locationImg" src="" style="width:250px;height:250px">
				</div>

				<div class="col-md-4">
				<img id="logoImg" src="" style="width:250px;height:250px">
				</div>

				<div class="col-md-4">
				<img id="headerImg" src="" style="width:250px;height:250px">
				</div>
			</div>
			
			<div class="col-md-12" style="margin-top:10px">
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
<h6 class="panel-title txt-dark"><?php echo direction("List","قائمة") ?></h6>
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
		<th><?php echo direction("Title","العنوان") ?></th>
		<th><?php echo direction("Sport","الرياضة") ?></th>
		<th><?php echo direction("Country","البلد") ?></th>
		<th><?php echo direction("Gender","الجنس") ?></th>
		<th><?php echo direction("Price","القيمة") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php  
		$count = (is_array($fieldsList) && !empty($fieldsList)) ? count($fieldsList) : 1;
		for( $z = 0; $z < $count; $z++ ){
			$id = ( isset($fieldsList[$z]) && !empty($fieldsList[$z]) ) ? "AND `id` = '{$fieldsList[$z]}'" : "";
		if( $fields = selectDB("fields_list","`status` = '0' {$id}") ){
			for( $i = 0; $i < sizeof($fields); $i++ ){
				$sport = selectDB("sports","`id` = '{$fields[$i]["sport"]}'");
				$title = direction($fields[$i]["enTitle"],$fields[$i]["arTitle"]);
				$videoText = ( !empty($fields[$i]["video"]) ) ? direction("Watch","شاهد") : "";
				$locationText = ( !empty($fields[$i]["location"]) ) ? direction("View","إعرض") : "";
				$price = ( empty($fields[$i]["price"]) )? direction("Free","مجانا") : $fields[$i]["price"];
                if ( $fields[$i]["gender"] == 1 ){
                    $genderText = direction("Man","رجال");
                }elseif( $fields[$i]["gender"] == 2 ){
                    $genderText = direction("Woman","سيدات");
                }elseif( $fields[$i]["gender"] == 3 ){
                    $genderText = direction("Boy","أولاد");
                }elseif( $fields[$i]["gender"] == 4 ){
                    $genderText = direction("Girl","بنات");
                }elseif( $fields[$i]["gender"] == 5 ){
                    $genderText = direction("Mixed Adults","مختلط كبار");
                }elseif( $fields[$i]["gender"] == 6 ){
                    $genderText = direction("Mixed Kids","مختلط الاطفال");
                }
				if ( $fields[$i]["hidden"] == 1 ){
					$icon = "fa fa-eye";
					$link = "?show={$fields[$i]["id"]}";
					$hide = direction("Show","أظهر");
				}else{
					$icon = "fa fa-eye-slash";
					$link = "?hide={$fields[$i]["id"]}";
					$hide = direction("Hide","إخفاء");
				}
				?>
				<tr>
				<td><?php echo str_pad(1 + $i, 3 ,'0', STR_PAD_LEFT) ?></td>
				<td><?php echo $title ?></td>
				<td><?php echo direction($sport[0]["enTitle"],$sport[0]["arTitle"]) ?></td>
				<td id="country<?php echo $fields[$i]["id"]?>" ><?php echo $fields[$i]["country"] ?></td>
				<td><?php echo $genderText ?><label style="display:none" id="gender<?php echo $fields[$i]["id"]?>"  ><?php echo $fields[$i]["gender"] ?></label></td>
				<td><?php echo $price ?><label style="display:none" id="price<?php echo $fields[$i]["id"]?>"  ><?php echo $fields[$i]["price"] ?></label></td>
				<td class="text-nowrap">
					<a id="<?php echo $fields[$i]["id"] ?>" class="edit btn btn-warning" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل")  ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
					</a>
					<a href="<?php echo $link . "&v={$_GET["v"]}" ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i></a>
					<a href="?delId=<?php echo $fields[$i]["id"] . "&v={$_GET["v"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف")  ?>" class="btn btn-danger"><i class="fa fa-close text-inverse"></i>
					</a>
					<div style="display:none"><label id="locationImg<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["locationImage"] ?></label></div>
					<div style="display:none"><label id="logo<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["imageurl"] ?></label></div>
					<div style="display:none"><label id="header<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["header"] ?></label></div>
					<div style="display:none"><label id="governates<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["governate"] ?></label></div>
					<div style="display:none"><label id="area<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["area"] ?></label></div>
					<div style="display:none"><label id="sport<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["sport"] ?></label></div>
					<div style="display:none"><label id="enTitle<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["enTitle"] ?></label></div>
					<div style="display:none"><label id="arTitle<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["arTitle"] ?></label></div>
					<div style="display:none"><label id="location<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["location"] ?></label></div>
					<div style="display:none"><label id="video<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["video"] ?></label></div>
					<div style="display:none"><label id="email<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["email"] ?></label></div>
					<div style="display:none"><label id="charges<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["charges"] ?></label></div>
					<div style="display:none"><label id="chargeType<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["chargeType"] ?></label></div>
					<div style="display:none"><label id="cc_charge<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["cc_charge"] ?></label></div>
					<div style="display:none"><label id="cc_chargetype<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["cc_chargetype"] ?></label></div>
					<div style="display:none"><label id="iban<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["iban"] ?></label></div>
					<div style="display:none"><label id="isIndoor<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["isIndoor"] ?></label></div>
					<div style="display:none"><label id="enTerms<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["enTerms"] ?></label></div>
					<div style="display:none"><label id="arTerms<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["arTerms"] ?></label></div>
					<div style="display:none"><label id="tabId<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["tabId"] ?></label></div>
					<div style="display:none"><label id="fieldsIds<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["fieldsIds"] ?></label></div>
					<div style="display:none"><label id="quantity<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["quantity"] ?></label></div>
					<div style="display:none"><label id="gameDate<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["gameDate"] ?></label></div>
					<div style="display:none"><label id="gameTime<?php echo $fields[$i]["id"]?>"><?php echo $fields[$i]["gameTime"] ?></label></div>
				</td>
				</tr>
				<?php
			}
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
		$(document).ready(function() {
			$('#mySelect').select2();
			$('#mySelect1').select2();
			$('#mySelect2').select2();
			$('#mySelect3').select2();
			$('#mySelect4').select2();
			$('#mySelect5').select2();
			// change the view of select sport
			$('.governateSelect').on('change', function () {
				var selectedGovernate = $(this).val();
				var governateDiv = $('#governate' + selectedGovernate);
				if (governateDiv.length) {
					var areas = governateDiv.html();
					$('.areaSelect').html(areas);
				}
			});

			$('.countrySelect').on('change', function () {
				var selectedCountry = $(this).val();
				var countryDiv = $('#country' + selectedCountry);
				if (countryDiv.length) {
					var areas = countryDiv.html();
					$('.governateSelect').html(areas);
				}
			});
		});

		$(document).on("click",".edit", function(){
			$("#editDetails").show();
			var id = $(this).attr("id");
			$("input[name=enTitle]").val($("#enTitle"+id).html()).focus();
			$("input[name=arTitle]").val($("#arTitle"+id).html());
			$("input[name=video]").val($("#video"+id).html());
			$("input[name=email]").val($("#email"+id).html());
			$("select[name=gender]").val($("#gender"+id).html());
			$("select[name=country]").val($("#country"+id).html()).trigger('change');
			$("select[name=governate]").val($("#governates"+id).html()).trigger('change');
			$("select[name=area]").val($("#area"+id).html()).trigger('change');
			$("select[name=tabId]").val($("#tabId"+id).html()).trigger('change');
			$("select[name=isIndoor]").val($("#isIndoor"+id).html());
			$("input[name=location]").val($("#location"+id).html());
			$("input[name=charges]").val($("#charges"+id).html());
			$("select[name=chargeType]").val($("#chargeType"+id).html());
			$("input[name=cc_charge]").val($("#cc_charge"+id).html());
			$("select[name=cc_chargetype]").val($("#cc_chargetype"+id).html());
			$("input[name=iban]").val($("#iban"+id).html());
			$("input[name=price]").val($("#price"+id).html());
			$("input[name=gameDate]").val($("#gameDate"+id).html());
			$("input[name=gameTime]").val($("#gameTime"+id).html());
			$("input[name=quantity]").val($("#quantity"+id).html());
			tinymce.get("enTerms").setContent($("#enTerms"+id).html());
			tinymce.get("arTerms").setContent($("#arTerms"+id).html());
			
			// Set selected fields
			var fieldsIds = $("#fieldsIds"+id).html();
			if( fieldsIds ){
				try {
					var fieldsArray = JSON.parse(fieldsIds);
					$("select[name='fieldsIds[]']").val(fieldsArray).trigger('change');
				} catch(e) {
					console.log("Error parsing fieldsIds", e);
				}
			}
			
			$("#logoImg").attr("src","../logos/"+$("#logo"+id).html());
			$("#headerImg").attr("src","../logos/"+$("#header"+id).html());
			$("#locationImg").attr("src","../logos/"+$("#locationImg"+id).html());
			$("#images").attr("style","margin-top:10px;display:block");
			$("input[name=update]").val(id);
		})
	</script>