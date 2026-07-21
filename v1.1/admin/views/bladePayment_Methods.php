<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Payment Method Details","تفاصيل طريقة الدفع") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Payment ID","رمز الدفع") ?></label>
			<input type="number" name="paymentId" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Icon","الأيقونه") ?></label>
			<input type="file" name="imageurl" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Enable Payment Method","تفعيل طريقة الدفع") ?></label>
			<select name="hidden" class="form-control">
				<option value="0">Yes</option>
				<option value="1">No</option>
			</select>
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
<h6 class="panel-title txt-dark"><?php echo direction("Payment Method List","قائمة طرق الدفع") ?></h6>
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
		<th><?php echo direction("Payment ID","رمز الدفع") ?></th>
		<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
		<th><?php echo direction("Icon","الأيقونه") ?></th>
		<th><?php echo direction("Status","الحالة") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $pMehtods = selectDB("payment_methods","`status` = '0' ORDER BY `order` ASC") ){
		for( $i = 0; $i < sizeof($pMehtods); $i++ ){
		    $hidden = $pMehtods[$i]["hidden"] == "0" ? direction("Active","مفعل") : direction("Disabled","معطل");
            if ( $pMehtods[$i]["hidden"] == 1 ){
                $icon = "fa fa-eye";
                $link = "?show={$pMehtods[$i]["id"]}";
                $hide = "Show";
            }else{
                $icon = "fa fa-eye-slash";
                $link = "?hide={$pMehtods[$i]["id"]}";
                $hide = "Hide";
            }
		?>
		<tr>
		<td>
            <input name="order[]" class="form-control" type="number" value="<?php echo $pMehtods[$i]["order"] ?>">
            <input name="id[]" class="form-control" type="hidden" value="<?php echo $pMehtods[$i]["id"] ?>">
		</td>
		<td id="payId<?php echo $pMehtods[$i]["id"]?>" ><?php echo $pMehtods[$i]["paymentId"] ?></td>
		<td id="enTitle<?php echo $pMehtods[$i]["id"]?>" ><?php echo $pMehtods[$i]["enTitle"] ?></td>
		<td id="arTitle<?php echo $pMehtods[$i]["id"]?>" ><?php echo $pMehtods[$i]["arTitle"] ?></td>
		<td id="imageurl<?php echo $pMehtods[$i]["id"]?>" ><img src="../logos/<?php echo $pMehtods[$i]["imageurl"] ?>" style="width:50px;height:50px"></td>
        <td id="hidden<?php echo $pMehtods[$i]["id"]?>" ><?php echo $hidden ?><label style="display:none" id="hiddenText<?php echo $pMehtods[$i]["id"] ?>"><?php echo $pMehtods[$i]["hidden"] ?></label></td>
		<td class="text-nowrap">
            <a id="<?php echo $pMehtods[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
            </a>
            <a href="<?php echo $link . "&v={$_GET["v"]}" ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
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
</form>
	
	<script>
		$(document).on("click",".edit", function(){
			var id = $(this).attr("id");
			var arTitle = $("#arTitle"+id).html();
			var enTitle = $("#enTitle"+id).html();
			var hidden = $("#hiddenText"+id).html();
			var payId = $("#payId"+id).html();
			$("input[name=arTitle]").val(arTitle).focus();
			$("input[name=update]").val(id);
			$("input[name=enTitle]").val(enTitle);
			$("input[name=paymentId]").val(payId);
			$("select[name=hidden]").val(hidden);
			$("input[name=imageurl]").removeAttr('required');
		})
	</script>