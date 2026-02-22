<?php 
if( isset($_GET["type"]) && !empty($_GET["type"]) ){
    if( !isset($_POST["userId"]) || empty($_POST["userId"]) ){
        $response["msg"] = "Please provide a user ID.";
        echo outputError($response);die();
    }
    if( $_GET["type"] == "requestOTP" ){
        if( !isset($_POST["mobile"]) || empty($_POST["mobile"]) ){
            $response["msg"] = "Please provide a mobile number.";
            echo outputError($response);die();
        }
        if( $user = selectDBNew("users", [$_POST["userId"]], "`id` = ?", "") ){
            $otp = rand(1000, 9999);
            if( updateDB("users", ["otp" => $otp], "`id` = '{$_POST["userId"]}'" ) ){
                whatsappUltraMsgVerify($_POST["mobile"], $otp);
                $response["msg"] = "OTP sent to your mobile.";
                echo outputData($response);die();
            }else{
                $response["msg"] = "Failed to send OTP.";
                echo outputError($response);die();
            }
        }else{
            $response["msg"] = "User not found.";
            echo outputError($response);die();
        }
    }elseif( $_GET["type"] == "checkOTP" ){
        if( !isset($_POST["otp"]) || empty($_POST["otp"]) ){
            $response["msg"] = "Please provide an OTP.";
            echo outputError($response);die();
        }
        if( !isset($_POST["mobile"]) || empty($_POST["mobile"]) ){
            $response["msg"] = "Please provide a mobile number.";
            echo outputError($response);die();
        }
        if( !isset($_POST["firebase"]) || empty($_POST["firebase"]) ){
            $response["msg"] = "Please provide a Firebase token.";
            echo outputError($response);die();
        }
        if( $user = selectDBNew("users", [$_POST["userId"]], "`id` = ?", "") ){
            if( $user[0]["otp"] == $_POST["otp"] ){
                $countryCode = getCountryCodeFromNumber($_POST["mobile"]);
                if( updateDB("users", ["otp" => "", "mobile" => $_POST["mobile"], "countryCode" => $countryCode], "`id` = '{$_POST["userId"]}'" ) ){
                    $data = array("firebase" => "{$_POST["firebase"]}");
                    if( updateDB2('users',$data,"`id` = '{$user[0]["id"]}'") ){
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://myacad.app/requests?a=Firebase&action=register',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => array('deviceToken' => "{$_POST["firebase"]}",),
                        CURLOPT_HTTPHEADER => array(
                            'myacadheader: myAcadAppCreate'
                        ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                    }
                    $response["id"] = $user[0]["id"];
                    $response["msg"] = "User verified successfully.";
                    echo outputData($response);die();
                }else{
                    $response["msg"] = "Failed to verify user.";
                    echo outputError($response);die();
                }
            }else{
                $response["msg"] = "Invalid OTP.";
                echo outputError($response);die();
            }
        }else{
            $response["msg"] = "User not found.";
            echo outputError($response);die();
        }
    }else{
        $response["msg"] = "Invalid request type.";
        echo outputError($response);die();
    }
}else{
    $response["msg"] = "request type is required.";
    echo outputError($response);die();
}
?>