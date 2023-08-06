<?php
if ( $social_media = selectDB("social_media","`id` = '1'") ){
	$array = ["whatsapp","snapchat","instagram","location","tiktok","email"];
}
?>
<div class="col-sm-12 col-xs-12">
<div class="form-wrap">
<form action="?update=1" method="POST">
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="zmdi zmdi-account mr-10"></i><?php echo $sMediaText ?>
</h6>
<hr class="light-grey-hr"/>
<div class="row">

<?php 
for( $i =0; $i < sizeof($array); $i++ ){
?>
	<div class="col-md-6">
	<div class="form-group">
	<label class="control-label mb-10"><?php echo strtoupper($array[0]) ?></label>
	<input type="text" name="<?php echo strtolower($array[0]) ?>" class="form-control" value="<?php echo $social_media[0][$array[0]] ?>"  >
	</div>
	</div>
<?php
}
?>
<div class="col-md-6">
<div class="form-group">
<button type="submit" class="btn btn-success  mr-10"><?php echo $save ?></button>
<input type="hidden" name="update" class="form-control" value="1"  >
</div>
</div>

</div>
</div>
</form>
</div>
</div>