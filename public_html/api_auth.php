<?php
ob_start(); // Start output buffering

$isLocal = in_array($_SERVER['HTTP_HOST'], ['localhost:8000', 'localhost:8001', '127.0.0.1']);
$email = $isLocal ? 'testgerman3@travcoding.com' : 'api@travsavers.com';
$password = $isLocal ? 'Trav123' : 'hzZGiGfwZnLWbKT';
$url = $isLocal 
    ? 'https://qa2-api.travcoding.com/identity/users/sign-in' 
    : 'https://api.travcoding.com/identity/users/sign-in';

$jsonData = [
    'email' => $email,
    'password' => $password,
];

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($jsonData),
    CURLOPT_SSL_VERIFYPEER => false, // Allow self-signed certificates in local dev
    CURLOPT_TIMEOUT => 10,
]);

$result = json_decode(curl_exec($ch));
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
// Close curl resource (deprecated in PHP 8.5 but still works)
if (function_exists('curl_close')) {
    @curl_close($ch);
}


// echo "<pre>";
// print_r($result);
// echo "</pre>";
$token = $result->accessToken ?? '';
$userId = $result->userId ?? '';

// Set cookies individually
// Use secure only for HTTPS, not for local development
$isSecure = !$isLocal && (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
setcookie(
    'accessToken',
    $token,
    [
        'expires' => time() + 3600, // 1 hour expiration
        'path' => '/',
        'secure' => $isSecure, // Only sent over HTTPS in production
        'httponly' => true, // Not accessible via JavaScript
        'samesite' => 'Strict' // Prevents CSRF attacks
    ]
);

setcookie(
    'userId',
    $userId,
);
