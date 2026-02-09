<?  include('../inc/db_connect.php');

$cancelsaleID = $_POST['postsaleID'];
$reason = $_POST['reason'];
$cancelop = $_SESSION['OpID'];

$cancelquery = mysqli_query($con,"UPDATE Sales SET Status = 'CANCEL', CancelReason = '$reason', CancelDateTime = NOW(), CancelOperator = '$cancelop' WHERE SaleID = $cancelsaleID");

header ('Location: operator_queue.php?msg=Sale%20Cancelled'); 

?>