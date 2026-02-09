<?php
include "./inc/db_connect.php";
include('api_auth.php');
$experience = $_POST['experience'] ?? '';
$destinationId = $_POST['destination_id'] ?? '';
$destination_name = explode(', ', $_POST['destination_name'] ?? '');
$city = $destination_name[0] ?? '';
$state = $destination_name[1] ?? '';
$arrival = $_POST['checkIn'] ?? '';
$departure = $_POST['checkOut'] ?? '';

$destinationList = [
    'Las Vegas, NV' => 94511,
    'Orlando, FL' => 34467,
    'Miami, FL' => 28632,
    'Myrtle Beach, SC' => 145014,
    'Gatlinburg, TN' => 150747,
    'Pigeon Forge, TN' => 151709,
    'Hilton Head, SC' => 144760,
    'Branson, MO' => 87419,
    'Virginia Beach, VA' => 171657,
    'Park City, UT' => 163309
];

$diffNights = 0;
if (!empty($arrival) && !empty($departure)) {
    $dateArrival = date_create($arrival);
    $dateDeparture = date_create($departure);
    // Check if date_create was successful
    if ($dateArrival !== false && $dateDeparture !== false) {
        $diffDate = date_diff($dateArrival, $dateDeparture);
        $diffNights = $diffDate->days ?? 0;
    }
}

$adults = $_POST['adults'] ?? 0;
$child = $_POST['child'] ?? 0;
$price = $_POST['price'] ?? 0;
$packageData = $_POST['packageData'] ?? '';
$nights = '';
$maxCost = '';
$packages = [];

const PACKAGEQUERY = "SELECT DISTINCT p.*, (p.preview_rate * p.nights) AS total_cost
                FROM packages p
                WHERE p.nights = ? AND (p.preview_rate * p.nights) <= ? AND p.status = 1
                ORDER BY total_cost DESC";

// Function to process packages and add to array
function processPackages($result, $con, $arrival, $destinationList, $price, $maxCost)
{
    $packages = [];
    while ($row = $result->fetch_assoc()) {
        // print_r($row);
        if (strtolower($row['use_hotel_api']) === 'no') {
            // Get hotel data from local DB
            $hotelStmt = $con->prepare("SELECT name, city, state FROM hotels WHERE id = ?");
            $hotelStmt->bind_param('i', $row['hotel_id']);
            $hotelStmt->execute();
            $hotelResult = $hotelStmt->get_result();
            $hotelData = $hotelResult->fetch_assoc();

            $row['name'] = $hotelData['name'] ?? '';
            $row['city'] = $hotelData['city'] ?? '';
            $row['state'] = $hotelData['state'] ?? '';
            $row['arrival'] = $arrival;
            $row['departure'] = date('Y-m-d', strtotime($arrival . ' + ' . $row['nights'] . ' days'));


            $packages[] = $row;
        } else {
            // Get location data for single location_id
            $sql_loc = "SELECT city, state FROM custom_locations WHERE id = ?";
            $stmt_loc = $con->prepare($sql_loc);
            $stmt_loc->bind_param('i', $row['location_id']);
            $stmt_loc->execute();
            $result_loc = $stmt_loc->get_result();
            $location_data = $result_loc->fetch_assoc();

            $location_name = '';
            $location_code = null;
            if ($location_data) {
                $location_name = $location_data['city'] . ', ' . $location_data['state'];
                if (isset($destinationList[$location_name])) {
                    $location_code = $destinationList[$location_name];
                }
            }

            $packages[] = [
                'price' => $price,
                'id' => $row['id'],
                'use_hotel_api' => 'Yes',
                'hotel_id' => $row['hotel_id'],
                'package_title' => $row['package_title'],
                'include_perks' => $row['include_perks'],
                'nights' => $row['nights'],
                'preview_rate' => $row['preview_rate'],
                'everyday_rate' => $row['everyday_rate'],
                'location_name' => $location_name,
                'location_code' => $location_code,
                'checkOut' => date('Y-m-d', strtotime($arrival . ' + ' . $row['nights'] . ' days')),
                'maxCost' => $maxCost
            ];
        }
    }
    return $packages;
}

