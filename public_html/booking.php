<?php
session_start();
$page = "Book Destination";
$title = "Review your booking!";
require "inc/header.php";
?>

<main>
<section class="backBtn pb-0">
        <div class="container position-relative">
            <div class="pb-0 d-flex justify-content-end">
                <a href="#" class="p-0 btn btn-link text-info mb-0 mb-lg-2" onclick="history.back()">
                    <i class="fa fa-arrow-left me-2" aria-hidden="true"></i>
                    Return to hotel details
                </a>
            </div>
        </div>
    </section>
    <section class="py-0">
        <div class="container">
            <div class="card bg-light overflow-hidden px-sm-3">
                <div class="row align-items-center g-4">
                    <div class="col-sm-9">
                        <div class="card-body">
                            <h2 class="m-0 h3 card-title">Just a few more details!</h2>
                        </div>
                    </div>

                    <div class="col-sm-3 text-end d-none d-sm-block">
                        <img src="assets/images/element/congratulations.svg" class="mb-n4" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="pt-5">
        <div class="container">
            <div class="row g-4 g-lg-5">

                <div class="col-xl-8">
                    <div class="vstack gap-5">

                        <div class="card shadow">
                            <div class="card-header border-bottom p-4">
                                <h4 class="card-title mb-0"><i class="bi bi-people me-2"></i>Guest Details</h4>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>Guest:</td>
                                                        <td id="guest"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email:</td>
                                                        <td id="email"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mobile:</td>
                                                        <td id="mobile"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Location:</td>
                                                        <td id="location"></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
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
                                    </div>


                                    <div class="card border mt-4">
                                        <div class="card-header border-bottom">
                                            <h5 class="card-title mb-0">Add special requests <span class="small">(Optional)</span></h5>
                                        </div>

                                        <div class="card-body">
                                            <form class="hstack flex-wrap gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="option1">
                                                    <label class="form-check-label" for="option1">ADA facilities</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="option2">
                                                    <label class="form-check-label" for="option2">First floor</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="option4">
                                                    <label class="form-check-label" for="option4">Early check-in</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="option5">
                                                    <label class="form-check-label" for="option5">Near elevator</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="option6">
                                                    <label class="form-check-label" for="option6">Turndown service</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="option7">
                                                    <label class="form-check-label" for="option7">Airport transport</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="option8">
                                                    <label class="form-check-label" for="option8">Extra linens</label>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow">
                            <div class="card-header border-bottom p-4">
                                <!-- Phone Order Info Section -->
                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                                    <div class="payment-title d-flex align-items-center">
                                        <h4 class="card-title mb-0"><i class="bi bi-wallet me-2"></i>Payment Details</h4>
                                    </div>
                                    <div class="text-end order-by-phone small text-muted">
                                        <div>Order by Phone <a href="tel:8006562780" class="text-primary">800–656–2780</a></div>
                                        <div class="text-center">OR</div>
                                        <div class="text-center">Pay Online below</div>
                                    </div>
                                </div>


                            </div>

                            <div class="card-body p-4 pb-0">
                                <form class="row g-3 pt-3" id="payment-form">
                                    <input type="hidden" name="fname" value="<?php echo $fname; ?>">
                                    <input type="hidden" name="lname" value="<?php echo $lname; ?>">
                                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                                    <input type="hidden" name="mobile" value="<?php echo $mobile; ?>">
                                    <input type="hidden" name="zip" value="<?php echo $zip; ?>">
                                    <input type="hidden" name="selected_package_id" value="<?php echo $selected_package_id; ?>">
                                    <input type="hidden" name="selected_rate_key" value="<?php echo $selected_rate_key; ?>">
                                    <div class="col-12">
                                        <label class="form-label"><span class="h6 fw-normal">Card Number *</span></label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control" maxlength="14" placeholder="XXXX XXXX XXXX XXXX" value="**** **** **** 5620">
                                            <img src="assets/images/element/mastercard.svg" class="w-30px position-absolute top-50 end-0 translate-middle-y me-2 d-none d-sm-block" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><span class="h6 fw-normal">Expiration date *</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" maxlength="2" placeholder="Month" value="02">
                                            <input type="text" class="form-control" maxlength="4" placeholder="Year" value="28">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><span class="h6 fw-normal">CVV / CVC *</span></label>
                                        <input type="password" class="form-control" maxlength="3" placeholder="***">
                                    </div>
                                    <div class="col-12 border-bottom pb-4">
                                        <label class="form-label"><span class="h6 fw-normal">Name on Card *</span></label>
                                        <input type="text" class="form-control" aria-label="name of card holder" placeholder="Enter card holder name" value="CHRISTOPHER W HUTCHISON">
                                    </div>

                                    <div class="col-12">
                                        <div class="card border">
                                            <div class="card-header border-bottom">
                                                <h5 class="card-title mb-0">Select Your Rate</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check mb-3 rate-option p-3 border rounded" id="everyday-rate-option">
                                                    <input class="form-check-input" type="radio" name="selectedRate" id="everyDayRateRadio" value="everyday" checked>
                                                    <label class="form-check-label fw-light" for="everyDayRateRadio">
                                                        <strong>Every Day Rate:</strong> <span class="fs-5 every-day-rate-section" id="every-day-rate-main"></span>
                                                    </label>
                                                </div>

                                                <div class="form-check mb-3 rate-option p-3 border rounded" id="preview-rate-option">
                                                    <input class="form-check-input" type="radio" name="selectedRate" id="resortPreviewRateRadioMain" value="preview">
                                                    <label class="form-check-label fw-bold" for="resortPreviewRateRadioMain">
                                                        <strong>Resort Preview Rate:</strong> <span class="fs-5 fw-bold resort-preview-rate-section" id="preview-rate-main"></span>
                                                    </label>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check form-switch form-check-md d-flex justify-content-between mb-4">
                                                        <input class="form-check-input flex-shrink-0" type="checkbox" id="checkPrivacy1">
                                                        <label class="form-check-label ps-2 pe-0" for="checkPrivacy1">No Thanks. I am not interested in the HUGE additional Saving by participating in the “Resort Preview Rate” . I am happy with the great savings I get with the Every Day TravSaver Rate</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check form-switch form-check-md d-flex justify-content-between mb-4">
                                            <input class="form-check-input flex-shrink-0" type="checkbox" id="checkPrivacy1">
                                            <label class="form-check-label ps-2 pe-0" for="checkPrivacy1">By Clicking the "Pay Now" button below I acknowledge this special travel promotion requires attendance at a Fun & Informative 120-min Resort sales & familiarization Preview. Married, cohabitating or life partners must travel and attend together and provide proof of co-residence by presenting matching ID upon check-in. I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms & Conditions and Qualifications</a> of this offer.</label>
                                        </div>
                                    </div>
                                    <div class="card-footer border-top">
                                        <div class="d-sm-flex justify-content-end align-items-center">
                                            <h4 class="text-success me-3" id="total-payment"> </h4>
                                            <!-- <a href="book-confirm.php" class="btn btn-success mb-0">Pay Now</a> -->
                                            <button class="btn btn-success mb-0" type="submit" name="pay_now">Pay Now</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card shadow">
                            <div class="card-header border-bottom px-4 py-3">
                                <h5 class="card-title my-0">Payment Policies</h5>
                            </div>

                            <div class="card-body p-4 pb-0">
                                <ul>
                                    <li>A FEE of $45.2 USD per room per stay will be charged at hotel</li>
                                    <li>Please note that we are unable to facilitate a rebate of Canadian Goods and Services Tax ('GST') for customers booking Canadian hotel accommodations utilizing our services. For bookings in Canada, the charges may also include destination marketing fees collected by the hotel and passed along to tourist bureaus.</li>
                                    <li>Depending on the property you stay at you may also be charged (i) certain mandatory hotel specific service fees, for example, resort fees (which typically apply to resort type destinations and, if applicable, may range from $10 to $40 per day), energy surcharges, newspaper delivery fees, in-room safe fees, tourism fees, or housekeeping fees and/or (ii) certain optional incidental fees, for example, parking charges, minibar charges, phone calls, room service and movie rentals, etc. These charges, if applicable, will be payable by you to the hotel directly at checkout. When you check in, a credit card or, in the hotel's discretion, a debit card, will be required to secure these charges and fees that you may incur during your stay. Please contact the hotel directly as to whether and which charges or service fees apply.</li>
                                    <li>For transactions involving hotels located within certain jurisdictions, the charge to your method of payment for Taxes and Fees includes a payment of tax that we are required to collect and remit to the jurisdiction for tax owed on amounts we retain as compensation for our services.</li>
                                    <li>In connection with facilitating your hotel transaction, the charge to your method of payment will include a charge for Taxes and Fees. This charge includes an estimated amount to recover the amount we pay to the hotel in connection with your reservation for taxes owed by the hotel including, without limitation, sales and use tax, occupancy tax, room tax, excise tax, value added tax and/or other similar taxes. In certain locations, the tax amount may also include government imposed service fees or other fees not paid directly to the taxing authorities but required by law to be collected by the hotel. The amount paid to the hotel in connection with your reservation for taxes may vary from the amount we estimate and include in the charge to you. The balance of the charge for Taxes and Fees is a fee we retain as part of the compensation for our services and to cover the costs of your reservation, including, for example, customer service costs. The charge for Taxes and Fees varies based on a number of factors including, without limitation, the amount we pay the hotel and the location of the hotel where you will be staying, and may include profit that we retain. Except as described below, we are not the vendor collecting and remitting taxes to the applicable taxing authorities. Our hotel suppliers, as vendors, include all applicable taxes in the amount billed to us and we pay over such amounts directly to the vendors. We are not a co-vendor associated with the vendor with whom we book or reserve our customer's travel arrangements. Taxability and the appropriate tax rate and the type of applicable taxes vary greatly by location.</li>
                                    <li>Pets Policy - Pets are allowed. Charges may apply.</li>
                                    <li>Occupancy Policy - All rooms will accommodate up to 2 people. Requests for bed types (King, Queen, Double, etc.) or other request(including preferences for smoking or non-smoking rooms) should be requested through your confirmed hotel and cannot be guaranteed.
                                    </li>
                                    <li>Check-in Policy - The reservation holder must present a valid photo ID and credit card at check-in. The credit card is required for any additional hotel specific service fees or incidental charges or fees that may be charged by the hotel to the customer at checkout. These charges may be mandatory (e.g., resort fees) or optional (parking, phone calls or mini-bar charges) and are not included in the room rate.
                                    </li>
                                    <li>Room Charge Disclosure - Your credit card is charged the total cost at time of purchase. Prices and room availability are not guaranteed until full payment is received.
                                    </li>
                                    <li>Age Restriction Disclosure - The reservation holder must be 21 years of age or older.
                                    </li>
                                    <li>Mandatory Fee Policy - This hotel charges an additional $45.2 USD mandatory fee. This fee will be charged to you directly by the hotel. Mandatory fees are not optional and typically cover items such as resort fees, energy charges or safe fees. The amount of the charge is subject to change.
                                    </li>
                                    <li>In order to obtain this discounted rate, prepayment is required at time of booking. Payment will appear on your credit card under Hotel Accommodations in US Dollars.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal modal-lg fade" id="termsModal" aria-hidden="true">
                    <div class="modal-dialog ">
                        <div class="modal-content">
                            <!-- Title -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="inquiryFormlabel">Terms & Conditions and Qualifications</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- Body -->
                            <div class="modal-body p-3">
                                <p class="lead">To accept this promotional offer you must meet promotional qualifications and agree to the following terms & conditions:</p>

                                <p>Guest is responsible for the on-site payment of any additional resort fees the property may charge, resort fees may change without notice, please confirm with property. Reservations are made on a space available basis. Inventory on the site is updated daily, but may not reflect real-time availability. Price offers are made for a limited time due to price fluctuation, expire soon after they are posted, and are subject to change. Your card will be authorized upon booking and final payment will not be processed until the reservation is fully confirmed, usually within 24-72 hours. Authorizations for reservations that cannot be confirmed will be released without charge.</p>

                                <p class="text-decoration-underline fw-bold">Promotional Qualifications:</p>

                                <ul>
                                    <li>As part of this promotion, your attendance at a 120-minute no-obligation sales presentation is required.</li>
                                    <li>Guests must be at least 28 years of age & have a combined household income of $60,000 (Single females must be 30 years of age, have $100,000 income, and be a major CC holder. No single males.)</li>
                                    <li>If married, cohabitating, or in a life partnership, both parties must attend together and show proof of co-residence by presenting matching ID/documents.
                                    </li>
                                    <li>Guests must present a major credit card (debit cards not accepted), and both parties must speak and understand fluent English.
                                    </li>
                                    <li>Your reservation request will not be finalized until we can confirm your reservation details with you via phone
                                        .</li>
                                </ul>

                                <p>Intentional misrepresentation of these qualifications may result in the cancellation of this package and forfeiture of the package price paid.</p>

                                <p>This offer is not valid for:</p>

                                <ul>
                                    <li>Guests who live within 60 miles of the property</li>
                                    <li>Westgate employees, Westgate timeshare owners, Westgate VOA owners, individuals employed in the vacation ownership industry, or realtors</li>
                                    <li>Guests who have scheduled for any other tour with Westgate during their stay.
                                    </li>
                                    <li>Persons who have received the vacation package as a gift from a second party.</li>
                                    <li>Anyone who is in the process of bankruptcy or foreclosure.
                                    </li>
                                    <li>Group travel (three or more couples or singles traveling together on separate packages).
                                    </li>
                                    <li>Anyone attending / participating in a sporting event, convention, or family reunion.</li>
                                    <li>Children or parents of Westgate owners</li>
                                    <li>If a customer has previously toured Westgate Travel Club, they are not eligible to tour Westgate Resorts again.
                                    </li>
                                    <li>Persons who are consuming alcohol or under the influence of alcohol at the time of the promotional presentation.</li>
                                    <li>Persons who have toured Westgate twice in a lifetime. A qualified customer must wait a full twelve (12) months before touring the same destination they have previously toured and 6 months to tour a different destination during value and standard season.</li>
                                </ul>

                                <p>Offer Sponsored by Westgate Resorts. Offer void where prohibited by law. This offer is made in compliance with the law of jurisdiction in which the projects are located.</p>

                                <p class="uppercase fw-bold">THIS ADVERTISING MATERIAL IS BEING USED FOR THE PURPOSE OF SOLICITING SALES OF TIMESHARE INTERESTS OR PLANS
                                </p>
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
                                        <!-- <li class="list-group-item d-flex justify-content-between align-items-center py-0" id="everydayRate">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="selectedRate" id="everyDayRateRadio" value="everyday"> 
                                                 <label class="form-check-label h6 fw-light mb-0 every-day-rate-section" for="everyDayRateRadio">
                                                    Every Day Rate:
                                                </label>
                                            </div>
                                            <span class="fs-5 every-day-rate-section" id="every-day-rate"></span>
                                        </li>
                                        <hr class="m-0"> -->
                                        <!-- <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="h6 fw-light mb-0">Resort Preview Rate:</span>
                                            <span class="fs-5 fw-bold resort-preview-rate-section" id="preview-rate"></span>
                                        </li>
                                        <hr class="m-0 resort-preview-rate-section"> -->
                                        <!-- <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="h6 fw-light mb-0"> Room Cost:</span>
                                            <span class="fs-5 fw-bold" id="room-cost"></span>
                                        </li>
                                        <hr class="m-0"> -->

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="h6 fw-light mb-0"> Taxes &amp; Recovery Fee:</span>
                                            <span class="fs-5" id="tax"></span>
                                        </li>

                                        <!-- <hr class="m-0">

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="h6 fw-light mb-0" id="description"></span>
                                            <span class="fs-5 text-success fw-bold">FREE</span>
                                        </li> -->

                                        <hr class="m-0">
                                        <div id="coupon-discount" style="display: none;">
                                        </div>

                                        <li class="list-group-item d-flex justify-content-between align-items-center mt-2">
                                            <span class="h5 fw-light mb-0">Total Payable Now</span>
                                            <span class="h5 mb-0" id="total"></span>
                                        </li>


                                    </ul>
                                </div>
                                <!-- <div class="card-footer border-top">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 mb-0">Payable Now</span>
                                        <span id="payable-now" class="h5 mb-0 fw-medium">$74.65</span>
                                    </div>
                                </div> -->
                                <!-- <div class="card-footer border-top py-3">
                                    <div class="d-sm-flex justify-content-end align-items-center">
                                        <div class="smaller fst-italic me-3">*Price Offer Expires April 8, 2025, Fully Refundable Before May 14, 2025</div>
                                    </div>
                                </div> -->
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
                                        <input class="form-control" id="coupon-code" placeholder="Enter code">
                                        <input type="hidden" id="cart-total" value="0">
                                        <em class="position-absolute icon-close" id="remove-coupon"></em>
                                        <button type="button" class="btn btn-primary btn-coupon" id="apply-coupon">Apply</button>
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
<script src="assets/js/frontend/payment.js"></script>
<script src="assets/js/frontend/coupon.js"></script>