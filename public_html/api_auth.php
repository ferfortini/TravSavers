<?php
ob_start(); // Start output buffering

$isLocal = in_array($_SERVER['HTTP_HOST'], ['localhost:8001', '127.0.0.1']);
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
]);

$result = json_decode(curl_exec($ch));
curl_close($ch);


// echo "<pre>";
// print_r($result);
// echo "</pre>";
$token = $result->accessToken ?? '';
$userId = $result->userId ?? '';

// Set cookies individually
setcookie(
    'accessToken',
    $token,
    [
        'expires' => time() + 3600, // 1 hour expiration
        'path' => '/',
        'secure' => true, // Only sent over HTTPS
        'httponly' => true, // Not accessible via JavaScript
        'samesite' => 'Strict' // Prevents CSRF attacks
    ]
);

setcookie(
    'userId',
    $userId,
);
