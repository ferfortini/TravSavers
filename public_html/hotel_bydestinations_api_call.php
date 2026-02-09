<?php
header('Content-Type: application/json');
$curl = curl_init();
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Get token from cookie
$token = $_COOKIE['accessToken'] ?? '';

$isLocal = in_array($_SERVER['HTTP_HOST'], ['localhost:8001', '127.0.0.1']);
$url = $isLocal 
    ? 'https://qa2-api.travcoding.com/contents/location/hotel/bydestination'
    : 'https://api.travcoding.com/contents/location/hotel/bydestination';
curl_setopt_array(
    $curl,
    [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ],
    ]
);


$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$error = curl_error($curl);
curl_close($curl);

if ($error) {
    echo "cURL Error: " . $error;
} else {
    echo $response;
}
