<?php
$page = "destination-search";
$title = "Book Online in No Time!";
require 'api_auth.php';

// Get destination from URL
$destLoc = isset($_GET['dest_loc']) ? base64_decode($_GET['dest_loc']) : '';
$city = explode(',', $destLoc)[0] ?? '';
$city = trim($city);
?>
<!-- Google Maps CSS (optional, for default styling) -->
<style>
    /* Ensure Google Maps container displays correctly */
    #hotel-map, #hotel-map-mobile {
        z-index: 1;
        height: 100%;
    }
    .gm-style .gm-style-iw-c { /* Google Maps InfoWindow styling */
        padding: 0;
    }
    .gm-style .gm-style-iw-d {
        overflow: hidden !important;
    }
</style>
<?php require "inc/header.php"; ?>

<main>
    <section class="pt-0 pb-4">
        <div class="container-fluid px-4 position-relative">

            <!-- Edit Search -->
            <div class="collapse" id="collapseFilter">
                <div class="card card-body bg-light p-4 mt-4 z-index-9">

                    <form class="row g-4" id="destintions-form">
                        <div class="col-md-4">
                            <div class="form-size-lg form-control-borderless">
                                <label class="form-label">Select location:</label>
                                <input type="text" name="dest_loc" id="dest_loc" class="form-control form-control-lg destinations" placeholder="Destination">
                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">
                                <input type="hidden" name="location_code" id="location_code">
                            </div>
                            <div class="invalid-feedback destinations-error"></div>
                        </div>

                        <div class="col-md-4">
                            <label for="hotelname" class="form-label">Hotel Name</label>
                            <input type="text" name="hotelName" class="form-control form-control-lg" placeholder="Specify Hotel" id="hotel_name">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Group Size:</label>
                            <div class="dropdown guest-selector me-2">
                                <input type="text" class="form-guest-selector form-control form-control-lg selection-result" placeholder="Select" data-bs-auto-close="outside" data-bs-toggle="dropdown" id="rooms">

                                <ul class="dropdown-menu guest-selector-dropdown">
                                    <li class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="mb-0">Adults</h6>
                                            <small>Ages 13 or above</small>
                                        </div>

                                        <div class="hstack gap-1 align-items-center">
                                            <button type="button" class="btn btn-link adult-remove p-0 mb-0"><i class="bi bi-dash-circle fs-5 fa-fw"></i></button>
                                            <h6 class="guest-selector-count mb-0 adults"></h6>
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
                                            <h6 class="guest-selector-count mb-0 child"></h6>
                                            <button type="button" class="btn btn-link child-add p-0 mb-0"><i class="bi bi-plus-circle fs-5 fa-fw"></i></button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12 collapse" id="child-ages-wrapper"></div>
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
                            <label class="form-label">Date Range:</label>
                            <div class="form-fs-lg">
                                <input type="text" class="form-control form-control-lg flatpickr destinations_date_range" name="date_range" id="date_range" data-date-format="d/m/y" data-mode="range" placeholder="Date Range">
                            </div>
                            <div class="invalid-feedback destinations_date_range-error"></div>
                        </div>
                        <!-- <div class="col-md-4 collapse" id="child-ages-wrapper"> -->
                        <div class="text-end justify-content-end">
                            <button type="submit" class="btn btn-success mb-0 ms-3 mt-lg-2">Update Search</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>

    <section class="pt-0">
        <div class="container-fluid px-4">
            <div class="row">
                <!-- Filters Sidebar -->
                <div class="col-lg-3 col-xl-2 mb-4" id="filters-sidebar">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Filters</h5>
                        </div>
                        <div class="card-body">
                            <!-- Star Rating Filter -->
                            <div class="mb-4">
                                <h6 class="fw-semibold mb-3">Star Rating</h6>
                                <div class="d-flex flex-column gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input star-filter" type="checkbox" value="5" id="star-5">
                                        <label class="form-check-label" for="star-5">
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i> 5 Stars
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input star-filter" type="checkbox" value="4" id="star-4">
                                        <label class="form-check-label" for="star-4">
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star text-muted"></i> 4+ Stars
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input star-filter" type="checkbox" value="3" id="star-3">
                                        <label class="form-check-label" for="star-3">
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star text-muted"></i>
                                            <i class="bi bi-star text-muted"></i> 3+ Stars
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Column -->
                <div class="col-lg-9 col-xl-7" id="results-column">
                    <!-- Controls at edges of results area -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <input type="checkbox" class="btn-check" id="btn-check-soft">
                        <label class="btn btn-primary-soft btn-primary-check mb-0" for="btn-check-soft" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-controls="collapseFilter">
                            <i class="bi fa-fe bi-search me-2"></i>Edit Search
                        </label>

                        <div class="d-flex gap-2 align-items-center">
                            <!-- Mobile toggle (hidden on desktop) -->
                            <div class="btn-group d-lg-none" role="group">
                                <input type="radio" class="btn-check" name="viewMode" id="viewList" value="list" checked>
                                <label class="btn btn-outline-primary" for="viewList">
                                    <i class="bi bi-list-ul me-1"></i>List
                                </label>
                                <input type="radio" class="btn-check" name="viewMode" id="viewMap" value="map">
                                <label class="btn btn-outline-primary" for="viewMap">
                                    <i class="bi bi-map me-1"></i>Map
                                </label>
                            </div>

                            <div class="col-auto">
                                <div class="form-control-borderless">
                                    <select class="form-select" id="sort" name="sort" style="min-width: 180px;">
                                        <option value="" selected disabled>Sort Results</option>
                                        <option value="BiggestSavings">Best Savings</option>
                                        <option value="PriceAsc">Price (Low to High)</option>
                                        <option value="PriceDesc">Price (High to Low)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="vstack gap-4" id="hotel-results">
                    </div>
                </div>

                <!-- Map Column - Always visible on desktop, toggle on mobile -->
                <div class="col-lg-12 col-xl-3 d-none d-lg-block" id="map-column-desktop">
                    <div class="card shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Map View</h5>
                        </div>
                        <div class="card-body p-0">
                            <div id="hotel-map" style="height: 600px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Map Column - Mobile view (toggle) -->
                <div class="col-12 d-lg-none" id="map-column-mobile" style="display: none;">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Map View</h5>
                        </div>
                        <div class="card-body p-0">
                            <div id="hotel-map-mobile" style="height: 500px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lead Capture Modal -->
    <div class="modal fade" id="guestModal" tabindex="-1" role="dialog" aria-labelledby="guestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header position-relative">
                    <h5 class="modal-title" id="exampleModalLabel">Guest Details</h5>
                    <div role="button" class="close position-absolute" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="row g-4" id="guest-form" method="post">
                        <div class="col-12">
                            <div class="bg-light rounded-2 px-4 py-3">
                                <h6 class="mb-0">Primary Guest</h6>
                            </div>
                        </div>
                        <input type="hidden" name="room_id" id="room_id" value="">
                        <input type="hidden" name="booking_type" id="booking_type" value="hotel">
                        <input type="hidden" name="package_id" id="package_id" value="">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control form-control-lg" placeholder="First Name"
                                name="fname" id="fname">
                            <div class="invalid-feedback" id="fname-error"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control form-control-lg" placeholder="Last Name" name="lname"
                                id="lname">
                            <div class="invalid-feedback" id="lname-error"></div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label req">Email</label>
                            <input type="email" class="form-control form-control-lg" placeholder="Valid email address"
                                name="email" id="email">
                            <div class="invalid-feedback" id="email-error"></div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label req">Mobile number</label>
                            <input type="text" class="form-control form-control-lg" id="mobile_no" name="mobile"
                                placeholder="Enter your mobile number" value="">
                            <div class="invalid-feedback" id="mobile_no-error"></div>
                        </div>

                        <div class="col-md-4">
                            <label for="zip" class="form-label req">Postal Code</label>
                            <input type="text" class="form-control form-control-lg" name="zip" id="zip"
                                placeholder="Postal Code">
                            <div class="invalid-feedback" id="zip-error"></div>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch form-check-md d-flex justify-content-between">
                                <input class="form-check-input flex-shrink-0" name="checkPrivacy1" type="checkbox"
                                    id="checkPrivacy1">
                                <label class="form-check-label ps-2 pe-0 small" for="checkPrivacy1">I agree to be
                                    contacted by phone or email regarding this reservation (details). Your reservation
                                    request will not be finalized until we can confirm your reservation details with you
                                    via phone</label>
                            </div>
                            <div class="invalid-feedback" id="checkPrivacy1-error"></div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-success" type="submit" name="reservation_submit">Next<i class="bi bi-chevron-double-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>

