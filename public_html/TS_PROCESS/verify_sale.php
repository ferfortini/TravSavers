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

<b>Verify Sale #<? echo $saleID; ?></b><br><br>

<form action='verify_process.php' method="POST">

<input type="hidden" name="postsaleID" value="<? echo $saleID; ?>">
<br><br>

<input type="submit" name="submit" value="Verify Sale!">

</form>




<script type="text/javascript" src="js/sortable.js"></script>