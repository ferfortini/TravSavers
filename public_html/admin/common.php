<?php

/**
 * Shows a Swal alert with a given message and type, then redirects to the given URL when the alert is closed.
 *
 * @param string $message The message to display in the alert
 * @param string $type The type of alert to display (e.g. 'success', 'error', etc.)
 * @param string $redirectUrl The URL to redirect to after the alert is closed
 */ function showAlertAndRedirect($message, $type, $redirectUrl)
{
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '<?php echo $type; ?>',
                title: '<?php echo ucfirst($type); ?>',
                text: '<?php echo $message; ?>'
            }).then(() => {
                setTimeout(function() {
                    window.location.href = '<?php echo $redirectUrl; ?>';
                }, 2000); // delay the redirect by 2 seconds
            });
        });
    </script>
<?php
}


/**
 * Renders a Bootstrap pagination component based on the given parameters.
 *
 * @param int $total_records Total number of records
 * @param int $limit Number of records per page
 * @param int $current_page The current page number
 * @param string $type The type of pagination to render (e.g. 'page' or 'hotel_page')
 * @param string $base_url The base URL for the pagination links
 *
 * @return string The rendered HTML output
 */
function renderPagination($total_records, $limit, $current_page, $type = 'page', $base_url = '?')
{
    $base_url .= $type . '=';
    $total_pages = ceil($total_records / $limit);
    $offset = ($current_page - 1) * $limit;

    ob_start(); // Start output buffering
?>
    <div class="d-sm-flex justify-content-sm-between align-items-sm-center">
        <p class="mb-sm-0 text-center text-sm-start">
            Showing <?= $offset + 1 ?> to <?= min($offset + $limit, $total_records) ?> of <?= $total_records ?> Locations
        </p>

        <nav class="mb-sm-0 d-flex justify-content-center" aria-label="navigation">
            <ul class="pagination pagination-sm pagination-primary-soft mb-0">
                <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $base_url . ($current_page - 1) ?>">Prev</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
                        <a class="page-link" href="<?= $base_url . $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $base_url . ($current_page + 1) ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
<?php
    return ob_get_clean(); // Return the HTML output as a string
}

/**
 * Inserts a new record into a given table with the provided values.
 *
 * @param mysqli $con              The database connection.
 * @param string $table            The name of the table to insert the record into.
 * @param string $fields           A comma-separated list of the fields to insert into.
 * @param array  $values           An array of the values to insert.
 * @param string $successMsg       The message to display if the insert is successful.
 * @param string $errorMsg         The message to display if the insert fails.
 * @param string $pageUrl          The URL to redirect to after inserting the record.
 *
 * @return void
 */
function insertRecord($con, $table, $fields, $values, $successMsg, $errorMsg, $pageUrl, $showAlert = true)
{
    $placeholders = rtrim(str_repeat('?,', count($values)), ',');
    $stmt = mysqli_prepare($con, "INSERT INTO $table ($fields) VALUES ($placeholders)");

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, str_repeat('s', count($values)), ...$values);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if ($result && $showAlert) {
            showAlertAndRedirect($successMsg, 'success', $pageUrl);
        }
        return $result;
    } else {
        if ($showAlert) {
            showAlertAndRedirect($errorMsg, 'error', $pageUrl);
        }
        return false;
    }
}

/**
 * Updates a record in the specified database table.
 *
 * @param mysqli $con The MySQLi connection object.
 * @param string $table The name of the table to update.
 * @param string $fields Comma-separated list of fields to update.
 * @param array $values An array of values corresponding to the fields.
 * @param mixed $id The ID of the record to update.
 * @param string $successMsg The success message to display if the update is successful.
 * @param string $errorMsg The error message to display if the update fails.
 * @param string $pageUrl The URL to redirect to after the update is attempted.
 */

