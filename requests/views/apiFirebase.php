<?php
if( isset($_GET["action"]) & !empty($_GET["action"]) ){
    if( $_GET["action"] == "register" ){
        if( !isset($_POST["deviceToken"]) || empty($_POST["deviceToken"]) ){
            $error["msg"] = popupMsg($requestLang,"Please enter device token . {$_POST["deviceToken"]}","الرجاء ادخال رمز الجهاز");
            echo outputError($error);die();
        }else{
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://createapi.link/api/v1/register_a_device',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'firebase_json'=> new CURLFILE('../../myacademy-bd81b-firebase-adminsdk-mdflj-3fbac4549d.json'),
                'deviceToken' => "{$_POST["deviceToken"]}",
                'topic' => 'news'
            ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $output["msg"] = popupMsg($requestLang,"Device has been registered successfully","تم تسجيل الجهاز بنجاح");
            echo outputData($output);die();
        }
    }elseif( $_GET["action"] == "sendNotification" ){
        if( !isset($_POST["title"]) || empty($_POST["title"]) ){
            $error["msg"] = popupMsg($requestLang,"Please enter title","الرجاء ادخال العنوان");
            echo outputError($error);die();
        }
        if( !isset($_POST["body"]) || empty($_POST["body"]) ){
            $error["msg"] = popupMsg($requestLang,"Please enter body","الرجاء ادخال الوصف");
            echo outputError($error);die();
        }
        if( !isset($_POST["image"]) || empty($_POST["image"]) ){
            $_POST["image"] = "";
        }else{
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://createapi.link/api/v1/send_to_topic',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'firebase_json'=> new CURLFILE('../../myacademy-bd81b-firebase-adminsdk-mdflj-3fbac4549d.json'),
                'topic' => 'news',
                'title' => "{$_POST["title"]}",
                'body' => "{$_POST["body"]}",
                'image'=> "{$_POST["image"]}"
            ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $output["msg"] = popupMsg($requestLang,"Notification has been sent successfully","تم ارسال الاشعار بنجاح");
            echo outputData($output);die();
        }
    }
}
?>