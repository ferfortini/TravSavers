<? include('../inc/db_connect.php');

$activatesaleID = $_GET['getsaleID'];

$activatequery = mysqli_query($con,"UPDATE Sales SET Status = 'UNVERIFIED' WHERE SaleID = $activatesaleID");

header ('Location: operator_queue.php?msg=Sale%20UnVerified'); 

?>