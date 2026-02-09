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
    $category = trim($_POST['category'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $value = trim($_POST['value'] ?? '');
    $perk_values_id = $_POST['perk_values_id'] ?? '';
    
    try {
        if (!empty($perk_values_id)) {
            // Update existing perk values
            $result = updateRecord(
                $con,
                'perk_values',
                'category, type, value',
                [$category, $type, $value],
                $perk_values_id,
                'Perk values updated successfully!',
                'There was a problem updating the perk values.',
                'dashboard.php',
                false // Don't show alert, we'll handle it ourselves
            );
            
            if ($result) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Perk values updated successfully!',
                    'action' => 'update'
                );
            } else {
                handleError('Failed to update perk values');
            }
            
        } else {
            // Insert new perk values
            $result = insertRecord(
                $con,
                'perk_values',
                'category, type, value',
                [$category, $type, $value],
                'Perk values added successfully!',
                'There was a problem adding the perk values.',
                'dashboard.php',
                false // Don't show alert, we'll handle it ourselves
            );
            
            if ($result !== false) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Perk values added successfully!',
                    'action' => 'insert'
                );
            } else {
                handleError('Failed to add perk values');
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
