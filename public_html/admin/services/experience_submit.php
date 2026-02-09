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
    $name = trim($_POST['name'] ?? '');
    $experience_id = $_POST['experience_id'] ?? '';
    
    // Validate input
    if (empty($name)) {
        handleError('Experience name is required');
    }
    
    try {
        if (!empty($experience_id)) {
            // Update existing experience
            $result = updateRecord(
                $con,
                'experiences',
                'name',
                [$name],
                $experience_id,
                'Experience updated successfully!',
                'There was a problem updating the experience.',
                'dashboard.php',
                false // Don't show alert, we'll handle it ourselves
            );
            
            if ($result) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Experience updated successfully!',
                    'action' => 'update'
                );
            } else {
                handleError('Failed to update experience');
            }
            
        } else {
            // Insert new experience
            $result = insertRecord(
                $con,
                'experiences',
                'name',
                [$name],
                'Experience added successfully!',
                'There was a problem adding the experience.',
                'dashboard.php',
                false // Don't show alert, we'll handle it ourselves
            );
            
            if ($result !== false) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Experience added successfully!',
                    'action' => 'insert'
                );
            } else {
                handleError('Failed to add experience');
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
