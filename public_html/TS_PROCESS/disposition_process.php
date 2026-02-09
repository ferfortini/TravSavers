<?
 include('../inc/db_connect.php');

if (($_GET['disp']) == ''){

header('Location: operator_queue.php?msg=You%20must%20select%20a%20status to update!');

}

/* NOT AVAILABLE */

if ($_GET['disp'] == 'NA'){

$leadcheck = $_GET['SaleID'];

$DispOp = $_SESSION['OpID'];

$result=MYSQLI_QUERY($con,"UPDATE Sales SET LeadDisposition = 'NA', DispositionOperator = '$DispOp', DispositionDateTime = NOW() WHERE SaleID = '".$leadcheck."'");
$result2 = MYSQLI_QUERY($con,"SELECT TimesDispositioned FROM Sales WHERE SaleID = '".$leadcheck."'");
$row2 = mysqli_fetch_array($result2);

$td = $row2['TimesDispositioned'];

$tdn = $td + 1;

$result3 =MYSQLI_QUERY($con,"UPDATE Sales SET TimesDispositioned = '$tdn' WHERE SaleID = '".$leadcheck."'");
header('Location: operator_queue.php?msg=No%20Answer');


}

/* BAD NUMBER */

if ($_GET['disp'] == 'BAD'){

$leadcheck = $_GET['SaleID'];

$DispOp = $_SESSION['OpID'];

$result=MYSQLI_QUERY($con,"UPDATE Sales SET LeadDisposition = 'BAD', DispositionOperator = '$DispOp', DispositionDateTime = NOW() WHERE SaleID = '".$leadcheck."'");
$result2 = MYSQLI_QUERY($con,"SELECT TimesDispositioned FROM Sales WHERE SaleID = '".$leadcheck."'");
$row2 = mysqli_fetch_array($result2);

$td = $row2['TimesDispositioned'];

$tdn = $td + 1;

$result3 =MYSQLI_QUERY($con,"UPDATE Sales SET TimesDispositioned = '$tdn' WHERE SaleID = '".$leadcheck."'");
header('Location: operator_queue.php?msg=Bad%20Number');

}


?>