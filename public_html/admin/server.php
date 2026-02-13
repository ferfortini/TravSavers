<?php
include('../inc/db_connect.php');
include('common.php');

$table = $_GET['table'] ?? '';
$columnsRaw = $_GET['columns'] ?? [];
if (is_string($columnsRaw)) {
    $columnsRaw = json_decode($columnsRaw, true);
}
$columns = array_map(fn($col) => $col['data'], $columnsRaw ?? []);
$limit = (int)($_GET['length'] ?? 10);
$start = (int)($_GET['start'] ?? 0);
$search = $_GET['search'] ?? '';
$orderDir = ($_GET['sortDirection'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
$sortColumn = $_GET['sortColumn'] ?? 'id';

// Total count (unfiltered)
if ($table === 'packages') {
    $totalQuery = "
        SELECT COUNT(DISTINCT p.id) AS total FROM packages p
            INNER JOIN experiences e ON p.experience_id = e.id
            INNER JOIN experience_type et ON p.experience_type_id = et.id
            INNER JOIN night_rates nr ON p.additional_night_rate = nr.id
            LEFT JOIN custom_locations ON JSON_CONTAINS(p.location_id, JSON_QUOTE(CAST(custom_locations.id AS CHAR)))
            LEFT JOIN hotels ON custom_locations.city = hotels.city AND custom_locations.state = hotels.state";
} else {
    $totalQuery = "SELECT COUNT(*) as total FROM `$table`";
}
$totalResult = $con->query($totalQuery);
$totalData = $totalResult ? (int)$totalResult->fetch_assoc()['total'] : 0;

// Searchable columns (only for valid ones)
$validCols = [
    'package_title',
    'description',
    'preview_rate',
    'everyday_rate',
    'status',
    'nights',
    'upgrade_cost',
    'experience_name',
    'experience_type_name',
    'offer_code',
    'start_date',
    'end_date',
    'discount_type',
    'discount_value',
    'category',
    'type',
    'value',
    'plus_set',
    'plus_type',
    'increment',
    'included',
    'cost',
    'state',
    'city',
    'country',
    'name',
    'address',
    'zip'
];

// Build WHERE clause
$where = "";
$paramTypes = "";
$params = [];

if (!empty($search)) {
    $searchClauses = [];

    foreach ($columns as $col) {
        if (!in_array($col, $validCols)) continue;

        if ($table === 'packages') {
            if ($col === 'experience_id') {
                $searchClauses[] = "e.name LIKE ?";
            } elseif ($col === 'experience_type_id') {
                $searchClauses[] = "et.name LIKE ?";
            } else {
                $searchClauses[] = "p.$col LIKE ?";
            }
        } else {
            $searchClauses[] = "$col LIKE ?";
        }

        $params[] = "%$search%";
        $paramTypes .= "s";
    }

    if ($searchClauses) {
        $where = "WHERE " . implode(" OR ", $searchClauses);
    }
}

// Filtered count
$totalFiltered = $totalData;

if (!empty($where)) {
    if ($table === 'packages') {
        $filteredQuery = "
            SELECT COUNT(DISTINCT p.id) AS total
            FROM packages p
            INNER JOIN experiences e ON p.experience_id = e.id
            INNER JOIN experience_type et ON p.experience_type_id = et.id
            INNER JOIN night_rates nr ON p.additional_night_rate = nr.id
            LEFT JOIN custom_locations ON JSON_CONTAINS(p.location_id, JSON_QUOTE(CAST(custom_locations.id AS CHAR)))
            LEFT JOIN hotels ON custom_locations.city = hotels.city AND custom_locations.state = hotels.state
            $where
        ";
    } else {
        $filteredQuery = "SELECT COUNT(*) as total FROM `$table` $where";
    }

    $stmt = $con->prepare($filteredQuery);
    if ($stmt) {
        $stmt->bind_param($paramTypes, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalFiltered = $result->fetch_assoc()['total'] ?? 0;
        $stmt->close();
    } else {
        echo json_encode(["error" => "Filtered count error", "sql" => $filteredQuery, "db" => $con->error]);
        exit;
    }
}

// Main data query
$data = [];

if ($table === 'packages') {
    $dataQuery = "
        SELECT 
            p.id,
            p.package_title,
            p.description,
            p.preview_rate,
            p.everyday_rate,
            p.published_at,
            p.include_perks,
            p.optional_perks,
            p.upgrade_cost,
            p.status,
            p.use_hotel_api,
            p.image,
            p.nights,
            p.hotel_display_threshold,
            p.hotel_id,
            p.location_id,
            e.id AS experience_id,
            e.name AS experience_name,
            et.id AS experience_type_id,
            et.name AS experience_type_name,
            nr.id AS additional_night_rate_id,
            GROUP_CONCAT(DISTINCT custom_locations.country) AS country,
            CONCAT('[', 
                GROUP_CONCAT(DISTINCT CONCAT('\"', custom_locations.id, '\"') SEPARATOR ','), 
            ']') AS location,
            GROUP_CONCAT(DISTINCT CONCAT(custom_locations.city, ', ', custom_locations.state) SEPARATOR '; ') AS location_names,
            GROUP_CONCAT(DISTINCT hotels.name) AS hotel_name,
            nr.value AS additional_night_rate
        FROM packages p
        INNER JOIN experiences e ON p.experience_id = e.id
        INNER JOIN experience_type et ON p.experience_type_id = et.id
        INNER JOIN night_rates nr ON p.additional_night_rate = nr.id
        LEFT JOIN custom_locations 
            ON JSON_CONTAINS(p.location_id, JSON_QUOTE(CAST(custom_locations.id AS CHAR)))
        LEFT JOIN hotels 
            ON custom_locations.city = hotels.city AND custom_locations.state = hotels.state
        $where
        GROUP BY p.id
        ORDER BY p.$sortColumn $orderDir LIMIT ?, ?";
} elseif ($table === 'perks') {
    $dataQuery = "
        SELECT 
            perks.*,
            pv.value AS plus_set,   
            pvt.value AS plus_type,
            iv.value AS increment,
            cv.value AS cost
        FROM perks
        LEFT JOIN perk_values pv ON perks.plus_set_id = pv.id
        LEFT JOIN perk_values pvt ON perks.plus_type_id = pvt.id
        LEFT JOIN perk_values iv ON perks.increment_id = iv.id
        LEFT JOIN perk_values cv ON perks.cost_id = cv.id
        $where
        GROUP BY perks.id
        ORDER BY perks.$sortColumn $orderDir
        LIMIT ?, ?
    ";
} elseif ($table === 'hotels') {
    $dataQuery = "
    SELECT 
        hotels.*,
        GROUP_CONCAT(DISTINCT ha.name) AS amenities,
        GROUP_CONCAT(DISTINCT ha.id) AS amenities_id,
        GROUP_CONCAT(DISTINCT hi.name) AS hotel_images
    FROM hotels
    LEFT JOIN hotel_amenities ha ON hotels.id = ha.hotel_id
    LEFT JOIN hotel_images hi ON hotels.id = hi.hotel_id
    $where
    GROUP BY hotels.id
    ORDER BY hotels.$sortColumn $orderDir
    LIMIT ?, ?
";
} else {
    $dataQuery = "SELECT * FROM `$table` $where ORDER BY $sortColumn $orderDir LIMIT ?, ?";
}

// Prepare and bind
$stmt = $con->prepare($dataQuery);
if ($stmt) {
    if (!empty($params)) {
        $paramTypes .= "ii";
        $params[] = $start;
        $params[] = $limit;
        $stmt->bind_param($paramTypes, ...$params);
    } else {
        $stmt->bind_param("ii", $start, $limit);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        if ($table === 'packages' && isset($row['image'])) {
            $row['image'] = getImagePath($row['image']);
        }
        $data[] = $row;
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Main query error", "sql" => $dataQuery, "db" => $con->error]);
    exit;
}

// Final output
echo json_encode([
    "draw" => intval($_GET['draw'] ?? 0),
    "recordsTotal" => $totalData,
    "recordsFiltered" => $totalFiltered,
    "data" => $data
]);
