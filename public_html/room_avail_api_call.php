<?

// ROOM AVAILABILITY

$curlavail = curl_init();

curl_setopt_array($curlavail, array(
  CURLOPT_URL => "https://qa.api.travcoding.com/properties/availability/search",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"Residency\": \"US\", \"Stay\": {\"CheckIn\": \"$CheckIn\",\"CheckOut\": \"$CheckOut\"},\"Properties\": [\"$pro\"],\"Occupancies\": [{\"adults\": 2,\"KidAges\": [],\"Total\": 2}],\"RoomCount\": 1}",


 CURLOPT_HTTPHEADER => array(
      'Content-Type:application/json',
'authorization: Bearer ' . $token
  ),
));

$availresponse = json_decode(curl_exec($curlavail));

curl_close($curlavail);


$roomdesc = $availresponse -> items [0] -> room[0] -> description;
$prop = $availresponse -> items[0] -> property -> name;
$retailprice = $availresponse -> items[0] -> publicPrices[0] -> price;
$price = $availresponse -> items[0] -> price;


?>