<?php

$tablewidth = "10";
$tickwidth = "2";

 include('../inc/db_connect.php');

include('menu.php');

$saleID = $_GET['getsaleID'];

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

<b>Cancel Sale #<? echo $saleID; ?></b><br><br>

<form action='cancel_process.php' method="POST">

<label>Reason For Cancellation: </label>
<select name="reason">
<option value="">Reason For Cancel</option>
<option value="NI">Not Interested</option>
<option value="Tour">Issue With Tour</option>
<option value="NQ">Not Qualified</option>
<option ="ND">No Dates Available</option>
<option "Unreachable">Unable To Verify</option>
<option "Price">Found Better Price</option>
</select>

<input type="hidden" name="postsaleID" value="<? echo $saleID; ?>">
<br><br>

<input type="submit" name="submit" value="Cancel Sale!">

</form>




<script type="text/javascript" src="js/sortable.js"></script>