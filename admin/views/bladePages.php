<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Page Details","تفاصيل الصفحة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">

            <div class="col-md-4">
                <label><?php echo direction("Section","التصنيف") ?></label>
                <select name="section" class="form-control">
                    <?php
                    if( $sections = selectDB("pages","`section` = '0'") ){
                        echo "<option value='0'>".direction("Main","رئيسي")."</option>";
                        for( $i = 0; $i < sizeof($sections); $i++){
                            echo "<option value='{$sections[$i]["id"]}'>".direction($sections[$i]["enTitle"],$sections[$i]["arTitle"])."</option>";
                        }
                    }else{
                        echo "<option value='0'>".direction("Main","رئيسي")."</option>";
                    }
                    ?>
                </select>
			</div>

			<div class="col-md-4">
			    <label><?php echo direction("English Title","العنوان الإنجليزي") ?></label>
			    <input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			    <label><?php echo direction("Arabic Title","العنوان العربي") ?></label>
			    <input type="text" name="arTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			    <label><?php echo direction("Icon","الأيقونه") ?></label>
			    <input type="text" name="icon" class="form-control" required>
			</div>

            <div class="col-md-6">
			    <label><?php echo direction("File name","إسم الملف") ?></label>
			    <input type="text" name="fileName" class="form-control" required>
			</div>
			
			<div class="col-md-6" style="margin-top:10px">
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
<form method="post" action="">
<input name="updateRank" type="hidden" value="1">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Pages","قائمة الصفحات") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<button class="btn btn-primary">
<?php echo direction("Submit rank","أرسل الترتيب") ?>
</button>  
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th><?php echo direction("Rank","الترتيب") ?></th>
		<th><?php echo direction("Section","العنوان") ?></th>
		<th><?php echo direction("English Title","العنوان") ?></th>
		<th><?php echo direction("Arabic Title","الرابط") ?></th>
		<th><?php echo direction("Icon","الصورة") ?></th>
        <th><?php echo direction("File Name","الرابط") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $pages = selectDB("pages","`status` = '0' ORDER BY `order` ASC") ){
		for( $i = 0; $i < sizeof($pages); $i++ ){
            if ($section = selectDB("pages","`id` = '{$pages[$i]["section"]}'") ){
            }else{
                $section[0]["enTitle"] = "Main";
                $section[0]["arTitle"] = "رئيسي";
            }
            if ( $pages[$i]["hidden"] == 1 ){
                $icon = "fa fa-eye";
                $link = "?show={$pages[$i]["id"]}";
                $hide = direction("Show","إظهار");
            }else{
                $icon = "fa fa-eye-slash";
                $link = "?hide={$pages[$i]["id"]}";
                $hide = direction("Hide","إخفاء");
            }
		?>
		<tr>
		<td>
            <input name="order[]" class="form-control" type="number" value="<?php echo $pages[$i]["order"] ?>">
            <input name="id[]" class="form-control" type="hidden" value="<?php echo $pages[$i]["id"] ?>">
		</td>
		<td id="section<?php echo $pages[$i]["id"]?>" ><?php echo direction($section[0]["enTitle"],$section[0]["arTitle"]) ?><label id="sectionHidden<?php echo $pages[$i]["id"]?>" style="display:none"><?php echo $pages[$i]["section"]?></label></td>
		<td id="enTitle<?php echo $pages[$i]["id"]?>" ><?php echo $pages[$i]["enTitle"] ?></td>
		<td id="arTitle<?php echo $pages[$i]["id"]?>" ><?php echo $pages[$i]["arTitle"] ?></td>
		<td id="icon<?php echo $pages[$i]["id"]?>" ><label class="<?php echo $pages[$i]["icon"] ?>"></label><label id="iconHidden<?php echo $pages[$i]["id"]?>" style="display:none"><?php echo $pages[$i]["icon"] ?></label></td>
		<td id="fileName<?php echo $pages[$i]["id"]?>" ><?php echo $pages[$i]["fileName"] ?></td>
		<td class="text-nowrap">
		
		<a id="<?php echo $pages[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo $link . "&v={$_GET["v"]}" ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
		</a>
		<a href="?delId=<?php echo $pages[$i]["id"] . "&v={$_GET["v"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i>
		</a>
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
</form>
	
	<script>
		$(document).on("click",".edit", function(){
			var id = $(this).attr("id");
            $("input[name=update]").val(id);
			var enTitle = $("#enTitle"+id).html();
			var arTitle = $("#arTitle"+id).html();
			var section = $("#sectionHidden"+id).html();
			var icon = $("#iconHidden"+id).html();
			var fileName = $("#fileName"+id).html();
			$("input[name=enTitle]").val(enTitle).focus();
			$("input[name=arTitle]").val(arTitle);
			$("input[name=icon]").val(icon);
			$("input[name=fileName]").val(fileName);
			$("select[name=section]").val(section);
		})
	</script>