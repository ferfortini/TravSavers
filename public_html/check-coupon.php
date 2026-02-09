<?php
require 'inc/db_connect.php';

$coupon_code = trim($_POST['coupon_code'] ?? '');
$cart_total = floatval($_POST['cart_total'] ?? 0);
$current_date = date('Y-m-d');

$response = ['success' => false, 'message' => 'Invalid coupon code.'];

// Prepare the statement
$stmt = $con->prepare("SELECT * FROM promo_codes WHERE offer_code = ? LIMIT 1");
$stmt->bind_param("s", $coupon_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $is_active = $row['status'] == 1;
    $start_date = $row['start_date'];
    $end_date = $row['end_date'];
    $min_price = floatval($row['min_price']);

    if ($current_date >= $start_date && $current_date <= $end_date && $is_active) {
        if ($cart_total >= $min_price) {
            $response = [
                'success' => true,
                'discount' => $row['discount_value'],
                'discount_type' => $row['discount_type'],
                'message' => 'Coupon applied successfully!'
            ];
        } else {
            $response['message'] = "Minimum purchase amount of $" . number_format($min_price, 2) . " required for this coupon.";
        }
    } else {
        $response['message'] = ($current_date > $end_date) ? "This coupon has expired." : "This coupon is not yet active.";
    }
}

echo json_encode($response);
