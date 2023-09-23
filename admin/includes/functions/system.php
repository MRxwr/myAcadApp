<?php
// user \\
function getLoginStatus(){
	$output = "";
	echo $_COOKIE["createmyacad"];
	if( isset($_COOKIE["createmyacad"]) && !empty($_COOKIE["createmyacad"]) && $user = selectDB("users","`keepMeAlive` LIKE '{$_COOKIE["createmyacad"]}'") ){
		$output = "<a href='?v=Logout' class='button'>".direction("Logout","تسجيل الخروج")."</a>";
	}else{
		$output = "<a href='?v=Login' class='button'>".direction("Login","تسجيل الدخول")."</a>";
	}
	return $output;
}

// user login Status Response \\
function getLoginStatusResponse(){
	$output = "";
	if( isset($_COOKIE["createmyacad"]) && !empty($_COOKIE["createmyacad"]) && $user = selectDB("users","`keepMeAlive` LIKE '{$_COOKIE["createmyacad"]}'") ){
		return $user[0]["id"];
	}else{
		return 0;
	}
}

// user login \\
function userLogin($data){
	if ( $user = selectDB("users","`email` LIKE '{$data["email"]}' AND `password` LIKE '".sha1($data["password"])."' AND `status` = '0' AND `hidden` = '0'") ){
		$randomCookie = sha1(rand(000000,999999)+time());
		setcookie("createmyacad", $randomCookie, time() + (86400*30 ), "/");
		$user_id = $user[0]["id"];
		setcookie("loggedin_user_id", $user_id, time() + (86400*30 ), "/");
		if( updateDB("users",array('keepMeAlive' => $randomCookie),"`id` = '{$user[0]["id"]}'") ){
			return 1;
		}else{
			return 0;
		}
	}else{
		return 0;
	}
}

// forget password \\ 
function forgetPass($data){
	GLOBAL $settingsTitle, $settingslogo, $settingsWebsite, $settingsEmail;
	$domainName = strstr($settingsWebsite, '.', true);
	$domainName = substr($domainName, strpos($domainName, '//') + 2);
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'myid.createkwservers.com/api/v1/send/notify',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => array(
			'site' => "{$settingsTitle}",
			'subject' => "Forget Password - {$settingsTitle}",
			'body' => "<center>
					<img src='{$settingsWebsite}/logos/{$settingslogo}' style='width:200px;height:200px'>
					<p>&nbsp;</p>
					<p>Dear {$data["email"]},</p>
					<p>Your new password at {$settingsWebsite} is:<br>
					</p>
					<p style='font-size: 25px; color: red'><strong>{$data["password"]}</strong></p>
					<p>Best regards,<br>
					<strong>{$settingsEmail}</strong></p>
					</center>",
			'from_email' => "noreply@{$domainName}.com",
			'to_email' => $data["email"]
		),
	));
	if ( $response = curl_exec($curl) ){
		curl_close($curl);
		return true;
	}else{
		return false;
	}
}

//categories
function getCategories(){
	$output = "";
	if($categories = selectDB("categories","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC")){
		$settings = selectDB("settings","`id` = '1'"); 
	    for ($i =0; $i < sizeof($categories); $i++){
			$categoryShape = ( $settings[0]["categoryView"] == 0 ) ? "product-box-img" : "product-box-img-rect" ;
    		$output .= "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6' style='text-align: -webkit-center!important'>
    		<a href='list.php?id={$categories[$i]["id"]}'>
    		<img src='logos/{$categories[$i]["imageurl"]}' class='img-fluid {$categoryShape} rounded' alt='{$categories[$i]["enTitle"]}'>";
    		if ( $settings[0]["showCategoryTitle"] == 0 ){
				$output .= "<span style='font-weight: 600;font-size: 18px;'>";
				$output .= direction($categories[$i]["enTitle"],$categories[$i]["arTitle"]);
				$output .= "</span>";
			}
    		$output .= "</a>
    		</div>";
	    }
	}
	return $output;
}

//items
function updateItemQuantity($data){
	GLOBAL $dbconnect;
	$check = [';','"',"'"];
	$data = str_replace($check,"",$data);
	$sql = "UPDATE `attributes_products`
			SET 
			`quantity` = `quantity` - {$data["quantity"]}
			WHERE
			`id` = '{$data["id"]}'
			";
	if($dbconnect->query($sql)){
		return 1;
	}else{
		$error = array("msg"=>"update quantity error");
		return outputError($error);
	}
}

function uploadImage($imageLocation){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://api.imgur.com/3/upload',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array('image'=> new CURLFILE($imageLocation)),
	  CURLOPT_HTTPHEADER => array(
		'Authorization: Client-ID 386563124e58e6c'
	  ),
	));
	$response = json_decode(curl_exec($curl),true);
	curl_close($curl);
	if( isset($response["success"]) && $response["success"] == true ){
		$imageSizes = ["","b","m"];
		for( $i = 0; $i < sizeof($imageSizes); $i++ ){
			// Your file
			$file = $response["data"]["link"];
			$newFile = str_lreplace(".","{$imageSizes[$i]}.",$file);
			//get File Name
			$fileTitle = str_replace("https://i.imgur.com/","",$newFile);
			$fileTitle = str_replace("{$imageSizes[$i]}.",".",$fileTitle);
			// Open the file to get existing content
			$data = file_get_contents($newFile);
			// New file
			$new = "../../../logos/{$imageSizes[$i]}".$fileTitle;
			// Write the contents back to a new file
			file_put_contents($new, $data);
		}
		return $fileTitle; 
	}else{
		return "";
	}
}

