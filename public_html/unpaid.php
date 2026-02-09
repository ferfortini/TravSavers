<?

require_once './vendor/mandrill/mandrill/src/Mandrill.php';
$apikey = "md-LYVN365SxOwYgFOD6HkSYg";
$mandrill = new Mandrill($apikey);

// notify me

$me = "chris@travnow.com";
$op = "mitchlokken@travnow.com";

$message2 = new stdClass();
$message2->html = "NEW UNPAID LEAD";
$message2->subject = "NEW TravSavers UNPAID";
$message2->from_email = "support@travsavers.com";
$message2->from_name  = "TravSavers Leads";
$message2->to = array(array("email" => $me), array("email" => $op));
$message2->track_opens = true;

$response2 = $mandrill->messages->send($message2);

?>