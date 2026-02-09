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
    $experience_id = $_POST['experience_type_id'] ?? '';
    
    // Validate input
    if (empty($name)) {
        handleError('Experience type name is required');
    }
    
    try {
        if (!empty($experience_id)) {
            // Update existing experience
            $result = updateRecord(
                $con,
                'experience_type',
                'name',
                [$name],
                $experience_id,
                'Experience type updated successfully!',
                'There was a problem updating the experience type.',
                'dashboard.php',
                false // Don't show alert, we'll handle it ourselves
            );
            
            if ($result) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Experience type updated successfully!',
                    'action' => 'update'
                );
            } else {
                handleError('Failed to update experience type');
            }
            
        } else {
            // Insert new experience
            $result = insertRecord(
                $con,
                'experience_type',
                'name',
                [$name],
                'Experience type added successfully!',
                'There was a problem adding the experience type.',
                'dashboard.php',
                false // Don't show alert, we'll handle it ourselves
            );
            
            if ($result !== false) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Experience type added successfully!',
                    'action' => 'insert'
                );
            } else {
                handleError('Failed to add experience type');
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
