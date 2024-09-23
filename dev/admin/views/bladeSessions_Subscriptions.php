<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
    <p><h6 class="panel-title txt-dark"><a href="?v=Sessions&code=<?php echo $_GET["code"] ?>" target="_blank"><?php echo direction("Back to sessions","العودة للمحاضرات") ?></a></h6></p>
	<h6 class="panel-title txt-dark"><?php echo direction("Subscription Details","تفاصيل الإشتراك") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-12">
			<label><?php echo direction("Select Subscription","إختر الإشتراك") ?></label>
			<select name="subscriptionId" class="form-control" required>
                <?php
                if( $subscriptionsList = selectDB("subscriptions","`status` = '0' AND `hidden` = '0' AND `academyId` LIKE '{$_GET["code"]}' ORDER BY `id` ASC") ){
                    for( $i =0; $i < sizeof($subscriptionsList); $i++ ){
                        $title = direction($subscriptionsList[$i]["enTitle"],$subscriptionsList[$i]["arTitle"]);
                        echo "<option value='{$subscriptionsList[$i]["id"]}'>{$title}</option>";
                    }
                }
                ?>
            </select>
			</div>
			
			<div class="col-md-12" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="0">
            <input type="hidden" name="academyId" value="<?php echo $_GET["code"] ?>">
            <input type="hidden" name="sessionId" value="<?php echo $_GET["sessionId"] ?>">
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Subscriptions","قائمة الإشتراكات") ?></h6>
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
		<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		$orderBy = direction("enTitle","arTitle");
		if( $sessions = selectDB("session_subscription","`status` = '0' AND `academyId` LIKE '{$_GET["code"]}' AND `sessionId` LIKE '{$_GET["sessionId"]}' ORDER BY `{$orderBy}` ASC") ){
			for( $i = 0; $i < sizeof($sessions); $i++ ){
                $subscription = selectDB("subscriptions","`id` = '{$sessions[$i]["subscriptionId"]}'");
				if ( $sessions[$i]["hidden"] == 1 ){
					$icon = "fa fa-eye";
					$link = "?show={$sessions[$i]["id"]}";
					$hide = direction("Show","أظهر");
				}else{
					$icon = "fa fa-eye-slash";
					$link = "?hide={$sessions[$i]["id"]}";
					$hide = direction("Hide","إخفاء");
				}
				?>
				<tr>
				<td><?php echo $counter = $i + 1 ?></td>
				<td id="enTitle<?php echo $subscription[0]["id"]?>" ><?php echo $subscription[0]["enTitle"] ?></td>
				<td id="arTitle<?php echo $subscription[0]["id"]?>" ><?php echo $subscription[0]["arTitle"] ?></td>
				<td class="text-nowrap">
					<a href="<?php echo "?delId={$sessions[$i]["id"]}&v={$_GET["v"]}&code={$_GET["code"]}&sessionId={$_GET["sessionId"]}" ?>" class="btn btn-danger" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"> <i class="fa fa-times text-inverse m-r-10"></i></a>			
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