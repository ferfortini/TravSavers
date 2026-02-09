<?php

$tablewidth = "10";
$tickwidth = "2";

 include('../inc/db_connect.php');

include('menu.php');

$resultleads = mysqli_query($con, "SELECT * FROM Sales WHERE Status = 'CANCEL' ORDER BY SaleDateTime ASC");

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
<h2>Cancelled Sales</h2>
<table class="sortable" id="sort1">
<tr>
<th>Status</th>
<th>Authorization Date</th>
<th>Name</th>
<th>Arrival</th>
<th>Package</th>
<th>Phone</th>
<th>Cancel Reason</th>
 <th>Activate Sale</th>

</tr>

<?

if(isset($_GET['msg'])){ echo "<b>".$_GET['msg']."</b><br><br>"; } else {}
echo "<b>".mysqli_num_rows($resultleads)." Cancelled Sales</b>";


while ($rowleads = mysqli_fetch_array( $resultleads ))

{ 

echo "<tr>";
echo "<td width='".$tablewidth."%'><b>Cancelled Sale</b></td>"; 
echo "<td width='".$tablewidth."%'>".$rowleads['SaleDateTime']."</td>";
echo "<td width='".$tablewidth."%'>".$rowleads['FirstName']." ".$rowleads['LastName']."<br></td>";
echo "<td width='".$tablewidth."%'><b>".$rowleads['LocName']."</b><br>".$rowleads['ArrivalDate']."<br>".$rowleads['RequestedProperty']."</td>";
echo "<td width='".$tablewidth."%'>".$rowleads['PackageNights']." Nights + ".$rowleads['PackageGifts']." - ".$rowleads['promoprice']."</td>";
echo "<td width='".$tablewidth."%'><b style='font-size:120%'>".$rowleads['Phone']."</b></td>";
echo "<td width='".$tablewidth."%'>".$rowleads['CancelReason']."</td>";
echo "<td width='".$tablewidth."%'><a href='activate_sale.php?getsaleID=".$rowleads['SaleID']."'><img src='images/star.png'><br>Activate</a></td>";
echo "</tr>";

}





?>

</table>
<br>

<script type="text/javascript" src="js/sortable.js"></script>