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
    $type = trim($_POST['type'] ?? '');
    $value = trim($_POST['value'] ?? '');
    $rate_id = $_POST['rate_id'] ?? '';

    try {
        if (!empty($rate_id)) {
            // Update existing rate
            $result = updateRecord(
                $con,
                'night_rates',
                'type, value',
                [$type, $value],
                $rate_id,
                'Rate updated successfully!',
                'There was a problem updating the rate.',
                'dashboard.php',
                false // Don't show alert, we'll handle it ourselves
            );
            
            if ($result) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Rate updated successfully!',
                    'action' => 'update'
                );
            } else {
                handleError('Failed to update rate');
            }
            
        } else {
            // Insert new rate
            $result = insertRecord(
                $con,
                'night_rates',
                'type, value',
                [$type, $value],
                'Rate added successfully!',
                'There was a problem adding the rate.',
                'dashboard.php',
                false // Don't show alert, we'll handle it ourselves
            );
            
            if ($result !== false) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Rate added successfully!',
                    'action' => 'insert'
                );
            } else {
                handleError('Failed to add rate');
            }
        }
        
        echo json_encode($response);
    } catch (Exception $e) {
        handleError($e->getMessage());
    }
} else {
    handleError('Invalid request method');
}
?>
