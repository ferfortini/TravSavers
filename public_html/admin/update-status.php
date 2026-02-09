<?php 
include('../inc/db_connect.php');
include 'common.php';
$pageUrl  = 'manage-perks.php';
if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $table = $_POST['table'];
    $successMsg = "Status updated successfully!";
    $errorMsg = "Error updating status!";
    statusChange($con, $table, $id, $status, $successMsg, $errorMsg, $pageUrl);
}
?>