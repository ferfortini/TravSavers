<?php
// Suppress warnings to ensure clean JSON output
error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);
ini_set('display_errors', 0);

header('Content-Type: application/json');

$curlprop = curl_init();
$isLocal = in_array($_SERVER['HTTP_HOST'], ['localhost:8000', 'localhost:8001', '127.0.0.1', 'localhost']);
$destination = $_GET['SearchString'] ?? '';

if (empty($destination)) {
    echo json_encode(['locations' => []]);
    exit;
}

$url = $isLocal
    ? "https://qa2-api.travcoding.com:4000/Locations?SearchString=" . urlencode($destination)
    : "https://api.travcoding.com:4000/Locations?SearchString=" . urlencode($destination);

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
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 10,
    ]
);

$response = curl_exec($curlprop);
$httpCode = curl_getinfo($curlprop, CURLINFO_HTTP_CODE);
$error = curl_error($curlprop);

// Close curl resource (deprecated in PHP 8.5 but still works)
if (function_exists('curl_close')) {
    @curl_close($curlprop);
}

// Handle errors
if ($error) {
    echo json_encode(['error' => 'Connection error', 'locations' => []]);
    exit;
}

// Check if response is valid JSON
if ($httpCode !== 200) {
    echo json_encode(['error' => 'API returned status ' . $httpCode, 'locations' => []]);
    exit;
}

// Try to decode and validate JSON
$decoded = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    // If response is not valid JSON, return empty result
    echo json_encode(['locations' => []]);
    exit;
}

// Ensure response has the expected structure
if (!isset($decoded['locations'])) {
    echo json_encode(['locations' => []]);
    exit;
}

echo $response;
