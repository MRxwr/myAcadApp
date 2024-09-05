<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("Send Notification","أرسل إشعار") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="row">
<div class="col-sm-12 col-xs-12">
<div class="form-wrap">

<form action="" method="post" enctype="multipart/form-data">
    <div class="col-md-4">
    <div class="form-group">
    <label class="control-label mb-10" for="exampleInputuname_1"><?php echo direction("Title","العنوان") ?></label>
    <div class="input-group">
    <div class="input-group-addon"><i class="fa fa-file"></i></div>
    <input type="text" class="form-control" name="firebaseTitle" required>
    </div>
    </div>
    </div>	

    <div class="col-md-4">
    <div class="form-group">
    <label class="control-label mb-10" for="exampleInputuname_1"><?php echo direction("Message","الرسالة") ?></label>
    <div class="input-group">
    <div class="input-group-addon"><i class="fa fa-file"></i></div>
    <input type="text" class="form-control" name="firebaseMsg" required>
    </div>
    </div>
    </div>	

    <div class="col-md-12">
    <button type="submit" class="btn btn-success mr-10"><?php echo direction("Submit","أرسل") ?></button>
    </div>
</form>

</div>
</div>
</div>
</div>
</div>
</div>
</div>