<?php
if( isset($_GET["status"]) && isset($_GET["id"]) && !empty($_GET["status"]) && !empty($_GET["id"]) ){
    $id = $_GET["id"];
    $status = $_GET["status"];
    if( $status == "1" ){
        if( $modify = selectDB("modifications","id = '{$id}'") ){
            $contents = json_decode($modify[0]["contents"],true);
            if( $modify[0]["postId"] != "0" ){
                updateDB("{$modify[0]["tableTitle"]}",$contents,"`id` = '{$modify[0]["postId"]}'");
            }else{
                insertDB("{$modify[0]["tableTitle"]}",$contents);
            }
            $data = array(
                "status" => "1",
            );
            updateDB("modifications",$data,"id = '$id'");
        }
    }elseif( $status == "2" ){
        $data = array(
            "status" => "2",
        );
        updateDB("modifications",$data,"id = '$id'");
    }else{
        ?>
        <script>
            alert(<?php echo direction("Please select the update to approve or cancel", "الرجاء تحديد التحديث للموافقة او الغاء") ?>);
            window.location.href = "?v=AppUpdates";
        </script>
        <?php
    }
}else{
    ?>
    <script>
        alert(<?php echo direction("Please select the update to approve or cancel", "الرجاء تحديد التحديث للموافقة او الغاء") ?>);
        window.location.href = "?v=AppUpdates";
    </script>
    <?php
}
?>
<style>
    .comparison-container {
        display: flex;
        width: 100%;
    }
    .comparison-column {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        margin: 5px;
    }
    .comparison-column h4 {
        margin-bottom: 15px;
        border-bottom: 1px solid #eee;
        padding-bottom: 5px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .control-label {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }
    .modal-body {
        max-height: 500px;
        overflow-y: auto;
    }
</style>
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Updates", "قائمة التحديثات") ?></h6>
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
		<th><?php echo direction("Type","النوع") ?></th>
		<th><?php echo direction("Where","من") ?></th>
		<th><?php echo direction("Action","العملية") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
        $dataJoin = array(
            "select" => ["t.*","t1.fullName"],
            "join" => ["employees"],
            "on" => ["t.empId = t1.id"],
        );
            if( $modifications = selectJoinDB("modifications",$dataJoin,"t.status = '0' AND t.hidden = '0' ORDER BY t.id DESC") ){
                for( $i = 0; $i < sizeof($modifications); $i++ ){
                    $type = ( $modifications[$i]["postId"] == "0" ) ? "New" : "Update";
                ?>
                    <tr>
                    <td><?php echo sprintf("%05d", $modifications[$i]["id"]) ?></td>
                    <td><?php echo $modifications[$i]["date"] ?></td>
                    <td><?php echo $modifications[$i]["fullName"] ?></td>
                    <td><?php echo $type ?></td>
                    <td><?php echo $modifications[$i]["tableTitle"] ?></td>
                    <td>
                        <a onclick='showUpdate(<?php echo $modifications[$i]["id"] ?>)' class="btn btn-warning"><?php echo direction("Show","اظهار") ?></a>
                        <a href="<?php echo "?v={$_GET["v"]}&id={$modifications[$i]["id"]}&status=1" ?>" class="btn btn-success"><?php echo direction("Approve","موافقة" ) ?></a>
                        <a href="<?php echo "?v={$_GET["v"]}&id={$modifications[$i]["id"]}&status=2" ?>" class="btn btn-danger"><?php echo direction("Cancel","الغاء") ?></a>
                        <div style="display: none;" id="new<?php echo $modifications[$i]["id"]?>">
                            <div class="comparison-column old-data">
                                <h4><?php echo direction("Previous Data", "البيانات السابقة") ?></h4>
                                <?php
                                $data = json_decode($modifications[$i]["oldContents"], true);
                                ksort($data);unset($data["status"]);unset($data["hidden"]);
                                foreach ($data as $key => $value) {
                                    echo "<div class='form-group'>";
                                    if (is_array($value)) {
                                        echo "<label class='control-label'><strong>$key</strong></label>";
                                        foreach ($value as $item) {
                                            echo "<input type='text' readonly value='$item' class='form-control'>";
                                        }
                                    } else {
                                        echo "<label class='control-label'><strong>$key</strong></label>";
                                        if ($key == 'arTerms' || $key == 'enTerms') {
                                            echo "<div class='form-control' style='height:auto;min-height:34px;'>$value</div>";
                                        } elseif ($key == 'imageurl' || $key == 'locationImage' || $key == 'header' || $key == 'clothesImage') {
                                            echo "<img src='../logos/$value' alt='$key' class='img-responsive' style='max-width: 100%; height: auto;'>";
                                        } else {
                                            echo "<input type='text' readonly value='$value' class='form-control'>";
                                        }
                                    }
                                    echo "</div>";
                                }
                                ?>
                            </div>
                            <div class="comparison-column new-data">
                                <h4><?php echo direction("New Data", "البيانات الجديدة") ?></h4>
                                <?php
                                $data = json_decode($modifications[$i]["contents"], true);
                                ksort($data);
                                foreach ($data as $key => $value) {
                                    echo "<div class='form-group'>";
                                    if (is_array($value)) {
                                        echo "<label class='control-label'><strong>$key</strong></label>";
                                        foreach ($value as $item) {
                                            echo "<input type='text' readonly value='$item' class='form-control'>";
                                        }
                                    } else {
                                        echo "<label class='control-label'><strong>$key</strong></label>";
                                        if ($key == 'arTerms' || $key == 'enTerms') {
                                            echo "<div class='form-control' style='height:auto;min-height:34px;'>$value</div>";
                                        } elseif ($key == 'imageurl' || $key == 'locationImage' || $key == 'header' || $key == 'clothesImage') {
                                            echo "<img src='../logos/$value' alt='$key' class='img-responsive' style='max-width: 100%; height: auto;'>";
                                        } else {
                                            echo "<input type='text' readonly value='$value' class='form-control'>";
                                        }
                                    }
                                    echo "</div>";
                                }
                                ?>
                            </div>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo direction("Comparison", "مقارنة") ?></h4>
      </div>
      <div class="modal-body">
        <table id="modal-example-1" class="table" data-paging="true" data-filtering="true" data-sorting="true"></table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
function showUpdate(id){
    var newContent = document.getElementById("new"+id).innerHTML;
    document.querySelector(".modal-body").innerHTML = '<div class="row comparison-container">' + newContent + '</div>';
    $('#myModal').modal('show');
}
</script>