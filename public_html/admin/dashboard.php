<?php
$page = "dashboard";
$title = "Dashboard";
include 'auth_check.php';
include 'includes/header.php';
?>

<div class="page-content-wrapper p-xxl-4">

    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h4 class="mb-0">Published Packages</h4>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card shadow rounded-3 h-100">
                <div class="card-header border-bottom">
                    <div class="d-sm-flex justify-content-end align-items-center">
                        <div class="dropdown">
                            <a class="btn btn-success btn-sm rounded-1" href="manage-packages.php" role="button" aria-expanded="false">
                                <i class="bi bi-plus-circle pe-2"> </i>Create New
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 table-responsive">
                            <table id="packages" class="table table-hover fw-light display nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Published</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Experience</th>
                                        <th>Type</th>
                                        <th class="text-end">Nights</th>
                                        <th class="text-end">Preview Rate</th>
                                        <th class="text-end">Every Day Rate</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- **************** MAIN CONTENT END **************** -->
<?php include('includes/footer.php'); ?>
<script src="../assets/js/admin/dashboard.js"></script>
</body>