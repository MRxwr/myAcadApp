<?php 
require_once("template/header.php");

if ( isset($_GET["hide"]) || isset($_GET["show"]) || isset($_GET["delId"]) || isset($_POST["update"]) || isset($_POST["order"]) ){
	$table = strtolower($_GET["v"]);
	if( isset($_GET["hide"]) && !empty($_GET["hide"]) && updateDB("{$table}",array('hidden'=> '1'),"`id` = '{$_GET["hide"]}'") ){
	}elseif( isset($_GET["show"]) && !empty($_GET["show"]) && updateDB("{$table}",array('hidden'=> '0'),"`id` = '{$_GET["show"]}'") ){
	}elseif( isset($_GET["delId"]) && !empty($_GET["delId"]) && updateDB("{$table}",array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
	}elseif( isset($_POST["setDefaultPrice"]) && !empty($_POST["setDefaultPrice"]) ){
        if( updateDB("{$table}",array('charges'=> $_POST["setDefaultPrice"]),"`id` != '0'") ){}
    }elseif( isset($_POST["update"]) ){
		$id = $_POST["update"];
		unset($_POST["update"]);
		if ( $id == 0 ){
			if( insertDB("{$table}", $_POST) ){
			}else{
			?>
			<script>
				alert("Could not process your request, Please try again.");
			</script>
			<?php
			}
		}else{
			if( updateDB("{$table}", $_POST, "`id` = '{$id}'") ){
			}else{
			?>
			<script>
				alert("Could not process your request, Please try again.");
			</script>
			<?php
			}
		}
	}elseif( isset($_POST["order"]) ){
		for( $i = 0; $i < sizeof($_POST['id']); $i++ ){
			updateDB("{$table}",array("order"=>$_POST["order"][$i]),"`id` = '{$_POST["id"][$i]}'");
		}
	}
	?>
	<script>
		window.location.replace("<?php echo "?v={$_GET["v"]}" ?>");
	</script>
	<?php
}

// get viewed page from pages folder \\
if( isset($_GET["v"]) && searchFile("views","blade{$_GET["v"]}.php") ){
	require_once("views/".searchFile("views","blade{$_GET["v"]}.php"));
}else{
	require_once("views/bladeHome.php");
}

require("template/footer.php");
?>