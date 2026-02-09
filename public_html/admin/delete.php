<?php 
include('../inc/db_connect.php');
include 'common.php';
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $table = $_POST['table'];
    $successMsg = "Deleted successfully!";
    $errorMsg = "Error deleting record!";
    deleteRecord($con, $table, $id, $successMsg, $errorMsg);
}
?>