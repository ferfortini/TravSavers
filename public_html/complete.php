<? 
include('inc/db_connect.php');

if (isset($_SESSION['CheckIn']) ) { } else {
header("Location: https://travsavers.com/");
}


$pagetitle = "Reservation Request Complete - TravSavers.com";
$desc =  "";
$keywords =  "";

include ('inc/header.php'); 

$comsess = $_SESSION['paymentsession'];

$comupdate = mysqli_query($con, "UPDATE Sales SET PaymentDateTime = NOW(), Status = 'PAID' WHERE paymentsession = '$comsess' ");

?>



<main>
     <section id="title" class="border-top pt-2">
            <div class="container">
                <div class="d-block d-lg-flex align-items-center">
                    <div class="me-lg-auto mb-2 mb-lg-2">
                        <!-- Title -->
                        <h1 class="display-8 fw-bold mb-0 text-body-emphasis" style="color:#111111;">Reservation Request Complete</h1>
                        <!-- /Title -->
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
                    <div class="col-24 col-xl-16 col-lg-14 order-0 order-lg-0">
                     


                            <!-- Payment methods -->
                            <div>
                               
                                <div class="mb-6">
                                   
                                    <p class="text-success fw-bold">
                                        <i class="ti ti-lock"></i>
                                        <span>Reservation Details</span>
                                    </p>
                                </div>
                                <div class="row">
                                    
                                     <section id="success" class="hidden">
    <p>
Thank you for your reservation request with <b>TravSavers.com</b>! A confirmation email will be sent to <b><span id="customer-email"></span></b>.
<br><br>
<b>Your reservation is not finalized.</b>  One of our representatives will contact you within the next 24 hours (48 hours on weekends) to confirm your reservation and acceptance and understanding of the terms and eligibility requirements of this promotional offer.  After your reservation is confirmed, you will receive a confirmation number and email detailing the specifics of your reservation. 
<br /><br />
<b>DO NOT TRAVEL</b> until you have received confirmation from one of our representatives.  If you would like to speak to someone about your reservation, please contact us by phone at <b>(866) 540-8956</b> or email <a href="mailto:support@travsavers.com">support@travsavers.com</a>.
<br><br>
<center><img src="/assets/img/travsav_logo_all.png" style="max-width:50%"></center>
    </p>
  </section>


                                        

                                    </div>
                                
                            </div>
                            <!-- /Payment methods -->
                      
                    
                    </div>
                    <div class="col-24 col-xl-8 col-lg-10 order-1 order-lg-1">
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
                                                <strong class="fs-5 text-danger"><sup>$</sup><? echo $_SESSION['pricechoice']; ?> TOTAL ($<? echo $_SESSION['savings']; ?> SAVINGS)</strong>
                                            </div>
                                            <div class="fsm-2 mb-2">
                                                <i class="ti ti-calendar-event"></i>
                                                <span><? echo $_SESSION['DisplayCheckIn']; ?> - <? echo $_SESSION['DisplayCheckOut']; ?>, <? if ($_SESSION['nts'] == '1') { echo "1 Night"; } else { echo $_SESSION['nts']." Nights"; } ?></span>
                                            </div>
                                            <div class="fsm-2 mb-2">
                                                <i class="ti ti-users"></i>
                                                <span><? echo $_SESSION['Adults']; ?> Adults, <? echo $_SESSION['Children']; ?> Children</span><br>
<span><b>Room Choice:</b> <? echo $_SESSION['RoomChoice']; ?></span>
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
                                                <span><? echo $_SESSION['giftshort']; ?></span>
                                            </div>
                                           
                                        </div>
                                    </div>
                                
                                </div>
                                <div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-semibold fs-5">Total:</span>
                                        <strong class="fw-bolder fs-2 text-danger"><sup>$</sup><? echo $_SESSION['pricechoice']; ?></strong>
                                    </div>
                                    <p class="text-secondary text-end fsm-3 mb-0">
                                        <em>* Taxes included</em>
<b style="font-size:75%;"><i>Fully Refundable Before <? echo $_SESSION['refundablebefore']; ?></i></b><br>
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


<!-- Event snippet for TS Purchase conversion page -->
<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-979590368/UxnzCNOVmv0YEOC5jdMD',
      'transaction_id': ''
  });
</script>
<? include ('paid.php'); ?>
<? include('confirm.php'); ?>
<? include("inc/footer.php"); ?>