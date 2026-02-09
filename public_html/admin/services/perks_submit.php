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
    $description = trim($_POST['description'] ?? '');
    $plus_set_id = trim($_POST['plusSet'] ?? '');
    $plus_type_id = trim($_POST['plusType'] ?? '');
    $increment_id = trim($_POST['increment'] ?? '');
    $included = trim($_POST['included'] ?? '');
    $cost_id = trim($_POST['cost'] ?? '');
    $perk_id = $_POST['perk_id'] ?? '';
    
    // Clean cost_id - remove dollar sign if present
    $cost_id = str_replace('$', '', $cost_id);
    
    try {
        if (!empty($perk_id)) {
            // Update existing perks
            $result = updateRecord(
                $con,
                'perks',
                'description, plus_set_id, plus_type_id, increment_id, included, cost_id',
                [$description, $plus_set_id, $plus_type_id, $increment_id, $included, $cost_id],
                $perk_id,
                'Perk updated successfully!',
                'There was a problem updating the perk.',
                'dashboard.php',
                false // Don't show alert, we'll handle it ourselves
            );
            
            if ($result) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Perk updated successfully!',
                    'action' => 'update'
                );
            } else {
                handleError('Failed to update perk');
            }
            
        } else {
            // Insert new perk values
            $result = insertRecord(
                $con,
                'perks',
                'description, plus_set_id, plus_type_id, increment_id, included, cost_id, status',
                [$description, $plus_set_id, $plus_type_id, $increment_id, $included, $cost_id, 0],
                'Perk added successfully!',
                'There was a problem adding the perk.',
                'dashboard.php',
                false // Don't show alert, we'll handle it ourselves
            );
            
            if ($result !== false) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Perk added successfully!',
                    'action' => 'insert'
                );
            } else {
                handleError('Failed to add perk');
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
