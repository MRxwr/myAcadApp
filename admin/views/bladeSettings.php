<?php
if( $settings = selectDB("settings","`id` = '1'")){

}
?>
<!-- Title -->
<div class="row heading-bg">
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
<h5 class="txt-dark">Application Settings</h5>
</div>
</div>
<!-- /Title -->

<!-- Row -->
<form method="post" action="" enctype="multipart/form-data">
<div class="row w-100">
<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("System", "النظام") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">

	<!-- system Title -->
	<div class="col-md-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Version</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="version" placeholder="1.0.0" value="<?php echo $settings[0]["version"] ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- system en terms -->
	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">English Terms</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="enTerms" placeholder="1.0.0" value="<?php echo $settings[0]["enTerms"] ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- system ar Terms -->
	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Arabic Terms</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="arTerms" placeholder="1.0.0" value="<?php echo $settings[0]["arTerms"] ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- system en policy -->
	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">English Policy</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="enPolicy" placeholder="1.0.0" value="<?php echo $settings[0]["enPolicy"] ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- system ar polcy -->
	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Arabic Policy</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="arPolicy" placeholder="1.0.0" value="<?php echo $settings[0]["arPolicy"] ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
</div>
</div>
</div>

<div class="col-md-12">
	<div class="panel panel-default card-view">
		<div class="panel-heading">
			<div class="pull-left">
				<h6 class="panel-title txt-dark">When Done Submit</h6>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-wrapper collapse in">
			<div class="panel-body">
				<div class="text">
					<input class="form-control btn btn-primary txt-light" type="submit" name="submit" value="Update">
					<input type="hidden" name="update" value="1">
				</div>
			</div>
		</div>
	</div>
</div>

</div>
</form>