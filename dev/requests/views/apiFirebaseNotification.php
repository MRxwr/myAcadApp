<?php
function getAccessToken() {
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://createapi.link/api/v1/request_token',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('firebase_json'=> new CURLFILE('../../../myacademy-bd81b-firebase-adminsdk-mdflj-3fbac4549d.json')),
    ));
    $response = curl_exec($curl);
    var_dump("../../myacademy-bd81b-firebase-adminsdk-mdflj-3fbac4549d.json");die();
    $response = json_decode($response, true);
    curl_close($curl);
    return $response["data"]['access_token'];
}

$bearer = getAccessToken();
$notificationData = array(
    "message" => array(
        "notification" => array( 
            "title" => "{$_POST["title"]}",
            "body"  => "{$_POST["body"]}",
            //"image" => "{$_POST["image"]}",
        )
    )
);

echo $bearer;die();

if( $users = selectDB("users", "`id` = '500' GROUP BY `firebase` ORDER BY `id` ASC") ){
    for( $i = 0; $i < sizeof($users); $i++){
        $notificationData["message"]["token"] = $users[$i]["firebase"];
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://fcm.googleapis.com/v1/projects/myacademy-bd81b/messages:send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => json_encode($notificationData),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $bearer
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }
}
?>