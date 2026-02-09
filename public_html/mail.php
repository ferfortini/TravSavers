<?

require_once './vendor/mandrill/mandrill/src/Mandrill.php';
$apikey = "md-LYVN365SxOwYgFOD6HkSYg";
$mandrill = new Mandrill($apikey);

$customer = 'chornbeck@gmail.com';
$echeckin = $_SESSION['DisplayCheckIn'];
$echeckout = $_SESSION['DisplayCheckOut'];
$enights = $_SESSION['nts'];
$eprop = $_SESSION['hotelname'];
$eroom = $_SESSION['RoomChoice'];
$eprice = $_SESSION['pricechoice'];

$message = new stdClass();
$message->html = "Thank you for your reservation request with <b>TravSavers.com</b>!  We're happy to be able to help you save money on your Vegas vacation!
<br><br>
<b>Your reservation is not finalized.</b>  One of our representatives will contact you within the next 24 hours (48 hours on weekends) to confirm your reservation and acceptance and understanding of the terms and eligibility requirements of this promotional offer.  After your reservation is confirmed, you will receive a confirmation number and email detailing the specifics of your reservation. 
<br><br>
If you would like to proactively confirm your reservation or ask questions about your reservation, please contact us by phone at <b>(866) 540-8956</b> or email <a href="mailto:support@travsavers.com">support@travsavers.com</a>. <b>DO NOT TRAVEL</b> until you have received confirmation from one of our representatives.  
<br><br>
<b>Reservation Request Details:</b>
<br><br>
<b>Location:</b> Las Vegas<br>
<b>Selected Property:</b> $eprop<br>
<b>Check-In:</b> $echeckin<br>
<b>Check-Out:</b> $echeckout<br>
<b># of Nights:</b> $enights<br>
<b>Room Choice:</b> $eroom<br>
<b>Your Resort Preview Price:</b> $eprice<br>

";
$message->subject = "Confirmation - Your Las Vegas Reservation Request";
$message->from_email = "support@travsavers.com";
$message->from_name  = "TravSavers Confirmations";
$message->to = array(array("email" => $customer));
$message->track_opens = true;

$response = $mandrill->messages->send($message);

// notify me

$me = 'chris@travnow.com';

$message2 = new stdClass();
$message2->html = "NEW INCOMPLETE LEAD";
$message2->subject = "NEW TravSavers INCOMPLETE";
$message2->from_email = "support@travsavers.com";
$message2->from_name  = "TravSavers Confirmation";
$message2->to = array(array("email" => $me));
$message2->track_opens = true;

$response2 = $mandrill->messages->send($message2);

?>