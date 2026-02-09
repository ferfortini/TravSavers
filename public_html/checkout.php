<? 

include('inc/db_connect.php');

if (isset($_SESSION['CheckIn']) ) { } else {
header("Location: https://travsavers.com/");
}

include('api_auth.php');

include ('room_choice_api_call.php');

$pagetitle = "Complete Your Reservation - TravSavers.com";
$desc =  "";
$keywords =  "";

$price = $_POST['promoprice'];
$_SESSION['promoprice'] = $_POST['promoprice'];
$_SESSION['publicprice'] = $_POST['publicprice'];
$_SESSION['ourprice'] = $_POST['ourprice'];
$_SESSION['giftshort'] = $_POST['giftshort'];
$_SESSION['thumb'] = $_POST['thumb'];
$_SESSION['propname'] = $_POST['propname'];
$_SESSION['savings'] = $_POST['savings'];
 $_SESSION['refundablebefore'] =  $_POST['refundablebefore'];
$_SESSION['propid'] = $_POST['propid'];
$_SESSION['loc'] = $_POST['loc'];
$_SESSION['resortfee'] = $_POST['resortfee'];

include ('inc/header.php'); 

?>

<main>
     <section id="title" class="border-top pt-2">
            <div class="container">
                <div class="d-block d-lg-flex align-items-center">
                    <div class="me-lg-auto mb-2 mb-lg-2">
                        <!-- Title -->
                        <h1 class="display-8 fw-bold mb-0 text-body-emphasis" style="color:#111111;">Complete Your Reservation</h1>
                        <!-- /Title -->
