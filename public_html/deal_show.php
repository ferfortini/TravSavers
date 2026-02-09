<div style="padding:10px;">
<?

// DEAL 1
for ($k = 1 ; $k < 6; $k++){

$dealq1 = mysqli_query($con, "SELECT * FROM vegas_deals WHERE dealnum = '$k' AND rating > 3 AND rating < 4.5 AND refundable = '1' AND propid != '359994' AND propid != '478558' AND promoprice < 800 ORDER BY bigsave DESC LIMIT 2");
$j = '0';
while ( $rowdealq1 = mysqli_fetch_array ($dealq1) ) {
if($j == '0') { 
$jci = date('m/d/Y', strtotime($rowdealq1['checkin']));
$jco = date('m/d/Y', strtotime($rowdealq1['checkout']));

echo "<img src='/assets/img/veg_icon_sm.png'><b>".$rowdealq1['nights']." Night Stay - ".$jci." To ".$jco."</b><br>"; } else {}
$j = $j + 1;
$bigsave1 = $rowdealq1['bigsave'];
echo "<div><img src='".$rowdealq1['thumb']."' style='float:left; max-width:120px; margin:10px; border-radius:8px;' class='shadysm'>";
 


echo "<b>".$rowdealq1['name']."</b>";
echo "<br><span class='star-rate-view star-rate-size-sm'>";
$stars = $rowdealq1['rating'];
 if ($stars == '5') { ?> <span class="star-value rate-50"></span> <? }
elseif ($stars == '4.5') { ?> <span class="star-value rate-45"></span> <? }
elseif ($stars == '4') { ?> <span class="star-value rate-40"></span> <? }
elseif ($stars == '3.5') { ?> <span class="star-value rate-35"></span> <? }
elseif ($stars == '3') { ?> <span class="star-value rate-30"></span> <? }
elseif ($stars == '2.5') { ?> <span class="star-value rate-25"></span> <? }
elseif ($stars == '2') { ?> <span class="star-value rate-20"></span> <? }
 else {} 
echo "</span>";
echo "<br>
<b style='font-size:120%;'>$".$rowdealq1['promoprice']." Resort Preview Rate<sup>*</sup> (<span style='color:#cc0000; font-size:80%;'>$".$bigsave1." Savings, <s>$".$rowdealq1['publicprice']." Retail</s></span>)</b></div><div style='clear:both;'></div>";
}
echo "<br>";
}
?>
</div>