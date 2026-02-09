<?php
session_start();
$page = "dashboard-hotel-confirm";
$title = "Booking confirmed!";
include 'inc/header.php';
include('api_auth.php');
?>

<main>
    <section class="pt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-xl-8 mx-auto">

                    <div class="card shadow">
                        <img src="assets/images/sample-hotels/orlando/hilton-vacation-club-grande-villas.webp" class="rounded-top object-fit-cover" alt="" style="height:300px;">

                        <div class="card-header border-bottom text-center p-4 pb-0">
                            <h1 class="card-title text-success fs-3">Congratulations!</h1>
                            <p class="lead mb-3">Your trip has been booked at:</p>

                            <h5 class="text-primary mb-0">Hilton Vacation Club Grand Villas</h5>
                            <p class="small">12118 Turtle Cay Circle, Orlando, FL 32836</p>
                        </div>
                        <div class="card-body text-center p-4 pb-0">
                            <div class="row justify-content-between text-start mb-4">
                                <div class="col-md-6" style="border-right:1px solid lightgray">
                                    <ul class="list-group list-group-borderless">
                                        <li class="list-group-item d-sm-flex justify-content-between align-items-center">
                                            <span class="mb-0"><i class="bi bi-vr fa-fw me-2"></i>Confirmation:</span>
                                            <span class="h6 fw-normal mb-0">33787388332</span>
                                        </li>
                                        <li class="list-group-item d-sm-flex justify-content-between align-items-center">
                                            <span class="mb-0"><i class="bi bi-person fa-fw me-2"></i>Booked by:</span>
                                            <span class="h6 fw-normal mb-0">Chris Hutchison</span>
                                        </li>
                                        <li class="list-group-item d-sm-flex justify-content-between align-items-center">
                                            <span class="mb-0"><i class="bi bi-wallet2 fa-fw me-2"></i>Payment Method:</span>
                                            <span class="h6 fw-normal mb-0">MasterCard</span>
                                        </li>
                                        <li class="list-group-item d-sm-flex justify-content-between align-items-center">
                                            <span class="mb-0"><i class="bi bi-currency-dollar fa-fw me-2"></i>Total Price:</span>
                                            <span class="h6 fw-normal mb-0">$74.65</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-borderless">
                                        <li class="list-group-item d-sm-flex justify-content-between align-items-center">
                                            <span class="mb-0"><i class="bi bi-calendar fa-fw me-2"></i>Check-In:</span>
                                            <span class="h6 fw-normal mb-0">June 15, 2025</span>
                                        </li>
                                        <li class="list-group-item d-sm-flex justify-content-between align-items-center">
                                            <span class="mb-0"><i class="bi bi-calendar fa-fw me-2"></i>Check-Out:</span>
                                            <span class="h6 fw-normal mb-0">June 18, 2025</span>
                                        </li>
                                        <li class="list-group-item d-sm-flex justify-content-between align-items-center">
                                            <span class="mb-0"><i class="bi bi-people fa-fw me-2"></i>Guests:</span>
                                            <span class="h6 fw-normal mb-0">2</span>
                                        </li>
                                        <li class="list-group-item d-sm-flex justify-content-between align-items-center">
                                            <span class="mb-0"><i class="bi bi-door-open fa-fw me-2"></i>Rooms:</span>
                                            <span class="h6 fw-normal mb-0">1</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top p-4">
                            <div class="d-sm-flex justify-content-sm-end d-grid">
                                <div class="dropdown me-sm-2 mb-2 mb-sm-0">
                                    <a href="#" class="btn btn-light mb-0 w-100" role="button" id="dropdownShare" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-share me-2"></i>Share Itinerary
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end min-w-auto shadow rounded" aria-labelledby="dropdownShare">
                                        <li><a  class="dropdown-item" href="#"><i class="bi bi-envelope me-2"></i>Email</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-phone me-2"></i>SMS</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-copy me-2"></i>Copy link</a></li>
                                    </ul>
                                </div>
                                <a href="#" class="btn btn-primary mb-0"><i class="bi bi-file-pdf me-2"></i>PDF Invoice</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>

<?php
include 'inc/footer.php';
?>
