<? 
include('../inc/db_connect.php');


$pagetitle = "TravSavers Vegas";
$desc =  "TravSavers Vegas";
$keywords =  "TravSavers Vegas";

include ('../inc/header.php'); 

$vegquery = mysqli_query($con, "SELECT * FROM new_vegas_hotels LIMIT 20 " );




?>
<main>
     <section id="title" class="border-top pt-2">
            <div class="container">
                <div class="d-block d-lg-flex align-items-center">
                    <div class="me-lg-auto mb-2 mb-lg-2">
                        <!-- Title -->
                        <h1 class="display-8 fw-bold mb-4 text-body-emphasis">Las Vegas Vacation Packages</h1>
                        <!-- /Title -->
                    </div>
                   
                </div>
            </div>
        </section>
        <!-- /Page title -->
        <!-- Tour list -->
        <section id="tours">
            <div class="container">
                <div class="row">
                    <div class="col-24">
                        <!-- Filter -->
                        <div class="d-block d-xl-flex align-items-center">
                            <!-- Info -->
                            <div class="mb-8 me-xl-auto">
Win big when you book your <b>Las Vegas vacation</b> with TravSavers! Take advantage of our everyday low rates, or book a promo package and <u>save an additional $200</u> on your choice of hotel in Las Vegas. Promo packages also include a <b>FREE $50 VISA gift card</b>!
<hr>

Your Dates: 11/14 - 11/17/23, 3 Nights - 2 Adults, 1 Child<br>
<a href="#"><<< Search Again</a><br><br>



<h2 class="h6 fw-normal mb-2">Choose From <b>152 Featured Properties</b> in Las Vegas</h2>
<div class="tour-filter b-block d-md-flex align-items-center">
                                    <div class="d-block d-md-flex align-items-center me-3 mb-3 flex-fill">
                                        <span class="me-2 d-none d-sm-inline text-nowrap">Sort by:</span>
                                        <select class="form-select dropdown shadow-sm dselect w-100" id="ddSort">
                                          <option value="0">Featured/Most Popular (Current)</option>
											<option value="1">Highest $ Savings</option>
                                            <option value="1">Price - Low to High</option>
                                            <option value="2">Price - High to low</option>
                                            <option value="3">Rating - High to Low</option>
                              
                                        </select>

                                    </div>
                                    
                                </div>
<!--
                                <ul class="list-inline d-inline-block fsm-4 mb-0">
                                    <li class="list-inline-item">
                                        <a href="./tour-grid.html" class="text-secondary">
                                            <i class="ti ti-x text-danger"></i><span>Paris</span>
                                        </a>, <a href="./tour-grid.html" class="text-secondary">
                                            <i class="ti ti-x text-danger"></i><span>Marseille</span>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <span class="text-secondary">|</span>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="./tour-grid.html" class="text-secondary">
                                            <i class="ti ti-x text-danger"></i><span>Cultural &amp; Foods</span>
                                        </a>, <a href="./tour-grid.html" class="text-secondary">
                                            <i class="ti ti-x text-danger"></i><span>Explorer & Adventure</span>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <span class="text-secondary">|</span>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="./tour-grid.html" class="text-secondary">
                                            <i class="ti ti-x text-danger"></i><span>1 - 3 days</span>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <span class="text-secondary">|</span>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="./tour-grid.html" class="text-secondary">
                                            <i class="ti ti-x text-danger"></i><span>200 - $1000</span>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <span class="text-secondary">|</span>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="./tour-grid.html" class="text-secondary">
                                            <i class="ti ti-x text-danger"></i><span>English</span>
                                        </a>
                                    </li>
                                </ul>
-->
                            </div>
                            <!-- /Info -->
                          
                        </div>
                        <!-- /Filter -->
                    </div>
                    <div class="col-24">
                        <!-- Tour list -->
                        <div class="row">


