<?php
include('../../inc/db_connect.php');
include('../common.php');
session_start();
header('Content-Type: application/json');

// Custom function to insert hotel and return the last inserted ID
function saveHotel($con, $hotelData, $hotelId = null)
{
    if ($hotelId) {
        // UPDATE
        $query = "UPDATE hotels SET name = ?, country = ?, state = ?, city = ?, address = ?, zip = ?, lat = ?, lng = ?, rating = ? WHERE id = ?";
    } else {
        // INSERT
        $query = "INSERT INTO hotels (name, country, state, city, address, zip, lat, lng, rating) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    }

    $stmt = mysqli_prepare($con, $query);

    if (!$stmt) {
        return false;
    }

    if ($hotelId) {
        mysqli_stmt_bind_param(
            $stmt,
            'ssssssssis',
            $hotelData['name'],
            $hotelData['country'],
            $hotelData['state'],
            $hotelData['city'],
            $hotelData['address'],
            $hotelData['zip'],
            $hotelData['lat'],
            $hotelData['lng'],
            $hotelData['rating'],
            $hotelId
        );
    } else {
        mysqli_stmt_bind_param(
            $stmt,
            'ssssssssi',
            $hotelData['name'],
            $hotelData['country'],
            $hotelData['state'],
            $hotelData['city'],
            $hotelData['address'],
            $hotelData['zip'],
            $hotelData['lat'],
            $hotelData['lng'],
            $hotelData['rating']
        );
    }

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($result) {
        return $hotelId ?: mysqli_insert_id($con);
    }

    return false;
}

// Function to delete hotel images that are no longer needed
function deleteUnusedHotelImages($con, $hotelId, $retainedImages)
{
    // Get all current images for this hotel
    $stmt = mysqli_prepare($con, "SELECT name FROM hotel_images WHERE hotel_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $hotelId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $currentImages = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $currentImages[] = $row['name'];
        }
        mysqli_stmt_close($stmt);
        
        // Find images that are no longer needed
        $imagesToDelete = array_diff($currentImages, $retainedImages);
        
        // Delete the unused images from server and database
        foreach ($imagesToDelete as $imageName) {
            $imagePath = '../uploads/hotel_images/' . $imageName;
            deleteImageFile($imagePath);
            
            // Delete from database
            $deleteStmt = mysqli_prepare($con, "DELETE FROM hotel_images WHERE hotel_id = ? AND name = ?");
            if ($deleteStmt) {
                mysqli_stmt_bind_param($deleteStmt, 'is', $hotelId, $imageName);
                mysqli_stmt_execute($deleteStmt);
                mysqli_stmt_close($deleteStmt);
            }
        }
    }
}

$response = array();

if (isset($_FILES['hotelImage']) && $_FILES['hotelImage']['error'][0] !== 4) {
    $imageResult = uploadMultipleImage();
    $imagePaths = $imageResult['imagePaths'] ?? [];
}

$existingImages = [];
if (isset($_POST['existingImages']) && !empty($_POST['existingImages'])) {
    $existingImages = explode(',', $_POST['existingImages']);
}

// Merge retained + new images
if (isset($imagePaths)) {
    $allImages = array_merge($existingImages, $imagePaths);
} else {
    $allImages = $existingImages;
}

if (isset($_POST['hotel_id']) && !empty($_POST['hotel_id'])) {
    // Update existing hotel
    $hotelData = [
        'name' => $_POST['hotelName'],
        'country' => $_POST['hotelCountry'],
        'state' => $_POST['hotelState'],
        'city' => $_POST['hotelCity'],
        'address' => $_POST['address'],
        'zip' => $_POST['zip'],
        'lat' => '',
        'lng' => '',
        'rating' => $_POST['starRating']
    ];
    $hotelId = $_POST['hotel_id'];
    saveHotel($con, $hotelData, $hotelId);

    // Delete unused hotel images
    deleteUnusedHotelImages($con, $hotelId, $allImages);

    // Update amenities - first delete existing ones
    mysqli_query($con, "DELETE FROM hotel_amenities WHERE hotel_id = " . $hotelId);
    foreach ($_POST['amenities'] as $amenity) {
        if (!empty(trim($amenity))) {
            $success = insertRecord(
                $con,
                'hotel_amenities',
                'hotel_id, name',
                [$_POST['hotel_id'], trim($amenity)],
                null,
                null,
                null,
                false
            );
        }
    }

    // Insert new images (only the new ones, not the retained ones)
    if (isset($imagePaths)) {
        foreach ($imagePaths as $imageName) {
            insertRecord(
                $con,
                'hotel_images',
                'hotel_id, name',
                [$hotelId, $imageName],
                null,
                null,
                null,
                false
            );
        }
    }
    $response = array(
        'status' => 'success',
        'message' => 'Hotel updated successfully!'
    );
} else {
    $amenities = $_POST['amenities'];
    // Prepare hotel data
    $hotelData = [
        'name' => $_POST['hotelName'],
        'country' => $_POST['hotelCountry'],
        'state' => $_POST['hotelState'],
        'city' => $_POST['hotelCity'],
        'address' => $_POST['address'],
        'zip' => $_POST['zip'],
        'lat' => '',
        'lng' => '',
        'rating' => $_POST['starRating']
    ];

    // Insert hotel and get the last inserted ID
    $lastInsertId = saveHotel($con, $hotelData);

    if ($lastInsertId !== false) {
        $_SESSION['last_hotel_id'] = $lastInsertId;

        if (isset($amenities) && is_array($amenities)) {
            foreach ($amenities as $amenity) {
                if (!empty(trim($amenity))) {
                    insertRecord(
                        $con,
                        'hotel_amenities',
                        'hotel_id, name',
                        [$lastInsertId, trim($amenity)],
                        null,
                        null,
                        null,
                        false
                    );
                }
            }
        }

        if (!empty($imagePaths)) {
            foreach ($imagePaths as $imagePath) {
                insertRecord(
                    $con,
                    'hotel_images',
                    'hotel_id, name',
                    [$lastInsertId, $imagePath],
                    null,
                    null,
                    null,
                    false
                );
            }
        }
        $response = array(
            'status' => 'success',
            'message' => 'Hotel added successfully!'
        );
    }
}

echo json_encode($response);