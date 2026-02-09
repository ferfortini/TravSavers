<?

if(!isset($_SESSION['OpID'])){

header("Location: main_login.php");

} else {}


?>

<head>
<link rel='stylesheet' type='text/css' href='css/example2.css'/>
	
<script language="Javascript" src="js/form_validate_process.js"></script>
</head>

<body>

<?

echo "<a href='operator_queue.php'>Pending Sales</a>   |   <a href='cancels.php'>Cancelled Sales / Tours</a>   |   <a href='sales.php'>Verified Sales / Tours</a>    |   <a href='logout.php'>Logout</a>";
echo "<div style='float:right;'>".$_SESSION['ProjectID']."<br>".$_SESSION['OpID']." - ".$_SESSION['OpName']." (".$_SESSION['Level'].")";
echo "<br>";

$CurrentOp = $_SESSION['OpID'];

?>
<br>