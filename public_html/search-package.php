<?php
$page = "package-search";
$title = "Book Online in No Time!";
include_once 'api_auth.php';
include_once "inc/header.php";
$experiences = mysqli_query($con, "SELECT * FROM experiences ORDER BY id DESC");
?>

<main>
    <section class="pt-0">
        <div class="container-fluid" style="background-image:url(assets/images/heros/vegas.jpg); background-position: center left; background-size: cover;">
            <div class="row">
                <div class="col-md-8 mx-auto text-start pt-7 pb-5">
                    <h1 class="text-white fw-light">Package Deals: <span class="fw-bold" id="destination-name"></span></h1>
                    <p class="lead text-white">Enjoy the ease and convenience of selecting a package deal - we take care of all the details!</p>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-0 pb-4" id="edit_package">
        <div class="container position-relative">

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <input type="checkbox" class="btn-check" id="btn-check-soft">
                        <label class="btn btn-primary-soft btn-primary-check mb-0" for="btn-check-soft" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-controls="collapseFilter">
                            <i class="bi fa-fe bi-search me-2"></i>Edit Search
                        </label>

                        <!-- <div class="col-2">
                            <div class="">
                                <div class="form-control-borderless">
                                    <select class="form-select js-choice" data-search-enabled="false">
                                        <option selected disabled>Sort Results</option>
                                        <option value="BiggestSavings">Best Savings</option>
                                        <option value="PriceAsc">Price (Low to High)</option>
                                        <option value="PriceDesc">Price (High to Low)</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>



            <div class="collapse" id="collapseFilter">
                <div class="card card-body bg-light p-4 mt-4 z-index-9">

                    <form class="row g-4">
                        <div class="col-md-4">
                            <div class="form-size-lg form-control-borderless">
                                <label class="form-label">Select Experience:</label>
                                <select class="form-select js-choice experience" name="experience" id="experience" data-search-enabled="false">
                                    <option value="" disabled>Select Experience</option>
                                    <?php while ($experience = mysqli_fetch_array($experiences)) { ?>
                                        <option value="<?php echo $experience['id']; ?>"><?php echo $experience['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="invalid-feedback experience-error"></div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-size-lg form-control-borderless">
                                <label for="hotelname" class="form-label">Select Destination:</label>
                                <select class="form-select js-choice destinations" name="destination" id="destination" data-search-enabled="false">
                                    <option value="" disabled>Select a destination</option>
                                </select>
                            </div>
                            <div class="invalid-feedback destinations-error"></div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Group Size:</label>
                            <div class="dropdown package-guest-selector me-2">
                                <input type="text" class="form-package-guest-selector form-control form-control-lg package-selection-result" id="package-selection-result" placeholder="Select" data-bs-auto-close="outside" data-bs-toggle="dropdown">

                                <ul class="dropdown-menu package-guest-selector-dropdown">
                                    <li class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="mb-0">Adults</h6>
                                            <small>Ages 13 or above</small>
                                        </div>

                                        <div class="hstack gap-1 align-items-center">
                                            <button type="button" class="btn btn-link package-adult-remove p-0 mb-0"><i class="bi bi-dash-circle fs-5 fa-fw"></i></button>
                                            <h6 class="guest-selector-count mb-0 package-adults">2</h6>
                                            <button type="button" class="btn btn-link package-adult-add p-0 mb-0"><i class="bi bi-plus-circle fs-5 fa-fw"></i></button>
                                        </div>
                                    </li>

                                    <li class="dropdown-divider"></li>

                                    <li class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="mb-0">Child</h6>
                                            <small>Ages 13 below</small>
                                        </div>

                                        <div class="hstack gap-1 align-items-center">
                                            <button type="button" class="btn btn-link package-child-remove p-0 mb-0"><i class="bi bi-dash-circle fs-5 fa-fw"></i></button>
                                            <h6 class="package-guest-selector mb-0 package-child">0</h6>
                                            <button type="button" class="btn btn-link package-child-add p-0 mb-0"><i class="bi bi-plus-circle fs-5 fa-fw"></i></button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12 collapse" id="package-child-ages-wrapper"></div>
                        <div class="col-md-4">
                            <div class="form-control-borderless">
                                <label class="form-label">Property Rating</label>
                                <ul class="list-inline mb-0 g-3">
                                    <li class="list-inline-item">
                                        <input type="checkbox" name="starRatings" value="3" class="btn-check" id="btn-check-11">
                                        <label class="btn btn-white btn-primary-soft-check" for="btn-check-11"><i class="bi bi-star-fill"></i> 3+</label>
                                    </li>
                                    <li class="list-inline-item">
                                        <input type="checkbox" name="starRatings" value="4" class="btn-check" id="btn-check-12">
                                        <label class="btn btn-white btn-primary-soft-check" for="btn-check-12"><i class="bi bi-star-fill"></i> 4+</label>
                                    </li>
                                    <li class="list-inline-item">
                                        <input type="checkbox" name="starRatings" value="5" class="btn-check" id="btn-check-13">
                                        <label class="btn btn-white btn-primary-soft-check" for="btn-check-13"><i class="bi bi-star-fill"></i> 5</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-control-borderless form-size-lg">
                                <label class="form-label">Arrival Date:</label>
                                <input type="text" class="form-control form-control-lg flatpickr package_arrival_date" name="package_arrival_date" id="package_arrival_date" placeholder="Select">
                                <span class="form-icon"></span>
                            </div>
                            <div class="invalid-feedback package_arrival_date-error"></div>
                        </div>

                        <div class="text-end justify-content-end">
                            <button type="submit" class="btn btn-success mb-0 ms-3 mt-lg-2">Update Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-0">
        <div class="container">

            <div class="row">

                <div class="col-12">
                    <div class="vstack gap-4" id="hotel-results">
                    </div>
                </div>
                <!-- Main content END -->
            </div> <!-- Row END -->
        </div>
    </section>


</main>



<!-- Traveler Information Modal -->
<div class="modal fade" id="travelerInfoModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="travelerInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="travelerInfoModalLabel">
                    <i class="fa-solid fa-user me-2"></i>Save Package for Later
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <img id="traveler-modal-hotel-image" src="" alt="Hotel Image" class="img-fluid rounded" style="max-height: 150px;">
                    </div>
                    <div class="col-md-8">
                        <h6 id="traveler-modal-hotel-name" class="mb-2"></h6>
                        <p id="traveler-modal-hotel-location" class="text-muted mb-2"></p>
                        <p class="mb-0"><strong>Package will be saved for future reference</strong></p>
                    </div>
                </div>
                
                <form id="travelerInfoForm">
                    <input type="hidden" id="package-name" name="packageName">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="travelerFirstName">First Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="travelerFirstName" name="firstName">
                                <div class="invalid-feedback" id="travelerFirstName-error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="travelerLastName">Last Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="travelerLastName" name="lastName">
                                <div class="invalid-feedback" id="travelerLastName-error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="travelerEmail">Email Address<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="travelerEmail" name="email">
                                <div class="invalid-feedback" id="travelerEmail-error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="travelerPhone">Phone Number<span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="travelerPhone" name="phone">
                                <div class="invalid-feedback" id="travelerPhone-error"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="permissionToContact" name="permissionToContact">
                                <label class="form-check-label" for="permissionToContact">
                                    I agree to be contacted by phone or email regarding this saved package and future travel opportunities
                                </label>
                                <div class="invalid-feedback" id="permissionToContact-error"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="submitTravelerInfoBtn">
                    <i class="fa-solid fa-save me-2"></i>Save Package
                </button>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php";
?>
<script src="./assets/js/frontend/package-list.js"></script>