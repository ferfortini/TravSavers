<?php
session_start();
$page = "Hotel Details";
$title = "Hotel Details";
include "inc/header.php";
?>

<main class="detailPage">
    <section class="backBtn pb-0">
        <div class="container position-relative">
            <div class="pb-0 d-flex justify-content-end">
                <a href="#" class="p-0 btn btn-link text-info mb-0 mb-lg-2" onclick="history.back()">
                    <i class="fa fa-arrow-left me-2" aria-hidden="true"></i>
                    Return to list of Destinations
                </a>
            </div>
        </div>
    </section>
    <!-- Skeleton Loading Start -->
    <div id="skeleton-loading">
        <!-- Banner Skeleton -->
        <section class="bannerSec pb-4">
            <div class="container">
                <div class="bannerSec-inner">
                    <div class="skeleton-banner"></div>
                </div>
            </div>
        </section>

        <!-- Detail Info Skeleton -->
        <section class="detailInfo pt-0">
            <div class="container">
                <div class="detailPage-left">
                    <!-- Title Skeleton -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="skeleton-title"></div>
                            <div class="skeleton-text"></div>
                        </div>
                    </div>

                    <!-- Rooms Skeleton -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="skeleton-title" style="width: 50%; margin-bottom: 24px;"></div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="skeleton-card"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="skeleton-card"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Amenities Skeleton -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="skeleton-title" style="width: 40%; margin-bottom: 24px;"></div>
                            <div class="row g-3">
                                <div class="col-6 col-md-4">
                                    <div class="skeleton-amenity"></div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="skeleton-amenity"></div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="skeleton-amenity"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews Skeleton -->
                    <div class="card">
                        <div class="card-body">
                            <div class="skeleton-title" style="width: 45%; margin-bottom: 24px;"></div>
                            <div class="skeleton-rating"></div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="skeleton-review"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="skeleton-review"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Actual Content (Hidden by default) -->

    <div id="actual-content" style="display: none;">

        <!-- Banner Section Start -->
        <section class="bannerSec pb-4 pt-2">

            <div class="container">
                <div class="bannerSec-inner d-flex gap-3">
                    <div class="detailPage_swiper-container">
                        <div class="swiper-container detailPage_swiper-main position-relative">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-container detailPage_swiper-thumbs">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination d-sm-none d-block"></div>
                        <div class="swiper-counter"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Banner Section End -->

        <!-- Detail Info Start -->
        <section class="detailInfo pt-0">
            <div class="container">
                <div class="detailPage-left">
                    <!-- Detail Content Card -->
                    <div class="card">
                        <div class="card-body">
                            <h1 class="detailPage-title text-primary" id="hotel-name"></h1>
                            <div class="detailInfo-address text-truncate" id="hotel-address"></div>
                            <ul class="detailInfo-list list-unstyled mt-4" id="hotel-description">
                            </ul>
                        </div>
                    </div>

                    <!-- Detail Room Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                <h2 class="card-title mb-sm-0 detailInfo-title" id="room-availability"></h2>
                                <!-- <div class="form-control-borderless">
                                    <select class="form-select js-choice" id="sort" name="sort"
                                        data-search-enabled="false">
                                        <option value="" disabled selected>Sort Price</option>
                                        <option value="LowestToHighest">Price - From Lowest to Highest</option>
                                        <option value="HighestToLowest">Price - From Highest to Lowest</option>
                                    </select>
                                </div> -->
                            </div>

                            <!-- included Room -->
                            <h3 class="mb-3 detailInfo-sub-title">Select Room Type</h3>
                            <div class="row g-3" id="room-cards">
                            </div>
                        </div>
                    </div>


                    <!-- Detail Amenities Card -->
                    <div class="card amenity-card">
                        <div class="card-body">
                            <h2 class="card-title mb-3 detailInfo-title">Amenities
                            </h2>
                            <div class="amenity-card-light">
                                <div class="amenities-grid" id="amenities">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews Card -->
                    <div class="card amenity-card">
                        <div class="card-body">
                            <h2 class="card-title mb-3 detailInfo-title">Guest Reviews
                            </h2>
                            <div class="review-header">
                                <div class="score-container">
                                    <div class="score-value d-sm-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="score-number mb-1" id="hotel-rating"></h3>
                                            <div class="score-label">Overall Rating</div>
                                        </div>
                                        <div class="text-sm-end mt-2 mt-sm-0">
                                            <div class="score-stars" id="hotel-rating-stars">
                                            </div>
                                            <div class="rating-meta">
                                                <div class="meta-item">
                                                    <i class="fas fa-user-check"></i>
                                                    <span id="hotel-reviews"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="ratings-container">

                                    <div class="rating-grid">
                                        <div class="rating-item">
                                            <div class="rating-label">
                                                <div class="rating-name">
                                                    <div class="rating-icon">
                                                        <i class="fas fa-bed"></i>
                                                    </div>
                                                    <span>Comfort</span>
                                                </div>
                                                <div class="rating-value" id="hotel-rating-comfort"></div>
                                            </div>
                                            <div class="rating-progress">
                                                <div class="progress-fill" data-width="94%"></div>
                                            </div>
                                        </div>

                                        <div class="rating-item">
                                            <div class="rating-label">
                                                <div class="rating-name">
                                                    <div class="rating-icon">
                                                        <i class="fas fa-swimming-pool"></i>
                                                    </div>
                                                    <span>Amenities</span>
                                                </div>
                                                <div class="rating-value" id="hotel-rating-amenties"></div>
                                            </div>
                                            <div class="rating-progress">
                                                <div class="progress-fill" data-width="92%"></div>
                                            </div>
                                        </div>

                                        <div class="rating-item">
                                            <div class="rating-label">
                                                <div class="rating-name">
                                                    <div class="rating-icon">
                                                        <i class="fas fa-broom"></i>
                                                    </div>
                                                    <span>Cleaning</span>
                                                </div>
                                                <div class="rating-value" id="hotel-rating-cleanliness"></div>
                                            </div>
                                            <div class="rating-progress">
                                                <div class="progress-fill" data-width="94%"></div>
                                            </div>
                                        </div>

                                        <div class="rating-item">
                                            <div class="rating-label">
                                                <div class="rating-name">
                                                    <div class="rating-icon">
                                                        <i class="fas fa-concierge-bell"></i>
                                                    </div>
                                                    <span>Service</span>
                                                </div>
                                                <div class="rating-value" id="hotel-rating-service"></div>
                                            </div>
                                            <div class="rating-progress">
                                                <div class="progress-fill" data-width="92%"></div>
                                            </div>
                                        </div>

                                        <div class="rating-item">
                                            <div class="rating-label">
                                                <div class="rating-name">
                                                    <div class="rating-icon">
                                                        <i class="fas fa-building"></i>
                                                    </div>
                                                    <span>Condition</span>
                                                </div>
                                                <div class="rating-value" id="hotel-rating-condition"></div>
                                            </div>
                                            <div class="rating-progress">
                                                <div class="progress-fill" data-width="94%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal -->
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
                            <input type="hidden" name="room_id" id="room_id">
                            <input type="hidden" name="booking_type" id="booking_type">
                            <input type="hidden" name="package_id" id="package_id">
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
                                    placeholder="Street address">
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
    </div>
</main>

<?php include "inc/footer.php"; ?>
<script src="assets/js/frontend/hotel-details.js"></script>