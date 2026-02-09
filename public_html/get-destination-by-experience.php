<?php
include 'inc/db_connect.php';
header('Content-Type: application/json');
$experience = $_POST['experience'] ?? null;

if (!$experience) {
    echo json_encode([]);
    exit;
}

$experience = intval($experience);

// 1. Get packages
$sql = "SELECT location_id FROM packages WHERE experience_id = $experience";
$result = mysqli_query($con, $sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (empty($rows)) {
    echo json_encode([]);
    exit;
}

// Extract location IDs from the result rows
$locationIds = [];
foreach ($rows as $row) {
    $locationIds[] = intval($row['location_id']);
}

// Filter out any zero or invalid values
$locationIds = array_filter($locationIds);

if (empty($locationIds)) {
    echo json_encode([]);
    exit;
}

$idList = implode(',', $locationIds);
$sql = "SELECT * FROM custom_locations WHERE id IN ($idList)";

$result = mysqli_query($con, $sql);
$locations = mysqli_fetch_all($result, MYSQLI_ASSOC);
echo json_encode($locations);