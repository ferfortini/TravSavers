<?php
// Suppress warnings to ensure clean JSON output
error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);
ini_set('display_errors', 0);

header('Content-Type: application/json');

$curl = curl_init();
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Get token from cookie
$token = $_COOKIE['accessToken'] ?? '';

$isLocal = in_array($_SERVER['HTTP_HOST'], ['localhost:8000', 'localhost:8001', '127.0.0.1', 'localhost']);
$url = $isLocal 
    ? 'https://qa2-api.travcoding.com:4000/Hotels/search/page'
    : 'https://api.travcoding.com:4000/Hotels/search/page';
    
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

// Close curl resource (deprecated in PHP 8.5 but still works)
if (function_exists('curl_close')) {
    @curl_close($curl);
}

// Handle errors
if ($error) {
    echo json_encode(['error' => 'Connection error: ' . $error, 'searchHotels' => []]);
    exit;
}

// Check if response is valid JSON
if ($httpCode !== 200) {
    echo json_encode(['error' => 'API returned status ' . $httpCode, 'searchHotels' => []]);
    exit;
}

// Try to decode and validate JSON
$decoded = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    // If response is not valid JSON, return empty result
    echo json_encode(['error' => 'Invalid JSON response', 'searchHotels' => []]);
    exit;
}

// Ensure response has the expected structure
if (!isset($decoded['searchHotels'])) {
    echo json_encode(['searchHotels' => []]);
    exit;
}

echo $response;
