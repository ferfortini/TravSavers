<?php
session_start();
$page = "dashboard-hotel-book";
$title = "Review your booking!";
include "inc/header.php";
include('api_auth.php');
?>

<main>
    <section class="py-0 ">
        <div class="container">
            <div class="card bg-light overflow-hidden px-sm-3">
                <div class="row align-items-center g-4">

                    <div class="col-sm-9">
                        <div class="card-body">
                            <h2 class="m-0 h3 card-title ">Great choice! Now complete your reservation:</h2>
                        </div>
                    </div>

                    <div class="col-sm-3 text-end d-none d-sm-block">
                        <img src="assets/images/element/17.svg" class="mb-n4" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-4 pb-3 chooseSec">
        <div class="container">
            <div class="row mt-2">
                <div class="col-12">
                    <div class="h5 fw-light mb-3">Choose your room type:</div>
                    <form>
                        <div id="roomCarousel" class="carousel slide">
                            <div class="carousel-inner" id="room-type">
                                <!-- Dynamic slides will be inserted here -->
                            </div>

                            <!-- Carousel controls -->
                            <button class="carousel-control-prev d-none" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                                <i class="bi-chevron-left"></i>
                            </button>
                            <button class="carousel-control-next d-none" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                                <i class="bi-chevron-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-0">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-xl-8">
                    <div class="vstack gap-5">
                        <div class="card shadow">
                            <div class="card-header border-bottom p-4">
                                <h4 class="card-title mb-0"><i class="bi bi-people me-2"></i>Guest Details</h4>
                            </div>
                            <div class="card-body p-4">
                                <form class="row g-4" id="guest-form" method="post">
                                    <div class="col-12">
                                        <div class="bg-light rounded-2 px-4 py-3">
                                            <h6 class="mb-0">Primary Guest</h6>
                                        </div>
                                    </div>
                                    <input type="hidden" name="selected_package_id" id="selected_package_id">
                                    <input type="hidden" name="selected_rate_key" id="selected_rate_key">
                                    <div class="col-md-6">
                                        <label class="form-label req">First Name</label>
                                        <input type="text" class="form-control form-control-lg" placeholder="First Name" name="fname" id="fname">
                                        <div class="invalid-feedback" id="fname-error"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label req">Last Name</label>
                                        <input type="text" class="form-control form-control-lg" placeholder="Last Name" name="lname" id="lname">
                                        <div class="invalid-feedback" id="lname-error"></div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label req">Email</label>
                                        <input type="email" class="form-control form-control-lg" placeholder="Valid email address" name="email" id="email">
                                        <div class="invalid-feedback" id="email-error"></div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label req">Mobile number</label>
                                        <input type="text" class="form-control form-control-lg" id="mobile_no" name="mobile" placeholder="Enter your mobile number" value="">
                                        <div class="invalid-feedback" id="mobile_no-error"></div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="zip" class="form-label req">Postal Code</label>
                                        <input type="text" class="form-control form-control-lg" name="zip" id="zip" placeholder="Street address">
                                        <div class="invalid-feedback" id="zip-error"></div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check form-switch form-check-md d-flex justify-content-between mb-4">
                                            <input class="form-check-input flex-shrink-0" name="checkPrivacy1" type="checkbox" id="checkPrivacy1">
                                            <label class="form-check-label ps-2 pe-0 small" for="checkPrivacy1">I agree to be contacted by phone or email regarding this reservation (details). Your reservation request will not be finalized until we can confirm your reservation details with you via phone</label>
                                        </div>
                                        <div class="invalid-feedback" id="checkPrivacy1-error"></div>

                                        <div class="d-flex justify-content-start">
                                            <button class="btn btn-lg btn-success" type="submit" name="reservation_submit">Next <i class="bi bi-chevron-double-right"></i></button>
                                            <!-- <a href="booking.php" class="btn btn-lg btn-success">Continue to payment <i class="bi bi-chevron-double-right ps-2"></i></a> -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="col-xl-4">
                    <div class="row g-4">
                        <div class="col-md-6 col-xl-12">
                            <div class="card shadow rounded-2">
                                <div class="card-header border-bottom">
                                    <h5 class="card-title mb-0"><i class="bi bi-building me-2"></i>Reservation Details</h5>
                                </div>
                                <div class="card-body">

                                    <div class="card mb-3">
                                        <div class="row align-items-top">
                                            <div class="col-md-6">
                                                <img src="" class="card-img" alt="" id="image">
                                            </div>

                                            <div class="col-md-6">
                                                <div class=" pt-3 pt-sm-0 p-0">
                                                    <p class="fw-bold" id="hotel-name"></p>
                                                    <p class="small mb-2" id="hotel-address"><a href="#"></a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <div class="bg-light py-3 px-4 rounded-2">
                                                <h6 class="fw-light small mb-1">Check-in:</h6>
                                                <h6 class="mb-1 fw-medium" id="check-in"></h6>
                                                <small><i class="bi bi-alarm me-1"></i>4:00 pm</small>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="bg-light py-3 px-4 rounded-2">
                                                <h6 class="fw-light small mb-1">Check out:</h6>
                                                <h6 class="mb-1 fw-medium" id="check-out"></h6>
                                                <small><i class="bi bi-alarm me-1"></i>11:00 am</small>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-group list-group-borderless">
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-0">
                                            <span class="h6 fw-light mb-0 every-day-rate-section">Every Day Rate:</span>
                                            <span class="fs-5" id="every-day-rate"></span>
                                        </li>
                                        <!-- <li class="list-group-item d-flex justify-content-between align-items-center py-0">
                                            <span class="h6 fw-light mb-0 every-day-rate-section">Today's Savings:</span>
                                            <span class="fs-5" id="savings"></span>
                                        </li> -->
                                        <hr class="m-0">
                                        <li class="list-group-item d-flex justify-content-between align-items-center resort-preview-rate">
                                            <span class="h6 fw-bold mb-0 resort-preview-rate-section"> Resort Preview Rate:</span>
                                            <span class="fs-5 fw-bold resort-preview-rate-section" id="preview-rate"></span>
                                        </li>

                                        <hr class="m-0 resort-preview-rate-section">

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="h6 fw-light mb-0"> Taxes &amp; Recovery Fee:</span>
                                            <span class="fs-5" id="tax"></span>
                                        </li>
                                        <div class="description-list-group"></div>
                                        <!-- <hr class="m-0"> -->

                                        <!-- <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="h6 fw-light mb-0" id="description"></span>
                                            <span class="fs-5 text-success fw-bold">FREE</span>
                                        </li> -->

                                        <hr class="m-0">
                                        <div id="coupon-discount" style="display: none;">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span class="h6 fw-light mb-0"> Discount Code:</span>
                                                <span class="fs-5">-$40.00</span>
                                            </li>
                                            <hr class="m-0">
                                        </div>

                                        <li class="list-group-item d-flex justify-content-between align-items-center mt-2">
                                            <span class="h5 fw-light mb-0">Total Payable Now</span>
                                            <span class="h5 mb-0" id="total"></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer border-top py-3">
                                    <div class="d-sm-flex justify-content-center align-items-center">
                                        <button type="button" class="btn btn-link text-nowrap py-0 my-0 text-info nav-link text-decoration-underline" data-bs-trigger="focus" data-bs-placement="top" data-bs-toggle="popover" data-bs-title="Cancellation Policy" data-bs-content="This reservation is Non-Refundable, no changes will be allowed. No refunds will be given in the event of no-show or day of check-in cancellation. Any modification to this reservation will require that the original booking be cancelled. Re-booking is subject to availability and fees are subject to change.">Cancellation Policy</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-12">
                            <div class="card shadow">
                                <div class="card-header border-bottom">
                                    <div class="cardt-title">
                                        <h5 class="mb-0">Discount Code</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="input-group">
                                        <input class="form-control" placeholder="Enter code">
                                        <button type="button" class="btn btn-primary btn-coupon">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </aside>
            </div>
        </div>
    </section>
</main>

<?php include "inc/footer.php";
?>
<script src="assets/js/frontend/hotel-details.js"></script>