<? 

include('inc/db_connect.php');

$locquery = mysqli_query($con, "SELECT * FROM locations WHERE id = '$loc' ");
$rowloc = mysqli_fetch_array($locquery);


$desc = $rowloc['pagedesc'];
$keywords = $rowloc['pagekeywords'];
$lp2text = $rowloc['lp2text'];
if(isset($lp2text)) { $_SESSION['lp2text'] = $lp2text; } else {}
$city = $rowloc['city'];
$st = $rowloc['st'];

if (isset($LPKW1)) { 


 } else { }
if (isset($LPKW1)) { $uckw = ucwords ($LPKW1); $_SESSION['uckw'] = $uckw; $uckwsing = ucwords ($LPKW1sing); $pagetitle = $city." ".$uckw." - Save Big On ".$uckw." In ".$city.", ".$st; 

} else {$pagetitle = $rowloc['pagetitle'];  $LPKW1sing = "vacation"; $uckw = "Vacation Packages";  $_SESSION['uckw'] = "Vacation Packages"; $uckws = "Vacation Package";}


include ('inc/header.php'); 

?>
<main>
        <!-- Title and Widget -->
        <section id="title" class="border-top pt-0 mb-8" style="background-image:url('/assets/img/<? echo $back; ?>'); background-repeat: no-repeat; background-position: center top;">

           


 <div class="container" >

          
<div class="row g-0 align-items-center">
                        <!-- Content -->
                

        <div class="mb-4 pt-2 pt-xl-0 pb-xl-0">

<div id="search2" class="col-24 col-sm-24 col-md-12 col-xl-12 col-xxl-12" style="float:left;padding-right:20px;">

                             <h1 class="display-7 fw-bold mb-3 mt-2 text-body-emphasis" ><span style="color:#dddddd;"> <? echo $rowloc['city'];?> <? echo $uckw; ?></span></h1>
<h4><span style="color:#bbbbbb;font-size:90%;"> <i class="ti ti-star"></i> 3-5 Star Hotels, As Low As $25/Night!</span></h4>
<p class='fs-6 mb-0 text-secondary' ><span style="color:#dddddd;"> Save <b>$200-$500 or more</b> when you book your <b><? echo $rowloc['city'];?> <? echo $LPKW1sing; ?></b> with TravSavers!  Resort Preview packages also <b>include dining/entertainment!</b>!</span>  
<br>
<a class="btn btn-primary rounded" style="padding:5px; margin:5px;" href='#mdlWhyTravSavers' data-bs-toggle='modal'>How Can We Offer Such Low Prices?</a>
 </p>

</div>
 
<!-- end search 2 -->


<div id="search1" class="col-24 col-sm-24 col-md-12 col-xl-12 col-xxl-12" style="float:left;margin-top:10px;">

 <!-- Find tours -->