function updateRecord($con, $table, $fields, $values, $id, $successMsg, $errorMsg, $pageUrl, $showAlert = true)
{
    // Handle image deletion for packages when updating
    if ($table == 'packages') {
        // Check if image field is being updated
        $fieldsArray = array_map('trim', explode(',', $fields));
        $imageFieldIndex = array_search('image', $fieldsArray);
        
        if ($imageFieldIndex !== false) {
            // Get the current image path from database
            $stmt = mysqli_prepare($con, "SELECT image FROM packages WHERE id = ?");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'i', $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $currentImagePath);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);

                // Get the new image path from values
                $newImagePath = $values[$imageFieldIndex];
                
                // Delete old image if new image is uploaded and old image exists
                if (!empty($newImagePath) && !empty($currentImagePath) && $newImagePath !== $currentImagePath) {
                    deleteImageFile($currentImagePath);
                }
            }
        }
    }

    // Prepare field assignments like: column1 = ?, column2 = ?
    $fieldsArray = array_map('trim', explode(',', $fields));
    $placeholders = implode(', ', array_map(function ($field) {
        return "$field = ?";
    }, $fieldsArray));

    // Build SQL query
    $sql = "UPDATE $table SET $placeholders WHERE id = ?";

    $stmt = mysqli_prepare($con, $sql);

    // Add the ID to values array
    $values[] = $id;

    // Generate types string (i = integer, d = double, s = string)
    $types = '';
    foreach ($values as $val) {
        if (is_int($val)) {
            $types .= 'i';
        } elseif (is_float($val)) {
            $types .= 'd';
        } else {
            $types .= 's';
        }
    }

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, $types, ...$values);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            mysqli_stmt_close($stmt);
            if ($showAlert) {
                showAlertAndRedirect($successMsg, 'success', $pageUrl);
            }
            return true;
        } else {
            $error = mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
            if ($showAlert) {
                showAlertAndRedirect("$errorMsg Error: $error", 'error', $pageUrl);
            }
            return false;
        }
    } else {
        $prepareError = mysqli_error($con);
        if ($showAlert) {
            showAlertAndRedirect("$errorMsg Prepare Error: $prepareError", 'error', $pageUrl);
        }
        return false;
    }
}


/**
 * Handles the uploading of an image file through a form submission.
 *
 * Validates the uploaded file to ensure it is an image of type JPEG, PNG, or GIF
 * and does not exceed 2MB in size. If the file is valid, it is moved to the
 * 'uploads/' directory with a unique filename. If the upload is successful,
 * returns an array containing the path to the uploaded image. Otherwise, returns
 * an array with an error message.
 *
 * @return array An associative array containing either the 'imagePath' or 'error'.
 */

function uploadImage()
{
    $imagePath = ''; // default fallback

    if (isset($_FILES['featuredImage']) && $_FILES['featuredImage']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['featuredImage']['tmp_name']);
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (in_array($fileType, $allowedTypes)) {
            if ($_FILES['featuredImage']['size'] <= $maxSize) {
                $uploadDir = '../uploads/';
                $fileName = uniqid() . '_' . basename($_FILES['featuredImage']['name']);
                $uploadPath = $uploadDir . $fileName;
               
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true); // create dir if not exists
                }

                if (move_uploaded_file($_FILES['featuredImage']['tmp_name'], $uploadPath)) {
                    $imagePath = $fileName;
                } else {
                    return array('error' => 'Failed to move uploaded image.');
                }
            } else {
                return array('error' => 'Image file exceeds 2MB.');
            }
        } else {
            return array('error' => 'Only JPEG, PNG, and GIF files are allowed.');
        }
    }

    return array('imagePath' => $imagePath);
}


function uploadMultipleImage()
{
    $imagePaths = []; // default fallback
    if (isset($_FILES['hotelImage']) && is_array($_FILES['hotelImage']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        foreach ($_FILES['hotelImage']['name'] as $index => $imageName) {
            $fileType = mime_content_type($_FILES['hotelImage']['tmp_name'][$index]);
            if (in_array($fileType, $allowedTypes)) {
                $uploadDir = '../uploads/hotel_images';
                $fileName = uniqid() . '_' . basename($imageName);
                $uploadPath = $uploadDir . '/' . $fileName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true); // create dir if not exists
                }

                if (move_uploaded_file($_FILES['hotelImage']['tmp_name'][$index], $uploadPath)) {
                    $imagePaths[] = $fileName;
                } else {
                    return array('error' => 'Failed to move uploaded image.');
                }
            } else {
                return array('error' => 'Only JPEG, PNG files are allowed.');
            }
        }
    }

    return array('imagePaths' => $imagePaths);
}
/**
 * Changes the status of a record in the specified database table.
 *
 * @param mysqli $con The MySQLi connection object.
 * @param string $table The name of the table to update.
 * @param int $id The ID of the record to update.
 * @param int $status The new value for the status column.
 * @param string $successMsg The success message to display if the update is successful.
 * @param string $errorMsg The error message to display if the update fails.
 *
 * @return void
 */
function statusChange($con, $table, $id, $status, $successMsg, $errorMsg)
{
    $stmt = mysqli_prepare($con, "UPDATE $table SET status = ? WHERE id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'si', $status, $id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if ($result) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => $successMsg]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $errorMsg]);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $errorMsg]);
    }
}

/**
 * Deletes a record from the specified database table.
 *
 * @param mysqli $con The MySQLi connection object.
 * @param string $table The name of the table to delete from.
 * @param int $id The ID of the record to delete.
 * @param string $successMsg The success message to display if the delete is successful.
 * @param string $errorMsg The error message to display if the delete fails.
 *
 * @return void
 */
