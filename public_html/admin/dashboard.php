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
                                        <th>Action</th>
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

<!-----Package View Modal ----------->
<div class="modal modal-xl fade" tabindex="-1" id="packageViewModal" aria-hidden="true" data-bs-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Title -->
            <div class="modal-header">
                <h5 class="modal-title">Package Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-12 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4 class="mb-2" id="view-package-title"></h4>
                                        <p class="text-muted mb-0" id="view-package-description"></p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <div id="view-package-image-container" class="mb-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Published Date</label>
                        <p class="mb-0" id="view-published-at"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <p class="mb-0">
                            <span class="badge" id="view-status-badge"></span>
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Experience</label>
                        <p class="mb-0" id="view-experience"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Experience Type</label>
                        <p class="mb-0" id="view-experience-type"></p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Preview Rate</label>
                        <p class="mb-0" id="view-preview-rate"></p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Every Day Rate</label>
                        <p class="mb-0" id="view-everyday-rate"></p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Nights</label>
                        <p class="mb-0" id="view-nights"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Additional Night Rate</label>
                        <p class="mb-0" id="view-additional-night-rate"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Use Hotel API</label>
                        <p class="mb-0" id="view-use-hotel-api"></p>
                    </div>

                    <div class="col-md-6 mb-3" id="view-hotel-display-threshold-wrapper">
                        <label class="form-label fw-bold">Hotel Display Threshold</label>
                        <p class="mb-0" id="view-hotel-display-threshold"></p>
                    </div>

                    <div class="col-md-6 mb-3" id="view-hotel-name-wrapper" style="display: none;">
                        <label class="form-label fw-bold">Custom Hotel</label>
                        <p class="mb-0" id="view-hotel-name"></p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Location(s)</label>
                        <p class="mb-0" id="view-location"></p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Include Perks</label>
                        <div id="view-include-perks"></div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Optional Perks</label>
                        <div id="view-optional-perks"></div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- **************** MAIN CONTENT END **************** -->
<?php include('includes/footer.php'); ?>
<script src="../assets/js/admin/dashboard.js"></script>
</body>