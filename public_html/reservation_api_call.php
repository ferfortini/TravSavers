<?php

$curl = curl_init();
$headers = getallheaders();
$token = $headers['Authorization'] ?? '';
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
$isLocal = in_array($_SERVER['HTTP_HOST'], ['localhost:8001', '127.0.0.1']);
$url = $isLocal 
    ? 'https://qa-api.travcoding.com/properties/booking/checkout'
    : 'https://api.travcoding.com/properties/booking/checkout';
curl_setopt_array(
    $curl,
    [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: ' .  $token
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
