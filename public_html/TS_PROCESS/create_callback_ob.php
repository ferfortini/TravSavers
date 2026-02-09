<?

 include('../inc/db_connect.php');

include ('menu.php');

if(isset($_GET['submit'])) {

$CallBackNotes = $_GET['CallBackNotes'];
$SaleID = $_GET['SaleID'];

if($_GET['ampm'] == 'PM'){

$Hour = $_GET['hour'] + 12;

} else { $Hour = $_GET['hour']; }

$NewCallBackDateTime = $_GET['year']."-".$_GET['month']."-".$_GET['day']." ".$Hour.":".$_GET['minute'].":00";

$Op = $_SESSION['OpID'];

$result=MYSQLI_QUERY($con,"UPDATE Sales SET CallBackDateTime = '$NewCallBackDateTime', CallBackNotes = '$CallBackNotes', CallBackSetTime = NOW(), DispositionOperator = '$Op' WHERE SaleID = '".$SaleID."'");



echo "<font color='blue'><b>Call Back Record Created!</b></font>";

}

?>
<h1>Set a Call Back</h1>

<form>


<table class="sortable">

<tr>
<td width="50%">


<BR>
<form onsubmit="return validate_form(this)" method="GET" action='<?php echo $_SERVER['PHP_SELF']; ?>'>

<input type="hidden" name="SaleID" value="<?php echo $_GET['sale']; ?>">

Call Back Date: 

<select name="month">

<option value="">-Month-</option>

<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
</select>
&nbsp;
<select name="day">

<option value="">-Day-</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
	<option value="24">24</option>
	<option value="25">25</option>
	<option value="26">26</option>
	<option value="27">27</option>
	<option value="28">28</option>
	<option value="29">29</option>
	<option value="30">30</option>
	<option value="31">31</option>

</select>
&nbsp;
<select name="year">

<option value="">-Year-</option>





<option value="2023">2023</option>
<option value="2024">2024</option>
</select>


<br><br>

Call Back Time (HH:MM): 

<select name="hour">
<option value="">HH</option>

<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
</select>:

<select name="minute">
<option value="">MM</option>

<option value="00">10</option>
<option value="15">15</option>
<option value="30">30</option>
<option value="45">45</option>
</select>
&nbsp;
<select name="ampm" value="">
<option value="AM">AM</option>
<option value="PM">PM</option>
</select>

<br><br>

Call Back Notes: <textarea cols="30" rows="10" name="CallBackNotes" value="" ></textarea><br><br>


<input type="submit" name="submit" value="Submit!"><br>

</td>
</tr>
</table>

</form>