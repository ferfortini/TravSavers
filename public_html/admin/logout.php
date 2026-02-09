<?php
session_start();
session_destroy();
include '../admin/includes/head-link.php';
?>
<script>
    successToaster("Logout successfully!");
    setTimeout(function() {
        window.location.href = "dashboard.php";
    }, 1000);
</script>
