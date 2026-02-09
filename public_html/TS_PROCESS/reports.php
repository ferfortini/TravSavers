<?php

include('rnt_mgmt_db_connect.php');

include('menu.php');


$pendingsales = mysqli_query($con, "SELECT * FROM Sales WHERE Status = 'PENDING'");
$pendingtours = mysqli_query($con, "SELECT * FROM Tours WHERE TourStatus = 'VERIFIED - PENDING'");
$completedtours = mysqli_query($con, "SELECT * FROM Tours WHERE TourStatus = 'COMPLETED'");
$canceltours = mysqli_query($con, "SELECT * FROM Tours WHERE TourStatus = 'CANCELLED'");



if (mysqli_error($con))
 {
  echo("Error description: " . mysqli_error($con));
  }
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="example.css"/>
<meta http-equiv="refresh" content="1800" />	
</head>
<body>


<?

$ps=mysqli_num_rows($pendingsales);
$pt=mysqli_num_rows($pendingtours);
$co=mysqli_num_rows($completedtours);
$ct=mysqli_num_rows($canceltours);

echo "<b>Project Lifetime Stats:</b><br><br>";
echo "Current Pending/Unverified Bookings: ".$ps."<br><br>";
echo "Current Pending Tours: ".$pt."<br><br>";
echo "Completed Tours: ".$co."<br><br>";
echo "Cancelled Tours: ".$ct."<br><br>";

echo "<b>Weekly Stats:</b><br><br>";

for ($x = 1; $x <= 53; $x++) {
 
$twtours = mysqli_query($con, "SELECT * FROM Tours WHERE WEEK(VerificationDateTime) = '$x'");
$twcancels = mysqli_query($con, "SELECT * FROM Tours WHERE WEEK(VerificationDateTime) = '$x' AND TourStatus = 'CANCELLED'");
$twpending = mysqli_query($con, "SELECT * FROM Sales WHERE WEEK(SaleDateTime) = '$x' AND Status = 'PENDING'");


$twtourscount = mysqli_num_rows ($twtours);
$twcancelscount = mysqli_num_rows ($twcancels);
$twpendingcount = mysqli_num_rows ($twpending);



if ($twtourscount != '0') {
echo "Week #".$x." Tours Verified: ".$twtourscount."<br> (minus ".$twcancelscount." cancels)<br>";
}

if ($twtourscount != '0') {
echo "Pending Bookings: ".$twpendingcount."<br><br>";
}



}




?>


</body>
