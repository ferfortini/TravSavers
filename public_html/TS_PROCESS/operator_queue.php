<?php

$tablewidth = "10";
$tickwidth = "2";

include('../inc/db_connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('menu.php');

$resultleads = mysqli_query($con, "SELECT * FROM Sales WHERE Status = 'UNPAID' OR Status = 'PAID' OR Status = 'REACTIVATED' OR Status = 'UNVERIFIED' ORDER BY DispositionDateTime ASC, TimesDispositioned ASC");

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
<th>Status</th>
<th>Lead Date</th>
<th>Name</th>
<th>Details</th>
<th>Pricing / Cost</th>
<th>Phone1</th>
 <th># Attempts</th>
<th>Last Attempt</th>
<th>Comments</th>
<th>Disposition</th>
<th>Calling Notes</th>
<th>Price/Fees Confirmed</th>
<th>Set Call Back</th>
<th>Verify / Create Tour</th>
<th>Cancel Sale</th>

</tr>

<?

if(isset($_GET['msg'])){ echo "<b>".$_GET['msg']."</b><br><br>"; } else {}
echo "<b>".mysqli_num_rows($resultleads)." Pending Sales</b>";


while ($rowleads = mysqli_fetch_array( $resultleads ))

{ 

echo "<tr>";
if (isset($rowleads['CallBackDateTime'])) { 

echo "<td width='".$tablewidth."%'><b>".$rowleads['Status']." - Requested Call Back</b> @ ".$rowleads['CallBackDateTime']."</td>";

} else { echo "<td width='".$tablewidth."%'><b>".$rowleads['Status']."</b></td>"; }

echo "<td width='".$tablewidth."%'>".$rowleads['SaleDateTime']."</td>";
echo "<td width='".$tablewidth."%'>".$rowleads['FirstName']." ".$rowleads['LastName']."<br>".$rowleads['Address']."<br>".$rowleads['City'].", ".$rowleads['State'].", ".$rowleads['ZIP']."<br><b>".$rowleads['Email']."</b></td>";
echo "<td width='".$tablewidth."%'><b>Location #".$rowleads['LocName']."</b><br>".$rowleads['ArrivalDate']."-".$rowleads['CheckOut'].", ".$rowleads['PackageNights']." Nights<br>".$rowleads['RequestedProperty']."<br>".$rowleads['RoomChoice']."</td>";
echo "<td width='".$tablewidth."%'> <b>Public Price:</b> $".$rowleads['publicprice']."</b><br><b>Our Cost:</b> $".$rowleads['price']."</b><br><b>Preview Price</b>: $".$rowleads['pricechoice']."</b><br><br><b>Resort Fee:</b> ".$rowleads['resortfee']."<br><b>Refundable Before:</b> ".$rowleads['refundablebefore']."</td>";
echo "<td width='".$tablewidth."%'><b style='font-size:120%'>".$rowleads['Phone']."</b></td>";
echo "<td width='".$tickwidth."%'><b style='font-size:140%'>".$rowleads['TimesDispositioned']."</b></td>";
echo "<td width='".$tablewidth."%'><b>".$rowleads['LeadDisposition']."</b> - ".$rowleads['DispositionDateTime']."</td>";
echo "<td width='".$tablewidth."%' style='font-size:70%'>Adults/Kids: ".$rowleads['Adults']."/".$rowleads['Children']."</td>";
echo "<td width='".$tablewidth."%'><form action='disposition_process.php' method='GET'><input type='hidden' name='SaleID' value='".$rowleads['SaleID']."' /><select name='disp'><option value=''></option><option value='NA'>Not Available</option><option value='BAD'>Bad Phone</option></select><input name='submit' type='submit' value='Go!' /></form></td>";
echo "<td width='".$tablewidth."%'>".$rowleads['CallBackNotes']."</td>";
echo "<td width='".$tablewidth."%'>";
echo "<a href='confirm_fees.php?sale=".$rowleads['SaleID']."'><img src='images/star.png'><br>Confirm Fees/Pricing</a>";

echo "<br>".$rowleads['PriceConfirmedStatus']." - ".$rowleads['PriceConfirmedDateTime'].", #".$rowleads['PriceConfirmedOperator']."<br>OP: ".$rowleads['PriceConfirmedOurPrice'].", RF: ".$rowleads['PriceConfirmedResortFee'];

echo "</td>";
echo "<td width='".$tablewidth."%'><a href='create_callback_ob.php?sale=".$rowleads['SaleID']."'><img src='images/clock.png'><br>Set Call Back</a></td>";
echo "<td width='".$tablewidth."%'><a href='verify_sale.php?getsaleID=".$rowleads['SaleID']."'><img src='images/star.png'><br>Verify Sale</a></td>";
echo "<td width='".$tablewidth."%'><a href='cancel_sale.php?getsaleID=".$rowleads['SaleID']."'><img src='images/star.png'><br>Cancel</a></td>";
echo "</tr>";

}

?>

</table>


<script type="text/javascript" src="js/sortable.js"></script>