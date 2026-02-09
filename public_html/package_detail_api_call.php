<?php
include('inc/db_connect.php');
$packageId = $_POST['package_id'];

$query = "SELECT * FROM packages WHERE id = $packageId";
$result = mysqli_query($con, $query);
$package = mysqli_fetch_assoc($result);

echo json_encode($package);
