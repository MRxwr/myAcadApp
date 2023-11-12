<?php
if ( isset($_GET["type"]) && !empty($_GET["type"]) ){
	if( $_GET["type"] == "login" ){
		if ( !isset($_POST["email"]) || empty($_POST["email"]) ){
			$error = array("msg"=>"Please enter email correctly.");
			echo outputError($error);die();
		}
		if ( !isset($_POST["password"]) || empty($_POST["password"]) ){
			$error = array("msg"=>"Please enter password correctly.");
			echo outputError($error);die();
		}
		if($user = selectDB('users',"`email` LIKE '".$_POST["email"]."' AND `password` LIKE '".sha1($_POST["password"])."'")){
			if( $user[0]["status"] == 1 ){
				$error = array("msg"=>"Your account has been blocked. Please aconatct administration.");
				echo outputError($error);die();
			}elseif( $user[0]["status"] == 2 ){
				$error = array("msg"=>"No user with this email.");
				echo outputError($error);die();
			}else{
				$data = array("firebase" => "{$_POST["firebase"]}");
				if( updateDB('users',$data,"`id` = '{$user[0]["id"]}'") ){
					
				}
				echo outputData(array('id'=>$user[0]["id"]));
			}
		}else{
			$error = array("msg"=>"Please enter user credintial correctly.");
			echo outputError($error);die();
		}
	}elseif( $_GET["type"] == "deleteUser" ){
		if ( !isset($_GET["userId"]) || empty($_GET["userId"]) ){
			$error = array("msg"=>"Please enter user id");
			echo outputError($error);die();
		}elseif( selectDB('users',"`id` = '{$_GET["userId"]}'") ){
			updateDB('users',array("status"=>"2"),"`id` = '{$_GET["userId"]}'");
			echo outputData(array('msg'=>"User account has been removed successfully."));
		}else{
			$error = array("msg"=>"user id is wrong, please check user id.");
			echo outputError($error);die();
		}
	}elseif( $_GET["type"] == "forgetPassword" ){
		if ( !isset($_GET["email"]) || empty($_GET["email"]) ){
			$error = array("msg"=>"Please fill email");
			echo outputError($error);die();
		}
		if( selectDB('users',"`email` LIKE '".$_GET["email"]."'") ){
			$random = rand(11111111,99999999);
			updateDB('users',array("password"=>sha1($random)),"`email` LIKE '".$_GET["email"]."'");
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://createid.link/api/v1/send/notify',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => array(
				'site' => '- MYACAD',
			  	'subject' => 'New Password - MYACAD',
			  	'body' => "<div style='text-align: -webkit-center;'><img src='https://myacad.app/img/logo.png' style='width:100px;height:100px'>
				  <p>&nbsp;</p>Your new password is: {$random}<br><br>(Note: Please change your passowrd as soon as you login in app.)</div>",
			  	'from_email' => 'noreply@myacad.com',
			  	'to_email' => $_GET["email"]),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			echo outputData(array('msg'=>"A new password has been sent to your email."));
		}else{
			$error = array("msg"=>"This email is not registred on our app, please enter a correct one.");
			echo outputError($error);die();
		}
	}elseif( $_GET["type"] == "changePassword" ){
		if ( !isset($_POST["oldPassword"]) || empty($_POST["oldPassword"]) ){
			$error = array("msg"=>"Please enter old password.");
			echo outputError($error);die();
		}
		if ( !isset($_POST["newPassword"]) || empty($_POST["newPassword"]) ){
			$error = array("msg"=>"Please enter new password.");
			echo outputError($error);die();
		}
		if ( !isset($_POST["confirmPassword"]) || empty($_POST["confirmPassword"]) ){
			$error = array("msg"=>"Please enter confirm password.");
			echo outputError($error);die();
		}
		if ( $_POST["confirmPassword"] != $_POST["newPassword"] ){
			$error = array("msg"=>"please set new password and confrim password correctly.");
			echo outputError($error);die();
		}
		if( $user = selectDB("users","`id` = '{$_GET["userId"]}'" ) ){
			$newPass = sha1($_POST["newPassword"]);
			$oldPass = sha1($_POST["oldPassword"]);
			if ( $user = selectDB("users","`id` = '{$_GET["userId"]}' AND `password` = '{$oldPass}'" ) ){
			updateDB('users',array("password"=>$newPass),"`id` = '{$_GET["userId"]}'");
				echo outputData(array('msg'=>"Password has been changed successfully."));
			}else{
				$error = array("msg"=>"Old password is wrong.");
				echo outputError($error);die();
			}
		}else{
			$error = array("msg"=>"This id is not registred.");
			echo outputError($error);die();
		}
	}elseif( $_GET["type"] == "register" ){
		if ( !isset($_POST["firstName"]) || empty($_POST["firstName"]) ){
			$error = array("msg"=>"Please enter first name");
			echo outputError($error);die();
		}
		if ( !isset($_POST["lastName"]) || empty($_POST["lastName"]) ){
			$error = array("msg"=>"Please enter last name");
			echo outputError($error);die();
		}
		if ( !isset($_POST["phone"]) || empty($_POST["phone"]) ){
			$error = array("msg"=>"Please enter mobile");
			echo outputError($error);die();
		}
		if ( !isset($_POST["email"]) || empty($_POST["email"]) ){
			$error = array("msg"=>"Please fill email");
			echo outputError($error);die();
		}
		if ( !isset($_POST["firebase"]) || empty($_POST["firebase"]) ){
			$error = array("msg"=>"Please fill firebase");
			echo outputError($error);die();
		}
		if ( !isset($_POST["password"]) || empty($_POST["password"]) ){
			$error = array("msg"=>"Please fill password");
			echo outputError($error);die();
		}
		if ( !isset($_POST["confirmPassword"]) || empty($_POST["confirmPassword"]) ){
			$error = array("msg"=>"Please fill confirm password");
			echo outputError($error);die();
		}
		if ( $_POST["password"] != $_POST["confirmPassword"] ){
			$error = array("msg"=>"Passwords does not match. Please try again.");
			echo outputError($error);die();
		}
	
		$_POST["password"] = sha1($_POST["password"]);		
		unset($_POST["confirmPassword"]);
		$data = $_POST;
		if( $user = selectDB('users',"`email` LIKE '".$_POST["email"]."'") ){
			if( $user[0]["status"] == 2 ){
				updateDB("users",array("email" => "DELETED - {$user[0]["email"]}" ), "`id` = '{$user[0]["id"]}'");
			}else{
				$error = array("msg"=>"A user with this email is already registred.");
				echo outputError($error);die();
			}
		}
		if( insertDB('users',$data) ){
			if ( $user = selectDB('users',"`email` LIKE '".$_POST["email"]."' AND `password` LIKE '".$_POST["password"]."'") ){
				if( $user[0]["status"] == 1 ){
					$error = array("msg"=>"Your account has been blocked. Please aconatct administration.");
					echo outputError($error);die();
				}
				echo outputData(array('id'=>$user[0]["id"]));
			}
		}else{
			$error = array("msg"=>"Please enter registration data correctly.");
			echo outputError($error);die();
		}
	}elseif( $_GET["type"] == "profile" ){
		if ( !isset($_GET["userId"]) || empty($_GET["userId"]) ){
			$error = array("msg"=>"Please enter user id");
			echo outputError($error);die();
		}
		if ( isset($_GET["update"]) && !empty($_GET["update"]) ){
			if ( !isset($_POST["firstName"]) || empty($_POST["firstName"]) ){
    			$error = array("msg"=>"Please enter first name");
    			echo outputError($error);die();
    		}
    		if ( !isset($_POST["lastName"]) || empty($_POST["lastName"]) ){
    			$error = array("msg"=>"Please enter last name");
    			echo outputError($error);die();
    		}
			if ( !isset($_POST["email"]) || empty($_POST["email"]) ){
    			$error = array("msg"=>"Please enter email");
    			echo outputError($error);die();
    		}
			if ( !isset($_POST["phone"]) || empty($_POST["phone"]) ){
    			$error = array("msg"=>"Please enter phone number");
    			echo outputError($error);die();
    		}
    		if ( !isset($_POST["gender"]) ){
    			$error = array("msg"=>"Please enter gender");
    			echo outputError($error);die();
    		}
			$data = array(
				"firstName"=>$_POST["firstName"],
				"lastName"=>$_POST["lastName"],
				"email"=>$_POST["email"],
				"phone"=>$_POST["phone"],
				"gender"=>$_POST["gender"]
			);
			if( $user = selectDB("users","`id` = '{$_GET["userId"]}' " ) ){
				if ( updateDB("users",$data,"`id` = '{$_GET["userId"]}'" ) ){
					$user = selectDB2("`firstName`, `lastName`, `email`, `phone`, `gender`","users","`id` = '{$_GET["userId"]}' " );
					echo outputData(array('msg'=>"profile has been updated successfully.","user"=>$user));
				}
			}else{
				$error = array("msg"=>"No user with this id");
				echo outputError($error);die();
			}
		}else{
			if( $user = selectDB2("`firstName`, `lastName`, `email`, `phone`, `gender`","users","`id` = '{$_GET["userId"]}' " ) ){
				echo outputData(array("user"=>$user));
			}else{
				$error = array("msg"=>"No user with this id");
				echo outputError($error);die();
			}
		}
	}else{
		$error = array("msg"=>"Please set type , 'login','register', 'forgetpassword', 'changePassword'.");
		echo outputError($error);die();
	}
}else{
	$error = array("msg"=>"Please set type , 'login','register', 'forgetpassword', 'changePassword'.");
	echo outputError($error);die();
}
?>