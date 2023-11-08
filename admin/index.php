<?php 
require_once("template/header.php");
if ( isset($_GET["hide"]) || isset($_GET["show"]) || isset($_GET["delId"]) || isset($_POST["update"]) || isset($_POST["order"]) || isset($_POST["setDefaultPrice"]) ){
	$table = strtolower($_GET["v"]);
	if( strtolower($_GET["v"]) == "areas" ){
		$table = strtolower("countries");
	}
	if( isset($_GET["hide"]) && !empty($_GET["hide"]) && updateDB("{$table}",array('hidden'=> '1'),"`id` = '{$_GET["hide"]}'") ){
	}elseif( isset($_GET["show"]) && !empty($_GET["show"]) && updateDB("{$table}",array('hidden'=> '0'),"`id` = '{$_GET["show"]}'") ){
	}elseif( isset($_GET["delId"]) && !empty($_GET["delId"]) && updateDB("{$table}",array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
	}elseif( isset($_POST["setDefaultPrice"]) && !empty($_POST["setDefaultPrice"]) ){
        if( updateDB("{$table}",array('charges'=> $_POST["setDefaultPrice"]),"`id` != '0'") ){}
    }elseif( isset($_POST["update"]) ){
		$id = $_POST["update"];unset($_POST["update"]);
		if ( $id == 0 ){
            if( isset($_FILES['imageurl']) && is_uploaded_file($_FILES['imageurl']['tmp_name']) ){
                $directory = "../logos/";
                $originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). "L." . getFileExtension($_FILES["imageurl"]["name"]);
                move_uploaded_file($_FILES["imageurl"]["tmp_name"], $originalfile);
                $_POST["imageurl"] = str_replace("../logos/",'',$originalfile);
            }else{
                if ( isset($_FILES['imageurl']) ){
                    $_POST["imageurl"] = "";
                }
            }

            if( isset($_FILES['imageurl600']) && is_uploaded_file($_FILES['imageurl600']['tmp_name']) ){
                $directory = "../logos/";
                $originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). "L." . getFileExtension($_FILES["imageurl600"]["name"]);
                move_uploaded_file($_FILES["imageurl600"]["tmp_name"], $originalfile);
                $_POST["imageurl600"] = str_replace("../logos/",'',$originalfile);
            }else{
                if ( isset($_FILES['imageurl600']) ){
                    $_POST["imageurl600"] = "";
                }
            }
            
            if( isset($_FILES['locationImage']) && is_uploaded_file($_FILES['locationImage']['tmp_name']) ){
                $directory = "../logos/";
                $originalfile1 = $directory . date("d-m-y") . time() .  round(microtime(true)). "H." . getFileExtension($_FILES["header"]["name"]);
                move_uploaded_file($_FILES["locationImage"]["tmp_name"], $originalfile1);
                $_POST["locationImage"] = str_replace("../logos/",'',$originalfile1);
            }else{
                if ( isset($_FILES['locationImage']) ){
                    $_POST["locationImage"] = "";
                }
            }

            if( isset($_FILES['header']) && is_uploaded_file($_FILES['header']['tmp_name']) ){
                $directory = "../logos/";
                $originalfile1 = $directory . date("d-m-y") . time() .  round(microtime(true)). "H." . getFileExtension($_FILES["header"]["name"]);
                move_uploaded_file($_FILES["header"]["tmp_name"], $originalfile1);
                $_POST["header"] = str_replace("../logos/",'',$originalfile1);
            }else{
                if ( isset($_FILES['header']) ){
                    $_POST["header"] = "";
                }
            }
            
            if( isset($_FILES['clothesImage']) && is_uploaded_file($_FILES['clothesImage']['tmp_name']) ){
                $directory = "../logos/";
                $originalfile1 = $directory . date("d-m-y") . time() .  round(microtime(true)). "C." . getFileExtension($_FILES["clothesImage"]["name"]);
                move_uploaded_file($_FILES["clothesImage"]["tmp_name"], $originalfile1);
                $_POST["clothesImage"] = str_replace("../logos/",'',$originalfile1);
            }else{
                if ( isset($_FILES['clothesImage']) ){
                    $_POST["clothesImage"] = "";
                } 
            }
			
			if( isset($_POST["password"]) && !empty($_POST["password"]) ){
				$_POST["password"] = sha1($_POST["password"]);
			}
			
			if( insertDB("{$table}", $_POST) ){
			}else{
			?>
			<script>
				alert("Could not process your request, Please try again.");
			</script>
			<?php
			}
		}else{
            if( isset($_FILES['imageurl']) && is_uploaded_file($_FILES['imageurl']['tmp_name']) ){
                $directory = "../logos/";
                $originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). "L." . getFileExtension($_FILES["imageurl"]["name"]);
                move_uploaded_file($_FILES["imageurl"]["tmp_name"], $originalfile);
                $_POST["imageurl"] = str_replace("../logos/",'',$originalfile);
            }else{
                if( isset($_FILES['imageurl']) ){
                    $imageurl = selectDB("{$table}","`id` = '{$id}'");
                    $_POST["imageurl"] = $imageurl[0]["imageurl"];
                }
            }

            if( isset($_FILES['imageurl600']) && is_uploaded_file($_FILES['imageurl600']['tmp_name']) ){
                $directory = "../logos/";
                $originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). "L." . getFileExtension($_FILES["imageurl600"]["name"]);
                move_uploaded_file($_FILES["imageurl600"]["tmp_name"], $originalfile);
                $_POST["imageurl600"] = str_replace("../logos/",'',$originalfile);
            }else{
                if( isset($_FILES['imageurl600']) ){
                    $imageurl = selectDB("{$table}","`id` = '{$id}'");
                    $_POST["imageurl600"] = $imageurl[0]["imageurl600"];
                }
            }
            
            if( isset($_FILES['locationImage']) && is_uploaded_file($_FILES['locationImage']['tmp_name']) ){
                $directory = "../logos/";
                $originalfile1 = $directory . date("d-m-y") . time() .  round(microtime(true)). "H." . getFileExtension($_FILES["header"]["name"]);
                move_uploaded_file($_FILES["locationImage"]["tmp_name"], $originalfile1);
                $_POST["locationImage"] = str_replace("../logos/",'',$originalfile1);
            }else{
                if( isset($_FILES['locationImage']) ){
                    $locationImage = selectDB("{$table}","`id` = '{$id}'");
                    $_POST["locationImage"] = $locationImage[0]["locationImage"];
                } 
            }

            if( isset($_FILES['header']) && is_uploaded_file($_FILES['header']['tmp_name']) ){
                $directory = "../logos/";
                $originalfile1 = $directory . date("d-m-y") . time() .  round(microtime(true)). "H." . getFileExtension($_FILES["header"]["name"]);
                move_uploaded_file($_FILES["header"]["tmp_name"], $originalfile1);
                $_POST["header"] = str_replace("../logos/",'',$originalfile1);
            }else{
                if( isset($_FILES['header']) ){
                    $header = selectDB("{$table}","`id` = '{$id}'");
                    $_POST["header"] = $header[0]["header"];
                } 
            }
            
            if( isset($_FILES['clothesImage']) && is_uploaded_file($_FILES['clothesImage']['tmp_name']) ){
                $directory = "../logos/";
                $originalfile1 = $directory . date("d-m-y") . time() .  round(microtime(true)). "C." . getFileExtension($_FILES["clothesImage"]["name"]);
                move_uploaded_file($_FILES["clothesImage"]["tmp_name"], $originalfile1);
                $_POST["clothesImage"] = str_replace("../logos/",'',$originalfile1);
            }else{
                if( isset($_FILES['clothesImage']) ){
                    $clothesImage = selectDB("{$table}","`id` = '{$id}'");
                    $_POST["clothesImage"] = $clothesImage[0]["clothesImage"];
                } 
            }
			
			if( isset($_POST["password"]) && !empty($_POST["password"]) ){
				$_POST["password"] = sha1($_POST["password"]);
			}elseif( isset($_POST["password"]) && empty($_POST["password"]) ){
				if( $user = selectDB("{$table}","`id` = '{$id}'") ){
					$_POST["password"] = $user[0]["password"];
				}
			}
			
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
	if( isset($_GET["code"]) && !empty($_GET["code"]) ){
		$countryCode = "&code={$_GET["code"]}";
	}else{
		$countryCode = "";
	}
	?>
	<script>
		window.location.replace("<?php echo "?v={$_GET["v"]}{$countryCode}" ?>");
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