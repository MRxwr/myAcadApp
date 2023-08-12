<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("User Details","تفاصيل العضو") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="?v=<?php echo $_GET["v"] ?>" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-4">
			<label><?php echo direction("First Name","الإسم الأول") ?></label>
			<input type="text" name="firstName" class="form-control" required>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Last Name","الإسم الأخير") ?></label>
			<input type="text" name="lastName" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Email","البريد الإلكتروني") ?></label>
			<input type="text" name="email" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Password","كلمة المرور") ?></label>
			<input type="text" name="password" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Gender","الجنس") ?></label>
			<select name="gender" class="form-control">
				<?php
				$gender = [direction("Male","ذكر"),direction("Female","أنثى")];
				$genderValue = [1,2];
				for( $i = 0; $i < sizeof($genderValue); $i++){
					echo "<option value='{$genderValue[$i]}'>{$gender[$i]}</option>";
				?>
				<?php
				}
				?>
			</select>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Mobile","الهاتف") ?></label>
			<input type="number" min="0" maxlength="8" name="phone" class="form-control" required>
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
	<div class="pull-left"><h6 class="panel-title txt-dark"><?php echo direction("List of Users","قائمة الأعضاء") ?></h6></div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th><?php echo direction("First Name","الإسم الأول") ?></th>
		<th><?php echo direction("Last Name","الإسم الأخير") ?></th>
		<th><?php echo direction("Email","الإيميل") ?></th>
		<th><?php echo direction("Mobile","الهاتف") ?></th>
		<th><?php echo direction("Gender","الجنس") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $users = selectDB("users","`status` = '0' AND `hidden` != '2'") ){
			for( $i = 0; $i < sizeof($users); $i++ ){
				$counter = $i + 1;
				if ( $users[$i]["hidden"] == 1 ){
					$icon = "fa fa-unlock";
					$link = "?v={$_GET["v"]}&show={$users[$i]["id"]}";
					$hide = direction("Unlock","فتح الحساب");
				}else{
					$icon = "fa fa-lock";
					$link = "?v={$_GET["v"]}&hide={$users[$i]["id"]}";
					$hide = direction("Lock","قفل الحساب");
				}

				$userGender = ( $users[$i]["gender"] == 1 ) ? direction("Male","ذكر") : ( ( $users[$i]["gender"] == 2 ) ? direction("Female","أنثى") : direction("Not submitted","لا يوجد") );
				
				?>
				<tr>
				<td id="firstName<?php echo $users[$i]["id"]?>" ><?php echo $users[$i]["firstName"] ?></td>
				<td id="lastName<?php echo $users[$i]["id"]?>" ><?php echo $users[$i]["lastName"] ?></td>
				<td id="email<?php echo $users[$i]["id"]?>" ><?php echo $users[$i]["email"] ?></td>
				<td id="mobile<?php echo $users[$i]["id"]?>" ><?php echo $users[$i]["phone"] ?></td>
				<td><?php echo $userGender ?><label id="gender<?php echo $users[$i]["id"]?>" style="display:none"><?php echo $users[$i]["gender"] ?></label></td>
				<td class="text-nowrap">
				<a id="<?php echo $users[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
				</a>
				<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
				</a>
				<a href="<?php echo "?v={$_GET["v"]}&delId=" . $users[$i]["id"] ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
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
<script>
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		var email = $("#email"+id).html();
		var fName = $("#firstName"+id).html();
		var lName = $("#lastName"+id).html();
		var mobile = $("#mobile"+id).html();
		var gender = $("#gender"+id).html();
		$("input[name=password]").prop("required",false);
		$("input[name=email]").val(email);
		$("input[name=phone]").val(mobile);
		$("select[name=gender]").val(gender);
		$("input[name=update]").val(id);
		$("input[name=firstName]").val(fName);
		$("input[name=firstName]").focus();
		$("input[name=lastName]").val(lName);
	})
</script>