<? if (isset($_GET['emsg'])) { echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Please enter a valid email address</a>"; } else {} ?>
                    </div>
                   
                </div>
            </div>
        </section>
        <!-- /Page title -->

          
        <!-- Checkout -->
        <section id="checkOut">
            <div class="container">
                <!-- Checkout -->
                <div class="row g-0 g-lg-8 g-xl-12">
                    <div class="col-24 col-xl-16 col-lg-14 order-1 order-lg-0">
                        <form class="needs-validation pb-10" method="post" action="payment.php" novalidate="">
<hr>

        

<h4>Choose Room Type:</h4>
<i style="font-size:75%; ">(All Room Types Accommodate <? echo $_SESSION['Adults']; ?> Adults, <? echo $_SESSION['Children']; ?> Children)</i><br>
<?
$c = '0';
// start foreach
foreach ($choiceresponse->items as $item) {
  if($c==6) break;

$desc = $item->room[0]->description;
$ourprice = $item->room[0]->price;
$refundablechoice = $item-> room[0] -> refundable;

$choicepromoprice = $ourprice - 200;
if ($choicepromoprice < 99) { $choicepromoprice = 99; } else {}
$choicepromoprice = number_format((float)$choicepromoprice, 2, '.', '');
$desc2 = ucwords($desc);
$extrapromoprice = $choicepromoprice - $_SESSION['promoprice'];
$extrapromoprice = number_format((float)$extrapromoprice, 2, '.', '');

// here
// refundable start here
if($refundablechoice == '1'){

$c = $c + 1;
// if c start
if($c == '1') {
	
if($extrapromoprice <1 ) { echo "<input type='radio' value='".$desc2."' name='RoomChoice' onClick='change(".$choicepromoprice.")' checked>  ".$desc2." - <b>$".$choicepromoprice." TOTAL</b></input><br>"; }
else { echo "<input type='radio' value='".$desc2."' name='RoomChoice' onClick='change(".$choicepromoprice.")' checked>  ".$desc2." - <b>$".$choicepromoprice." TOTAL</b> (+ $".$extrapromoprice.")</input><br>"; }

} else {

if($extrapromoprice <1 ) { echo "<input type='radio' value='".$desc2."' name='RoomChoice' onClick='change(".$choicepromoprice.")'>  ".$desc2." - <b>$".$choicepromoprice." TOTAL</b></input><br>"; }
else { echo "<input type='radio' value='".$desc2."' name='RoomChoice' onClick='change(".$choicepromoprice.")'>  ".$desc2." - <b>$".$choicepromoprice." TOTAL</b> (+ $".$extrapromoprice.")</input><br>"; }

// if c end
}

// refundable end here
} else {}


// here


//end foreach
}
?>
 
<input type="hidden" id="pricechoice" name="pricechoice" value="<? echo $_SESSION['promoprice']; ?>">


<hr>
                            <!-- Your information -->
                            <div class="pb-6">
                                <h4>Reservation Information</h4>
                                <div class="row">
                                    <div class="col-24 col-md-12">
                                        <div class="mb-5">
                                            <label class="form-label" for="first">First Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control shadow-sm" id="first" name="first" placeholder="" required="">
                                        </div>
                                    </div>
<div class="col-24 col-md-12">
                                        <div class="mb-5">
                                            <label class="form-label" for="last">Last Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control shadow-sm" id="last" name="last" placeholder="" required="">
                                        </div>
                                    </div>
                                    <div class="col-24 col-md-12">
                                        <div class="mb-5">
                                            <label class="form-label" for="email">Email<span class="text-danger">*</span></label>
                                            <input type="email" class="form-control shadow-sm" id="email" name="email" placeholder="" required="">
                                        </div>
                                    </div>
                                    <div class="col-24 col-md-12">
                                        <div class="mb-5">
                                            <label class="form-label" for="phone">Phone<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control shadow-sm" id="phone" name="phone" placeholder="" required="">
                                        </div>
                                    </div>
<div class="col-24">
                                        <div class="mb-5">
                                            <label class="form-label" for="address">Address<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control shadow-sm" id="address" name="address" placeholder="" required="">
                                        </div>
                                    </div>
                                    <div class="col-24 col-md-12">
                                        <div class="mb-5">
                                             <label class="form-label" for="city">City<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control shadow-sm" id="city" name="city" placeholder="" required="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-5">
                                            <label class="form-label" for="state">State</label>
                                           <select id=state" name="state" id="state" class="form-control shadow-sm" required="">
<option value="">Select...</option>
	<option value="AL">Alabama</option>
	<option value="AK">Alaska</option>
	<option value="AZ">Arizona</option>
	<option value="AR">Arkansas</option>
	<option value="CA">California</option>
	<option value="CO">Colorado</option>
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="DC">District Of Columbia</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="HI">Hawaii</option>
	<option value="ID">Idaho</option>
	<option value="IL">Illinois</option>
	<option value="IN">Indiana</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="MT">Montana</option>
	<option value="NE">Nebraska</option>
	<option value="NV">Nevada</option>
	<option value="NH">New Hampshire</option>
	<option value="NJ">New Jersey</option>
	<option value="NM">New Mexico</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="ND">North Dakota</option>
	<option value="OH">Ohio</option>
	<option value="OK">Oklahoma</option>
	<option value="OR">Oregon</option>
	<option value="PA">Pennsylvania</option>
	<option value="RI">Rhode Island</option>
	<option value="SC">South Carolina</option>
	<option value="SD">South Dakota</option>
	<option value="TN">Tennessee</option>
	<option value="TX">Texas</option>
	<option value="UT">Utah</option>
	<option value="VT">Vermont</option>
	<option value="VA">Virginia</option>
	<option value="WA">Washington</option>
	<option value="WV">West Virginia</option>
	<option value="WI">Wisconsin</option>
	<option value="WY">Wyoming</option>
</select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-5">
                                            <label class="form-label" for="zip">ZIP Code<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control shadow-sm" name="zip" id="zip" placeholder="" required="">
                                        </div>
                                    </div>
                                    
                                    <div class="col-24">
                                        <div>
                                            <label class="form-label">Request (Optional)</label>
                                            <textarea rows="2" class="form-control shadow-sm" name="request" id = "request" placeholder=""></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Your information -->

                            <hr>
<b>Please read and agree to the terms and qualifications of this special promotional offer:  </b>
<br>
<div class="form-check">
    <input class="form-check-input shadow-sm" type="checkbox" value="1" id="TCAgree1" name="TCAgree1" required>
    <label class="form-check-label" for="TCAgree1">
    As part of this promotion, your attendance at a 120-minute no-obligation presentation is required
    </label>
</div>
<div class="form-check">
    <input class="form-check-input shadow-sm" type="checkbox" value="1" id="TCAgree2" name="TCAgree2" required>
    <label class="form-check-label" for="TCAgree2">
   Guests must be at least 28 years of age, have a combined household income of $60,000, and be a major credit card holder (debit cards only not accepted)
    </label>
</div>
<div class="form-check">
    <input class="form-check-input shadow-sm" type="checkbox" value="1" id="TCAgree3" name="TCAgree3" required>
    <label class="form-check-label" for="TCAgree3">
 If married, cohabitating, or in a life partnership, both parties must attend together and show proof of co-residence by presenting matching ID/documents (<a href="#mdlSingle" data-bs-toggle="modal">Single?</a>)
    </label>
</div>
<div class="form-check">
    <input class="form-check-input shadow-sm" type="checkbox" value="1" id="TCAgree4" name="TCAgree4" required>
    <label class="form-check-label" for="TCAgree4">
 I agree to the <a href="#mdlTerms" data-bs-toggle="modal">Terms & Conditions</a> of this offer and I understand the related promotional qualifications
    </label>
</div>
<div class="form-check">
    <input class="form-check-input shadow-sm" type="checkbox" value="1" id="TCAgree5" name="TCAgree5" required>
    <label class="form-check-label" for="TCAgree5">
     I agree to be contacted by phone or email regarding this reservation (<a href="#mdlContact" data-bs-toggle="modal">details</a>). Your reservation request will not be finalized until we can confirm your reservation details with you via phone
    </label>
</div>


<span class="fsm-6">Not interested in taking part in this promotion?  <a href="everyday-search.php?propid=<? echo $_SESSION['propid']; ?>&loc=<? echo $_SESSION['loc']; ?>">Click here</a> to book this hotel at our everyday retail rate of <b>$<? echo $_SESSION['publicprice']; ?></b> - no promotional preview required.</span>

                            <div class="text-xl-end pt-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-arrow"></i> Continue To Payment</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-24 col-xl-8 col-lg-10 order-0 order-lg-1">
                        <!-- Selected tours -->
                        <div class="card sticky-top sticky-top-120 shadow-sm mb-10">
                            <div class="card-body p-6 p-xl-8">
                                <h2 class="mb-8">Reservation Details</h2>
                                <div>
                                    <div class="mb-6 pb-6 border-bottom">
                                        <figure>
<img src="<? echo $_SESSION['thumb']; ?>" style="max-width:40%; border-radius:8px; float:right; margin:8px;">
</figure>
										<h3 class="h6 mb-2">
                                            <a href="#" class="text-body link-hover-primary"><? echo $_SESSION['propname']; ?></a>
                                        </h3>
                                        <div class="fsm-2">
                                            <div class="fw-semibold mb-2">
                                                <span>Today's Resort Preview Rate<a href="#mdlTerms" data-bs-toggle="modal" class="text-body link-hover-primary">*</a></sup>:</span><br>
                                                <strong class="fs-5 text-danger"><div id="FinalPrice"><sup>$</sup><? echo $_SESSION['promoprice']; ?></div> TOTAL ($<? echo $_SESSION['savings']; ?> SAVINGS)</strong>
                                            </div>
                                            <div class="fsm-2 mb-2">
                                                <i class="ti ti-calendar-event"></i>
                                                <span><? echo $_SESSION['DisplayCheckIn']; ?> - <? echo $_SESSION['DisplayCheckOut']; ?>, <? if ($_SESSION['nts'] == '1') { echo "1 Night"; } else { echo $_SESSION['nts']." Nights"; } ?></span>
                                            </div>
                                            <div class="fsm-2 mb-2">
                                                <i class="ti ti-users"></i>
                                                <span><? echo $_SESSION['Adults']; ?> Adults, <? echo $_SESSION['Children']; ?> Children</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-6 pb-6 border-bottom">
                                        <h3 class="h6 mb-2">
                                            <a href="#" class="text-body link-hover-primary">PLUS Promo Package</a>
                                        </h3>
                                        <div class="fsm-2">
                                            <div class="fw-semibold mb-2">
                                                <span>Price:</span>
                                                <strong class="fs-5 text-danger">INCLUDED FREE</strong>
                                            </div>
                                            <div class="fsm-2 mb-2">
                                                <i class="ti ti-gift"></i>
                                                <span><? echo  $_SESSION['giftshort']; ?></span>
                                            </div>
                                           
                                        </div>
                                    </div>
                                
                                </div>
                                <div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-semibold fs-5">Total:</span>
                                        <strong class="fw-bolder fs-2 text-danger"><div id="FinalPrice2"><sup>$</sup><? echo $_POST['promoprice']; ?>.00</div> </strong>

                                    </div>
                                    <p class="text-secondary text-end fsm-3 mb-0">
                                        <em>* Taxes included</em> <br>
<b style="font-size:75%;">Price Offer Expires <? echo date('F j, Y', strtotime('+1 days')); ?>, <i>Fully Refundable Before <? echo $_SESSION['refundablebefore']; ?></i></b><br>
<? if ($_SESSION['resortfee'] != 'none') { echo "<i><a href='#mdlResortFee' data-bs-toggle='modal' class='text-body link-hover-primary'>Resort fee <i class='ti ti-help'></i></a> of $".$_SESSION['resortfee']." (total) payable to property upon check-in</i>"; } else {} ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- /Selected tours -->
                    </div>
                </div>
                <!-- /Checkout -->
            </div>
        </section>
        <!-- /Checkout -->
    </main>

<!-- SINGLE -->
                                        <div class="modal fade" id="mdlSingle" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdlSingleTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title h5" id="mdlSingleTitle" style="color:#000;">Single Traveler?</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:center; color:#000;">
                                                     
All guests who live with their spouse or significant other must travel together.  Single females may participate in this offer (must be 30+ years of age w/ minimum income $100,000 and a major credit card).  No single males may take part in this promotional offer.


                                                    </div>
                                                </div>
                                            </div>
                                        </div>

<!-- SINGLE -->

<!-- CONTACT -->
                                        <div class="modal fade" id="mdlContact" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdlContactTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title h5" id="mdlContactTitle" style="color:#000;">Permission to Contact You About Your Reservation</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:center; color:#000;">
                                                     
By checking this box, I expressly consent and request that TravSavers.com and Westgate
Resorts, Ltd and its related and affiliated entities contact me at the number(s) provided using an
automated telephone dialing/selecting system, prerecorded message, electronic mail or SMS text
message, regardless of any prior election to the contrary. I acknowledge and agree that I
am not required to sign this agreement as a condition of purchasing any property, goods or
services.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

<!-- CONTACT -->

<!-- Event snippet for Res Details Page remarketing page -->
<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-979590368/8DxHCPnis_0YEOC5jdMD',
      'value': 1.0,
      'currency': 'USD',
      'aw_remarketing_only': true
  });
</script>

<? include("inc/footer.php"); ?>