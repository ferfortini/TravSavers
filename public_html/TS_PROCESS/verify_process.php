<?  include('../inc/db_connect.php');

$verifysaleID = $_POST['postsaleID'];
$verifyop = $_SESSION['OpID'];

$verifyquery = mysqli_query($con,"UPDATE Sales SET Status = 'VERIFIED', VerifyDateTime = NOW(), VerifyOperator = '$verifyop' WHERE SaleID = $verifysaleID");

header ('Location: operator_queue.php?msg=Sale%20Verified'); 

?>