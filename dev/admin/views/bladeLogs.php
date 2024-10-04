<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Logs", "قائمة السجلات") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap">
<div class="table-responsive">

	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th>#</th>
		<th><?php echo direction("Date","التاريخ") ?></th>
		<th><?php echo direction("Username","اسم المستخدم") ?></th>
		<th><?php echo direction("Module","الوحدة") ?></th>
		<th><?php echo direction("Action","العملية") ?></th>
		<th><?php echo direction("Data","البيانات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
            if( $logs = selectDB("logs","`id` != '0' ") ){
                for( $i = 0; $i < sizeof($logs); $i++ ){
                ?>
                    <tr>
                    <td><?php echo sprintf("%05d", $logs[$i]["id"]) ?></td>
                    <td><?php echo $logs[$i]["date"] ?></td>
                    <td><?php echo $logs[$i]["username"] ?></td>
                    <td><?php echo $logs[$i]["module"] ?></td>
                    <td><?php echo $logs[$i]["action"] ?></td>
                    <td>
                        <?php
                        $data = json_decode($logs[$i]["sqlQuery"], true);
                        foreach ($data as $key => $value) {
                            if (is_array($value)) {
                                echo "<pre><code>$key :</code></pre>";
                                foreach ($value as $item) {
                                    echo "<pre><code>  - $item</code></pre>";
                                }
                            } else {
                                //echo "<pre><code>$key : $value</code></pre>";
                            }
                        }
                        ?>
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