function showLogo(){
	if( $showLogo = selectDB("settings","`id`= '1' ") ){
		$output = $showLogo[0]["showLogo"] == '0' ? "" : "display:none";
	}
	return $output;
}

// whatsapp notification \\
function whatsappNoti($order){
	if( $whatsappNoti = selectDB("settings","`id` = '1'") ){
		$whatsappNoti1 = json_decode($whatsappNoti[0]["whatsappNoti"],true);
		if( $whatsappNoti1["status"] != 1 ){
			$data = array();
		}else{
			$data["type"] = "template";
			$data["comapany_name"] = "createkuwait";
			$data["lang"] = $whatsappNoti1["lang"];
			$data["domain_token"] = $whatsappNoti1["domain_token"];
			$data["to"] = $whatsappNoti1["to"];
			$data["customer_name"] = $whatsappNoti1["name"];
			$data["invoiceid"] = $order;
			$data["invoice_name"] = "invoice-{$whatsappNoti1["name"]}-{$order}";
			$data["invoice_url"] = getPDF($order);
		}
	}else{
		$data = array();
	}
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://automate.createkwservers.com/api/whatsapp/send',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => $data,
	  CURLOPT_HTTPHEADER => array(
		'Cookie: XSRF-TOKEN=eyJpdiI6Im5NMzk2M3B6bU92UzdmY2tCK3NCMXc9PSIsInZhbHVlIjoiQnJrRjEzTjVON1ZSVjN4ZEtwN1oveCtHTXhnWU5pRTFEVHpNeStzRDhmZE1rN1dFMjMzb3ZENFJ0OUVXbnBGSmRYRmdPYm9hTmlkQnMxVUxCRDROU1Q0TXQvdE5JRS9heENTOEI3dW9Gb2d0Y1hJVi9UMUVQWHRFOWRDaGRxdHQiLCJtYWMiOiI3YWNhNmNmZDk4YjNmZDM5ZjM1YjY4ZDI5ZDI4YWIxMTZjYTdmOGNhODQ1ZmQwNGUxYmRmNWY5Y2VmMDE1NTZhIiwidGFnIjoiIn0%3D; laravel_session=eyJpdiI6IlJHY2sxMnVrdFBUOUZlSlQ3UlhJN0E9PSIsInZhbHVlIjoiTmhCS3RUaFJMOTZxNEF3TFdieXM1YkF4RTVJTGx4WkVadURLSWhnOEV1c0E4Tm9ueEdaUlJzSkgycXgvbzVmMXg4aWE2RkduVEdZdWdDdGtXdkMvQUdaVEJjRDZ6QzlCYWo5MmpzTzdvcmZQaUVJVS84RkdFZnJZVU9tQ0NCUHUiLCJtYWMiOiIzN2VmNzE2ZWZlZjQ0NmFjOGUzMjlhYzYxNTVlNTg5MGZlYWQ3ZWYyMGY1ZmRhMDMwMzkzYzkwYzY3Y2E0MGExIiwidGFnIjoiIn0%3D'
	  ),
	));
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}

function getPDF($orderId){
	$settings = selectDB("settings","`id` = '1'");
	$curl = curl_init();
	curl_setopt_array($curl, array(
	CURLOPT_URL => "https://automate.createkwservers.com/api/generate/pdf?url={$settings[0]["website"]}/invoice.php?orderId={$orderId}",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'GET',
	CURLOPT_HTTPHEADER => array(
		'Cookie: XSRF-TOKEN=eyJpdiI6Ik9TWmJlUDF2VGdNNVIzek5Yc0RHUUE9PSIsInZhbHVlIjoiWUxlSVpqVVZvMFhBbmtwZzM3Z0U3NW5ScFVYeVVhdVA5UU1xMXBTemtrZmJZQnNkNldaUzArZFpuR1krUGp5TzkzaDI1WnZmMEpNdUxtWU5ERVdTRnpzZlBjeVRyR2RTa0IwRDYrRnJ5SW5xMy9ob1JzUkV0anFOdUtlL0ZpcTciLCJtYWMiOiJlMjljZWUwNGJhYmE4NGM2ODc1MjFlMWI1ZGI3YTFjMmMwYjZiMTRiYzAxNzljNGJlYTQ2MTFmYTBjZmUwMTJmIiwidGFnIjoiIn0%3D; laravel_session=eyJpdiI6IjRoZGhHbHJyTmhjNUZmVUdsZldieHc9PSIsInZhbHVlIjoiOVhSY0VFampJQjJOSVdxVGlCZkZYWmdkb1NoaGExNmduVHlLN2l3bDNQNVd1VnNLTWorMTN6SCtkMGtaVjVOeDl2N1FjZkZrcWlDRVBmcVQzd2FNMWtkYTRYR1NPY0psTFJFakNxbmRQMDduZGNKbU5TN2c1Y2twWWp4c0lEK20iLCJtYWMiOiIwODViMmJlN2RjZjUwZjExMDM0YTU2NGE2NWMyYjc2NDM4MGU3OGE2MDY1YzBkMDQ3MzYzZmVhYTMxMzZkYTM0IiwidGFnIjoiIn0%3D'
	),
	));
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
function getLogOut(){
	$user_id = $_COOKIE["loggedin_user_id"];
	setcookie("loggedin_user_id", $user_id, time() + (86400*30 ), "/");
	if( updateDB("users",array('keepMeAlive' => ''),"`id` = '{$user_id}'") ){
		setcookie("createmyacad", '', time() + (86400*30 ), "/");
	    setcookie("loggedin_user_id",0, time() + (86400*30 ), "/");
		return 1;
	}else{
		return 0;
	}
}
?>