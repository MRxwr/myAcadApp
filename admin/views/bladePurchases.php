<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Invoice Details","تفاصيل الفاتورة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
            <div class="col-md-4">
			<label><?php echo direction("Academy","الأكادمية") ?></label>
			<select name="academyId" class="form-control" id="academyList">
				<?php
                echo "<option value='0'>".direction("None","لايوجد")."</option>";
				if( $academy = selectDB("academies","`status` = '0'") ){
					for( $i = 0; $i < sizeof($academy); $i++ ){
						$academyTitle = direction($academy[$i]["enTitle"],$academy[$i]["arTitle"]);
						echo "<option value='{$academy[$i]["id"]}'>{$academyTitle}</option>";
					}
				}
				?>
			</select>
			</div>

            <div class="col-md-4">
			<label><?php echo direction("Type","النوع") ?></label>
			<select name="type" class="form-control">
                <option value='0'><?php echo direction("None","لايوجد") ?></option>
                <option value='1'><?php echo direction("Wallet","محفظة") ?></option>
                <option value='2'><?php echo direction("Voucher","كود") ?></option>
			</select>
			</div>

            <div class="col-md-4">
			<label><?php echo direction("From/To MYACAD","من/إلى ماي اكاد") ?></label>
			<select name="isMyacad" class="form-control">
                <option value='1'><?php echo direction("From MyAcad","من ماي اكاد") ?></option>
                <option value='2'><?php echo direction("To MyAcad","إلى ماي اكاد") ?></option>
			</select>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Note","الملاحظة") ?></label>
			<input type="text" name="note" class="form-control" required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("Price","القيمه") ?></label>
			<input type="number" step="any" name="price" class="form-control" required>
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Governates","قائمة المحافظات") ?></h6>
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
        <th><?php echo direction("#","#") ?></th>
        <th><?php echo direction("Date","التاريخ") ?></th>
		<th><?php echo direction("Academy","الأكادمية") ?></th>
        <th><?php echo direction("Type","النوع") ?></th>
        <th><?php echo direction("From/To","من/إلى") ?></th>
        <th><?php echo direction("Note","الملاحظة") ?></th>
        <th><?php echo direction("Price","القيمه") ?></th>
        <th><?php echo direction("Status","الحالة") ?></th>
        <th><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $purchases = selectDB("purchases","`id` != '0' ORDER BY `id` DESC") ){
			for( $i = 0; $i < sizeof($purchases); $i++ ){
                $academy = ( $purchases[$i]["academyId"] != 0 ) ? selectDB("academies","`id` = '{$purchases[$i]["academyId"]}'") : array(array("enTitle"=>"None","arTitle"=>"لايوجد"));
                $type = ( $purchases[$i]["type"] == 0 ) ? direction("None","لايوجد") : ( ( $purchases[$i]["type"] == 1 ) ? direction("Wallet","محفظة") : direction("Voucher","كود") );
                $isMyacad = ( $purchases[$i]["isMyacad"] == 1 ) ? direction("From MyAcad","من ماي اكاد") : direction("To MyAcad","إلى ماي اكاد") ;
                $status = ( $purchases[$i]["status"] == 0 ) ? direction("Pending","قيد الانتظار") : ( ( $purchases[$i]["status"] == 1 ) ? direction("Accepted","مقبول") : direction("Rejected","مرفوض") );
                $statusColor = ( $purchases[$i]["status"] == 0 ) ? "default" : ( ( $purchases[$i]["status"] == 1 ) ? "success" : "danger" );
				$counter = $i + 1;
				?>
				<tr>
                <td><?php echo $purchases[$i]["id"] ?></td>
				<td><?php echo substr($purchases[$i]["date"],0,10) ?></td>
				<td><?php echo direction($academy[0]["enTitle"],$academy[0]["arTitle"]) ?></td>
				<td><?php echo $type ?></td>
				<td><?php echo $isMyacad ?></td>
				<td><?php echo $purchases[$i]["note"] ?></td>
				<td><?php echo $purchases[$i]["price"] ?></td>
				<td class='text-<?php echo $statusColor ?>'><?php echo $status ?></td>
				<td class="text-nowrap">
                    <?php
                    if( $purchases[$i]["status"] == 0 && $purchases[$i]["isMyacad"] == 1 ){
                        ?>
                        <button class="btn btn-primary btn-outline btn-icon left-icon" onclick="generatePurchaseLink('<?php echo $purchases[$i]["id"] ?>')"><?php echo direction("Pay now","ادفع") ?></button>
                        <?php
                    }elseif( $purchases[$i]["status"] == 0 && $purchases[$i]["isMyacad"] == 2 ){
                        ?>
                        <button class="btn btn-primary btn-outline btn-icon left-icon" onclick="sharePurchaseLink('<?php echo $purchases[$i]["id"] ?>')"><?php echo direction("Share link","شارك الرابط") ?></button>
                        <?php
                    }
                    ?>
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
    $(document).ready(function(){
		$('#academyList').select2();
	})
    function generatePurchaseLink(id){
        $.ajax({
            type: "POST",
            url: "../requests/index.php?a=Purchases",
            data: {
                id: id,
                type: "pay"
            },
            headers: {
                "myacadheader": "myAcadAppCreate",
            },
            beforeSend: function(){
                $("#loader").show();
            },
            success: function(result) {
                $("#loader").hide();
                if (result["status"] === "successful") {
                    alert("Success.. you will be redirected to payment gateway.");
                    window.open(result["data"]["paymentURL"], "_blank");
                } else {
                    alert("Fail.. please try again.");
                }
            },
        })
    }
    function sharePurchaseLink(id) {
        $.ajax({
            type: "POST",
            url: "../requests/index.php?a=Purchases",
            data: {
                id: id,
                type: "share"
            },
            headers: {
                "myacadheader": "myAcadAppCreate",
            },
            beforeSend: function() {
                $("#loader").show();
            },
        })
        .done(function(result) {
            if (result["status"] === "successful") {
                shareMe(result["data"]["data"]["InvoiceId"]);
            } else {
                alert("Fail.. please try again.");
            }
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX request failed:", status, error);
            alert("An error occurred. Please try again later.");
        })
        .always(function() {
            $("#loader").hide();
        });
    }

    function shareMe(id) {
        console.log("shareMe called with id:", id);
        if (navigator.share !== undefined && navigator.share !== null) {
            // Use the Web Share API
            navigator.share({
                    title: 'MY ACAD - Purchase',
                    text: "Please follow this link to pay your purchase.",
                    url: 'https://myacad.app/Purchase.php?s=' + id
                })
                .then(() => {
                    console.log('Shared successfully');
                })
                .catch((error) => {
                    console.error('Error sharing:', error);
                });
        } else {
            // Fallback behavior for browsers that do not support the Web Share API
            alert('Sharing is not supported on this device/browser.');
        }
    }
</script>