<?php
header('Content-Type: application/json');
$curl = curl_init();
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
$isLocal = in_array($_SERVER['HTTP_HOST'], ['localhost:8001', '127.0.0.1']);
$token = $_COOKIE['accessToken'] ?? '';
$url = $isLocal 
    ? 'https://qa2-api.travcoding.com:4000/hotels/hotel/booking-summary'
    : 'https://api.travcoding.com:4000/hotels/hotel/booking-summary';
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
