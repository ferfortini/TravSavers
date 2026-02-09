<? 
include('inc/db_connect.php');

$loc = $_GET['loc'];



if ($loc == '1') { $deals = '1'; } else {}

$llquery = mysqli_query($con, "SELECT * FROM locations WHERE id = '$loc' ");
$rowloc = mysqli_fetch_array($llquery);
$gifts = $rowloc['gifts'];
$logo = $rowloc['logo'];
$locq = $rowloc['hoteltable'];
$locname = $rowloc['city'];

$pagetitle = $locname." Hotel Map";
$desc = $locname." Hotels & Resorts - Map Of Your Search Results";
$keywords =  $locname." hotel maps";


if (isset($_SESSION['sessioncheck']) ) { } else {
header("Location: https://travsavers.com/");
}
$sc = $_SESSION['sessioncheck'] ;

include ('inc/header.php'); 

/* get properties with session, here is lat lon query */
$mapquery = mysqli_query($con,"SELECT * FROM vegas_api_temp WHERE sessionid = '$sc' AND rating >= 3 AND propid != '359994' AND propid != '478558' AND propid != '369785' AND propid != '474470' AND refundable = '1' ORDER BY promoprice ASC, bigsave DESC, rating DESC ") or die ('Unable to execute query. '. mysqli_error($con));


?>
<main>
        <!-- Title and Widget -->
        <section id="title" class="border-top pt-0 mb-8">
            <div class="container">
          
<div class="row g-0 align-items-center">
                        <!-- Content -->
                        <div class="mb-4 pt-2 pt-xl-0 pb-xl-0">

<br>
<a href="property-search.php?loc=<? echo $loc;?>" class="btn btn-sm btn-primary me-3" style="margin-bottom:10px;"><<< Return to Search</a>

                             <h1 class="display-7 fw-bold mb-3" style="color:#333333;">PAGE TITLE</h1>

    <gmp-map     id="marker-click-event-example" center="36.171390533447266,-115.14041900634766" zoom="12" map-id="DEMO_MAP_ID">
      

 

<? while ( $rowmap = mysqli_fetch_array($mapquery)) {

$mapname = $rowmap['name'];
$mapid = $rowmap['propid'];
$mappromoprice = $rowmap['promoprice'];
$maplat = $rowmap['latitude'];
$maplon = $rowmap['longitude'];
$maprating = $rowmap['rating'];

echo "<gmp-advanced-marker position='".$maplat.",".$maplon."' title='".$mapname."'>
    
</gmp-advanced-marker>";

}
?>

   </gmp-map>
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
<? include("inc/footer.php"); ?>