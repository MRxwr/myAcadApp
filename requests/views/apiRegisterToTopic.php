<?php
function getCredentialsFromFile($filePath) {
  if (!file_exists($filePath)) {
    die("Service account key file not found: " . $filePath);
  }

  $content = file_get_contents($filePath);
  $credentials = json_decode($content, true);

  if (json_last_error() !== JSON_ERROR_NONE) {
    die("Error parsing service account key file: " . json_last_error_msg());
  }

  return $credentials;
}

function getAccessToken($credentials) {
    var_dump($credentials);
    $url = 'https://oauth2.googleapis.com/token';
    $data = [
        'grant_type' => 'urn:ietf:params:oauth2.0:client_credentials',
        'audience' => 'https://www.googleapis.com/auth/firebase.messaging',
        'client_email' => $credentials['client_email'],
        'private_key' => $credentials['private_key']
    ];

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $response = json_decode($response, true);

    if (isset($response['access_token'])) {
        return $response['access_token'];
    } else {
        die("Error getting access token: " . json_encode($response));
    }
}

function subscribeToTopic($deviceToken, $topic, $accessToken) {
    $url = "https://iid.googleapis.com/iid/v1/{$deviceToken}/rel/topics/{$topic}";

    $headers = [
        "Authorization: Bearer {$accessToken}",
        "Content-Type: application/json"
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

// Replace with the path to your service account key file
$keyFilePath = '../../myacademy-bd81b-firebase-adminsdk-mdflj-3fbac4549d.json'; 

// Get credentials from the file
$credentials = getCredentialsFromFile($keyFilePath);

// Get access token
$accessToken = getAccessToken($credentials);

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