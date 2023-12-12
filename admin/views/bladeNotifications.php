<?php
//require('../admin/includes/config.php');
if ( isset($_POST["title"]) ){
    if( $users = selectDB("users","`id` != '0' GROUP BY `firebase`")){
        for( $i = 0; $i < sizeof($users); $i++ ){
            $_POST["firebase"] = $users["firebase"] ;
            sendNotification($_POST);
        }
    }
}
?>
<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark">Send Notification</h6>
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
    <label class="control-label mb-10" for="exampleInputuname_1">Title</label>
    <div class="input-group">
    <div class="input-group-addon"><i class="fa fa-file"></i></div>
    <input type="text" class="form-control" name="title" required>
    </div>
    </div>
    </div>	

    <div class="col-md-4">
    <div class="form-group">
    <label class="control-label mb-10" for="exampleInputuname_1">Message</label>
    <div class="input-group">
    <div class="input-group-addon"><i class="fa fa-file"></i></div>
    <input type="text" class="form-control" name="msg" required>
    </div>
    </div>
    </div>	

    <div class="col-md-12">
    <button type="submit" class="btn btn-success mr-10">Submit</button>
    </div>
</form>

</div>
</div>
</div>
</div>
</div>
</div>
</div>