<?php include "inc/footer.php";
?>
<!-- Google Maps API -->
<script>
    // Declare initGoogleMaps globally before the API script loads
    window.initGoogleMaps = function() {
        console.log("Google Maps JavaScript API loaded.");
        // Call the function from hotel-list.js to initialize maps
        if (typeof waitForGoogleMaps === 'function') {
            waitForGoogleMaps();
        } else {
            console.error("waitForGoogleMaps function not found in hotel-list.js");
        }
    };
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJ0HmlpsmNj9SWN98j9PTnzA4fSC8TMUk&callback=initGoogleMaps&loading=async" async defer></script>
<script src="assets/js/frontend/hotel-list.js"></script>
<script>
$(document).ready(function() {
    // Guest form validation and submission (for lead capture from search results)
    $('#guest-form').on('submit', function (e) {
        e.preventDefault();

        // Perform field validations
        const isValid = [
            validateInput($('#fname'), $('#fname-error'), 'Please enter first name'),
            validateInput($('#lname'), $('#lname-error'), 'Please enter last name'),
            validateInput($('#email'), $('#email-error'), 'Please enter email'),
            validateInput($('#mobile_no'), $('#mobile_no-error'), 'Please enter mobile number', { numeric: true, digitsBetween: [6, 13] }),
            validateInput($('#zip'), $('#zip-error'), 'Please enter postal code'),
            validateCheckobox($('#checkPrivacy1'), $('#checkPrivacy1-error'), 'Please check privacy policy')
        ];

        if (!isValid.includes(false)) {
            const guestFormData = {
                room_id: $('#room_id').val() || '',
                package_id: $('#package_id').val() || '',
                fname: $('#fname').val(),
                lname: $('#lname').val(),
                email: $('#email').val(),
                mobile: $('#mobile_no').val(),
                zip: $('#zip').val(),
                checkPrivacy1: $('#checkPrivacy1').is(':checked'),
                booking_type: $('#booking_type').val() || 'hotel'
            };
            
            // Save guest form data to localStorage
            localStorage.setItem('guestFormData', JSON.stringify(guestFormData));
            
            // Hide modal and redirect to hotel detail page
            $('#guestModal').modal('hide');
            window.location.href = 'hotel-detail.php';
        }
    });

    // Reset form when modal is closed
    $('#guestModal').on('hidden.bs.modal', function () {
        $('#guest-form')[0].reset();
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    });
});
</script>