<? 
if (isset($_GET['msg'])) { 

if  ($_GET['msg'] == '1' ) { echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Check-Out Date Must Be Later Than Check-In Date</div>"; } 
elseif  ($_GET['msg'] == '2' ) { echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Please Select Number Of Adults</div>"; } 
elseif  ($_GET['msg'] == '3' ) { echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>For Bookings Within 7 Days, Please Call (866) 540-8956 For Assistance</div>"; } 
elseif  ($_GET['msg'] == '4' ) { echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Our Packages Require a Two Night Minimum Stay</div>"; } 
elseif  ($_GET['msg'] == '8' ) { echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Your search didn't return any results, please try again.  For our guests' comfort and convenience, we only display 3 to 5 star properties with flexible cancellation policies.</div>"; } 

else {}



} else {}
?>
<div id="findTour" class="find-tour shadow rounded-3 p-3 bg-body border border-light-subtle mb-8">

<form action="https://travsavers.com/property-search.php?loc=<? echo $loc; ?>" method="post">
<h5><b> <i class="ti ti-search"></i> Search Great Deals In <? echo $rowloc['city']; ?>!</b></h5>
<b style="font-size:80%;">Check-In / Check-Out:</b><br>
 <input   id="datepicker" class="shadow form-control form-control-lg bg-transparent rounded border-1 "  inputmode="none" autocomplete="off" placeholder="Enter Your Dates" name="datepicker" required>
<? 

$lpdate = date('Y-m-d', strtotime("+3 days"));
$lpdatemax = date('Y-m-d', strtotime("+180 days"));
?>

<script>
new Litepicker({
  element: document.getElementById('datepicker'),
  singleMode: false,
format: 'MMM D, YYYY',
minDate: '<? echo $lpdate; ?>',
maxDate: '<? echo $lpdatemax; ?>',

  tooltipText: {
    one: 'night',
    other: 'nights'
  },
  tooltipNumber: (totalDays) => {
    return totalDays - 1;
  }
})
</script>

<select  style="margin-top:10px;" class="form-select shadow-sm" name="Adults" aria-label="# of Adults" required>
        <option value="2" selected>2 Adults</option>
        <option value="1">1 Adult</option>
        <option value="2">2 Adults</option>
        <option value="3">3 Adults</option>
 <option value="4">4 Adults</option>
    </select>

<script type="application/javascript">

function yesnoCheck(that) {
    if (that.value == "1") {
 
        document.getElementById("ageOne").style.display = "block";
    } else {
        document.getElementById("ageOne").style.display = "none";
    }
 if (that.value == "2") {
 
        document.getElementById("ageOne").style.display = "block";
 document.getElementById("ageTwo").style.display = "block";
    } else {
        document.getElementById("ageTwo").style.display = "none";
    }
if (that.value == "3") {
  
        document.getElementById("ageOne").style.display = "block";
 document.getElementById("ageTwo").style.display = "block";
 document.getElementById("ageThree").style.display = "block";
    } else {
        document.getElementById("ageThree").style.display = "none";
    }
if (that.value == "4") {
 
        document.getElementById("ageOne").style.display = "block";
 document.getElementById("ageTwo").style.display = "block";
 document.getElementById("ageThree").style.display = "block";
 document.getElementById("ageFour").style.display = "block";
    } else {
        document.getElementById("ageFour").style.display = "none";
    }


}

</script>

 <select  style="margin-top:10px;" onchange="yesnoCheck(this);" class="form-select shadow-sm" name="Children" aria-label="# of Children">
        <option value="0" selected># of Children</option>
         <option value="0">0 Children</option>
  <option value="1">1 Child</option>
        <option value="2">2 Children</option>
        <option value="3">3 Children</option>
 <option value="4">4 Children</option>
    </select>


<div id="ageOne" style="display: none;">
<b style="font-size:55%;">Child 1 Age:</b><br>
    <select name="age1" class="form-select shadow-sm">
<option value="">-</option>    
    <option value="1">0-12mo</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
</select>
</div>

<div id="ageTwo" style="display: none;">
<b style="font-size:55%;">Child 2 Age:</b><br>
    <select name="age2" class="form-select shadow-sm">
<option value="">-</option>    
<option value="1">0-12mo</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
</select>
</div>

<div id="ageThree" style="display: none;">
<b style="font-size:55%;">Child 3 Age:</b><br>
    <select name="age3" class="form-select shadow-sm">
<option value="">-</option>    
<option value="1">0-12mo</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
</select>
</div>

<div id="ageFour" style="display: none;">
<b style="font-size:55%;">Child 4 Age:</b><br>
    <select name="age4" class="form-select shadow-sm">
 <option value="">-</option>    
<option value="1">0-12mo</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
</select>
</div>




                                <!-- Button -->
                                <div class="check-button" style="margin-top:10px;">
                                    <button id="Search" type="submit" onclick="showDiv()" class="btn btn-lg btn-primary w-100 rounded">
                                        <i class="ti ti-search"></i>
                                        <span>Search! <div id="loadingGif" style="display:none"><img src="/assets/img/spinner.png" style="max-width:50px;"></div></span>

                                    </button>
 

                                </div>

           
                    </form>

</div>     <!-- /Find tours -->

<!--- end search1 -->
</div>
</div>

</div>

<? 

include("inc/savers_include.php"); 

?>

            
        </section>
        <!-- /Title and Widget -->
<? 
/*
include ('inc/where_to_stay.php'); 
*/
?>
    </main>
<? include("inc/footer.php"); ?>