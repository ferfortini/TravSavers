<?php
$page = "destination-search";
$title = "Book Online in No Time!";
require 'api_auth.php';
require "inc/header.php";
?>

<main>
    <section class="pt-0">
        <div class="container-fluid" style="background-image:url(assets/images/heros/orlando.jpg); background-position: center left; background-size: cover;">
            <div class="row">
                <div class="col-md-8 mx-auto text-start pt-7 pb-5">
                    <h1 class="text-white fw-light">Destinations: <span class="fw-bold" id="destination"></span></h1>
                    <p class="lead text-white">Our nightly destination pricing is unbeatable!</p>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-0 pb-4">
        <div class="container-fluid px-4 position-relative">

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <input type="checkbox" class="btn-check" id="btn-check-soft">
                        <label class="btn btn-primary-soft btn-primary-check mb-0" for="btn-check-soft" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-controls="collapseFilter">
                            <i class="bi fa-fe bi-search me-2"></i>Edit Search
                        </label>

                        <div class="d-flex gap-2 align-items-center">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="viewMode" id="viewList" value="list" checked>
                                <label class="btn btn-outline-primary" for="viewList">
                                    <i class="bi bi-list-ul me-1"></i>List
                                </label>
                                <input type="radio" class="btn-check" name="viewMode" id="viewMap" value="map">
                                <label class="btn btn-outline-primary" for="viewMap">
                                    <i class="bi bi-map me-1"></i>Map
                                </label>
                            </div>

                            <div class="col-2">
                                <div class="form-control-borderless">
                                    <select class="form-select js-choice" id="sort" name="sort" data-search-enabled="false">
                                        <option selected disabled>Sort Results</option>
                                        <option value="BiggestSavings">Best Savings</option>
                                        <option value="PriceAsc">Price (Low to High)</option>
                                        <option value="PriceDesc">Price (High to Low)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


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
                    <div class="vstack gap-4" id="hotel-results">
                    </div>
                </div>

                <!-- Map Column - Always visible on the right -->
                <div class="col-lg-12 col-xl-3" id="map-column">
                    <div class="card shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Map View</h5>
                        </div>
                        <div class="card-body p-0">
                            <div id="hotel-map" style="height: 600px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</main>

<?php include "inc/footer.php";
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAy1L4SogCeS9kwHHK8n_0LKVGCtcDwUs4&libraries=places" async defer></script>
<script src="assets/js/frontend/hotel-list.js"></script>