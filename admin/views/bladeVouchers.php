<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Voucher Details","تفاصيل كود الخصم") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="?v=<?php echo $_GET["v"] ?>" enctype="multipart/form-data">
		<div class="row m-0">

			<div class="col-md-4">
			<label><?php echo direction("Title","عنوان") ?></label>
			<input type="text" name="title" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Code","كود الخصم") ?></label>
			<input type="text" name="code" class="form-control" required>
			</div>

            <div class="col-md-4">
			<label><?php echo direction("How Many times?","عدد المرات ؟") ?></label>
			<input type="number" min="0" step="1" name="numberOfTimes" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Amount","القيمة") ?></label>
			<input type="number" name="amount" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Type","النوع") ?></label>
			<select name="type" class="form-control">
                <option value='0'><?php echo direction("Percentage","نسبة مؤوية") ?></option>
                <option value='1'><?php echo direction("Fixed","قيمة ثابته") ?></option>
			</select>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Academy","الأكادمية") ?></label>
			<select name="academyId" class="form-control" id="mySelect">
                <option value='0'><?php echo direction("All","الكل") ?></option>
				<?php
				if( $academy = selectDB("academies","`status` = '0'") ){
					for( $i = 0; $i < sizeof($academy); $i++ ){
						$academyTitle = direction($academy[$i]["enTitle"],$academy[$i]["arTitle"]);
						echo "<option value='{$academy[$i]["id"]}'>{$academyTitle}</option>";
					}
				}
				?>
			</select>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("Start Date","تاريخ البداية") ?></label>
			<input type="date" name="startDate" class="form-control" required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("End Date","تاريخ الإنتهاء") ?></label>
			<input type="date" name="endDate" class="form-control" required>
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
	<div class="pull-left"><h6 class="panel-title txt-dark"><?php echo direction("List of Employees","قائمة الموظفين") ?></h6></div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th><?php echo direction("Title","عنوان") ?></th>
		<th><?php echo direction("Code","كود الخصم") ?></th>
		<th><?php echo direction("How Many times?","عدد المرات ؟") ?></th>
		<th><?php echo direction("Amount","القيمة") ?></th>
		<th><?php echo direction("Type","النوع") ?></th>
		<th><?php echo direction("Academy","الأكادمية") ?></th>
		<th><?php echo direction("Start Date","تاريخ البداية") ?></th>
		<th><?php echo direction("End Date","تاريخ الإنتهاء") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $vouchers = selectDB("vouchers","`status` = '0' AND `hidden` != '2'") ){
			for( $i = 0; $i < sizeof($vouchers); $i++ ){
				if ( $vouchers[$i]["hidden"] == 1 ){
					$icon = "fa fa-unlock";
					$link = "?v={$_GET["v"]}&show={$vouchers[$i]["id"]}";
					$hide = direction("Unlock","فتح الكود");
				}else{
					$icon = "fa fa-lock";
					$link = "?v={$_GET["v"]}&hide={$vouchers[$i]["id"]}";
					$hide = direction("Lock","قفل الكود");
				}

				$type = ( $vouchers[$i]["type"] == 0 ) ? direction("Percentage","نسبة مؤوية") : direction("Fixed","قيمة ثابته") ;

				if( $academy = selectDB("academies","`id` = '{$vouchers[$i]["academyId"]}'") ){
					$academy = direction($academy[0]["enTitle"],$academy[0]["arTitle"]);
				}else{
					$academy = "";
				}
				
				?>
				<tr>
				<td id="title<?php echo $vouchers[$i]["id"]?>" ><?php echo $vouchers[$i]["title"] ?></td>
				<td id="code<?php echo $vouchers[$i]["id"]?>" ><?php echo $vouchers[$i]["code"] ?></td>
				<td id="numberOfTimes<?php echo $vouchers[$i]["id"]?>" ><?php echo $vouchers[$i]["numberOfTimes"] ?></td>
				<td id="amount<?php echo $vouchers[$i]["id"]?>" ><?php echo $vouchers[$i]["amount"] ?></td>
				<td><?php echo $type ?></td>
				<td><?php echo $academy ?></td>
                <td id="startDate<?php echo $vouchers[$i]["id"]?>" ><?php echo substr($vouchers[$i]["startDate"],0,10) ?></td>
				<td id="endDate<?php echo $vouchers[$i]["id"]?>" ><?php echo substr($vouchers[$i]["endDate"],0,10) ?></td>
				<td class="text-nowrap">
				
				<a id="<?php echo $vouchers[$i]["id"] ?>" class="edit btn btn-warning" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل")  ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
				</a>
				<a href="<?php echo $link ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
				</a>
				<a href="<?php echo "?v={$_GET["v"]}&delId=" . $vouchers[$i]["id"] ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف")  ?>" class="btn btn-danger"><i class="fa fa-close text-inverse"></i>
				</a>
				<div style="display:none">
					<label id="type<?php echo $vouchers[$i]["id"]?>"><?php echo $vouchers[$i]["type"] ?></label>
					<label id="academy<?php echo $vouchers[$i]["id"]?>"><?php echo $vouchers[$i]["academyId"] ?></label>			
                </div>				
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
		});

	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		var code = $("#code"+id).html();
		var title = $("#title"+id).html();
		var numberOfTimes = $("#numberOfTimes"+id).html();
		var amount = $("#amount"+id).html();
		var startDate = $("#startDate"+id).html();
		var endDate = $("#endDate"+id).html();
		var amount = $("#amount"+id).html();
		var type = $("#type"+id).html();
		var academy = $("#academy"+id).html();
        $("input[name=update]").val(id);
		$("input[name=code]").val(code);
		$("input[name=numberOfTimes]").val(numberOfTimes);
		$("input[name=amount]").val(amount);
		$("input[name=startDate]").val(startDate);
		$("input[name=endDate]").val(endDate);
		$("input[name=title]").val(title);
		$("select[name=type]").val(type);
		$("select[name=academyId]").val(academy).trigger('change');;
        $("input[name=title]").focus();
	})
</script>

