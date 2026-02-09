<?php
include('inc/db_connect.php');
include('admin/common.php');
session_start();
header('Content-Type: application/json');

/**
 * Handle errors by sending a JSON error response
 *
 * @param mixed $error The error message or exception object
 * @return void
 */
function handleError($error)
{
    $response = array(
        'success' => false,
        'error' => is_string($error) ? $error : 'An error occurred while processing your request.'
    );
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $packageName = trim($_POST['packageName'] ?? '');
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $permissionToContact = isset($_POST['permissionToContact']) && $_POST['permissionToContact'] ? 1 : 0;

    $hotelData = $_POST['hotelData'] ?? [];

    // Extract required hotel details
    $displayName = $hotelData['displayName'] ?? 'N/A';
    $address = $hotelData['address'] ?? 'N/A';
    $checkIn = $hotelData['possibleStays'][0]['checkIn'] ?? 'N/A';
    $checkOut = $hotelData['possibleStays'][0]['checkOut'] ?? 'N/A';

    // Format dates (optional)
    $checkInFormatted = $checkIn !== 'N/A' ? date('F j, Y', strtotime($checkIn)) : 'N/A';
    $checkOutFormatted = $checkOut !== 'N/A' ? date('F j, Y', strtotime($checkOut)) : 'N/A';

    // Prepare email
    $to = 'puja.sharma@codiant.com';
    $subject = "New 'Save for Later' Submission";

    $message = "
    <html>
    <head><title>Save for Later Details</title></head>
    <body>
        <h2>User Information</h2>
        <p><strong>Name:</strong> {$firstName} {$lastName}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Permission to Contact:</strong> " . ($permissionToContact ? 'Yes' : 'No') . "</p>
        
        <h2>Hotel Information</h2>
        <p><strong>Package Name:</strong> {$packageName}</p>
        <p><strong>Hotel Name:</strong> {$displayName}</p>
        <p><strong>Address:</strong> {$address}</p>
        <p><strong>Check-In:</strong> {$checkInFormatted}</p>
        <p><strong>Check-Out:</strong> {$checkOutFormatted}</p>
    </body>
    </html>
    ";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $email" . "\r\n";
    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'Package saved and email sent.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send email.']);
    }
}
