<?php
$page = "create-package";
$title = "Create a new package";
include 'auth_check.php';
include 'includes/header.php';
include 'common.php';
?>

<?php
$textNightRates = mysqli_query($con, "SELECT * FROM night_rates WHERE type = 'Text'");
$text_night_rates_data = mysqli_fetch_all($textNightRates, MYSQLI_ASSOC);

$usdNightRates = mysqli_query($con, "SELECT * FROM night_rates WHERE type = 'USD'");
$usd_night_rates_data = mysqli_fetch_all($usdNightRates, MYSQLI_ASSOC);

$experience_types = mysqli_query($con, "SELECT * FROM experience_type ORDER BY id DESC");
$experience_types_data = mysqli_fetch_all($experience_types, MYSQLI_ASSOC);

$experiences = mysqli_query($con, "SELECT * FROM experiences ORDER BY id DESC");
$experiences_data = mysqli_fetch_all($experiences, MYSQLI_ASSOC);

$locations = mysqli_query($con, "SELECT * FROM custom_locations ORDER BY id DESC");
$locations_data = mysqli_fetch_all($locations, MYSQLI_ASSOC);

$hotels = mysqli_query($con, "SELECT * FROM hotels ORDER BY id DESC");
$hotels_data = mysqli_fetch_all($hotels, MYSQLI_ASSOC);

