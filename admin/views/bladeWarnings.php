<!-- Bordered Table -->
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Academies","قائمة الأكاديمات") ?></h6>
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
		<th><?php echo direction("Title","العنوان") ?></th>
		<th><?php echo direction("Area","المنطقة") ?></th>
		<th><?php echo direction("Gender","الجنس") ?></th>
        <th><?php echo direction("Date of last subscription","تاريخ اخر اشتراك") ?></th>
        <th><?php echo direction("Last Invoice ID","رقم آخر فاتورة") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		<tbody>
		<?php 
        $joinData = array(
            "select" => ["t.arAcademy","t.enAcademy","MAX(t.id) as id","t.date","t1.area","t1.gender","t2.areaEnTitle","t2.areaArTitle"],
            "join" => ["academies","countries"],
            "on" => ["t.academyId = t1.id","t1.area = t2.id"]
        );
        // add where to the quesy to check if the data passed 30 days or not
			if( $academies = selectJoinDB("orders",$joinData,"t.date <= DATE_SUB(NOW(), INTERVAL 30 DAY) AND t.status IN ('1','4') AND t.tournamentId = '0' GROUP BY t.academyId ORDER BY t.id DESC") ){
                $gendersList = array(
                    "1" => direction("Man","رجل"),
                    "2" => direction("Woman","إمرأه"),
                    "3" => direction("Boy","ولد"),
                    "4" => direction("Girl","بنت"),
                    "5" => direction("Mix Adults","مختلط الكبار"),
                    "6" => direction("Mix Children","مختلط الاطفال"),
                );
				for( $i = 0; $i < sizeof($academies); $i++ ){
					?>
					<tr>
					<td><?php echo str_pad(1 + $i, 5 ,'0', STR_PAD_LEFT) ?></td>
					<td><?php echo direction($academies[$i]["enAcademy"],$academies[$i]["arAcademy"]) ?></td>
					<td><?php echo direction($academies[$i]["areaEnTitle"],$academies[$i]["areaArTitle"]) ?></td>
					<td><?php echo $gendersList[$academies[$i]["gender"]] ?></td>
					<td><?php echo $academies[$i]["date"] ?></td>
					<td><?php echo $academies[$i]["id"] ?></td>
					<td class="text-nowrap">
						<a href="?v=Order&id=<?php echo $academies[$i]["id"] ?>" class="btn btn-primary"><?php echo direction("View","إعرض") ?></a>
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