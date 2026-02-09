<?

$input_ci=$_POST['CheckIn'];
$CheckInP=date("Y-m-d H:i:s",strtotime($input_ci));
$CheckInT = $CheckInP."Z";
$CheckIn = str_replace(" 00:","T00:",$CheckInT);
$CheckIn = str_replace("00Z","01Z",$CheckIn);
$input_co=$_POST['CheckOut'];
$CheckOutP=date("Y-m-d H:i:s",strtotime($input_co));
$CheckOutT = $CheckOutP."Z";
$CheckOut = str_replace(" 00:","T00:",$CheckOutT);
$CheckOut = str_replace("00Z","01Z",$CheckOut);
$Adults = $_POST['Adults'];
$Children = $_POST['Children'];

if ( !empty( $_POST['age1'] ) ) {  $children_age_string = $_POST['age1']; } else {}
if (!empty($_POST['age2'] ) ) {  $children_age_string = $_POST['age1'].','.$_POST['age2'] ; } else {}
if ( !empty($_POST['age3'] ) ) {  $children_age_string = $_POST['age1'].','.$_POST['age2'].','.$_POST['age3'] ; } else {}
if (!empty($_POST['age4'] ) ) {  $children_age_string = $_POST['age1'].','.$_POST['age2'].','.$_POST['age3'].','.$_POST['age4'] ; } else {}

if (!isset($children_age_string)){ $children_age_string = ''; } else {}

$total = $Adults + $Children;

$_SESSION['CheckIn'] = $CheckIn;
$_SESSION['CheckOut'] = $CheckOut;
$_SESSION['Adults'] = $_POST['Adults'];
$_SESSION['Children'] = $_POST['Children'];
$_SESSION['ChildrenAges'] = $children_age_string;



$curlprop = curl_init();

curl_setopt_array($curlprop, array(
    CURLOPT_URL => "https://b2b.travcoding.com/properties/availability/search",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"Residency\":\"US\",\"Stay\":{\"CheckIn\":\"$CheckIn\",\"CheckOut\":\"$CheckOut\"},\"Occupancies\":[{\"adults\":$Adults,\"KidAges\":[$children_age_string],\"Total\":$total}],\"Place\":{\"Id\":$placeid}}",
   CURLOPT_HTTPHEADER => array(
    'content-type: application/json',
'authorization: Bearer ' . $token,
'x-api-key: ' .$xapi

  ),
));

$propresponse = json_decode(curl_exec($curlprop));

curl_close($curlprop);

/*
echo "<pre>";
print_r($propresponse);
echo "</pre>";
*/


$delete = mysqli_query($con, "DELETE FROM vegas_api_temp WHERE sessionid = '$sid' ") or die ('Unable to execute query. '. mysqli_error($con));

foreach ($propresponse->items as $item) {
$propid = $item-> property -> code;
$latitude = $item-> property -> location -> latitude;
$longitude = $item-> property -> location -> longitude;
$propname = $item-> property -> name;
$propname2 = mysqli_real_escape_string($con,$propname);
$propstars = $item-> property -> rating;
$reviews = $item-> property -> reviews;
$thumb = $item-> property -> thumb;
$description = addslashes($item-> room[0] -> description);
$publicprice = $item-> publicPrices[0] -> price;
$price = $item-> price;
$pricediff = $publicprice - $price;
$promoprice = $price - 200;
if ($promoprice < 99 ) { $promoprice = '99'; }
$bigsave = $publicprice - $promoprice;
$refundable = $item-> room[0] -> refundable;
if (isset($item-> room[0] -> taxes[1] -> type)) { $resortfeetype = $item-> room[0] -> taxes[1] -> type; } else { $resortfeetype= 'none'; }
if (isset($item-> room[0] -> taxes[1] -> amount)) { $resortfeeamount = $item-> room[0] -> taxes[1] -> amount; } else { $resortfeeamount = 'none'; }

if(isset($item-> room[0] -> cancellationPolicies[1] -> from)) { $refundablebefore = $item-> room[0] -> cancellationPolicies[1] -> from; } else { $refundablebefore = '';}
if(isset($item-> room[0] -> cancellationPolicies[1] -> amount)) { $cancelcost = $item-> room[0] -> cancellationPolicies[1] -> amount;} else { $cancelcost = '';}

$rbdate0 = strtotime($refundablebefore);
$rbdate1 = date('F j, Y', $rbdate0);

if($pricediff > 0) {
$feat = mysqli_query($con, "INSERT INTO vegas_api_temp (id, sessionid, propid, name, rating, reviews, thumb, publicprice, price, promoprice, pricediff, bigsave, description, adults, children_string, checkin, checkout, timestamp, latitude, longitude, refundable, refundablebefore, cancelcost, resortfeetype, resortfeeamount) VALUES ('NULL', '$sid','$propid', '$propname2','$propstars','$reviews','$thumb','$publicprice','$price','$promoprice','$pricediff','$bigsave','$description','$Adults','$children_age_string','$CheckIn','$CheckOut', NOW(), '$latitude','$longitude','$refundable','$rbdate1','$cancelcost','$resortfeetype','$resortfeeamount')") or die ('Unable to execute query. '. mysqli_error($con));
} else {}

}



?>