<?php
header('Content-Type: application/json');
$curlprop = curl_init();
$isLocal = in_array($_SERVER['HTTP_HOST'], ['localhost:8001', '127.0.0.1']);
$destination = $_GET['SearchString'];
$url = $isLocal
    ? "https://qa2-api.travcoding.com:4000/Locations?SearchString=$destination"
    : "https://api.travcoding.com:4000/Locations?SearchString=$destination";

// Get token from cookie
$token = $_COOKIE['accessToken'] ?? '';

curl_setopt_array(
    $curlprop,
    [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ],
    ]
);

$response = curl_exec($curlprop);

$error = curl_error($curlprop);

curl_close($curlprop);

if ($error) {
    echo "cURL Error #:" . $error;
} else {
    echo $response;
}
