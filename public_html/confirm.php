<?
require_once './vendor/mandrill/mandrill/src/Mandrill.php';
$apikey3 = "md-LYVN365SxOwYgFOD6HkSYg";
$mandrill3 = new Mandrill($apikey3);

// notify customer


$custy = $_SESSION['Email'];

$message3 = new stdClass();
$message3->html = "Thank you for your reservation request with <b>TravSavers.com</b>!  We're happy to be able to help you save money on your Vegas vacation!
<br><br>
<b>Your reservation is not finalized.</b>  One of our representatives will contact you within the next 24 hours (48 hours on weekends) to confirm your reservation and acceptance and understanding of the terms and eligibility requirements of this promotional offer.  After your reservation is confirmed, you will receive a confirmation number and email detailing the specifics of your reservation.
<br><br>
If you would like to proactively confirm your reservation or ask questions about your reservation, please contact us by phone at <b>(866) 540-8956</b> or email <a href='mailto:support@travsavers.com'>support@travsavers.com</a>. <b>DO NOT TRAVEL</b> until you have received confirmation from one of our representatives.
<br><br>
We look forward to speaking with you to confiirm your reservation and hope you enjoy your trip to Las Vegas!
<br>
Best,<br>
TravSavers Customer Support<br>
support@travsavers.com";

$message3->subject = "TravSavers Reservation Request Confirmation";
$message3->from_email = "support@travsavers.com";
$message3->from_name  = "TravSavers Confirmations";
$message3->to = array(array("email" => $custy));
$message3->track_opens = true;

$response3 = $mandrill3->messages->send($message3);

?>