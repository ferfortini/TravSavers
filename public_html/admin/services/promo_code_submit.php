<?php
include('../../inc/db_connect.php');
include('../common.php');
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
        'status' => 'error',
        'message' => is_string($error) ? $error : 'An error occurred while processing your request.'
    );
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offer_code = trim($_POST['offer_code'] ?? '');
    $start_date = trim($_POST['start_date'] ?? '');
    $end_date = trim($_POST['end_date'] ?? '');
    $discount_type = trim($_POST['discount_type'] ?? '');
    $discount_value = trim($_POST['discount_value'] ?? '');
    $min_price = trim($_POST['min_price'] ?? '');
    $promo_code_id = $_POST['promo_code_id'] ?? '';

    try {
        if (!empty($promo_code_id)) {
            // Update existing promo codes
            $result = updateRecord(
                $con,
                'promo_codes',
                'offer_code, start_date, end_date, discount_type, discount_value, min_price',
                [$offer_code, $start_date, $end_date, $discount_type, $discount_value, $min_price],
                $promo_code_id,
                'Promo code updated successfully!',
                'There was a problem updating the promo code.',
                'dashboard.php',
                false
            );

            if ($result) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Promo code updated successfully!',
                    'action' => 'update'
                );
            } else {
                handleError('Failed to update promo code');
            }
        } else {
            // Insert new promo codes
            $result = insertRecord(
                $con,
                'promo_codes',
                'offer_code, start_date, end_date, discount_type, discount_value, min_price, status',
                [$offer_code, $start_date, $end_date, $discount_type, $discount_value, $min_price, 0],
                'Promo code added successfully!',
                'There was a problem adding the promo code.',
                'dashboard.php',
                false
            );

            if ($result !== false) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Promo code added successfully!',
                    'action' => 'insert'
                );
            } else {
                handleError('Failed to add promo code');
            }
        }

        echo json_encode($response);
    } catch (Exception $e) {
        handleError($e->getMessage());
    }
} else {
    handleError('Invalid request method');
}
