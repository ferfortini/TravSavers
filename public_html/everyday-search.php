<? include('inc/db_connect.php'); 

if (isset($_GET['propid']) ) { } else {
header("Location: https://travsavers.com/");
}


$propid = $_GET['propid'];
$loc = $_GET['loc'];

$suquery = mysqli_query($con,"SELECT searchurl FROM locations WHERE id = '$loc' ") or die ('Unable to execute query. '. mysqli_error($con));
$rowsu = mysqli_fetch_array($suquery);
$su = $rowsu['searchurl'];


$pagetitle = "Search Our Everyday Low Prices On Hotels & Resorts - TravSavers"; 
$desc = "";
$keywords = "";

?>

<? include ("inc/header.php"); ?>

    <!-- /Header -->
    <main>
        <!-- Hero images -->
       <section id="title" class="border-top pt-0 mb-8" style="background-image:url('/assets/img/vegas_back.jpg'); background-repeat: no-repeat; background-position: center top;">
            <div class="container">
                <!-- Caption-->
                <div class="row g-0 align-items-center">
                    <div class="col-36 col-xl-12" style="width:75%">
                        <!-- Content -->
                        <div class="mb-4 pt-0 pt-xl-0 pb-xl-0">
                            <h2 class="display-6 fw-bold lh-sm" style="color:#dddddd;"> Save Big With TravSavers!</h2>
                            <p class="fs-5 mb-0" style="color:#dddddd;"> Discover unbelievably low rates on hotel and entertainment packages in exciting tourist destinations!<br><a href='#mdlWhyTravSavers' data-bs-toggle='modal'>Why Book With TravSavers?</a>
<br><br>
Use the search feature below to access our "Everyday Prices", which are competitive with other internet booking sites, and do not require a promotional presenation.  If you're interested in saving an extra $200-$500 or more on top of these already low prices, please search our promotional rates <a href="<? echo $su; ?>">here</a>.</p>
                           
                        </div>
                        <!-- /Content -->
                    </div>
                    <div class="col-6 col-xl-12"  style="width:25%">


                    </div>
                </div>
                <!-- /Caption-->


 


            </div>
        </section>
        <!-- /Hero images -->

<section id="search" style="background-color: #eff2f4;">
<? include ('inc/ts_widget_hotel.php'); ?>
</section>
       
    </main>
  
<? include('inc/footer.php'); ?>