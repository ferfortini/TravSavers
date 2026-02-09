<?

include('../inc/db_connect.php');

$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword'];

$sql="SELECT * FROM TS_Operators WHERE OpID='$myusername' and OpPassword='$mypassword'";
$result=mysqli_query($con,$sql);
$count=mysqli_num_rows($result);
$rowlogin = mysqli_fetch_array($result);

if($count==1){

$_SESSION['OpID'] = $rowlogin['OpID'];
$_SESSION['Level'] = $rowlogin['Level'];
$_SESSION['OpName'] = $rowlogin['OpName'];
$_SESSION['ProjectID'] = $rowlogin['ProjectID'];
$logop = $_SESSION['OpID'];


header("location:operator_queue.php");


}
else {
echo "Wrong Username or Password";

?>
<head>
<link rel='stylesheet' type='text/css' href='example2.css'/>
	</head>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form name="form1" method="post" action="check_login.php">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td colspan="3"><strong>Operator Login </strong></td>
</tr>
<tr>
<td width="78">Operator Number</td>
<td width="6">:</td>
<td width="294"><input name="myusername" type="text" id="myusername"></td>
</tr>
<tr>
<td>Password</td>
<td>:</td>
<td><input name="mypassword" type="text" id="mypassword"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>


<td><input type="submit" name="submit" value="Login"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>
<br><br>
<?


}

?>