<? 
include('inc/db_connect.php');

if (isset($_SESSION['CheckIn']) ) { } else {
header("Location: https://travsavers.com/");
}


if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        // valid address, just chill
    }
    else {
        // invalid address, redirect with msg
header("Location: https://travsavers.com/checkout.php?emsg=1");
    }


$_SESSION['paymentsession'] = session_id();
$paymentsession = $_SESSION['paymentsession'];
$_SESSION['Email'] = $_POST['email'];

$promoprice = $_SESSION['promoprice'];
$price = $_SESSION['ourprice'];
$publicprice = $_SESSION['publicprice'];
$_SESSION['pricechoice'] = $_POST['pricechoice'];
$pricechoice = $_SESSION['pricechoice'];
$upgradecost = $pricechoice - $promoprice;

$LocName = $_SESSION['loc'];

$ArrivalDate = $_SESSION['DisplayCheckIn'];
$CheckOut = $_SESSION['DisplayCheckOut'];

$PackagePrice = $_SESSION['promoprice'];
$PackageDays = $_SESSION['nts'] + 1;
$PackageNights = $_SESSION['nts'];

$RoomChoice =  addslashes($_POST['RoomChoice']);
$_SESSION['RoomChoice'] = $RoomChoice;
$refundablebefore = $_SESSION['refundablebefore'];
$resortfee = $_SESSION['resortfee'];

$PackageGifts =  addslashes($_SESSION['giftshort']);
$IP = $_SERVER['REMOTE_ADDR'];
$HotelName =  addslashes($_SESSION['propname']);


$FirstName= addslashes($_POST['first']);
$LastName= addslashes($_POST['last']);
$PhoneNumeric = preg_replace('/\D/', '', $_POST['phone']);
$Phone= $PhoneNumeric;
$Email = $_POST['email'];
$Address= addslashes($_POST['address']);
$City =  addslashes($_POST['city']);
$State =  addslashes($_POST['state']);
$ZIP=  addslashes($_POST['zip']);
if(isset($_POST['request'])) { $request=  addslashes($_POST['request']); } else { $request = 'na'; }
$Adults = $_SESSION['Adults'];
$Children = $_SESSION['Children'];
if (isset($_SESSION['ChildrenAges'])) { $ChildrenAges = $_SESSION['ChildrenAges']; } else { $ChildrenAges = 'na'; }
if(isset($_SESSION['kw'])) { $Keyword = $_SESSION['kw']; } else { $Keyword = 'na'; }
if(isset($_SESSION['adsrc'])) { $Source = $_SESSION['adsrc']; } else { $Source = 'na'; }
if(isset($_SESSION['ad'])) { $AdCode = $_SESSION['ad']; } else { $AdCode = 'na'; }

$TCAgree1 = $_POST['TCAgree1'];
$TCAgree2 = $_POST['TCAgree2'];
$TCAgree3 = $_POST['TCAgree3'];
$TCAgree4 = $_POST['TCAgree4'];
$TCAgree5 = $_POST['TCAgree5'];


/*
if(isset($_SESSION['LastID'])) {} else {
*/

$result=MYSQLI_QUERY($con,"INSERT INTO Sales (SaleID, ArrivalDate, CheckOut, LocName, PackageDays, PackageNights, PackageGifts, promoprice, pricechoice, upgradecost, price, publicprice, RequestedProperty, RoomChoice, refundablebefore, resortfee, SaleDateTime, FirstName, LastName, Phone, Email, Address, City, State, ZIP, request, IP, Keyword, Source, AdCode, Status, TCAgree1, TCAgree2, TCAgree3, TCAgree4, TCAgree5, Adults, Children, ChildrenAges, paymentsession) 

VALUES ('NULL','$ArrivalDate','$CheckOut','$LocName','$PackageDays','$PackageNights','$PackageGifts','$promoprice','$pricechoice','$upgradecost','$price','$publicprice','$HotelName','$RoomChoice','$refundablebefore','$resortfee',NOW(),'$FirstName','$LastName','$Phone','$Email','$Address','$City','$State','$ZIP','$request','$IP','$Keyword','$Source','$AdCode','UNPAID','$TCAgree1', '$TCAgree2', '$TCAgree3', '$TCAgree4', '$TCAgree5','$Adults','$Children','$ChildrenAges','$paymentsession');") or die ('Unable to execute query. '. mysqli_error($con));  ;

$last_id = mysqli_insert_id($con);

$_SESSION['LastID'] = $last_id;
/*

}
*/



$pagetitle = "Enter Payment Information - TravSavers.com";
$desc =  "";
$keywords =  "";

include ('inc/header.php'); 


?>



<main>
     <section id="title" class="border-top pt-2">
            <div class="container">
                <div class="d-block d-lg-flex align-items-center">
                    <div class="me-lg-auto mb-2 mb-lg-2">
                        <!-- Title -->
                        <h1 class="display-8 fw-bold mb-0 text-body-emphasis" style="color:#111111;">Enter Your Payment Information</h1>
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
                    <div class="col-24 col-xl-16 col-lg-14 order-1 order-lg-0">
                     


                            <!-- Payment methods -->
                            <div>
                               
                                <div class="mb-6">
                                   
                                    <p class="text-success fw-bold">
                                        <img src="/assets/img/secure.png">
<br>
<b>Price Offer Expires <? echo date('F j, Y', strtotime('+1 days')); ?>, <i>This Reservation Is Fully Refundable Before <? echo $_SESSION['refundablebefore']; ?></i></b>
                                    </p>
                                </div>
                                <div class="row">
                                    
                              
                                        <div id="checkout" style="width:100%; border:1px solid #000; padding:0px;">
        <!-- Checkout will insert the payment form here -->
      </div>

                                    </div>
                                
                            </div>
                            <!-- /Payment methods -->
                      
                    
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
                                        <em>* Taxes included</em><br>
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

<!-- Event snippet for UNPAID remarketing page -->
<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-979590368/00dTCMXbs_0YEOC5jdMD',
      'value': 1.0,
      'currency': 'USD',
      'aw_remarketing_only': true
  });
</script>

<? include('unpaid.php'); ?>

<? include("inc/footer.php"); ?>