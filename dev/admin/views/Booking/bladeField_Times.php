<?php
if( !isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"])  ){
    echo "<script>window.location='?v=Fields_List'</script>";
    die();
}
?>
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Day Details","تفاصيل اليوم") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-4">
			    <label><?php echo direction("Day","اليوم") ?></label>
                <select name="day" class="form-control" required>
                    <option value="0"><?php echo direction("Sunday","الأحد") ?></option>
                    <option value="1"><?php echo direction("Monday","الإثنين") ?></option>
                    <option value="2"><?php echo direction("Tuesday","الثلاثاء") ?></option>
                    <option value="3"><?php echo direction("Wednesday","الأربعاء") ?></option>
                    <option value="4"><?php echo direction("Thursday","الخميس") ?></option>
                    <option value="5"><?php echo direction("Friday","الجمعة") ?></option>
                    <option value="6"><?php echo direction("Saturday","السبت") ?></option>
                </select>
			</div>
			
			<div class="col-md-4">
			    <label><?php echo direction("openTime","وقت الفتح") ?></label>
			    <input type="time" name="openTime" class="form-control" required>
			</div>

			<div class="col-md-4">
			    <label><?php echo direction("closeTime","وقت الإغلاق") ?></label>
			    <input type="time" name="closeTime" class="form-control" required>
			</div>
			
			<div class="col-md-12" style="margin-top:10px">
			    <input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
				<input type="hidden" name="update" value="0">
				<input type="hidden" name="fieldId" value="<?php echo $_GET["id"] ?>">
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Days","قائمة الأيام") ?></h6>
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
		<th><?php echo direction("Day","اليوم") ?></th>
		<th><?php echo direction("Open Time","وقت الفتح") ?></th>
		<th><?php echo direction("Close Time","وقت الإغلاق") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $days = selectDB("fields_times","`status` = '0' ORDER BY `id` ASC") ){
            for( $i = 0; $i < sizeof($days); $i++ ){
                if ( $days[$i]["hidden"] == 1 ){
                    $icon = "fa fa-eye";
                    $link = "?show={$days[$i]["id"]}";
                    $hide = direction("Show","إظهار");
                }else{
                    $icon = "fa fa-eye-slash";
                    $link = "?hide={$days[$i]["id"]}";
                    $hide = direction("Hide","إخفاء");
                }
            ?>
            <tr>
            <td id="day<?php echo $days[$i]["id"]?>" ><?php echo $days[$i]["day"] ?></td>
            <td id="openTime<?php echo $days[$i]["id"]?>" ><?php echo $days[$i]["openTime"] ?></td>
            <td id="closeTime<?php echo $days[$i]["id"]?>" ><?php echo $days[$i]["closeTime"] ?></td>
            <td class="text-nowrap">
                <a id="<?php echo $days[$i]["id"] ?>" class="edit btn btn-warning" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل")  ?>"> 
                <a href="<?php echo $link . "&v={$_GET["v"]}" ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i></a>
                <a href="?delId=<?php echo $days[$i]["id"] . "&v={$_GET["v"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>" class="btn btn-danger"><i class="fa fa-close text-inverse"></i></a>
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
    $(document).on("click",".edit", function(){
        var id = $(this).attr("id");
        $("input[name=update]").val(id);
        $("input[name=day]").val($("#day"+id).html()).focus();
        $("input[name=openTime]").val($("#openTime"+id).html());
        $("input[name=closeTime]").val($("#closeTime"+id).html());
    })
</script>