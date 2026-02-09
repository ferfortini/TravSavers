<? include('inc/db_connect.php'); ?>

<?
$pagetitle = "TravBenefits - The Best Deals On Hotels, Vacation Rentals, Condo/Timeshare Rentals, & More!"; 
$desc = "Discover unbelievable deals on hotels, vacation rentals, condo/timeshare rentals, and other unique properties with TravBenefits!";
$keywords = "hotels, vacation rentals, vacation condos, timeshare rentals ";

?>

<? include ("inc/header.php"); ?>

    <!-- /Header -->
    <main>
        <!-- Hero images -->
        <section id="hero" class="pt-0">
            <div class="container">
                <!-- Caption-->
                <div class="row g-0 align-items-center">
                    <div class="col-36 col-xl-12" style="width:75%">
                        <!-- Content -->
                        <div class="mb-4 pt-0 pt-xl-0 pb-xl-0">
                            <h2 class="display-6 fw-bold lh-sm"> Save With TravBenefits!</h2>
                            <p class="fs-5 mb-0 text-secondary"> Discover unbelievably low rates on hotels, vacation rentals, condo/timeshare rentals and more!<br><a href='#mdlWhyTravBen' data-bs-toggle='modal'>Why Book With TravBenefits?</a></p>
                           
                        </div>
                        <!-- /Content -->
                    </div>
                    <div class="col-6 col-xl-12"  style="width:25%">
      


                    </div>
                </div>
                <!-- /Caption-->
<? 
include('inc/ts_widget_both.php'); 
?>

 


            </div>
        </section>
        <!-- /Hero images -->
<br><br>
<? include('inc/member_include.php'); ?>


       
    </main>

<? include('inc/footer.php'); ?>