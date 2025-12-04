<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Event Voucher Details","تفاصيل كود الخصم للحدث") ?></h6>
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
			
			<div class="col-md-3">
			<label><?php echo direction("Amount","القيمة") ?></label>
			<input type="number" name="amount" class="form-control" required>
			</div>
			
			<div class="col-md-3">
			<label><?php echo direction("Type","النوع") ?></label>
			<select name="type" class="form-control">
                <option value='0'><?php echo direction("Percentage","نسبة مؤوية") ?></option>
                <option value='1'><?php echo direction("Fixed","قيمة ثابته") ?></option>
			</select>
			</div>

            <div class="col-md-3">
			<label><?php echo direction("Start Date","تاريخ البداية") ?></label>
			<input type="date" name="startDate" class="form-control" required>
			</div>

            <div class="col-md-3">
			<label><?php echo direction("End Date","تاريخ الإنتهاء") ?></label>
			<input type="date" name="endDate" class="form-control" required>
			</div>


			<div class="col-md-12">
			<div class="form-group">
			<label class="control-label mb-10"><?php echo direction("Event","الحدث") ?></label>
			<select class="form-control" name="eventIds[]" class="form-control" id="mySelect" multiple style="height: 200px">
				<?php
				if( $userType == 0 || $userType == 8 ){
					echo "<option value='0' selected>".direction("All","الكل")."</option>";
				}
				$count = (is_array($eventsList) && !empty($eventsList)) ? count($eventsList) : 1;
				$orderBy = direction("enTitle","arTitle");
				for( $z = 0; $z < $count; $z++ ){
					$id = ( isset($eventsList[$z]) && !empty($eventsList[$z]) ) ? "AND `id` = '{$eventsList[$z]}'" : "AND `id` != '0'";
					if( $events = selectDB("tabs_list","`status` = '0' {$id} ORDER BY `{$orderBy}` ASC") ){
						for( $i = 0; $i < sizeof($events); $i++ ){
							$area = selectDB("countries","`id` = '{$events[$i]["area"]}'");
							$areaTitle = direction($area[0]["areaEnTitle"],$area[0]["areaArTitle"]);
							$eventTitle = direction($events[$i]["enTitle"],$events[$i]["arTitle"]);
							echo "<option value='{$events[$i]["id"]}'>{$eventTitle} - {$areaTitle} </option>";
						}
					}
				}
				?>
			</select>
			</div>	
			</div>
			
			<div class="col-md-6" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="0">
			<input type="hidden" name="typeOfVoucher" value="2">
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
	<div class="pull-left"><h6 class="panel-title txt-dark"><?php echo direction("List of Events Vouchers","قائمة كوبونات الحدث") ?></h6></div>
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
		<th><?php echo direction("Event","الحدث") ?></th>
		<th><?php echo direction("Start Date","تاريخ البداية") ?></th>
		<th><?php echo direction("End Date","تاريخ الإنتهاء") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		$voucherIds = array();
		$count = (is_array($eventsList) && !empty($eventsList)) ? count($eventsList) : 1;
		for( $z = 0; $z < $count; $z++ ){
			$id = ( isset($eventsList[$z]) && !empty($eventsList[$z]) ) ? "AND `eventIds` LIKE '%{$eventsList[$z]}%'" : "";
			if( $vouchers = selectDB("vouchers","`status` = '0' AND `hidden` != '2' AND `typeOfVoucher` = '2' {$id}") ){
				for( $i = 0; $i < sizeof($vouchers); $i++ ){
					if ( !in_array($vouchers[$i]["id"],$voucherIds) ){
						array_push($voucherIds, $vouchers[$i]["id"]);
					if ( $vouchers[$i]["hidden"] == 1 ){
						$icon = "fa fa-unlock";
						$link = "?v={$_GET["v"]}&show={$vouchers[$i]["id"]}";
						$hide = direction("Unlock","فتح الكود");
					}else{
						$icon = "fa fa-lock";
						$link = "?v={$_GET["v"]}&hide={$vouchers[$i]["id"]}";
						$hide = direction("Lock","قفل الكود");
					}
					$event = "";
					$type = ( $vouchers[$i]["type"] == 0 ) ? direction("Percentage","نسبة مؤوية") : direction("Fixed","قيمة ثابته") ;
					$cleanedEventId = str_replace(['[', ']', '"'], '', $vouchers[$i]["eventIds"]);
					$vouchers[$i]["eventIds"] = explode(',', $cleanedEventId);
					for( $j = 0; $j < sizeof($vouchers[$i]["eventIds"]); $j++ ){
						if( $eventData = selectDB("tabs_list","`id` = '{$vouchers[$i]["eventIds"][$j]}'") ){
							$event .= direction($eventData[0]["enTitle"],$eventData[0]["arTitle"]) . " - ";
						}else{
							$event .= "";
						}
					}
					?>
					<tr>
					<td id="title<?php echo $vouchers[$i]["id"]?>" ><?php echo $vouchers[$i]["title"] ?></td>
					<td id="code<?php echo $vouchers[$i]["id"]?>" ><?php echo $vouchers[$i]["code"] ?></td>
					<td id="numberOfTimes<?php echo $vouchers[$i]["id"]?>" ><?php echo $vouchers[$i]["numberOfTimes"] ?></td>
					<td id="amount<?php echo $vouchers[$i]["id"]?>" ><?php echo $vouchers[$i]["amount"] ?></td>
					<td><?php echo $type ?></td>
					<td><?php echo $event ?></td>
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
						<label id="tournament<?php echo $vouchers[$i]["id"]?>"><?php echo json_encode($vouchers[$i]["tournamentIds"]) ?></label>
					</div>				
					</td>
					</tr>
					<?php
					}	
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
			// set overflow:Auto to #mySelect
			$('.select2').css('overflow', 'auto');
		});

	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
        $("input[name=update]").val(id);
		$("input[name=code]").val($("#code"+id).html());
		$("input[name=numberOfTimes]").val($("#numberOfTimes"+id).html());
		$("input[name=amount]").val($("#amount"+id).html());
		$("input[name=startDate]").val($("#startDate"+id).html());
		$("input[name=endDate]").val($("#endDate"+id).html());
		$("input[name=title]").val($("#title"+id).html());
		$("select[name=type]").val($("#type"+id).html());
		var tournament = JSON.parse($("#tournament"+id).html());
		$("#mySelect").val(tournament).trigger('change');
        $("input[name=title]").focus();
	})
</script>

