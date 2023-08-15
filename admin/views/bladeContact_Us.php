<!-- Bordered Table -->
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Messages","قائمة الرسائل") ?></h6>
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
		<th><?php echo direction("Title","العنوان") ?></th>
		<th><?php echo direction("Email","البريد الإلكتروني") ?></th>
		<th><?php echo direction("Phone","الهاتف") ?></th>
		<th><?php echo direction("Message","الرسالة") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $contacts = selectDB("contact_us","`status` = '0' ORDER BY `id` ASC") ){
			for( $i = 0; $i < sizeof($contacts); $i++ ){
				$counter = $i + 1;
				?>
				<tr>
				<td id="title<?php echo $contacts[$i]["id"]?>" ><?php echo $contacts[$i]["title"] ?></td>
				<td id="email<?php echo $contacts[$i]["id"]?>" ><?php echo $contacts[$i]["email"] ?></td>
				<td id="phone<?php echo $contacts[$i]["id"]?>" ><?php echo $contacts[$i]["phone"] ?></td>
				<td id="message<?php echo $contacts[$i]["id"]?>" ><?php echo $contacts[$i]["message"] ?></td>
				<td class="text-nowrap">
					<a href="?delId=<?php echo $contacts[$i]["id"] . "&v={$_GET["v"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف")  ?>" class="btn btn-danger"><i class="fa fa-close text-inverse"></i>
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
	<!-- JavaScript -->