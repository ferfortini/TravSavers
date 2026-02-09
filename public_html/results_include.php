                    <div class="col-24">
                        <!-- Tour list -->
                        <div class="row">

<? 

$h = '0';

while ( $rowprice = mysqli_fetch_array($pricequery) ) {

$h = $h + 1;

$pro = $rowprice['propid'];

// GET PHOTO URLS AND HOTEL DESCRIPTION

$picquery = mysqli_query($con, "SELECT url FROM prop_photos WHERE propid = '$pro'");
$rowpic = mysqli_fetch_array($picquery);
$descquery = mysqli_query($con, "SELECT description FROM $hoteltable WHERE id = '$pro'");
$rowdesc = mysqli_fetch_array($descquery);
$url = $rowpic[0];

// PROCESS PRICE

$publicprice = $rowprice['publicprice'];
$price = $rowprice['price'];
$promoprice = $rowprice['promoprice'];
$stars = $rowprice['rating'];
$name = $rowprice['name'];
$thumb = $rowprice['thumb'];

$refundablebefore = $rowprice['refundablebefore'];
$refundcost = $rowprice['cancelcost'];
$rfcost = $rowprice['resortfeeamount'];
if ($rfcost != 'none') { $rfcost = number_format($rfcost,2); }

$rpublic = round($publicprice, 2);
$rour = round($price, 2);
$rpromo =  round($promoprice, 2);
$bigsave = $rpublic - $rpromo;

if ($rpublic < $rpromo) {} else {

?>
<!-- MODALS START -->
<!-- Hotel 1 -->
                                        <div class="modal fade" id="mdlHotel<? echo $h; ?>" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdlHotel<? echo $h; ?>Title" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                                <div class="modal-content" style="height:80%;">
                                                    <div class="modal-header" style="padding:5px; text-align:center;">
                                                        <h6 class="modal-title h6" id="mdlHotel<? echo $h; ?>Title"><? echo $name; ?></h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
<? echo $rowdesc['description']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<!-- /Hotel 1 -->

<!-- Ready 1 -->
                                        <div class="modal fade" id="mdlReserve<? echo $h; ?>" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdlReserve<? echo $h; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                                <div class="modal-content" style="height:80%;">
                                                    <div class="modal-header" style="padding:5px; text-align:center;">
                                                        <h6 class="modal-title h6" id="mdlReserve<? echo $h; ?>Title">Ready To Reserve Your Stay?</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" style="padding:10px; background-color:#eff2f4;"">


<b><? echo $name; ?></b><br>
<span style="font-size:75%;"><? echo $_SESSION['DisplayCheckIn']; ?> - <? echo $_SESSION['DisplayCheckOut']; ?> | <? echo $_SESSION['Adults']; ?> Adults, <? echo $_SESSION['Children']; ?> Children<br></span>
<b>Today's Resort Preview Rate<sup>*</sup>:</b> $<? echo $rpromo; ?> TOTAL ($<? echo $bigsave; ?> Savings)<br>
<b style="font-size:75%;"><i>Fully Refundable Before <? echo $refundablebefore; ?> </i></b>

<div style="border:1px solid #444; padding:5px; margin:5px;border-radius:10px; font-size: 75%; background-color:#fff;">
<center><u><i>Your Package Includes</i></u></center>
<ul>
<li>Promotional Discounted Hotel Stay   ($<? echo $bigsave; ?> Savings)</li>
<li><? echo $gifts; ?></li>
</div>

<form action="checkout.php" method="POST">

<input type="hidden" value="<? echo $pro; ?>" name="propid">
<input type="hidden" value="<? echo $name; ?>" name="propname">
<input type="hidden" value="<? echo $_SESSION['CheckIn']; ?>" name="APICheckIn">
<input type="hidden" value="<? echo $_SESSION['CheckOut']; ?>" name="APICheckOut">
<input type="hidden" value="<? echo $_SESSION['ChildrenAges']; ?>" name="agestring">
<input type="hidden" value="<? echo $rpromo; ?>" name="promoprice">
<input type="hidden" value="<? echo $rour; ?>" name="ourprice">
<input type="hidden" value="<? echo $rpublic; ?>" name="publicprice">
<input type="hidden" value="<? echo $thumb; ?>" name="thumb">
<input type="hidden" value="<? echo $giftshort2; ?>" name="giftshort">
<input type="hidden" value="<? echo $bigsave; ?>" name="savings">
<input type="hidden" value="<? echo $refundablebefore; ?>" name="refundablebefore">
<input type="hidden" value="<? echo $refundcost; ?>" name="refundcost">
<input type="hidden" value="<? echo $loc; ?>" name="loc">
<input type="hidden" value="<? echo $rfcost; ?>" name="resortfee">



<center>
<!--
 <button onclick="showDiv()" class="btn btn-primary w-50" id="btnSubmit3">
                                            <i class="ti ti-calendar-check"></i>
                                            <span>Reserve Your Stay <div id="loadingGif" style="display:none;"><img src="/assets/img/spinner.png" style="max-width:50px;"></div></span>
                                        </button>
-->
</form>
</center>

<p style="font-size:60%; margin-top:10px;">
To take advantage of this special offer, your attendance at a 120-minute presentation is required and you must meet certain promotional qualifications.  There is no obligation other than your attendance.
Not interested in this promotional offer? Close this window and choose our "Everyday Low Price"<br>

</p>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<!-- /Ready 1 -->

<!-- Photo Gallery 1 -->
                                        <div class="modal fade" id="mdlGallery<? echo $h; ?>" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdlGallery<? echo $h; ?>Title" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                                <div class="modal-content" style="height:80%;">
                                                    <div class="modal-header" style="padding:5px; text-align:center;">
                                                        <h6 class="modal-title h6" id="mdlGallery<? echo $h; ?>Title">Photo Gallery</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
<h4><? echo $name; ?></h4>
<br>
<img src="<? if (isset ($rowpic[0])) { echo $rowpic['0']; } else { echo $featimage; } ?>"  class="img-fluid" alt="<? echo $name; ?>"><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
 <!-- / Photo Gallery 1 -->

<!-- MODALS END -->

                            <div class="col-24 col-xl-24">
                                <!-- HOTEL ITEM -->
                                <div class="pb-4 mb-0">
                                    <div class="row shadow" style="margin:3px; border:1px solid #555555; padding:20px 10px 10px 10px; border-radius:10px; background-color:#ffffff;">
                                        <div class="col-24 col-xxl-8 col-xl-9 col-lg-8 col-md-12">
                                            <!-- Image -->
                                            <div class="mb-0">
                                                <div class="img-info img-info-bottom">
                                                    <a href="hotel-feature.php?loc=<? echo $loc; ?>&hotel=<? echo $pro; ?>" class="d-block mb-0">
                                                        <figure class="img-info-thumbnail image-hover-scale image-hover-overlay rounded"  style="border:2px solid #333333;">
                                                            <img src="<? if (isset($url)) { echo $url; } else { echo "../assets/img/".$featimage; } ?>" class="img-fluid" alt="<? echo $name; ?>">
                                                        </figure>
                                                    </a>
                                            

       <a href='hotel-feature.php?loc=<? echo $loc; ?>&hotel=<? echo $pro; ?>' >
<span class="like-icon liked-icon position-absolute top-0 end-0 me-5 mt-2 shadow-sm"><i class="ti ti-photo-search"></i></span>
</a>

<a href='hotel-feature.php?loc=<? echo $loc; ?>&hotel=<? echo $pro; ?>'>
<span class="like-icon liked-icon position-absolute top-0 end-0 me-5 mt-11 shadow-sm"><i class="ti ti-info-square-rounded"></i></span>
</a>

                                                    <div class="img-info-body mb-5 start-0 ms-5 me-3 shadow d-inline-flex align-items-center fsm-6 fw-semibold" style="position:relative;top:-10px; " >
                                                       <h5 class="fs-8 mb-0 text-body-emphasis">
            <span><? echo $name; ?></span><br>

 <span class="star-rate-view star-rate-size-sm">
<?

 if ($stars == '5') { ?> <span class="star-value rate-50"></span> <? }
elseif ($stars == '4.5') { ?> <span class="star-value rate-45"></span> <? }
elseif ($stars == '4') { ?> <span class="star-value rate-40"></span> <? }
elseif ($stars == '3.5') { ?> <span class="star-value rate-35"></span> <? }
elseif ($stars == '3') { ?> <span class="star-value rate-30"></span> <? }
elseif ($stars == '2.5') { ?> <span class="star-value rate-25"></span> <? }
elseif ($stars == '2') { ?> <span class="star-value rate-20"></span> <? }
 else {} 
?>

</span>

        </h5>

<p class="fsm-4 text-secondary mb-0" style="margin-left:5px;">
Retail Price: <s>$<? echo $rpublic; ?></s><br>
<span class="text-danger">Resort Preview Rate<sup>*</sup>: $<? echo $rpromo; ?> (<u>Save $<? echo $bigsave; ?></u>)</span>
</p>

                          <span style="margin-left:5px;">                     
<a href='hotel-feature.php?loc=<? echo $loc; ?>&hotel=<? echo $pro; ?>'>
                                                        <i class="ti ti-zoom-in"></i>
                                                        Property Details / Photos
                                                    </a></span><br><br>
                                                            
                                                    </div>

<span class="badge bg-primary text-white position-absolute top-0 start-0 ms-6 mt-6 shadow-sm text-uppercase">$<? echo $bigsave; ?> Savings On Your Stay!</span>
                                                </div>

                                            </div>

<div class="text-secondary mb-2" style="color:#222;">

<a href='#mdlPromo' data-bs-toggle='modal' style="font-size:100%;z-index:3;"> <i class="ti ti-help-hexagon"></i>    <b style="font-size:80%;">How can I get this special Resort Preview rate?</b></a><br>



</div>
                                            <!-- /Image -->
                                        </div>
                                        <div class="col-24 col-xxl-16 col-xl-15 col-lg-16 col-md-12">
                                            <!-- Content -->
                                            <div class="mb-4">
                                                <div class="mb-4">
                                                   
                                                    <div class="d-flex align-items-center fsm-2 text-secondary mb-0">
                                                        <div class="lh-1 me-1">
                                                           
                                                        </div>
                                                     </div>
                                                    <div class="fw-semibold mb-1">
                                                        
                                                    </div>

<div class="fw-semibold mb-1">


                                                        <span style="font-size:90%;">Today's Resort Preview Rate (Sponsored)<a href="#mdlTerms" data-bs-toggle="modal" class="text-body link-hover-primary">*</a></sup> </span><br>
                                                        <strong class="fs-5 text-danger"><sup>$</sup><? echo $rpromo; ?> TOTAL FOR <? echo $_SESSION['nts']; ?> Nights </strong>($<? echo $bigsave; ?> Savings Off The Best Online Rate Available) 

                                                    </div>
<i class="ti ti-gift"></i>
<span style="font-size:85%;">Package includes <? echo $giftshort; ?></span>

<form action="checkout.php" method="POST">
<input type="hidden" value="<? echo $pro; ?>" name="propid">
<input type="hidden" value="<? echo $name; ?>" name="propname">
<input type="hidden" value="<? echo $_SESSION['CheckIn']; ?>" name="APICheckIn">
<input type="hidden" value="<? echo $_SESSION['CheckOut']; ?>" name="APICheckOut">
<input type="hidden" value="<? echo $_SESSION['ChildrenAges']; ?>" name="agestring">
<input type="hidden" value="<? echo $rpromo; ?>" name="promoprice">
<input type="hidden" value="<? echo $rour; ?>" name="ourprice">
<input type="hidden" value="<? echo $rpublic; ?>" name="publicprice">
<input type="hidden" value="<? echo $thumb; ?>" name="thumb">
<input type="hidden" value="<? echo $giftshort2; ?>" name="giftshort">
<input type="hidden" value="<? echo $bigsave; ?>" name="savings">
<input type="hidden" value="<? echo $refundablebefore; ?>" name="refundablebefore">
<input type="hidden" value="<? echo $refundcost; ?>" name="refundcost">
<input type="hidden" value="<? echo $loc; ?>" name="loc">
<input type="hidden" value="<? echo $rfcost; ?>" name="resortfee">

<button onclick="showDiv()" class="btn btn-primary" style="width:300px;margin-top:10px;" id="btnSubmit3">
                                            <i class="ti ti-calendar-event"></i>
                                            <span>Book Today's Resort Preview Rate - $<? echo $rpromo; ?> TOTAL <div id="loadingGif" style="display:none;"><img src="/assets/img/spinner.png" style="max-width:50px;"></div></span>
                                        </button>

<!--
<a href='#mdlReserve<? echo $h; ?>' data-bs-toggle='modal' class="btn btn-sm btn-primary me-3">
                                                        <i class="ti ti-calendar-event"></i>
                                                        <span>Book Today's Resort Preview Rate - $<? echo $rpromo; ?> TOTAL</span>
                                                    </a>

-->
</form>



<b style="font-size:85%;">  <i class="ti ti-premium-rights"></i> <i>Price Offer Expires <? echo date('F j, Y', strtotime('+1 days')); ?></i><br>
 <i class="ti ti-receipt-refund"></i> <i>Fully Refundable Before <? echo $refundablebefore; ?></b> <br>
<span style="font-size:85%;"><? if ($rfcost > 0) { 

$rfpn = $rfcost / $_SESSION['nts'];
$rfpn = number_format($rfpn, 2);
$rfpnts = $_SESSION['nts'];
echo " <i class='ti ti-discount-check'></i> <a href='#mdlResortFee' data-bs-toggle='modal' class='text-body link-hover-primary'><b>Resort Fee <i class='ti ti-help'></i></b></a> - $".$rfcost." ($".$rfpn."/night x ".$rfpnts." nights)<br>"; } 
else {  } 
?>
</span></i>
<center>
<hr style="width:80%; border-color:#555; margin-top:5px; margin-bottom:5px;">
</center>

<div>

         </div>                                         
                                                </div>
                                                <div>
                                                    <!-- Detail & Booking -->
                                                     


<div class="fw-semibold mb-1" style="font-size:80%;">
                                                        <span>Today's Everyday Low Price (Not Sponsored)<a href="#mdlTerms" data-bs-toggle="modal" class="text-body link-hover-primary">*</a></sup> </span><br>
                                                        <strong class="fs-5"><sup>$</sup><? echo $rpublic; ?> TOTAL FOR <? echo $_SESSION['nts']; ?> Nights</strong> (Compare To Priceline & Hotels.com At $<? echo $rpublic +2; ?>) 

                                                    </div>
<span style="font-size:75%;"> <i class="ti ti-circle-x"></i> No Resort Preview Required For This Rate</span>
<br>


          <a href="everyday-search.php?propid=<? echo $pro; ?>&loc=<? echo $loc; ?>" class="btn btn-sm btn-outline-primary" style="margin-top:10px;">
   <i class="ti ti-calendar-event"></i>
                                                        <span>Book At Everyday Low Price - $<? echo $rpublic; ?></span>
                                                   
                                                    </a>



                                                    <!-- /Detail & Booking -->
                                                </div>
                                            </div>
                                            <!-- /Content -->
                                        </div>
                                    </div>
                                </div>
                                <!-- /HOTEL ITEM -->
                             
                            </div>

<? 

}

} 

?>
                        
                                        <!-- Filter Options -->
                       
                                </div>
                                <!-- Filter -->
                            </div>
                        </div>
                        <!-- /Tour list -->
                       
            </div>