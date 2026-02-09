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
    // Handle image upload first
    $imageResult = uploadImage();
    $imagePath = '';
    
    if (isset($imageResult['imagePath']) && !empty($imageResult['imagePath'])) {
        $imagePath = $imageResult['imagePath'];
    } elseif (isset($imageResult['error'])) {
        handleError('Image upload failed: ' . $imageResult['error']);
        return;
    }
    
    // Now use $imagePath in your database operations
    $package_title = trim($_POST['packageTitle'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $use_hotel_api = trim($_POST['use_hotel_api'] ?? '');
    $experience_id = trim($_POST['experience'] ?? '');
    $experience_type_id = trim($_POST['experienceType'] ?? '');
    $preview_rate = trim($_POST['previewRate'] ?? '');
    $everyday_rate = trim($_POST['everyDayRate'] ?? '');
    $nights = trim($_POST['nights'] ?? '');
    $additional_night_rate = trim($_POST['additionalNightRate'] ?? '');
    $include_perks = trim(json_encode($_POST['includePerks']) ?? '');
    $optional_perks = trim(json_encode($_POST['optionalPerks']) ?? '');
    $upgrade_cost = trim(json_encode($_POST['upgradeCost']) ?? '');
    $package_id = trim($_POST['package_id'] ?? '');

    // Add missing fields
    $hotel_display_threshold = trim($_POST['hotelDisplayThreshold'] ?? '');
    $location_id = trim($_POST['location'] ?? '');
    $hotel_id = trim($_POST['hotelName'] ?? '');
    $current_date = date("Y-m-d");

    try {
        if (!empty($package_id)) {
            // Update existing package
            if ($use_hotel_api === 'Yes') {
                $result = updateRecord(
                    $con,
                    'packages',
                    'package_title, description, use_hotel_api, hotel_display_threshold, location_id, experience_id, experience_type_id, preview_rate, everyday_rate, nights, additional_night_rate, include_perks, optional_perks, upgrade_cost,published_at, image',
                    [$package_title, $description, $use_hotel_api, $hotel_display_threshold, $location_id, $experience_id, $experience_type_id, $preview_rate, $everyday_rate, $nights, $additional_night_rate, $include_perks, $optional_perks, $upgrade_cost,$current_date, $imagePath],
                    $package_id,
                    'Package updated successfully!',
                    'There was a problem updating the package.',
                    'dashboard.php',
                    false // Don't show alert, we'll handle it ourselves
                );
            } else {
                $result = updateRecord(
                    $con,
                    'packages',
                    'package_title, description, use_hotel_api, hotel_id, experience_id, experience_type_id, preview_rate, everyday_rate, nights, additional_night_rate, include_perks, optional_perks, upgrade_cost,published_at, image',
                    [$package_title, $description, $use_hotel_api, $hotel_id, $experience_id, $experience_type_id, $preview_rate, $everyday_rate, $nights, $additional_night_rate, $include_perks, $optional_perks, $upgrade_cost, $current_date, $imagePath],
                    $package_id,
                    'Package updated successfully!',
                    'There was a problem updating the package.',
                    'dashboard.php',
                    false // Don't show alert, we'll handle it ourselves
                );
            }
            
            if ($result) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Package updated successfully!',
                    'action' => 'update'
                );
            } else {
                handleError('Failed to update package');
            }
            
        } else {
            // Insert new package
            if ($use_hotel_api === 'Yes') {
                $result = insertRecord(
                    $con,
                    'packages',
                    'package_title, description, use_hotel_api, hotel_display_threshold, location_id, experience_id, experience_type_id, preview_rate, everyday_rate, nights, additional_night_rate, include_perks, optional_perks, upgrade_cost,published_at, image',
                    [$package_title, $description, $use_hotel_api, $hotel_display_threshold, $location_id, $experience_id, $experience_type_id, $preview_rate, $everyday_rate, $nights, $additional_night_rate, $include_perks, $optional_perks, $upgrade_cost, $current_date, $imagePath],
                    'Package added successfully!',
                    'There was a problem adding the package.',
                    'dashboard.php',
                    false // Don't show alert, we'll handle it ourselves
                );
            } else {
                $result = insertRecord(
                    $con,
                    'packages',
                    'package_title, description, use_hotel_api, hotel_id, experience_id, experience_type_id, preview_rate, everyday_rate, nights, additional_night_rate, include_perks, optional_perks, upgrade_cost,published_at, image',
                    [$package_title, $description, $use_hotel_api, $hotel_id, $experience_id, $experience_type_id, $preview_rate, $everyday_rate, $nights, $additional_night_rate, $include_perks, $optional_perks, $upgrade_cost, $current_date, $imagePath],
                    'Package added successfully!',
                    'There was a problem adding the package.',
                    'dashboard.php',
                    false // Don't show alert, we'll handle it ourselves
                );
            }
            
            if ($result !== false) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Package added successfully!',
                    'action' => 'insert'
                );
            } else {
                handleError('Failed to add package');
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
