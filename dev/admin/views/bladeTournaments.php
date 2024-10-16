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
			<div class="col-md-12">
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

			<div class="col-md-3">
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

			<div class="col-md-3">
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

			<div class="col-md-3">
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

			<div class="col-md-3">
			<label><?php echo direction("Location","الموقع") ?></label>
			<input type="text" name="location" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Gender","الجنس") ?></label>
			<select name="gender" class="form-control" required>
				<option value="1" ><?php echo direction("Man","رجل") ?></option>
				<option value="2" ><?php echo direction("Woman","أنثى") ?></option>
				<option value="3" ><?php echo direction("Boy","ولد") ?></option>
				<option value="4" ><?php echo direction("Girl","بنت") ?></option>
				<option value="5" ><?php echo direction("Mix Adults","مختلط كبار") ?></option>
				<option value="6" ><?php echo direction("Mix Kids","مختلط الاطفال") ?></option>
			</select>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Video","الفيديو") ?></label>
			<input type="text" name="video" class="form-control" required>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Quantity","الكمية") ?></label>
			<input type="number" step="any" name="quantity" class="form-control" required>
			</div>
			
			<div class="col-md-3">
			<label><?php echo direction("Price","سعر") ?></label>
			<input type="number" step="any" name="price" class="form-control" required>
			</div>

            <div class="col-md-3">
			<label><?php echo direction("Players","اللاعبين") ?></label>
			<input type="number" step="any" name="players" class="form-control" required>
			</div>

            <div class="col-md-3">
			<label><?php echo direction("Bench","الإحتياط") ?></label>
			<input type="number" step="any" name="bench" class="form-control" required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("Tournament Date","تاريخ البطولة") ?></label>
			<input type="date" name="gameDate" class="form-control" required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("Turnament Time","وقت البطولة") ?></label>
			<input type="time" name="gameTime" class="form-control" required>
			</div>

			<div class="col-md-12">
			<label><?php echo direction("IBAN","الأيبان") ?></label>
			<input type="text" name="iban" class="form-control" required>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("KNET Charge","عمولة الكي نت") ?></label>
			<input type="number" step="any" name="charges" class="form-control" required>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("KNET charge type","نوع خصم الكي نت") ?></label>
			<select name="chargeType" class="form-control" required>
				<option value='fixed'>fixed</option>
				<option value='percentage'>percentage</option>
			</select>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Visa Charge","عمولة الفيزا") ?></label>
			<input type="number" step="any" name="cc_charge" class="form-control" required>
			</div>

			<div class="col-md-3">
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
		<th>#</th>
		<th><?php echo direction("Title","العنوان") ?></th>
		<th><?php echo direction("Sport","الرياضة") ?></th>
		<th><?php echo direction("Country","البلد") ?></th>
		<th><?php echo direction("Gender","الجنس") ?></th>
		<th><?php echo direction("Price","القيمة") ?></th>
		<th><?php echo direction("Date","التاريخ") ?></th>
		<th><?php echo direction("Time","الوقت") ?></th>
		<th><?php echo direction("Players","اللاعبين") ?></th>
		<th><?php echo direction("Bench","الإحتياط") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $tournaments = selectDB("tournaments","`status` = '0'") ){
			for( $i = 0; $i < sizeof($tournaments); $i++ ){
				$sport = selectDB("sports","`id` = '{$tournaments[$i]["sport"]}'");
				$academyTitle = direction($tournaments[$i]["enTitle"],$tournaments[$i]["arTitle"]);
				$videoText = ( !empty($tournaments[$i]["video"]) ) ? direction("Watch","شاهد") : "";
				$locationText = ( !empty($tournaments[$i]["location"]) ) ? direction("View","إعرض") : "";
				$price = ( empty($tournaments[$i]["price"]) )? direction("Free","مجانا") : $tournaments[$i]["price"];
                if ( $tournaments[$i]["gender"] == 1 ){
                    $genderText = direction("Man","رجل");
                }elseif( $tournaments[$i]["gender"] == 2 ){
                    $genderText = direction("Woman","إمرأه");
                }elseif( $tournaments[$i]["gender"] == 3 ){
                    $genderText = direction("Boy","ولد");
                }elseif( $tournaments[$i]["gender"] == 4 ){
                    $genderText = direction("Girl","بنت");
                }elseif( $tournaments[$i]["gender"] == 5 ){
                    $genderText = direction("Mixed Adults","مختلط كبار");
                }elseif( $tournaments[$i]["gender"] == 6 ){
                    $genderText = direction("Mixed Kids","مختلط الاطفال");
                }
				if ( $tournaments[$i]["hidden"] == 1 ){
					$icon = "fa fa-eye";
					$link = "?show={$tournaments[$i]["id"]}";
					$hide = direction("Show","أظهر");
				}else{
					$icon = "fa fa-eye-slash";
					$link = "?hide={$tournaments[$i]["id"]}";
					$hide = direction("Hide","إخفاء");
				}
				?>
				<tr>
				<td><?php echo str_pad(1 + $i, 3 ,'0', STR_PAD_LEFT) ?></td>
				<td><?php echo $academyTitle ?></td>
				<td><?php echo direction($sport[0]["enTitle"],$sport[0]["arTitle"]) ?></td>
				<td id="country<?php echo $tournaments[$i]["id"]?>" ><?php echo $tournaments[$i]["country"] ?></td>
				<td><?php echo $genderText ?><label style="display:none" id="gender<?php echo $tournaments[$i]["id"]?>"  ><?php echo $tournaments[$i]["gender"] ?></label></td>
				<td><?php echo $price ?><label style="display:none" id="price<?php echo $tournaments[$i]["id"]?>"  ><?php echo $tournaments[$i]["price"] ?></label></td>
				<td id="gameDate<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["gameDate"] ?></td>
				<td id="gameTime<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["gameTime"] ?></td>
				<td id="players<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["players"] ?></td>
				<td id="bench<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["bench"] ?></td>
				<td class="text-nowrap">
					<a id="<?php echo $tournaments[$i]["id"] ?>" class="edit btn btn-warning" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل")  ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
					</a>
					<a href="<?php echo $link . "&v={$_GET["v"]}" ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i></a>
					<a href="?delId=<?php echo $tournaments[$i]["id"] . "&v={$_GET["v"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف")  ?>" class="btn btn-danger"><i class="fa fa-close text-inverse"></i>
					</a>
					<div style="display:none"><label id="locationImg<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["locationImage"] ?></label></div>
					<div style="display:none"><label id="logo<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["imageurl"] ?></label></div>
					<div style="display:none"><label id="header<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["header"] ?></label></div>
					<div style="display:none"><label id="governates<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["governate"] ?></label></div>
					<div style="display:none"><label id="area<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["area"] ?></label></div>
					<div style="display:none"><label id="sport<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["sport"] ?></label></div>
					<div style="display:none"><label id="enTitle<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["enTitle"] ?></label></div>
					<div style="display:none"><label id="arTitle<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["arTitle"] ?></label></div>
					<div style="display:none"><label id="location<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["location"] ?></label></div>
					<div style="display:none"><label id="video<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["video"] ?></label></div>
					<div style="display:none"><label id="email<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["email"] ?></label></div>
					<div style="display:none"><label id="charges<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["charges"] ?></label></div>
					<div style="display:none"><label id="chargeType<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["chargeType"] ?></label></div>
					<div style="display:none"><label id="cc_charge<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["cc_charge"] ?></label></div>
					<div style="display:none"><label id="cc_chargetype<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["cc_chargetype"] ?></label></div>
					<div style="display:none"><label id="iban<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["iban"] ?></label></div>
					<div style="display:none"><label id="isIndoor<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["isIndoor"] ?></label></div>
					<div style="display:none"><label id="enTerms<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["enTerms"] ?></label></div>
					<div style="display:none"><label id="arTerms<?php echo $tournaments[$i]["id"]?>"><?php echo $tournaments[$i]["arTerms"] ?></label></div>
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
		$(document).ready(function() {
			$('#mySelect').select2();
			$('#mySelect1').select2();
			$('#mySelect2').select2();
			$('#mySelect3').select2();
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
			var id = $(this).attr("id");
			$("input[name=enTitle]").val($("#enTitle"+id).html()).focus();
			$("input[name=arTitle]").val($("#arTitle"+id).html());
			$("input[name=video]").val($("#video"+id).html());
			$("input[name=email]").val($("#email"+id).html());
			$("select[name=gender]").val($("#gender"+id).html());
			$("select[name=country]").val($("#country"+id).html()).trigger('change');
			$("select[name=governate]").val($("#governates"+id).html()).trigger('change');
			$("select[name=area]").val($("#area"+id).html()).trigger('change');
			$("select[name=sport]").val($("#sport"+id).html()).trigger('change');
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
			$("input[name=players]").val($("#players"+id).html());
			$("input[name=bench]").val($("#bench"+id).html());
			tinymce.get("enTerms").setContent($("#enTerms"+id).html());
            tinymce.get("arTerms").setContent($("#arTerms"+id).html());
			$("#logoImg").attr("src","../logos/"+$("#logo"+id).html());
			$("#headerImg").attr("src","../logos/"+$("#header"+id).html());
			$("#locationImg").attr("src","../logos/"+$("#locationImg"+id).html());
			$("#images").attr("style","margin-top:10px;display:block");
			$("input[name=update]").val(id);
		})
	</script>