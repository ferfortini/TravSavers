<?php
require_once 'vendor/autoload.php';
include 'google_ads_php.ini';
$ini = parse_ini_file('google_ads_php.ini', true);
$clientId = $ini['GOOGLE_ADS']['clientId'];
$clientSecret = $ini['GOOGLE_ADS']['clientSecret'];

$oauth2 = new \Google\Auth\OAuth2([
    'authorizationUri' => 'https://accounts.google.com/o/oauth2/auth',
    'tokenCredentialUri' => 'https://oauth2.googleapis.com/token',
    'clientId' => $clientId,
    'clientSecret' => $clientSecret,
    'redirectUri' => 'http://localhost:8001/callback.php',
    'scope' => 'https://www.googleapis.com/auth/adwords',
]);

$authUrl = $oauth2->buildFullAuthorizationUri();
echo "Open this URL in your browser and authorize:\n$authUrl\n";

// After user authorizes, they'll get a code in the URL
$authCode = readline("Enter the authorization code here: ");
$oauth2->setCode($authCode);
$authToken = $oauth2->fetchAuthToken();

echo "Your Refresh Token: " . $authToken['refresh_token'];


$client = new \GuzzleHttp\Client();

$response = $client->post('https://oauth2.googleapis.com/token', [
    'form_params' => [
        'code' => $authCode,
        'client_id' => 'YOUR_CLIENT_ID',
        'client_secret' => 'YOUR_CLIENT_SECRET',
        'redirect_uri' => 'YOUR_REDIRECT_URI',
        'grant_type' => 'authorization_code',
    ],
]);

$body = json_decode((string) $response->getBody(), true);
$accessToken = $body['access_token'];
$refreshToken = $body['refresh_token'];