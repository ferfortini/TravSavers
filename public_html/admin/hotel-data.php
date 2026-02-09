<?php
/**
 * Hotel Data Retrieval Script
 * Fetches hotel information based on provided hotel ID
 */

require '../inc/db_connect.php';
header('Content-Type: application/json');

$hotelId = $_POST['hotelId'];

// Prepare statement to prevent SQL injection with joins
$stmt = mysqli_prepare($con, "
    SELECT 
        h.*,
        GROUP_CONCAT(DISTINCT hi.name) as images,
        GROUP_CONCAT(DISTINCT ha.name) as amenities
    FROM hotels h
    LEFT JOIN hotel_images hi ON h.id = hi.hotel_id
    LEFT JOIN hotel_amenities ha ON h.id = ha.hotel_id
    WHERE h.id = ?
    GROUP BY h.id
");

if ($stmt) {
    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "s", $hotelId);
    
    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    // Get the result
    $result = mysqli_stmt_get_result($stmt);
    
    // Fetch the data
    $hotelData = mysqli_fetch_assoc($result);
    
    // Close the statement
    mysqli_stmt_close($stmt);
    
    // Process the data
    if ($hotelData) {
        // Convert comma-separated strings to arrays
        $hotelData['images'] = $hotelData['images'] ? explode(',', $hotelData['images']) : [];
        $hotelData['amenities'] = $hotelData['amenities'] ? explode(',', $hotelData['amenities']) : [];
        
        echo json_encode([
            'status' => 'success',
            'data' => $hotelData
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Hotel not found'
        ]);
    }
} else {
    // Handle error if preparation fails
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . mysqli_error($con)
    ]);
    error_log("Failed to prepare statement: " . mysqli_error($con));
}
