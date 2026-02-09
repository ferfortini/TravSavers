<?php
$page = "manage-promo-codes";
$title = "Manage Promo Codes";
include 'auth_check.php';
include 'includes/header.php';
include 'common.php';
?>
<div class="page-content-wrapper p-xxl-4">

    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h4 class="mb-0"><i class="bi bi-stars pe-2"></i>Manage Promo Code</h4>
            </div>
        </div>

        <div class="col-lg-12 mb-3">
            <div class="card shadow rounded-3 h-100">
                <div class="card-header border-bottom">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div>
                            <div class="h4">Promo Codes</div>
                        </div>
                        <div class="hstack">
                            <button class="btn btn-sm btn-info" id="addPromoCodeButton" data-bs-toggle="modal" data-bs-target="#addPromoCode"><i class="bi bi-plus me-2"></i>Add Promo Code</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive col-lg-12">
                            <table id="promo_codes" class="table table-sm table-hover fw-light display nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Offer Code</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Discount Type</th>
                                        <th>Discount Value</th>
                                        <th>Minimum Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal modal-lg fade" tabindex="-1" id="addPromoCode" aria-hidden="true" data-bs-backdrop="static" data-keyboard="false">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <!-- Title -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="inquiryFormlabel">Create Promo Code</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body p-3">
                        <form class="row g-3 mt-1" id="addEditPromoCodeForm">
                            <input type="hidden" name="promo_code_id" id="promo_code_id" value="">
                            <div class="col-md-12 mb-1">
                                <label class="form-label" for="offer_code">Offer Code:</label>
                                <input type="text" class="form-control" name="offer_code" id="offer_code" value="" placeholder="">
                                <div class="invalid-feedback" id="offer_code-error"></div>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="start_date">Start Date:</label>
                                <div class="input-group input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-calendar fs-5"></i>
                                    </span>
                                    <input type="text" class="form-control flatpickr" name="start_date" id="start_date" placeholder="">
                                </div>
                                <div class="invalid-feedback" id="start_date-error"></div>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="end_date">End Date:</label>
                                <div class="input-group input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-calendar fs-5"></i>
                                    </span>
                                    <input type="text" class="form-control flatpickr" name="end_date" id="end_date" placeholder="">
                                </div>
                                <div class="invalid-feedback" id="end_date-error"></div>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label class="form-label" for="discount_type">Discount Type:</label>
                                <select class="form-select form-select-sm js-choice border-0" name="discount_type" id="discount_type">
                                    <option value="" selected disabled>Select:</option>
                                    <option value="percent">Percentage Discount</option>
                                    <option value="dollar">Dollar Discount</option>
                                </select>
                                <div class="invalid-feedback" id="discount_type-error"></div>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label class="form-label" for="discount_value">Discount Value:</label>
                                <input type="text" class="form-control" name="discount_value" id="discount_value" value="" placeholder="">
                                <div class="invalid-feedback" id="discount_value-error"></div>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label class="form-label" for="min_price">Minimum Price:</label>
                                <input type="text" class="form-control" name="min_price" id="min_price" value="" placeholder="">
                                <div class="invalid-feedback" id="min_price-error"></div>
                            </div>

                            <div class="col-md-12 text-end mt-md-4">
                                <button class="btn btn-info" type="submit" id="submitPromoCodeBtn" name="submitPromoCodeBtn">Create Promo Code <i class="bi bi-chevron-double-right"></i></button>
                                <button type="button" data-bs-dismiss="modal" id="cancelBtn" class="btn btn btn-light cancelButton text-capitalize">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- **************** MAIN CONTENT END **************** -->
<?php include('includes/footer.php'); ?>
</body>

<script src="../assets/js/admin/manage-promo-code.js"></script>