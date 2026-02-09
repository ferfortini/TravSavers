<?

$email = 'travcoding@travcoding.com';
$password = 'Trav123';

$jsonData = array(
  'email'=> $email,
  'password' => $password
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json'
));

curl_setopt($ch, CURLOPT_URL, "https://qa.api.travcoding.com/identity/users/sign-in" );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POST, 1 );
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonData));

$result=json_decode(curl_exec ($ch));

$token = $result-> accessToken;




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
  CURLOPT_POSTFIELDS => "{\"Residency\": \"US\", \"Stay\": {\"CheckIn\": \"2023-12-14T00:00:01Z\",\"CheckOut\": \"2023-12-17T00:00:01Z\"},\"Properties\": [\"310234\"],\"Occupancies\": [{\"adults\": 2,\"KidAges\": [],\"Total\": 2}],\"RoomCount\": 1}",


 CURLOPT_HTTPHEADER => array(
      'Content-Type:application/json',
'authorization: Bearer ' . $token
  ),
));

$availresponse = json_decode(curl_exec($curlavail));
curl_close($curlavail);

$prop = $availresponse -> items[0] -> property -> name;
$rateKey = $availresponse -> items [0] -> room[0] -> rateKey;
$packageId = $availresponse -> items [0] -> packageId;
echo $prop."- RateKey: ".$rateKey." - PID: ".$packageId;





$curlrate = curl_init();

curl_setopt_array($curlrate, array(
  CURLOPT_URL => "https://qa.api.travcoding.com/properties/check/checkrates",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"PackageId\": \"$packageId\",\"RateKey\": [\"$rateKey\"] }",
  CURLOPT_HTTPHEADER => array(
       'Content-Type:application/json',
'authorization: Bearer ' . $token
  ),
));

$responserate = curl_exec($curlrate);
$responsejson = json_decode(curl_exec($curlrate));

echo $responserate;

curl_close($curlrate);

echo $responserate -> items[0] -> property -> name;

$pubprice = $responserate -> items[0] -> publicPrices -> price;
echo "<BR>Price:<BR><BR>".$pubprice;













?>