<? while ($rowveg = mysqli_fetch_array($vegquery)) { 

$pro = $rowveg['propid'];
$stars = $rowveg['stars'];
$picquery = mysqli_query($con, "SELECT url FROM prop_photos WHERE propid = '$pro'");
$rowpic = mysqli_fetch_array($picquery);
/*
$u = 0;
while ($rowpic = mysqli_fetch_array($picquery)) {
// add pics to array hotel1
}
*/

$url = $rowpic['url'];

include ('api_call.php');

$rretail = round($retailprice, 2);
$rpublic = round($price, 2);
$rpromo = $rpublic - 200;
$bigsave = $rretail - $rpromo;

?>

                            <div class="col-24 col-xl-17">
                                <!-- HOTEL ITEM -->
                                <div class="border-bottom pb-4 mb-8">
                                    <div class="row">
                                        <div class="col-24 col-xxl-8 col-xl-9 col-lg-8 col-md-12">
                                            <!-- Image -->
                                            <div class="mb-0">
                                                <div class="img-info img-info-bottom">
                                                    <a href="./single-tour.html" class="d-block mb-0">
                                                        <figure class="img-info-thumbnail image-hover-scale image-hover-overlay rounded">
                                                            <img src="<? echo $url; ?>" class="img-fluid" alt="">
                                                        </figure>
                                                    </a>
                                                   <a href='#mdlGallery1' data-bs-toggle='modal'>
 <span class="like-icon liked-icon position-absolute top-0 end-0 me-5 mt-5 shadow-sm"><i class="ti ti-photo-plus"></i></span>
</a>
  <a href='#mdlHotel1' data-bs-toggle='modal'>
 <span class="like-icon liked-icon position-absolute top-0 end-0 me-5 mt-13 shadow-sm"><i class="ti ti-info-square-rounded"></i></span>
</a>
                                                    <div class="img-info-body mb-5 start-0 ms-6 shadow d-inline-flex align-items-center fsm-6 fw-semibold" style="position:relative;top:-30px;" >
                                                       <h5 class="fs-8 mb-0 text-body-emphasis">
            <span><? echo $rowveg['name']; ?></span><br>
 <span class="star-rate-view star-rate-size-sm">



</span>

        </h5>

<p class="fsm-4 text-secondary mb-0" style="margin-left:5px;">
Retail Price: <s>$<? echo $rretail; ?></s><br>
<span class="text-danger">Promo Rate $<? echo $rpromo; ?> (<u>Save $<? echo $bigsave; ?></u>)</span>
</p>
                                                            
                                                    </div>

                                                </div>

                                            </div>

  <div class="text-secondary mb-2 fsm-5" style="color:#222;margin-top:-20px;">
                                                   
												Choose Today's TravSavers Promo Rate & Save An Additional <b>$200 Off</b> Our Already Great Rates! Promo Package Also Includes a <b>FREE $50 VISA Gift Card</b>
                                                    </div>
                                            <!-- /Image -->
                                        </div>
                                        <div class="col-24 col-xxl-16 col-xl-15 col-lg-16 col-md-12">
                                            <!-- Content -->
                                            <div class="mb-6">
                                                <div class="mb-6">
                                                   
                                                    <div class="d-flex align-items-center fsm-2 text-secondary mb-0">
                                                        <div class="lh-1 me-1">
                                                           
                                                        </div>
                                                     
  
                                                    </div>
                                                    <div class="fw-semibold mb-1">
                                                        <span style="font-size:75%">Internet Retail Price (PriceLine):</span>
                                                        <strong class="fs-8"><sup>$</sup><? echo $rretail; ?></strong>
                                                    </div>
<div class="fw-semibold mb-1">
                                                        <span style="font-size:75%">Our Everyday Low Price:</span>
                                                        <strong class="fs-8"><sup>$</sup><? echo $rpublic; ?></strong>
                                                    </div>
<div class="fw-semibold mb-1">
                                                        <span>Today's Promo Rate (<u>Save $<? echo $bigsave; ?></u>):</span>
                                                        <strong class="fs-5 text-danger"><sup>$</sup><? echo $rpromo; ?></strong>
                                                    </div>
<div>
<b><input type="radio" checked></b> &nbsp;<? echo $roomdesc; ?><br>
         </div>                                         
                                                </div>
                                                <div>
                                                    <!-- Detail & Booking -->
                                                     <a href='#mdlReserve1' data-bs-toggle='modal' class="btn btn-sm btn-primary me-3">
                                                        <i class="ti ti-calendar-event"></i>
                                                        <span>Book Promo Rate - $<? echo $rpromo; ?></span>
                                                    </a><br><br>
                                                    <a href="./single-tour.html" class="btn btn-sm btn-outline-primary">
   <i class="ti ti-calendar-event"></i>
                                                        <span>Book Without Promo - $<? echo $rpublic; ?></span>
                                                   
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

<? } ?>
                        
                                        <!-- Filter Options -->
                                        
                                    </form>
                                </div>
                                <!-- Filter -->
                            </div>
                        </div>
                        <!-- /Tour list -->
                        <!-- Pagination -->
                        <div class="mb-6 pt-6">
                            <div class="d-inline-flex align-items-center">
                                <a href="./tour-grid.html" class="btn btn-outline-primary disabled">
                                    <i class="ti ti-arrow-narrow-left"></i>
                                </a>
                                <span class="ms-10 me-10">Page <strong>1</strong> of <strong>10</strong></span>
                                <a href="./tour-grid.html" class="btn btn-outline-primary">
                                    <i class="ti ti-arrow-narrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- /Pagination -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /Tour list -->
    </main>

<? include("hotel_info.php"); ?>
<? include("reserve_room.php"); ?>
<? include("photo_gallery.php"); ?>

<? include("inc/footer.php"); ?>