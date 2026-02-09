<?  include('../inc/db_connect.php');

$confirmsaleID = $_POST['postsaleID'];
$confirmop = $_SESSION['OpID'];
$confirmstatus = $_POST['confirmstatus'];
$confirmourprice = $_POST['confirmourprice'];
$confirmresortfee = $_POST['confirmresortfee'];

$confirmquery = mysqli_query($con,"UPDATE Sales SET PriceConfirmedStatus = '$confirmstatus', PriceConfirmedDateTime = NOW(), PriceConfirmedOperator = '$confirmop', PriceConfirmedOurPrice = '$confirmourprice', PriceConfirmedResortFee = '$confirmresortfee' WHERE SaleID = $confirmsaleID");

header ('Location: operator_queue.php?msg=Sale%20Confirmed'); 

?>