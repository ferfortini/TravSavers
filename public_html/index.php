<?php
$page = "home";
$title = "Book Online in No Time!";
include "inc/header.php";
$experiences = mysqli_query($con, "SELECT * FROM experiences ORDER BY id DESC");
$destinations = mysqli_query($con, "SELECT * FROM custom_locations ORDER BY id DESC");
?>
<main>

    <section class="pt-0">
        <div class="container-fluid" style="background-image:url(assets/images/heros/travsavers-home4.jpg); background-position: center left; background-size: cover;">
            <div class="row">
                <div class="col-md-6 mx-auto text-center pt-7 pb-9">
                    <h1 class="text-white">Find your perfect vacation</h1>
                    <p class="lead text-white mb-5">Get the best prices on 200,000+ properties and packages, worldwide</p>
                </div>
            </div>
        </div>

        <div class="container mt-n8">
            <div class="row">
                <div class="col-8 col-lg-8 col-xl-6 mx-auto">
                    <ul class="nav nav-tabs nav-bottom-line nav-justified nav-responsive bg-mode rounded-top z-index-9 position-relative pt-2 pb-0 px-4">
                        <li class="nav-item">
                            <a class="nav-link mb-0 active" data-bs-toggle="tab" href="#destinations"><i class="bi bi-compass fs-6 fa-fw me-2"></i>Destinations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0" data-bs-toggle="tab" href="#packages"><i class="bi bi-suitcase-lg fs-6 fa-fw me-2"></i>Packages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0" data-bs-toggle="tab" href="#tickets"><i class="bi bi-ticket-perforated fs-6 fa-fw me-2"></i>Tickets</a>
                        </li>
                    </ul>
                </div>

                <div class="col-9 mx-auto">
                    <div class="tab-content" id="nav-tabContent">

                        <!-- Tab 1 -->
                        <div class="tab-pane fade show active" id="destinations" data-tab-id="destinations">
                            <form class="card shadow p-0" autocomplete="off" id="destintions-form">
                                <div class="card-header p-4">
                                    <h5 class="mb-0"><i class="bi bi-compass fs-4 me-2"></i>Destinations</h5>
                                </div>

                                <div class="card-body p-4 pt-0">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-icon-input form-size-lg form-fs-lg">
                                                <input type="text" name="dest_loc" id="dest_loc" class="form-control form-control-lg destinations" placeholder="Destination">
                                                <input type="hidden" name="latitude" id="latitude">
                                                <input type="hidden" name="longitude" id="longitude">
                                                <input type="hidden" name="location_code" id="location_code">
                                                <span class="form-icon"><i class="bi bi-search fs-5"></i></span>
                                                <span id="loader" class="loader" style="position: absolute; top: 40%; right: 10px; transform: translateY(-50%);"></span>
                                            </div>
                                            <div class="invalid-feedback destinations-error"></div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-icon-input form-size-lg form-fs-lg">
                                                <input type="text" class="form-control form-control-lg" name="hotel_name" placeholder="Hotel Name (Optional)">
                                                <span class="form-icon"><i class="bi bi-building fs-5"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-icon-input form-fs-lg">
                                                <div class="dropdown guest-selector me-2">
                                                    <input type="text" class="form-guest-selector form-control form-control-lg selection-result" placeholder="Group Size" data-bs-auto-close="outside" data-bs-toggle="dropdown">
                                                    <ul class="dropdown-menu guest-selector-dropdown">
                                                        <li class="d-flex justify-content-between">
                                                            <div>
                                                                <h6 class="mb-0">Adults</h6>
                                                                <small>Ages 13 or above</small>
                                                            </div>

                                                            <div class="hstack gap-1 align-items-center">
                                                                <button type="button" class="btn btn-link adult-remove p-0 mb-0"><i class="bi bi-dash-circle fs-5 fa-fw"></i></button>
                                                                <h6 class="guest-selector-count mb-0 dest-adults">2</h6>
                                                                <button type="button" class="btn btn-link adult-add p-0 mb-0"><i class="bi bi-plus-circle fs-5 fa-fw"></i></button>
                                                            </div>
                                                        </li>

                                                        <li class="dropdown-divider"></li>

                                                        <!-- Child selection -->
                                                        <li class="d-flex justify-content-between">
                                                            <div>
                                                                <h6 class="mb-0">Child</h6>
                                                                <small>Ages 13 below</small>
                                                            </div>

                                                            <div class="hstack gap-1 align-items-center">
                                                                <button type="button" class="btn btn-link child-remove p-0 mb-0"><i class="bi bi-dash-circle fs-5 fa-fw"></i></button>
                                                                <h6 class="guest-selector-count mb-0 child">0</h6>
                                                                <button type="button" class="btn btn-link child-add p-0 mb-0"><i class="bi bi-plus-circle fs-5 fa-fw"></i></button>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <span class="form-icon"><i class="bi bi-people fs-5"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-icon-input form-fs-lg">
                                                <input type="text" class="form-control form-control-lg flatpickr destinations_date_range" name="date_range" id="date_range" data-date-format="d/m/y" data-mode="range" placeholder="Date Range">
                                                <span class="form-icon"><i class="bi bi-calendar-week fs-5"></i></span>
                                            </div>
                                            <div class="invalid-feedback destinations_date_range-error"></div>
                                        </div>

                                    </div>
                                    <div class="col-md-12 collapse" id="child-ages-wrapper">
                                    </div>
                                    <div class="text-center pt-0">
                                        <button type="submit" class="btn btn-lg btn-primary mb-n7">Search Hotels <i class="bi bi-arrow-right ps-3"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tab 2 -->
                        <div class="tab-pane fade" id="packages" data-tab-id="packages">
                            <form class="card shadow p-0" autocomplete="off" id="packages-form">
                                <div class="card-header p-4">
                                    <h5 class="mb-0"><i class="bi bi-suitcase-lg fs-4 me-2"></i>Vacation Packages</h5>
                                </div>

                                <div class="card-body p-4 pt-0">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-icon-input form-size-lg form-fs-lg">
                                                <select class="form-select js-choice experience" name="experience" id="experience" data-search-enabled="false">
                                                    <option value="" disabled selected>Select Experience</option>
                                                    <?php while ($experience = mysqli_fetch_array($experiences)) { ?>
                                                        <option value="<?php echo $experience['id']; ?>"><?php echo $experience['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <span class="form-icon"><i class="bi bi-search fs-5"></i></span>
                                            </div>
                                            <div class="invalid-feedback experience-error"></div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-icon-input form-size-lg form-fs-lg">
                                                <select class="form-select js-choice destinations" name="destination" data-search-enabled="false">
                                                    <option value="">Destination</option>
                                                </select>
                                                <span class="form-icon"><i class="bi bi-geo-alt fs-5"></i></span>
                                            </div>
                                            <div class="invalid-feedback destinations-error"></div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-icon-input form-fs-lg">
                                                <div class="dropdown guest-selector me-2">
                                                    <input type="text" class="form-guest-selector form-control form-control-lg package-selection-result" placeholder="Group Size" data-bs-auto-close="outside" data-bs-toggle="dropdown">

                                                    <ul class="dropdown-menu guest-selector-dropdown">
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
                                                <span class="form-icon"><i class="bi bi-people fs-5"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-icon-input form-fs-lg">
                                                <input type="text" class="form-control form-control-lg flatpickr arrivalDate" name="package_arrival_date" id="package_arrival_date" placeholder="Arrival">
                                                <span class="form-icon"><i class="bi bi-calendar fs-5"></i></span>
                                            </div>
                                            <div class="invalid-feedback arrivalDate-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 collapse" id="package-child-ages-wrapper">
                                    </div>
                                    <div class="text-center pt-0">
                                        <button type="submit" class="btn btn-lg btn-primary mb-n7">Search Packages <i class="bi bi-arrow-right ps-3"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tab 3 -->
                        <div class="tab-pane fade" id="tickets">
                            <form class="card shadow p-0">
                                <div class="card-header p-4">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-md-6">
                                            <h5 class="mb-0"><i class="bi bi-ticket-perforated fs-4 fa-fw me-2"></i>Tickets</h5>
                                        </div>

                                        <div class="col-md-6 d-flex justify-content-end">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                                                <label class="form-check-label" for="inlineCheckbox1">Shows</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2" checked>
                                                <label class="form-check-label" for="inlineCheckbox2">Attractions</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3" checked>
                                                <label class="form-check-label" for="inlineCheckbox3">Dining</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body p-4 pt-0">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="form-icon-input form-size-lg form-fs-lg">
                                                <select class="form-select js-choice" data-search-enabled="true">
                                                    <option value="">Select Location</option>
                                                    <option value="94511">Las Vegas, NV</option>
                                                    <option value="34467">Orlando, FL</option>
                                                    <option value="28632">Miami, FL</option>
                                                    <option value="145014">Myrtle Beach, SC</option>
                                                    <option value="150747">Gatlinburg, TN</option>
                                                    <option value="151709">Pigeon Forge, TN</option>
                                                    <option value="144760">Hilton Head, SC</option>
                                                    <option value="87419">Branson, MO</option>
                                                    <option value="171657">Virginia Beach, VA</option>
                                                    <option value="163309">Park City, UT</option>
                                                </select>
                                                <span class="form-icon"><i class="bi bi-search fs-5"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-icon-input form-fs-lg">
                                                <div class="dropdown guest-selector me-2">
                                                    <input type="text" class="form-guest-selector form-control form-control-lg selection-result" placeholder="Group Size" data-bs-auto-close="outside" data-bs-toggle="dropdown">

                                                    <ul class="dropdown-menu guest-selector-dropdown">
                                                        <li class="d-flex justify-content-between">
                                                            <div>
                                                                <h6 class="mb-0">Adults</h6>
                                                                <small>Ages 13 or above</small>
                                                            </div>

                                                            <div class="hstack gap-1 align-items-center">
                                                                <button type="button" class="btn btn-link adult-remove p-0 mb-0"><i class="bi bi-dash-circle fs-5 fa-fw"></i></button>
                                                                <h6 class="guest-selector-count mb-0 adults">2</h6>
                                                                <button type="button" class="btn btn-link adult-add p-0 mb-0"><i class="bi bi-plus-circle fs-5 fa-fw"></i></button>
                                                            </div>
                                                        </li>

                                                        <li class="dropdown-divider"></li>

                                                        <li class="d-flex justify-content-between">
                                                            <div>
                                                                <h6 class="mb-0">Child</h6>
                                                                <small>Ages 13 below</small>
                                                            </div>

                                                            <div class="hstack gap-1 align-items-center">
                                                                <button type="button" class="btn btn-link child-remove p-0 mb-0"><i class="bi bi-dash-circle fs-5 fa-fw"></i></button>
                                                                <h6 class="guest-selector-count mb-0 child">0</h6>
                                                                <button type="button" class="btn btn-link child-add p-0 mb-0"><i class="bi bi-plus-circle fs-5 fa-fw"></i></button>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <span class="form-icon"><i class="bi bi-people fs-5"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-icon-input form-fs-lg">
                                                <input type="text" class="form-control form-control-lg flatpickr" data-date-format="d/m/y" placeholder="Start Date">
                                                <span class="form-icon"><i class="bi bi-calendar fs-5"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-icon-input form-fs-lg">
                                                <input type="text" class="form-control form-control-lg flatpickr" data-date-format="d/m/y" placeholder="End Date">
                                                <span class="form-icon"><i class="bi bi-calendar fs-5"></i></span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="text-center pt-0">
                                        <a class="btn btn-lg btn-primary mb-n7" href="#">Search Tickets <i class="bi bi-arrow-right ps-3"></i></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="flex-row g-4">
                <div class="d-flex justify-content-center">
                    <div class="h4 card-title mb-4" style="text-decoration:underline;">Or select by package price:</div>
                </div>
            </div>
            <div class="row g-4">

                <div class="col-sm-6 col-md-3">
                    <div class="card card-body bg-light h-100 align-items-center justify-content-center">
                        <div class="openDateModal d-flex align-items-center" data-price="49">
                            <img src="assets/images/element/beach.svg" class="h-30px me-3" alt="">
                            <input type="text" id="date-range" style="display:none;" placeholder="Select date range" />
                            <h6 class="card-title mb-0"><a id="package" data-price="49" href="#" class="stretched-link">$49 Packages</a></h6>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="card card-body bg-light h-100 align-items-center justify-content-center">
                        <div class="openDateModal d-flex align-items-center" data-price="99">
                            <img src="assets/images/element/island.svg" class="h-30px me-3" alt="">
                            <input type="text" id="date-range" style="display:none;" placeholder="Select date range" />
                            <h6 class="card-title mb-0"><a id="package" data-price="99" href="#" class="stretched-link">$99 Packages</a></h6>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="card card-body bg-light h-100 align-items-center justify-content-center">
                        <div class="openDateModal d-flex align-items-center" data-price="199">
                            <img src="assets/images/element/pool.svg" class="h-30px me-3" alt="">
                            <h6 class="card-title mb-0"><a id="package" data-price="199" href="#" class="stretched-link">$199 Packages</a></h6>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="card card-body bg-light h-100 align-items-center justify-content-center">
                        <div class="openDateModal d-flex align-items-center" data-price="399">
                            <img src="assets/images/element/camping.svg" class="h-30px me-3" alt="">
                            <h6 class="card-title mb-0"><a id="package" data-price="399" href="#" class="stretched-link">$399 Packages</a></h6>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <section class="bg-light mt-5">
        <div class="container my-4 py-2">
            <div class="row g-4 g-md-5">
                <div class="col-sm-4">
                    <div class="d-flex">
                        <i class="bi bi-calendar-week" style="font-size:50px;"></i>
                        <div class="ms-3">
                            <h5 class="mb-2">Search Deals</h5>
                            <p class="mb-0">Search for the best deals on cruises, day trips, vacation packages, tours, and exclusive getaways! TravNow Members save even more.</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="d-flex">
                        <i class="bi bi-chat-right-text" style="font-size:50px;"></i>
                        <div class="ms-3">
                            <h5 class="mb-2">Chat with an Agent</h5>
                            <p class="mb-0">Click or call 1-770-821-6831 to speak with an expert TravNow agent to ensure the best travel or vacation experience at the best value.</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="d-flex">
                        <i class="bi bi-award" style="font-size:50px;"></i>
                        <div class="ms-3">
                            <h5 class="mb-2">Why TravSavers?</h5>
                            <p class="mb-0">Personal Service + Best Prices! We've spent decades uncovering hundreds of thousands of exclusive travel deals, nationally and worldwide.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>
<!-- Modal -->
<div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Arrival Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="package-price-form">
                    <input type="hidden" name="price" id="selectedPrice">
                    <div class="row">
                        <!-- Arrival Date -->
                         <div class="col-md-6 mb-3">
                            <label for="arrivalDate" class="form-label">Arrival Date</label>
                            <input type="text" name="arrivalDate" id="arrivalDate" class="form-control flatpickr arrivalDate" placeholder="Select arrival date">
                            <div class="invalid-feedback arrivalDate-error"></div>
                        </div> 

                        <!-- Departure Date -->
                         <div class="col-md-6 mb-3">
                            <label for="departureDate" class="form-label">Departure Date</label>
                            <input type="text" name="departureDate" id="departureDate" class="form-control flatpickr departureDate" placeholder="Select departure date" readonly>
                            <div class="invalid-feedback departureDate-error"></div>
                        </div> 
                        <!-- <div class="col-lg-6">
                            <div class="form-icon-input form-fs-lg">
                                <input type="text" class="form-control form-control-lg flatpickr" data-date-format="d/m/y" data-mode="range" placeholder="Date Range">
                                <span class="form-icon"><i class="bi bi-calendar-week fs-5"></i></span>
                            </div>
                            <div class="invalid-feedback destinations_date_range-error"></div>
                        </div> -->
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" id="submitDates" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php";
?>
<script src="./assets/js/frontend/index.js"></script>