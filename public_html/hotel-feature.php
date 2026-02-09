<? 
include('inc/db_connect.php');

if (isset($_GET['hotel']) ) { } else {
header("Location: https://travsavers.com/");
}

$hotid = $_GET['hotel'];
$loc = $_GET['loc'];



if ($loc == '1') { $deals = '1'; } else {}

$llquery = mysqli_query($con, "SELECT * FROM locations WHERE id = '$loc' ");
$rowloc = mysqli_fetch_array($llquery);
$gifts = $rowloc['gifts'];
$logo = $rowloc['logo'];
$locq = $rowloc['hoteltable'];
$locname = $rowloc['city'];

$hotquery = mysqli_query($con, "SELECT * FROM $locq WHERE id = '$hotid' ");
$rowhot = mysqli_fetch_array($hotquery);
$hotel = $rowhot['name'];
$description = $rowhot['description'];
$address = $rowhot['address'];
$stars = $rowhot['stars'];
$rating = $rowhot['rating'];
$reviews = $rowhot['reviews'];


$pagetitle = $hotel." - ".$locname." Vacation Packages";
$desc =  "Great Deals On ".$hotel." & Other Popular ".$locname." Hotels & Resorts";
$keywords =  "".$hotel." ".$locname.", ".$locname." ".$hotel.", ".$hotel." packages";

if (isset($_SESSION['sessioncheck']) ) { } else {
header("Location: https://travsavers.com/");
}
$sc = $_SESSION['sessioncheck'] ;

include ('inc/header.php'); 

$hotphotquery = mysqli_query($con, "SELECT url FROM prop_photos WHERE propid = '$hotid' ");
$rowhotphot = mysqli_fetch_array($hotphotquery);


$thumb = $rowhotphot['url'];



$proppricequery = mysqli_query($con, "SELECT * FROM vegas_api_temp WHERE sessionid = '$sc' AND propid = '$hotid' ");
$rowpp = mysqli_fetch_array($proppricequery);

$photquery = mysqli_query($con, "SELECT * FROM vegas_1000 WHERE PropertyId = '$hotid' ");
$countphotos = mysqli_num_rows($photquery);
    
$bigsave = $rowpp['publicprice'] - $rowpp['promoprice'];
$lat = $rowpp['latitude'];
$lon = $rowpp['longitude'];

?>
<main>
        <!-- Title and Widget -->
        <section id="title" class="border-top pt-0 mb-8">
            <div class="container">
          
<div class="row g-0 align-items-center">
                        <!-- Content -->
                        <div class="mb-4 pt-2 pt-xl-0 pb-xl-0">
<div class="img-info img-info-left ms-4 ms-lg-4 " style="float:right; max-width:50%;">
  
   <br> <figure class="img-info-thumbnail rounded shady" style="margin:10px;">
 <a href='#mdlPG' data-bs-toggle='modal'>      
  <img src="<? echo $thumb; ?>" alt="Save On <? echo $hotel; ?>" style="float:right; " >

</a>

    </figure>
<div style="text-align:center;">
<a href='#mdlPG' data-bs-toggle='modal'>   <i class="ti ti-photo-search"></i> View Property Photos (<? echo $countphotos; ?> <i class="ti ti-camera"></i>)</a>
    </div>


</div>
<br>
<a href="property-search.php?loc=<? echo $loc;?>" class="btn btn-sm btn-primary me-3" style="margin-bottom:10px;"><<< Return to Search</a>

                             <h1 class="display-7 fw-bold mb-3" style="color:#333333;"><? echo $hotel; ?></h1>
<? echo $address; ?><br>

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

</span><br><? echo $rating; ?> Guest Rating <br>(<? echo $reviews; ?> Reviews)<br>
 <a href='#mdlPG' data-bs-toggle='modal'>  <i class="ti ti-photo-search"></i><b> Photo Gallery (<? echo $countphotos; ?> <i class="ti ti-camera"></i>)</b></a>
<a href='#mdlMap' data-bs-toggle='modal'>  |  <i class="ti ti-map"></i><b> Map This Location</b></a>

<br><br>



<!-- Ready 1 -->
                                        <div class="modal fade" id="mdlReserve" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdlReserve" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                                <div class="modal-content" style="height:80%;">
                                                    <div class="modal-header" style="padding:5px; text-align:center;">
                                                        <h6 class="modal-title h6" id="mdlReserveTitle">Ready To Reserve Your Stay?</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" style="padding:10px; background-color:#eff2f4;"">


<b><? echo $rowpp['name']; ?></b><br>
<span style="font-size:75%;"><? echo $_SESSION['DisplayCheckIn']; ?> - <? echo $_SESSION['DisplayCheckOut']; ?> | <? echo $_SESSION['Adults']; ?> Adults, <? echo $_SESSION['Children']; ?> Children<br></span>
<b>Today's Resort Preview Rate<sup>*</sup>:</b> $<? echo $rowpp['promoprice']; ?> TOTAL ($<? echo $bigsave; ?> Savings)<br>
<b style="font-size:75%;"><i>Fully Refundable Before <? echo $rowpp['refundablebefore']; ?> </i></b>

<div style="border:1px solid #444; padding:5px; margin:5px;border-radius:10px; font-size: 75%; background-color:#fff;">
<center><u><i>Your Package Includes</i></u></center>
<ul>
<li>Promotional Discounted Hotel Stay   ($<? echo $bigsave; ?> Savings)</li>
<li><? echo $gifts; ?></li>
</div>

<form action="checkout.php" method="POST">