function deleteRecord($con, $table, $id, $successMsg, $errorMsg)
{
    // Define relationships between tables and their foreign key dependencies
    $tableRelations = [
        'packages' => [
            ['table' => 'hotels', 'key' => 'hotel_id'],
            ['table' => 'custom_locations', 'key' => 'location_id'],
            ['table' => 'experiences', 'key' => 'experience_id'],
            ['table' => 'experience_type', 'key' => 'experience_type_id'],
            ['table' => 'night_rates', 'key' => 'additional_night_rate']
        ],
        'experiences' => [
            ['table' => 'packages', 'key' => 'experience_id']
        ],
        'experience_type' => [
            ['table' => 'packages', 'key' => 'experience_type_id']
        ],
        'night_rates' => [
            ['table' => 'packages', 'key' => 'additional_night_rate']
        ],
        'custom_locations' => [
            ['table' => 'hotels', 'key' => 'city']
        ],
        'hotels' => [
            ['table' => 'packages', 'key' => 'hotel_id'],
            ['table' => 'hotel_amenities', 'key' => 'hotel_id']
        ],
        'perks' => [
            ['table' => 'perk_values', 'key' => 'plus_set_id'],
            ['table' => 'perk_values', 'key' => 'plus_type_id'],
            ['table' => 'perk_values', 'key' => 'increment_id'],
            ['table' => 'perk_values', 'key' => 'cost_id']
        ],
        'perk_values' => [
            ['table' => 'perks', 'key' => 'plus_set_id'],
            ['table' => 'perks', 'key' => 'plus_type_id'],
            ['table' => 'perks', 'key' => 'increment_id'],
            ['table' => 'perks', 'key' => 'cost_id']
        ]
    ];

    // Check if table has any defined relations
    if (isset($tableRelations[$table])) {
        $relations = $tableRelations[$table];
        $unionQueries = [];

        // Build UNION query to check all relations in a single query
        foreach ($relations as $relation) {
            if ($relation['table'] == 'packages') {
                $unionQueries[] = "(SELECT '{$relation['table']}' as table_name, COUNT(*) as count 
                                  FROM {$relation['table']} 
                                  WHERE {$relation['key']} = $id)";
            }
        }

        if (!empty($unionQueries)) {
            $query = implode(' UNION ALL ', $unionQueries);
            $result = mysqli_query($con, $query);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['count'] > 0) {
                        header('Content-Type: application/json');
                        echo json_encode([
                            'status' => 'error',
                            'message' => "Cannot delete this record as it is linked to other tables."
                        ]);
                        mysqli_free_result($result);
                        return;
                    }
                }
                mysqli_free_result($result);
            }
        }
    }

    // Delete associated image file if deleting a package
    if ($table == 'packages') {
        // Get the image path from the database before deletion
        $stmt = mysqli_prepare($con, "SELECT image FROM packages WHERE id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $imagePath);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            // Delete the image file if it exists and is not empty
            if (!empty($imagePath)) {
                deleteImageFile($imagePath);
            }
        }
    }

    // Delete associated image files if deleting a hotel
    if ($table == 'hotels') {
        // Get all image names for this hotel
        $stmt = mysqli_prepare($con, "SELECT name FROM hotel_images WHERE hotel_id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            // Delete each image file
            while ($row = mysqli_fetch_assoc($result)) {
                $imagePath = '../uploads/hotel_images/' . $row['name'];
                deleteImageFile($imagePath);
            }
            mysqli_stmt_close($stmt);
        }
    }

    // If no relations found or all checks passed, proceed with deletion
    if ($table == 'hotels') {
        // Delete hotel amenities first
        $stmt = mysqli_prepare($con, "DELETE FROM hotel_amenities WHERE hotel_id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    $stmt = mysqli_prepare($con, "DELETE FROM $table WHERE id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header('Content-Type: application/json');
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => $successMsg]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => $errorMsg
            ]);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => $errorMsg
        ]);
    }
}

/**
 * Constructs the full image path from a filename
 *
 * @param string $filename The image filename
 * @return string The full path to the image
 */
function getImagePath($filename)
{
    if (empty($filename)) {
        return '';
    }
    
    // If it's already a full path, return as is
    if (strpos($filename, '/') !== false || strpos($filename, '\\') !== false) {
        return $filename;
    }
    
    // Construct full path from filename
    return '/admin/uploads/' . $filename;
}

/**
 * Deletes an image file from the server if it exists.
 *
 * @param string $imagePath The filename or path to the image file to delete.
 * @return bool True if the file was deleted or doesn't exist, false if deletion failed.
 */
function deleteImageFile($imagePath)
{
    // If it's just a filename (no path separators), construct the full path
    if (!empty($imagePath) && strpos($imagePath, '/') === false && strpos($imagePath, '\\') === false) {
        $imagePath = '../uploads/' . $imagePath;
    }
    
    if (!empty($imagePath) && file_exists($imagePath)) {
        return unlink($imagePath);
    }
    return true; // Return true if file doesn't exist (nothing to delete)
}
