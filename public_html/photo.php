<?
include('inc/db_connect.php');

$photquery = mysqli_query($con, "SELECT * FROM vegas_hotel_photos WHERE PropertyId = '568621' ");

while ($rowphot = mysqli_fetch_array($photquery) ) {

echo $rowphot['Uri']."<br>";

}

?>