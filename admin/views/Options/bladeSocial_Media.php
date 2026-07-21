<?php
if ( $social_media = selectDB("social_media","`id` = '1'") ){
	$array = ["youtube","whatsapp","snapchat","instagram","location","tiktok","email"];
}
?>
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Social Media Accounts", "حسابات السوشال ميديا") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
		<?php 
		for( $i =0; $i < sizeof($array); $i++ ){
		?>
			<div class="col-md-6">
			<div class="form-group">
			<label class="control-label mb-10"><?php echo strtoupper($array[$i]) ?></label>
			<input type="text" name="<?php echo strtolower($array[$i]) ?>" class="form-control" value="<?php echo $social_media[0][$array[$i]] ?>"  >
			</div>
			</div>
		<?php
		}
		?>
		<div class="col-md-12">
		<div class="form-group">
		<button type="submit" class="btn btn-primary w-50"><?php echo direction("Update","تعديل") ?></button>
		<input type="hidden" name="update" class="form-control" value="1"  >
		</div>
		</div>
	</div>
	</form>
</div>
</div>
</div>
</div>