<?php

$tablewidth = "10";
$tickwidth = "2";

 include('../inc/db_connect.php');

include('menu.php');

$saleID = $_GET['sale'];

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

<b>Confirm Price & Fees - Sale #<? echo $saleID; ?></b><br><br>

<form action='confirm_process.php' method="POST">

<label>PLEASE Confirm Property, Dates, Refundable Policy, Room Choice, # of Adults/Children, and Children's Ages in our internal booknig system.
<br><br>
CHECK that OUR PRICE is not more than $200 more than the guest's FINAL PRICE.  Please also note RESORT FEES and that they match.</label>
<br><br>
Result Of Check:<br>
<select name="confirmstatus" required>
<option value="">Choose Result...</option>
<option value="Price & Fees OK">Price & Fees OK</option>
<option value="Price OK & Fees Too High">Price OK & Fees Too High</option>
<option value="Price Too High & Fees OK">Price Too High & Fees OK</option>
<option value="Price Too High & Fees Too High">Price Too High & Fees Too High</option>
</select>
<br><br>
Confirmed Internal Price: (Total)<br>
<input type="text" name="confirmourprice" value="">
<br><br>
Confirmed Resort Fee: (Total)<br>
<input type="text" name="confirmresortfee" value="">
<br>

<input type="hidden" name="postsaleID" value="<? echo $saleID; ?>">
<br><br>

<input type="submit" name="submit" value="Confirm Pricing and Resort Fee Check Complete">

</form>





<script type="text/javascript" src="js/sortable.js"></script>