<?php
include('../../inc/db_connect.php');
include('../common.php');
$imageName = $_POST['image'];
$hotelId = $_POST['hotelId'];
$imagePath = '../uploads/hotel_images/' . $imageName;

deleteImageFile($imagePath);

$deleteData = mysqli_query($con, "DELETE FROM hotel_images WHERE hotel_id = '$hotelId' AND name = '$imageName'");
if ($deleteData) {
    $response = [
        'status' => 'success',
        'message' => 'Image deleted successfully!'
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'Image not deleted '
    ];
}
echo json_encode($response);