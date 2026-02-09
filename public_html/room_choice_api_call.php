<?

$apipropid = $_POST['propid'];
$apici = $_POST['APICheckIn'];
$apico = $_POST['APICheckOut'];
$apiadults = $_SESSION['Adults'];
$apichildren = $_SESSION['Children'];
$apiagestring = $_POST['agestring'];
$apitotal = $apiadults + $apichildren;

$curlchoice = curl_init();

curl_setopt_array($curlchoice, array(
  CURLOPT_URL => "https://b2b.travcoding.com/properties/availability/search",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"Residency\": \"US\", \"Stay\": {\"CheckIn\": \"$apici\",\"CheckOut\": \"$apico\"},\"Properties\": [\"$apipropid\"],\"Occupancies\": [{\"adults\": $apiadults,\"KidAges\": [$apiagestring],\"Total\": $apitotal}],\"RoomCount\": 4 }",
  CURLOPT_HTTPHEADER => array(
    'content-type: application/json',
'authorization: Bearer ' . $token,
'x-api-key: ' .$xapi
  ),
));


$choiceresponse = json_decode(curl_exec($curlchoice));
/*
echo "<pre>";
print_r($choiceresponse);
echo "</pre>";
*/
curl_close($curlchoice);


?>