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
        "Authorization: Bearer ya29.c.c0ASRK0GaS4DxS9mr3BjZmfZdCJO4jncRJ_JQSyKpOYJYSgNehu2LabDjkpNyccOC7lvM2HAVoPYtaABtryjv4_xI5Ty_DWVFnivoO9kTQ2kqTwlXLEc8z8ENYGXRYYSyp8_XBw8ztxSpt1LDYm7UMg-wYPZ1SEf4cC5N3vQqETiRL7BXxhXk0DkjMc9t2QlLpUe_ZsJkMGol5LKQNQuVpESlLIqaHyc80Erv-qVRE6PGhWO-dEPYe_aq7MEptoUD4NClfIJBZlTlE7qPFysuoKMKNNB0vqgR1NxnlIgKvE8ov8Jk400Yri2Bhx4krsdEoV3xBVIAC2fl0B8_wGQX6GdWLnXabWUqgwmBTsPcoOLtRbPJ4hiOv9ZEWdQG387Dfxj_9JpWShd5di1laX5ZxjVfSMeIjakv4Mh5BafuFOBbaJxYxROFJ-4UtxS7p8nUzZ6mO5eqRh8w3c7SgQVuB2V_WsFJmx-cdqwl42FW61fxth2R661UZs7js7ZIV7b8VB_537hBnigerd2B4txlhIik1Sbwv0RIgYFgodzBq1Ugs6lcz4pw4X9xgFxlUrrRem0YbU1kqIQo2c2qb6d6qadM4OZf-aUOacnMyholtuvuVZzz9IJi7BjzB5zknm5B0tpUO9Jw9eanj13wQR2ShjUuRh2Og4pkSjM5StsfF6lvdh2jhXB5aaM1WvhQn4iQo_Bbfs00Mx8l9ourJSkFt2xpB3rR5Sv8l1cRwXp4Qt6p366lv8zB3o9p3ls_4dFlij-gaVfZUaolatWJ14o_cJg-_k5mpjyWBXgV9z9pUqlI3gRRxJ2rVgZsgzUkfOiFmhtvBhge3U109BgqpkXZI0s1b6jRFFph8URYMeni4RxnJx3tlq0sBshem7ioYzpsV5p51XpoU0Vuv3xYu525VQvw1ByyVssi9z2wvfafW8OtlQwf_Icb9eOeIMJqmlh4tSg7qsF7ibafqqof6wbn-bvn817wcnBx5g-tBJkeYFkhe6Qh845Z2xWz",
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