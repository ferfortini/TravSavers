<?php
$page = "manage-perks";
$title = "Create a new package";
include 'auth_check.php';
include 'includes/header.php';
include 'common.php';
?>
<?php
$values = mysqli_query($con, "SELECT * FROM perk_values");
?>
<div class="page-content-wrapper p-xxl-4">

    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h4 class="mb-0"><i class="bi bi-stars pe-2"></i>Manage Perks</h4>
            </div>
        </div>

        <div class="col-lg-12 mb-3">
            <div class="card shadow rounded-3 h-100">
                <div class="card-header border-bottom">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div>
                            <div class="h4">Perks</div>
                        </div>
                        <div class="hstack">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#addPerk"><i class="bi bi-plus me-2"></i>Add Perk</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive col-lg-12">
                            <table id="perks" class="table table-sm table-hover fw-light display nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>PLUS+ Set</th>
                                        <th>PLUS+ Type</th>
                                        <th>Description</th>
                                        <th>Increment</th>
                                        <th>Included</th>
                                        <th>Cost</th>
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

        <div class="modal modal-lg fade" tabindex="-1" id="addPerk" aria-hidden="true" data-bs-backdrop="static" data-keyboard="false">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <!-- Title -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="inquiryFormlabel">Create New Perk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body p-3">
                        <form class="row g-3 mt-1" id="addEditPerkForm">
                            <input type="hidden" name="perk_id" id="perk_id" value="">
                            <div class="col-md-12 mb-1">
                                <label class="form-label" for="description">Description:</label>
                                <input type="text" class="form-control" name="description" id="description" value="" placeholder="">
                                <div class="invalid-feedback" id="description-error"></div>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="selectPlusSet">Plus+ Set:</label>
                                <select class="form-select form-select-sm js-choice border-0" name="plusSet" id="plusSet">
                                    <option value="" selected disabled>Select:</option>
                                    <?php foreach ($values as $set) {
                                        if ($set['category'] == 'PLUS+_set') { ?>
                                            <option value="<?php echo $set['id']; ?>"><?php echo $set['value']; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                                <div class="invalid-feedback" id="plusSet-error"></div>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="selectPlusType">Plus+ Type:</label>
                                <select class="form-select form-select-sm js-choice border-0" name="plusType" id="plusType">
                                    <option value="" selected disabled>Select:</option>
                                    <?php foreach ($values as $type) {
                                        if ($type['category'] == 'PLUS+_type') { ?>
                                            <option value="<?php echo $type['id']; ?>"><?php echo $type['value']; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                                <div class="invalid-feedback" id="plusType-error"></div>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label class="form-label" for="increment">Increment:</label>
                                <select class="form-select form-select-sm js-choice border-0" name="increment" id="increment">
                                    <option value="" selected disabled>Select:</option>
                                    <?php foreach ($values as $increment) {
                                        if ($increment['category'] == 'increment') { ?>
                                            <option value="<?php echo $increment['id']; ?>"><?php echo $increment['value']; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                                <div class="invalid-feedback" id="increment-error"></div>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label class="form-label" for="included">Included:</label>
                                <select class="form-select form-select-sm js-choice border-0" name="included" id="included">
                                    <option value="" selected disabled>Select:</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <div class="invalid-feedback" id="included-error"></div>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label class="form-label" for="cost">Cost:</label>
                                <select class="form-select form-select-sm js-choice border-0" name="cost" id="cost">
                                    <option value="" selected disabled>Select:</option>
                                    <?php foreach ($values as $cost) {
                                        if ($cost['category'] == 'cost') { ?>
                                            <option value="<?php echo $cost['id']; ?>">$<?php echo $cost['value']; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                                <div class="invalid-feedback" id="cost-error"></div>
                            </div>

                            <div class="col-md-12 text-end mt-md-4">
                                <button class="btn btn-info" type="submit" id="submitPerkBtn" name="submitPerkBtn">Create Perk <i class="bi bi-chevron-double-right"></i></button>
                                <button type="button" data-bs-dismiss="modal" id="cancelBtn" class="btn btn btn-light cancelButton text-capitalize">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="h4">Create Perk Values</div>
                        </div>
                    </div>

                    <form class="row g-3 mt-1" id="addEditPerkValues">
                        <div class="col-md-12 mb-1">
                            <label class="form-label">Category</label>
                            <select class="form-select form-select-sm js-choice border-0" name="category" id="category">
                                <option value="" selected disabled>Choose a Category</option>
                                <option value="PLUS+_set">PLUS+ Set</option>
                                <option value="PLUS+_type">PLUS+ Type</option>
                                <option value="increment">Increment</option>
                                <option value="cost">Cost</option>
                            </select>
                            <div class="invalid-feedback" id="category-error"></div>
                        </div>

                        <div class="col-md-4 mb-1">
                            <label class="form-label">Type</label>
                            <select class="form-select form-select-sm js-choice border-0" name="type" id="type">
                                <option value="" selected disabled>Select:</option>
                                <option value="text">Text</option>
                                <option value="usd">USD</option>
                            </select>
                            <div class="invalid-feedback" id="type-error"></div>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label" for="value">Value</label>
                            <input type="text" class="form-control" name="value" id="value" value="" placeholder="">
                            <div class="invalid-feedback" id="value-error"></div>
                        </div>

                        <div class="col-md-12 text-end mt-md-4">
                            <button class="btn btn-info" type="submit" id="submitPerkValueBtn" name="submitPerkValueBtn">Create Value <i class="bi bi-chevron-double-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-5">
            <div class="card shadow rounded-3 h-100">
                <div class="card-header border-bottom">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div>
                            <div class="h4">Custom Perk Values</div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive col-lg-12">
                            <table id="perkValues" class="table table-sm table-hover fw-light display nowrap">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Category</th>
                                        <th>Value</th>
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

<!----Modal Edit Perk Values---->
<div class="modal modal-lg fade" tabindex="-1" id="editPerkValues" aria-hidden="true" data-bs-backdrop="static" data-keyboard="false">
    <div class="modal-dialog ">
        <div class="modal-content">
            <!-- Title -->
            <div class="modal-header">
                <h5 class="modal-title" id="inquiryFormlabel">Edit Perk Values</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-3">
                <form class="row g-3 mt-1" id="editPerkValuesForm">
                    <input type="hidden" name="perk_values_id" id="perk_values_id" value="">

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="selectPlusSet">Category</label>
                        <select class="form-select form-select-sm js-choice border-0" name="category" id="editCategory">
                            <option value="" selected disabled>Choose a category</option>
                            <option value="PLUS+_set">PLUS+ Set</option>
                            <option value="PLUS+_type">PLUS+ Type</option>
                            <option value="increment">Increment</option>
                            <option value="cost">Cost</option>
                        </select>
                        <div class="invalid-feedback" id="editCategory-error"></div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="selectPlusSet">Type</label>
                        <select class="form-select form-select-sm js-choice border-0" name="type" id="editType">
                            <option value="" selected disabled>Select:</option>
                            <option value="text">Text</option>
                            <option value="usd">USD</option>
                        </select>
                        <div class="invalid-feedback" id="editType-error"></div>
                    </div>

                    <div class="col-md-12 mb-1">
                        <label class="form-label" for="value">Value</label>
                        <input type="text" class="form-control" name="value" id="editValue" value="" placeholder="">
                        <div class="invalid-feedback" id="editValue-error"></div>
                    </div>

                    <div class="col-md-12 text-end mt-md-4">
                        <button class="btn btn-info" type="submit" id="submitPerkValueBtn" name="submitPerkValueBtn">Update Value <i class="bi bi-chevron-double-right"></i></button>
                        <button type="button" data-bs-dismiss="modal" id="cancelBtn" class="btn btn btn-light cancelButton text-capitalize">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- **************** MAIN CONTENT END **************** -->
<?php include('includes/footer.php'); ?>
</body>
<script src="../assets/js/admin/manage-perks.js"></script>