switch ($price) {
    case '49':
        $nights = 2;
        $maxCost = 150;
        $sql = PACKAGEQUERY;
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ii', $nights, $maxCost);
        $stmt->execute();
        $result = $stmt->get_result();
        $packages = processPackages($result, $con, $arrival, $destinationList, $price, $maxCost);
        break;

    case '99':
        $nights = 3;
        $maxCost = 225;
        $sql = PACKAGEQUERY;
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ii', $nights, $maxCost);
        $stmt->execute();
        $result = $stmt->get_result();
        $packages = processPackages($result, $con, $arrival, $destinationList, $price, $maxCost);
        break;

    case '199':
        $nights = 4;
        $maxCost = 300;
        $sql = PACKAGEQUERY;
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ii', $nights, $maxCost);
        $stmt->execute();
        $result = $stmt->get_result();
        $packages = processPackages($result, $con, $arrival, $destinationList, $price, $maxCost);
        break;

    case '399':
        $nights = 4;
        $experience = 3;
        $sql = "SELECT p.*, (p.preview_rate * p.nights) AS total_cost
        FROM packages p
        WHERE p.nights = ? AND p.experience_id = ? AND p.status = 1
        ORDER BY total_cost DESC";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ii', $nights, $experience);
        $stmt->execute();
        $result = $stmt->get_result();
        $packages = processPackages($result, $con, $arrival, $destinationList, $price, $maxCost);
        break;

    default:
        // Handle default case when no specific price is selected
        if (!$departure) {
            // Normal single destination mode
            $sql = "
                SELECT p.*, 
                       h.name AS hotel_name, h.city AS hotel_city, h.state AS hotel_state,
                       cl.city AS location_city, cl.state AS location_state,
                       (p.preview_rate * p.nights) AS total_cost
                FROM packages p
                LEFT JOIN hotels h ON p.hotel_id = h.id
                LEFT JOIN custom_locations cl ON p.location_id = cl.id
                WHERE p.status = 1
                  AND p.experience_id = ?
                  AND (
                        (cl.city IS NOT NULL AND cl.city LIKE ?)
                        OR (p.location_id IS NULL AND h.city LIKE ?)
                      )
                ";

            $stmt = $con->prepare($sql);
            $cityParam = '%' . $city . '%';
            $stmt->bind_param('iss', $experience, $cityParam, $cityParam);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            if (strtolower($row['use_hotel_api']) === 'no') {
                $row['name'] = $row['hotel_name'] ?? '';
                $row['city'] = $row['location_city'] ?? $row['hotel_city'] ?? '';
                $row['state'] = $row['location_state'] ?? $row['hotel_state'] ?? '';
                $row['arrival'] = $arrival;
                $row['departure'] = date('Y-m-d', strtotime($arrival . ' + ' . $row['nights'] . ' days'));

                $packages[] = $row;
            } else {
                $packages[] = [
                    'id' => $row['id'],
                    'use_hotel_api' => 'Yes',
                    'hotel_id' => $row['hotel_id'],
                    'package_title' => $row['package_title'],
                    'include_perks' => $row['include_perks'],
                    'nights' => $row['nights'],
                    'preview_rate' => $row['preview_rate'],
                    'everyday_rate' => $row['everyday_rate'],
                    'destination_id' => $row['location_id'],
                    'city' => $row['location_city'] ?? $row['hotel_city'] ?? '',
                    'state' => $row['location_state'] ?? $row['hotel_state'] ?? '',
                    'checkOut' => (!empty($arrival) && !empty($row['nights']))
                        ? date('Y-m-d', strtotime($arrival . ' + ' . $row['nights'] . ' days'))
                        : null
                ];
            }
        }
}



echo json_encode([
    'data' => array_values($packages),
    'count' => count($packages),
    'page' => 1,
    'pageSize' => 10
]);
