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
		</tr>
		</thead>
		<tbody>
		<?php 
        $joinData = array(
            "select" => ["t.enTitle","t.arTitle","t.area","t.gender","t1.areaEnTitle","t1.areaArTitle"],
            "join" => ["countries"],
            "on" => ["t.area = t1.id"]
        );
        // add where to the quesy to check if the data passed 30 days or not
			if( $academies = selectJoinDB("academies",$joinData,"NOT EXISTS (SELECT 1 FROM orders oWHERE o.academyId = a.id AND o.status IN ('1','4') AND o.tournamentId = '0' AND o.date > DATE_SUB(NOW(), INTERVAL 30 DAY))") ){
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
					<td><?php echo direction($academies[$i]["enTitle"],$academies[$i]["arTitle"]) ?></td>
					<td><?php echo direction($academies[$i]["areaEnTitle"],$academies[$i]["areaArTitle"]) ?></td>
					<td><?php echo $gendersList[$academies[$i]["gender"]] ?></td>
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