<input type="hidden" value="<? echo $hotid; ?>" name="propid">
<input type="hidden" value="<? echo $hotel; ?>" name="propname">
<input type="hidden" value="<? echo $_SESSION['CheckIn']; ?>" name="APICheckIn">
<input type="hidden" value="<? echo $_SESSION['CheckOut']; ?>" name="APICheckOut">
<input type="hidden" value="<? echo $_SESSION['ChildrenAges']; ?>" name="agestring">
<input type="hidden" value="<? echo $rowpp['promoprice']; ?>" name="promoprice">
<input type="hidden" value="<? echo $rowpp['price']; ?>" name="ourprice">
<input type="hidden" value="<? echo $rowpp['publicprice']; ?>" name="publicprice">
<input type="hidden" value="<? echo $thumb; ?>" name="thumb">
<input type="hidden" value="<? echo $rowloc['giftshort2']; ?>" name="giftshort">
<input type="hidden" value="<? echo $bigsave; ?>" name="savings">
<input type="hidden" value="<? echo $rowpp['refundablebefore']; ?>" name="refundablebefore">
<input type="hidden" value="<? echo $rowpp['cancelcost']; ?>" name="refundcost">
<input type="hidden" value="<? echo $loc; ?>" name="loc">
<? $rf = round($rowpp['resortfeeamount'], 2); ?>
<input type="hidden" value="<? echo $rf; ?>" name="resortfee">



<center>
 <button onclick="showDiv()" class="btn btn-primary w-50" id="btnSubmit3">
                                            <i class="ti ti-calendar-check"></i>
                                            <span>Reserve Your Stay <div id="loadingGif" style="display:none;"><img src="/assets/img/spinner.png" style="max-width:50px;"></div></span>
                                        </button>
</form>
</center>

<p style="font-size:60%; margin-top:10px;">
To take advantage of this special offer, your attendance at a 120-minute presentation is required.  There is no obligation other than your attendance.
Not interested in this promotional offer? Close this window and choose our "Everyday Low Price"<br>

</p>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<!-- /Ready 1 -->

<!-- PHOTOGALL -->
                                        <div class="modal fade" id="mdlPG" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdlPG" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                                <div class="modal-content" style="height:80%;">
                                                    <div class="modal-header" style="padding:5px; text-align:center;">
                                                        <h6 class="modal-title h6" id="mdlPGTitle">Photo Gallery - <? echo $hotel; ?></h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:center; padding:10px; background-color:#eff2f4;"">

<?

while ($rowpq = mysqli_fetch_array($photquery)) {

echo "<a href=' ".$rowpq['Uri']." ' class='glightbox' data-gallery='gallery1';>";
echo "<img src=' ".$rowpq['Uri']." ' style='max-width:95%; border: 1px solid #000;'>";
echo "</a><br><br>";
}

?>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<!-- /PHOTOGALL -->


<!-- MAP -->
                                        <div class="modal fade" id="mdlMap" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdlMap" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                                <div class="modal-content" style="height:80%;">
                                                    <div class="modal-header" style="padding:5px; text-align:center;">
                                                        <h6 class="modal-title h6" id="mdlMapTitle">Map - <? echo $hotel; ?></h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:center; padding:10px; background-color:#eff2f4;"">

 <gmp-map     id="marker-click-event-example" center="<? echo $lat.", ".$lon; ?>" zoom="14" map-id="<? echo $hotel;?>">
   <gmp-advanced-marker position="<? echo $lat.", ".$lon; ?>">
</gmp-advanced-marker>
   </gmp-map>



<?
echo "<b>".$hotel."<br></b>";
echo $address;
?>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<!-- /MAP -->






 <!-- Detail & Booking -->
                                                     <a href='#mdlReserve' data-bs-toggle='modal' class="btn btn-sm btn-primary me-3" style="margin:10px;">
                                                        <i class="ti ti-calendar-event"></i>
                                                        <span>Book Today's Resort Preview Rate<sup>*</sup> - $<? echo $rowpp['promoprice']; ?> TOTAL</span>
                                                    </a>

                                                    <a href="everyday-search.php?propid=<? echo $hotid; ?>&loc=<? echo $loc; ?>" class="btn btn-sm btn-outline-primary" style="margin:10px;">
   <i class="ti ti-calendar-event"></i>
                                                        <span>Book At Everyday Low Price - $<? echo $rowpp['publicprice']; ?></span>
                                                   
                                                    </a>
<br>
<i style="font-size:75%;">Today's Competitor Rates: Priceline $<? echo $rowpp['publicprice']; ?>, Hotels.com $<? echo $rowpp['publicprice'] + 1; ?></i>
<br><br>
                                                    <!-- /Detail & Booking -->

<p class='fs-9 mb-0 text-secondary'><? echo $description; ?></p>

<hr>

<p class='fs-5 mb-0 text-secondary'>Save big when you book your <b><? echo $locname; ?> vacation</b> with TravSavers! Take advantage of our everyday low rates, or book a promo package and <u>save an additional $200-$500 or more</u> on your choice of hotel in <? echo $locname; ?></b>!  
<br>
<a href='#mdlWhyTravSavers' data-bs-toggle='modal'>Why Book With TravSavers?</a>
 </p>
</div>
                    
</div>
 


<? 

include('inc/savers_include.php'); 

?>

            </div>
        </section>
        <!-- /Title and Widget -->
<? 
/*
include ('inc/where_to_stay.php'); 
*/
?>
    </main>

<? include("inc/map_scripts.php"); ?>
<? include("inc/footer.php"); ?>