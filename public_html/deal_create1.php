<?

 $input_ci= date('Y-m-d', strtotime('+45 days'));
 $input_co= date('Y-m-d', strtotime('+49 days'));
$nights = '4';

echo $input_ci;
echo $input_co;

$CheckInP=date("Y-m-d H:i:s",strtotime($input_ci));
echo $CheckInP;
$CheckInT = $CheckInP."Z";
$CheckIn = str_replace(" 00:","T00:",$CheckInT);
$CheckIn = str_replace("00Z","01Z",$CheckIn);
$CheckOutP=date("Y-m-d H:i:s",strtotime($input_co));
$CheckOutT = $CheckOutP."Z";
$CheckOut = str_replace(" 00:","T00:",$CheckOutT);
$CheckOut = str_replace("00Z","01Z",$CheckOut);

$curlprop = curl_init();

curl_setopt_array($curlprop, array(
    CURLOPT_URL => "https://b2b.travcoding.com/properties/availability/search",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"Residency\":\"US\",\"Stay\":{\"CheckIn\":\"$CheckIn\",\"CheckOut\":\"$CheckOut\"},\"Occupancies\":[{\"adults\":2,\"KidAges\":[],\"Total\":2}],\"Place\":{\"Id\":2587061}}",
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
$delete = mysqli_query($con, "DELETE FROM vegas_deals WHERE dealnum='1' ") or die ('Unable to execute query. '. mysqli_error($con));

foreach ($propresponse->items as $item) {
$propid = $item-> property -> code;
$propname = $item-> property -> name;
$propname2 = mysqli_real_escape_string($con,$propname);
$propstars = $item-> property -> rating;
$reviews = $item-> property -> reviews;
$thumb = $item-> property -> thumb;
$publicprice = $item-> publicPrices[0] -> price;
$price = $item-> price;
$pricediff = $publicprice - $price;
$promoprice = $price - 200;
if ($promoprice < 99 ) { $promoprice = '99'; }
$bigsave = $publicprice - $promoprice;
$refundable = $item-> room[0] -> refundable;


$feat = mysqli_query($con, "INSERT INTO vegas_deals (id, propid, name, rating, thumb, publicprice, price, promoprice, pricediff, bigsave, checkin, checkout, timestamp, refundable,dealnum,nights) VALUES ('NULL', '$propid', '$propname2','$propstars','$thumb','$publicprice','$price','$promoprice','$pricediff','$bigsave','$CheckIn','$CheckOut', NOW(), '$refundable','1','$nights')") or die ('Unable to execute query. '. mysqli_error($con));


}

?>