$perks = mysqli_query($con, "SELECT 
            perks.*,
            pv.value AS plus_set,   
            pvt.value AS plus_type,
            iv.value AS increment,
            cv.value AS cost
        FROM perks
        INNER JOIN perk_values pv ON perks.plus_set_id = pv.id
        INNER JOIN perk_values pvt ON perks.plus_type_id = pvt.id
        INNER JOIN perk_values iv ON perks.increment_id = iv.id
        INNER JOIN perk_values cv ON perks.cost_id = cv.id ORDER BY perks.id DESC");
$perks_data = mysqli_fetch_all($perks, MYSQLI_ASSOC);
?>
<div class="page-content-wrapper p-xxl-4">
    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h4 class="mb-0">Create a new package</h4>
            </div>
        </div>

        <div class="col-lg-12 mb-5">
            <div class="card shadow rounded-1 h-100">
                <div class="card-body">
                    <form class="row g-3" id="addEditPackageForm" enctype="multipart/form-data">
                        <div class="col-md-3 mb-3">
                            <label class="form-label req">Package Title</label>
                            <input type="text" class="form-control packageTitle" name="packageTitle" id="packageTitle" value="" placeholder="">
                            <div class="invalid-feedback packageTitle-error"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label req" for="description">Package Description</label>
                            <input type="text" class="form-control description" name="description" id="description" value="" placeholder="">
                            <div class="invalid-feedback description-error"></div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label req" for="featuredImage">Featured Image</label>
                            <input type="file" class="form-control featuredImage" name="featuredImage" id="featuredImage">
                            <div id="featuredImagePreview" class="mt-2"></div>
                            <div class="invalid-feedback featuredImage-error d-block"></div>
                        </div>
                        <div class="mb-3 col-md-2">
                            <label class="form-label req">Use Hotel API?</label>
                            <select id="use_hotel_api" class="form-select form-select-sm js-choice border-0 use_hotel_api" name="use_hotel_api">
                                <option value="Yes" selected>Yes</option>
                                <option value="No">No</option>
                            </select>
                            <div class="invalid-feedback use_hotel_api-error"></div>
                        </div>
                        <div id="hotel-display-rule" class="mb-3 col-md-4">
                            <label class="form-label req">Hotel Display Threshold</label>
                            <input type="text" class="form-control hotelDisplayThreshold" name="hotelDisplayThreshold" id="hotelDisplayThreshold" placeholder="Properties less than $___ per night">
                            <div class="invalid-feedback hotelDisplayThreshold-error"></div>
                        </div>
                        <div class="mb-3 col-md-6 collapse" id="hotel-selector-wrapper">
                            <label class="form-label req">Select Custom Hotel</label>
                            <?php
                            // Group hotels by state
                            $hotelsArray = [];
                            foreach ($hotels_data as $hotel) {
                                $hotelsArray[$hotel['state']][] = ['id' => $hotel['id'], 'name' => $hotel['name']];
                            }
                            ?>

                            <select class="form-select form-select-sm js-choice border-0 hotelName" name="hotelName" id="hotelName">
                                <option value="" selected disabled>Select</option>
                                <?php foreach ($hotelsArray as $state => $hotelNames) { ?>
                                    <optgroup label="+++++ <?php echo ucwords(str_replace('_', ' ', htmlspecialchars($state))) ?> +++++">
                                        <?php foreach ($hotelNames as $hotel) { ?>
                                            <option value="<?php echo htmlspecialchars($hotel['id']) ?>"><?php echo htmlspecialchars($hotel['name']) ?></option>
                                        <?php } ?>
                                    </optgroup>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback hotelName-error"></div>
                        </div>

                        <div class="mb-3 col-md-3" id="location-selector-wrapper">
                            <label class="form-label req">Location(s)</label>
                            <select class="form-select form-select-sm js-choice border-0 location" name="location" id="location">
                                <option value="">Select:</option>
                                <?php foreach ($locations_data as $location) { ?>
                                    <option value="<?php echo $location['id']; ?>">
                                        <?php echo $location['city'] . ', ' . $location['state']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback location-error"></div>
                        </div>

                        <div class="mb-3 col-md-3">
                            <label class="form-label req">Experience</label>
                            <select class="form-select form-select-sm js-choice border-0 experience" name="experience" id="experience">
                                <option value="" selected disabled>Select:</option>
                                <?php foreach ($experiences_data as $experience) { ?>
                                    <option value="<?php echo $experience['id']; ?>"><?php echo $experience['name']; ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback experience-error"></div>
                        </div>

                        <div class="mb-3 col-md-3">
                            <label class="form-label req">Experience Type</label>
                            <select class="form-select form-select-sm js-choice border-0 experienceType" name="experienceType" id="experienceType">
                                <option value="" selected disabled>Select:</option>
                                <?php foreach ($experience_types_data as $experience_type) { ?>
                                    <option value="<?php echo $experience_type['id']; ?>"><?php echo $experience_type['name']; ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback experienceType-error"></div>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="form-label req" for="previewRate">Preview Rate</label>
                            <input type="number" class="form-control previewRate" name="previewRate" id="previewRate" value="" placeholder="$">
                            <div class="invalid-feedback previewRate-error"></div>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="form-label req" for="everyDayRate">Every Day Rate</label>
                            <input type="number" class="form-control everyDayRate" name="everyDayRate" id="everyDayRate" value="" placeholder="$">
                            <div class="invalid-feedback everyDayRate-error"></div>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="form-label req" for="nights">Nights</label>
                            <input type="number" class="form-control nights" name="nights" id="nights" value="" placeholder="">
                            <div class="invalid-feedback nights-error"></div>
                        </div>

                        <div class="mb-3 col-md-3">
                            <label class="form-label req">Additional Nights Rate</label>
                            <select class="form-select form-select-sm js-choice border-0 additionalNightRate" name="additionalNightRate" id="additionalNightRate">
                                <option value="" selected disabled>Select:</option>
                                <optgroup label="+++++ Text Options +++++">
                                    <?php foreach ($text_night_rates_data as $text_night_rate) { ?>
                                        <option value="<?php echo $text_night_rate['id']; ?>"><?php echo $text_night_rate['value']; ?></option>
                                    <?php } ?>
                                </optgroup>
                                <optgroup label="+++++ USD Options +++++">
                                    <?php foreach ($usd_night_rates_data as $usd_night_rate) { ?>
                                        <option value="<?php echo $usd_night_rate['id']; ?>"><?php echo $usd_night_rate['value']; ?></option>
                                    <?php } ?>
                                </optgroup>
                            </select>
                            <div class="invalid-feedback additionalNightRate-error"></div>
                        </div>

                        <div class="mb-3 col-md-12">
                            <label class="form-label">Include Perks</label>

                            <select class="form-select form-select-sm js-choice border-0 includePerks" id="includePerks[]" name="includePerks[]" multiple>
                                <option value="" disabled>Select one or more options</option>
                                <?php
                                // Group perks by plus_set
                                $groupedPerks = [];
                                foreach ($perks_data as $perk) {
                                    $groupedPerks[$perk['plus_set']][] = $perk;
                                }

                                foreach ($groupedPerks as $plusSetName => $perks) {
                                    echo '<optgroup label="+++++ ' . htmlspecialchars($plusSetName) . ' +++++">';
                                    foreach ($perks as $perk) {
                                        $label = htmlspecialchars($perk['plus_type']) . ' ($' . htmlspecialchars($perk['cost']) . ')';
                                        echo '<option value="' . htmlspecialchars($label) . '">' . $label . '</option>';
                                    }
                                    echo '</optgroup>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback includePerks-error"></div>
                        </div>
                        <div class="mb-3">
                            <div class="row mb-2">
                                <label class="form-label">Optional Perks</label>
                            </div>
                            <div id="input-container">
                                <div class="row mb-2 input-row">
                                    <div class="col-md-8 mb-3">
                                        <input type="text" class="form-control" name="optionalPerks[]" placeholder="">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <input type="number" class="form-control" name="upgradeCost[]" placeholder="">
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-sm btn-danger remove-input">
                                            <i class="bi bi-plus me-2"></i>Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-input" class="btn btn-sm btn-info">+ Add More</button>
                        </div>

                        <div class="card-footer">
                            <div class="row text-end">
                                <div class="col-md-12">
                                    <button class="btn btn-success text-end" type="submit" name="package_submit"><i class="bi bi-plus-circle pe-3"></i>Create Package</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card shadow rounded-3 h-100">
                <div class="card-header border-bottom">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div>
                            <div class="h5">Edit Published Packages</div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 table-responsive">
                            <table id="packages" class="table table-sm table-hover fw-light display nowrap">
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

<!-----Custom Value Model ----------->
<div class="modal modal-xl fade" tabindex="-1" id="customValueModal" aria-hidden="true" data-bs-backdrop="static" data-keyboard="false">
    <div class="modal-dialog ">
        <div class="modal-content">
            <!-- Title -->
            <div class="modal-header">
                <h5 class="modal-title" id="inquiryFormlabel">Edit Package</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-3">
                <form class="row g-3" id="addEditPackageForm" enctype="multipart/form-data">
                    <input type="hidden" name="package_id" id="package_id" value="">
                    <div class="col-md-3 mb-3">
                        <label class="form-label req">Package Title</label>
                        <input type="text" class="form-control packageTitle" name="packageTitle" id="packageTitle" placeholder="">
                        <div class="invalid-feedback packageTitle-error"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label req" for="description">Package Description</label>
                        <input type="text" class="form-control description" name="description" id="description" value="" placeholder="">
                        <div class="invalid-feedback description-error"></div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label req" for="featuredImage">Featured Image</label>
                        <input type="hidden" name="existingImage" class="existingImage" value="">
                        <input type="file" class="form-control featuredImage" name="featuredImage" id="featuredImage" value="">
                        <div id="featuredImagePreview" class="mt-2"></div>
                        <div class="invalid-feedback featuredImage-error"></div>
                    </div>
                    <div class="mb-3 col-md-2">
                        <label class="form-label req">Use Hotel API?</label>
                        <select id="edit_use_hotel_api" class="form-select form-select-sm js-choice border-0 use_hotel_api" name="use_hotel_api">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <div class="invalid-feedback use_hotel_api-error"></div>
                    </div>
                    <div id="edit-hotel-display-rule" class="mb-3 col-md-4">
                        <label class="form-label req">Hotel Display Threshold</label>
                        <input type="text" class="form-control hotelDisplayThreshold" name="hotelDisplayThreshold" id="hotelDisplayThreshold" placeholder="Properties less than $___ per night">
                        <div class="invalid-feedback hotelDisplayThreshold-error"></div>
                    </div>
                    <div class="mb-3 col-md-6 collapse" id="edit-hotel-selector-wrapper">
                        <label class="form-label req">Select Custom Hotel</label>
                        <?php
                        // Group hotels by state
                        $hotelsArray = [];
                        foreach ($hotels_data as $hotel) {
                            $hotelsArray[$hotel['state']][] = ['id' => $hotel['id'], 'name' => $hotel['name']];
                        }
                        ?>

                        <select class="form-select form-select-sm js-choice border-0 hotelName" name="hotelName" id="editHotelName">
                            <option value="" selected disabled>Select</option>
                            <?php foreach ($hotelsArray as $state => $hotelNames) {
                                $groupLabel = !empty($state) ? ucwords(str_replace('_', ' ', htmlspecialchars($state))) : 'Unknown';
                            ?>
                                <optgroup label="+++++ <?php echo $groupLabel; ?> +++++">
                                    <?php foreach ($hotelNames as $hotel) { ?>
                                        <option value="<?php echo htmlspecialchars($hotel['id']) ?>"><?php echo htmlspecialchars($hotel['name']) ?></option>
                                    <?php } ?>
                                </optgroup>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback hotelName-error"></div>
                    </div>

                    <div class="mb-3 col-md-3" id="edit-location-selector-wrapper">
                        <label class="form-label req">Location(s)</label>
                        <select class="form-select form-select-sm js-choice border-0 location" name="location" id="editLocation">
                            <option value="">Select:</option>
                            <?php foreach ($locations_data as $location) { ?>
                                <option value="<?php echo $location['id']; ?>">
                                    <?php echo $location['city'] . ', ' . $location['state']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback location-error"></div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <label class="form-label req">Experience</label>
                        <select class="form-select form-select-sm js-choice border-0 experience" name="experience" id="editExpeirience">
                            <option value="" selected disabled>Select:</option>
                            <?php foreach ($experiences_data as $experience) { ?>
                                <option value="<?php echo $experience['id']; ?>"><?php echo $experience['name']; ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback experience-error"></div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <label class="form-label req">Experience Type</label>
                        <select class="form-select form-select-sm js-choice border-0 experienceType" name="experienceType" id="editExperienceType">
                            <option value="" selected disabled>Select:</option>
                            <?php foreach ($experience_types_data as $experience_type) { ?>
                                <option value="<?php echo $experience_type['id']; ?>"><?php echo $experience_type['name']; ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback experienceType-error"></div>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label req" for="previewRate">Preview Rate</label>
                        <input type="number" class="form-control previewRate" name="previewRate" id="previewRate" value="" placeholder="$">
                        <div class="invalid-feedback previewRate-error"></div>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label req" for="everyDayRate">Every Day Rate</label>
                        <input type="number" class="form-control everyDayRate" name="everyDayRate" id="everyDayRate" value="" placeholder="$">
                        <div class="invalid-feedback everyDayRate-error"></div>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label req" for="nights">Nights</label>
                        <input type="number" class="form-control nights" name="nights" id="nights" value="" placeholder="">
                        <div class="invalid-feedback nights-error"></div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <label class="form-label req">Additional Nights Rate</label>
                        <select class="form-select form-select-sm js-choice border-0 additionalNightRate" name="additionalNightRate" id="editAdditionalNightRate">
                            <option value="" selected disabled>Select:</option>
                            <optgroup label="+++++ Text Options +++++">
                                <?php foreach ($text_night_rates_data as $text_night_rate) { ?>
                                    <option value="<?php echo $text_night_rate['id']; ?>"><?php echo $text_night_rate['value']; ?></option>
                                <?php } ?>
                            </optgroup>
                            <optgroup label="+++++ USD Options +++++">
                                <?php foreach ($usd_night_rates_data as $usd_night_rate) { ?>
                                    <option value="<?php echo $usd_night_rate['id']; ?>"><?php echo $usd_night_rate['value']; ?></option>
                                <?php } ?>
                            </optgroup>
                        </select>
                        <div class="invalid-feedback additionalNightRate-error"></div>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label class="form-label">Include Perks</label>
                        <?php
                        // Group perks by plus_set
                        $plusSets = [];
                        foreach ($perks_data as $perk) {
                            $plusSets[$perk['plus_set']][] = $perk['plus_type'] . ' ($' . $perk['cost'] . ')';
                        }
                        ?>

                        <select class="form-select form-select-sm js-choice border-0 includePerks" multiple id="editIncludePerks" name="includePerks[]">
                            <?php foreach ($plusSets as $plusSet => $plusTypes) { ?>
                                <optgroup label="+++++ <?php echo htmlspecialchars($plusSet) ?> +++++">
                                    <?php foreach ($plusTypes as $plusType) { ?>
                                        <option value="<?php echo htmlspecialchars($plusType) ?>"><?php htmlspecialchars($plusType) ?></option>
                                    <?php } ?>
                                </optgroup>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback includePerks-error"></div>
                    </div>
                    <div class="mb-3">
                        <div class="row mb-2">
                            <label class="form-label">Optional Perks</label>
                        </div>
                        <div id="input-container">
                        </div>
                        <button type="button" id="addMoreBtn" class="btn btn-sm btn-info">+ Add More</button>
                    </div>

                    <div class="card-footer">
                        <div class="row text-end">
                            <div class="col-md-12">
                                <button class="btn btn-success text-end" type="submit" name="package_submit">Update Package</button>
                                <button type="button" data-bs-dismiss="modal" id="cancelBtn" class="btn btn btn-light cancelButton text-capitalize">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
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
<script src="../assets/js/admin/manage-package.js"></script>
</body>