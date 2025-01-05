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
    CURLOPT_POSTFIELDS => array('firebase_json'=> new CURLFILE('../../myacademy-bd81b-firebase-adminsdk-mdflj-3fbac4549d.json')),
    CURLOPT_HTTPHEADER => array(
        'Accept: application/json'
    ),
    ));
    $response = curl_exec($curl);
    $response = json_decode($response, true);
    curl_close($curl);
    return $response["data"]['access_token'];
}

function subscribeToTopic($deviceToken, $topic, $accessToken)
{
    // Validate topic name
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $topic)) {
        die("Invalid topic name: $topic");
    }

    $url = "https://iid.googleapis.com/iid/v1/{$deviceToken}/rel/topics/{$topic}";

    $headers = [
        "Authorization: Bearer $accessToken",
        "Content-Type: application/json",
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        echo "cURL error: " . curl_error($ch);
    } else {
        if ($httpCode === 200) {
            echo "Device successfully subscribed to the topic: $topic!";
        } else {
            echo "Error subscribing to the topic: " . $response;
        }
    }
    curl_close($ch);
}

if( $users = selectDB("users", "`id` = '6' GROUP BY `firebase` ORDER BY `id` ASC") ){
    $bearer = getAccessToken();
    for( $i = 0; $i < sizeof($users); $i++){
        $deviceToken = "{$users[$i]["firebase"]}"; // Replace with the device token
        $topic = "general_updates"; // Replace with your desired topic
        $accessToken = "{$bearer}"; // Replace with the OAuth2 token
        subscribeToTopic($deviceToken, $topic, $accessToken);
    }
}
?>