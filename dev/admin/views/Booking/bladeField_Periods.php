<?php
if( !isset($_GET["code"]) || empty($_GET["code"]) || !is_numeric($_GET["code"])  ){
    echo "<script>window.location='?v=Fields_List'</script>";
    die();
}else{
    $fieldDetails = selectDBNew("fields_list",[$_GET["code"]],"`id` = ?","");
}
?>
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Period Details","تفاصيل الفترة") ?></h6>
</div>
<div class="pull-right">
	<h6 class="panel-title txt-dark"><?php echo direction($fieldDetails[0]["enTitle"], $fieldDetails[0]["arTitle"]) ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-4">
			    <label><?php echo direction("English Title","العنوان الإنجليزي") ?></label>
			    <input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			    <label><?php echo direction("Arabic Title","العنوان العربي") ?></label>
			    <input type="text" name="arTitle" class="form-control" required>
			</div>

			<div class="col-md-4">
			    <label><?php echo direction("Period In Minutes","مدة الفترة بالدقائق") ?></label>
			    <input type="number" step="1" name="period" class="form-control" required>
			</div>
			
			<div class="col-md-12" style="margin-top:10px">
			    <input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
				<input type="hidden" name="update" value="0">
				<input type="hidden" name="fieldId" value="<?php echo $_GET["code"] ?>">
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Periods","قائمة الفترات") ?></h6>
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
		<th><?php echo direction("English Title","العنوان") ?></th>
		<th><?php echo direction("Arabic Title","الرابط") ?></th>
		<th><?php echo direction("Period In Minutes","مدة الفترة بالدقائق") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $periods = selectDB("fields_periods","`status` = '0' ORDER BY `id` ASC") ){
            for( $i = 0; $i < sizeof($periods); $i++ ){
                if ( $periods[$i]["hidden"] == 1 ){
                    $icon = "fa fa-eye";
                    $link = "?show={$periods[$i]["id"]}";
                    $hide = direction("Show","إظهار");
                }else{
                    $icon = "fa fa-eye-slash";
                    $link = "?hide={$periods[$i]["id"]}";
                    $hide = direction("Hide","إخفاء");
                }
            ?>
            <tr>
            <td id="enTitle<?php echo $periods[$i]["id"]?>" ><?php echo $periods[$i]["enTitle"] ?></td>
            <td id="arTitle<?php echo $periods[$i]["id"]?>" ><?php echo $periods[$i]["arTitle"] ?></td>
            <td id="period<?php echo $periods[$i]["id"]?>" ><?php echo $periods[$i]["period"] ?></td>
            <td class="text-nowrap">
                <a id="<?php echo $periods[$i]["id"] ?>" class="edit btn btn-warning" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل")  ?>"> 
                <a href="<?php echo $link . "&v={$_GET["v"]}" ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i></a>
                <a href="?delId=<?php echo $periods[$i]["id"] . "&v={$_GET["v"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>" class="btn btn-danger"><i class="fa fa-close text-inverse"></i></a>
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
        $("input[name=enTitle]").val($("#enTitle"+id).html()).focus();
        $("input[name=arTitle]").val($("#arTitle"+id).html());
        $("input[name=period]").val($("#period"+id).html());
    })
</script>