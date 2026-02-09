<?php

$tablewidth = "10";
$tickwidth = "2";

 include('../inc/db_connect.php');

include('menu.php');

$resulttours = mysqli_query($con, "SELECT * FROM Sales WHERE Status = 'VERIFIED' ORDER BY SaleDateTime ASC");
if (mysqli_error($con))
 {
  echo("Error description: " . mysqli_error($con));
  }
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="example.css"/>
<meta http-equiv="refresh" content="1800" />	

<style type="text/css">

td {
text-align:center;
font-family:arial;
font-size:12px;
border:1px solid #000;

}

th {
font-family:arial;
font-size:12px;
border:1px solid #000;

}

</style>
</head>
<body>

<table class="sortable" id="sort1">
<tr>
<th>Tour #</th>
<th>Status</th>
<th>Verification Date</th>
<th>Name</th>
<th>Check-In</th>
<th>Merchant Notes</th>
<th>Phone 1 & 2</th>
 <th>Transaction Code</th>
<th>Edit Tour</th>
<th>Change Tour Status</th>

</tr>

<?

if(isset($_GET['msg'])){ echo "<b>".$_GET['msg']."</b><br><br>"; } else {}
echo "<b>".mysqli_num_rows($resulttours)." Pending Tours</b>";


while ($rowtours = mysqli_fetch_array( $resulttours ))

{ 

echo "<tr>";
echo "<td width='".$tablewidth."%'><a href='display_tour.php?tour=".$rowtours['TourID']."'>".$rowtours['TourID']."</a></td>";
echo "<td width='".$tablewidth."%'>".$rowtours['TourStatus']."</td>";
echo "<td width='".$tablewidth."%'>".$rowtours['VerificationDateTime']."</td>";
echo "<td width='".$tablewidth."%'>".$rowtours['Guest1FirstName']." ".$rowtours['Guest1LastName']." +<br> ".$rowtours['Guest2FirstName']." ".$rowtours['Guest2LastName']."<br></td>";
echo "<td width='".$tablewidth."%'>".$rowtours['HotelCheckIn']."<br></td>";
echo "<td width='".$tablewidth."%'>".$rowtours['MerchantNotes']."<br></td>";
echo "<td width='".$tablewidth."%'><b style='font-size:120%'>".$rowtours['GuestPhone1']."</b><br><b style='font-size:120%'>".$rowtours['GuestPhone2']."</b></td>";
echo "<td width='".$tickwidth."%'><b style='font-size:140%'>".$rowtours['MerchantTransactionID']."</b></td>";
echo "<td width='".$tablewidth."%'><a href='display_tour.php?tour=".$rowtours['TourID']."'><img src='images/star.png'><br>Display / Edit Tour</a></td>";
echo "<td width='".$tablewidth."%'><a href='change_tour_status.php?tour=".$rowtours['TourID']."&field=TourStatus'><img src='images/star.png'><br>Change Tour Status</a></td>";
echo "</tr>";

}

?>

</table>


<script type="text/javascript" src="js/sortable.js"></script>