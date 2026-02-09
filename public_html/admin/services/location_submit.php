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
    $country = trim($_POST['country'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $location_id = $_POST['location_id'] ?? '';
    
    try {
        if (!empty($location_id)) {
            // Update existing location
            $result = updateRecord(
                $con,
                'custom_locations',
                'country, state, city',
                [$country, $state, $city],
                $location_id,
                'Location updated successfully!',
                'There was a problem updating the location.',
                'dashboard.php',
                false // Don't show alert, we'll handle it ourselves
            );
            
            if ($result) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Location updated successfully!',
                    'action' => 'update'
                );
            } else {
                handleError('Failed to update location');
            }
            
        } else {
            // Insert new location
            $result = insertRecord(
                $con,
                'custom_locations',
                'country, state, city',
                [$country, $state, $city],
                'Location added successfully!',
                'There was a problem adding the location.',
                'dashboard.php',
                false // Don't show alert, we'll handle it ourselves
            );
            
            if ($result !== false) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Location added successfully!',
                    'action' => 'insert'
                );
            } else {
                handleError('Failed to add location');
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
