<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Facility Details","تفاصيل المرفق") ?></h6>
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
			    <label><?php echo direction("Icon","الأيقونة") ?></label>
			    <input type="file" name="icon" class="form-control" required>
			</div>

            <div class="col-md-6">
			    <label><?php echo direction("Current Icon","الأيقونة الحالية") ?></label>
                <br>
                <img id="iconPreview" src="" style="width:150px;height:150px;display:none;">
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Facilities","قائمة المرفقات") ?></h6>
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
        <th><?php echo direction("Icon","الأيقونة") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $facilities = selectDB("field_facilities","`status` = '0' ORDER BY `id` ASC") ){
            $counter = 1;
            for( $i = 0; $i < sizeof($facilities); $i++ ){
                if ( $facilities[$i]["hidden"] == 1 ){
                    $icon = "fa fa-eye";
                    $link = "?show={$facilities[$i]["id"]}";
                    $hide = direction("Show","إظهار");
                }else{
                    $icon = "fa fa-eye-slash";
                    $link = "?hide={$facilities[$i]["id"]}";
                    $hide = direction("Hide","إخفاء");
                }
            ?>
            <tr>
            <td><?php echo $counter++; ?></td>
            <td id="enTitle<?php echo $facilities[$i]["id"]?>" ><?php echo $facilities[$i]["enTitle"] ?></td>
            <td id="arTitle<?php echo $facilities[$i]["id"]?>" ><?php echo $facilities[$i]["arTitle"] ?></td>
            <td><img src="../logos/facilities/<?php echo $facilities[$i]["icon"] ?>" style="width:50px;height:50px;"></td>
            <td class="text-nowrap">
                <a id="<?php echo $facilities[$i]["id"] ?>" class="edit btn btn-warning" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل")  ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                <a href="<?php echo $link . "&v={$_GET["v"]}" ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i></a>
                <a href="?delId=<?php echo $facilities[$i]["id"] . "&v={$_GET["v"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>" class="btn btn-danger"><i class="fa fa-close text-inverse"></i></a>
                <div style="display:none">
                    <span id="icon<?php echo $facilities[$i]["id"]?>" ><?php echo $facilities[$i]["icon"] ?></span>
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
        $("#iconPreview").attr("src", "../logos/facilities/" + $("#icon"+id).html()).show();
    })
</script>