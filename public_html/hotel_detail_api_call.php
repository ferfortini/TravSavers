<?php
// Suppress warnings to ensure clean JSON output
error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);
ini_set('display_errors', 0);

header('Content-Type: application/json');

$curl = curl_init();
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

$isLocal = in_array($_SERVER['HTTP_HOST'], ['localhost:8000', 'localhost:8001', '127.0.0.1', 'localhost']);
$url = $isLocal 
    ? 'https://qa2-api.travcoding.com:4000/hotels/hotel'
    : 'https://api.travcoding.com:4000/hotels/hotel';

$token = $_COOKIE['accessToken'] ?? '';

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
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 30,
    ]
);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$error = curl_error($curl);

if (function_exists('curl_close')) {
    @curl_close($curl);
}

if ($error) {
    echo json_encode(['error' => 'Connection error: ' . $error]);
    exit;
}

if ($httpCode !== 200) {
    echo json_encode(['error' => 'API returned status ' . $httpCode]);
    exit;
}

echo $response;
