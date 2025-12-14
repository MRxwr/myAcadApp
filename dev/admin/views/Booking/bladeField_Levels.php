<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Level Details","تفاصيل المستوى") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			    <label><?php echo direction("English Title","العنوان الإنجليزي") ?></label>
			    <input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			    <label><?php echo direction("Arabic Title","العنوان العربي") ?></label>
			    <input type="text" name="arTitle" class="form-control" required>
			</div>

            <div class="col-md-6">
			    <label><?php echo direction("English Details","التفاصيل الإنجليزية") ?></label>
			    <input type="text" name="enDetails" class="form-control" required>
			</div>

            <div class="col-md-6">
			    <label><?php echo direction("Arabic Details","التفاصيل العربية") ?></label>
			    <input type="text" name="arDetails" class="form-control" required>
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Levels","قائمة المستويات") ?></h6>
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
		<th><?php echo direction("English Title","العنوان") ?></th>
		<th><?php echo direction("Arabic Title","الرابط") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $levels = selectDB("field_levels","`status` = '0' ORDER BY `id` ASC") ){
            $counter = 1;
            for( $i = 0; $i < sizeof($levels); $i++ ){
                if ( $levels[$i]["hidden"] == 1 ){
                    $icon = "fa fa-eye";
                    $link = "?show={$levels[$i]["id"]}";
                    $hide = direction("Show","إظهار");
                }else{
                    $icon = "fa fa-eye-slash";
                    $link = "?hide={$levels[$i]["id"]}";
                    $hide = direction("Hide","إخفاء");
                }
            ?>
            <tr>
            <td><?php echo $counter++; ?></td>
            <td id="enTitle<?php echo $levels[$i]["id"]?>" ><?php echo $levels[$i]["enTitle"] ?></td>
            <td id="arTitle<?php echo $levels[$i]["id"]?>" ><?php echo $levels[$i]["arTitle"] ?></td>
            <td class="text-nowrap">
                <a id="<?php echo $levels[$i]["id"] ?>" class="edit btn btn-warning" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل")  ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                <a href="<?php echo $link . "&v={$_GET["v"]}&code={$_GET["code"]}" ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i></a>
                <a href="?delId=<?php echo $levels[$i]["id"] . "&v={$_GET["v"]}&code={$_GET["code"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>" class="btn btn-danger"><i class="fa fa-close text-inverse"></i></a>
                <div style="display:none">
                    <span id="enDetails<?php echo $levels[$i]["id"]?>" ><?php echo $levels[$i]["enDetails"] ?></span>
                    <span id="arDetails<?php echo $levels[$i]["id"]?>" ><?php echo $levels[$i]["arDetails"] ?></span>
                </div>
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
        $("input[name=enDetails]").val($("#enDetails"+id).html());
        $("input[name=arDetails]").val($("#arDetails"+id).html());
    })
</script>