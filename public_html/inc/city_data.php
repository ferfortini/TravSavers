        <!-- Top tags -->
        
<?
$attquery = mysqli_query($con, "SELECT * FROM attraction WHERE newcity = '$city'") ;
if (mysqli_num_rows($attquery) > 0) {
 echo "<section id='attractions' class='pt-0 pb-1'>
            
<div class='card'>
    <div class='card-body'>
<img src='https://travnow.com/assets/img/icons/att_icon.jpg' style='max-width:120px; float:left;' alt='Local Attractions & Things To Do'>
        <h6 class='card-title'>Local Attractions & Things To Do</h6>
<ul>
";
            

while ($rowatt = mysqli_fetch_array( $attquery ))
{

if (!empty($rowatt['description'])) {

echo "<li><a href='https://travnow.com/travel-guide.php?att=".$rowatt['id']."'>".$rowatt['attraction']."</a></li>";

} else {

echo "<li>".$rowatt['attraction']."</li>";
}


}

echo "
</ul>
            </div>
</div>
        </section>";

} else {}

?>
   



                   <?
$resquery = mysqli_query($con, "SELECT * FROM restaurant WHERE city = '$city'") ;
if (mysqli_num_rows($resquery) > 0) {
 echo "
<section id='restaurants' class='pt-0 pb-1'>
            
<div class='card'>
    <div class='card-body'>
<img src='https://travnow.com/assets/img/icons/rest_icon.jpg' style='max-width:120px; float:left;' alt='Local Restaurant Spotlight'>
        <h6 class='card-title'>Local Restaurant Spotlight: Our \"Top Restaurant Choice For Travelers - 2023\"</h6>
                  
";             

while ($rowres = mysqli_fetch_array( $resquery ))
{

echo "

     <a href='https://travnow.com/travel-guide.php?res=".$rowres['id']."'> <h4><i class='ti ti-star'></i>&nbsp;".$rowres['title']."</h4></a><br>
        <a href='https://travnow.com/travel-guide.php?res=".$rowres['id']."'  class='btn btn-primary' style='padding:5px; color:#fff;'>Read Our Review</a>";

}


echo "
           </div>
</div>
        </section>";

} else {}

?>





 <?
$hoquery = mysqli_query($con, "SELECT * FROM properties WHERE locid = '$city' AND description != '' ORDER BY rating DESC LIMIT 20") ;
if (mysqli_num_rows($hoquery) > 0) {
 echo "
<section id='hotels' class='pt-0 pb-1'>
         <div class='card'>
    <div class='card-body'>
<img src='https://travnow.com/assets/img/icons/hot_icon.jpg' style='max-width:75px; float:left;' alt='Featured Hotels & Vacation Rentals'>
        <h6 class='card-title'>Featured Hotels & Vacation Rentals in ".$rowcity['name']."</h6>
<p>TravNow is pleased to feature the following ".$rowcity['name']." hotels & vacation rentals which were rated highest overall in our guest reviews:<br><br></p>
<ul>
";             

while ($rowho = mysqli_fetch_array( $hoquery ))
{

if (!empty($rowho['description'])) {

echo "<li><a href='https://travnow.com/hotel-feature.php?hotel=".$rowho['id']."'>".$rowho['name']."</a> - ".$rowho['reviews']." Guest Reviews (".$rowho['rating']." Avg Rating)</li>";

} else {

echo "<li>".$rowho['name']."</li>";

}

}

$ho2query = mysqli_query($con, "SELECT id FROM properties WHERE locid = '$city' AND description != ''") ;
if (mysqli_num_rows($ho2query) > 20) {

$rowho2 = mysqli_fetch_array($ho2query);

echo "</ul><br><a href='https://travnow.com/featured-hotels.php?city=".$city."' class='btn btn-primary'>View All Featured ".$rowcity['name']." Hotels & Vacation Rentals</a>";

} else {}

echo "

            </div>
</div>
        </section>";

} else {}

?>









                


                   <?
$hisquery = mysqli_query($con, "SELECT * FROM historic WHERE newcity = '$city'") ;
if (mysqli_num_rows($hisquery) > 0) {
 echo "
<section id='historic' class='pt-0 pb-1'>
         <div class='card'>
    <div class='card-body'>
<img src='https://travnow.com/assets/img/icons/his_icon.jpg' style='max-width:75px; float:left;' alt='Historic Sites & Points of Interest'>
        <h6 class='card-title'>Historic Sites & Points of Interest</h6>
<ul>
";             

while ($rowhis = mysqli_fetch_array( $hisquery ))
{

if (!empty($rowhis['description'])) {

echo "<li><a href='https://travnow.com/travel-guide.php?his=".$rowhis['id']."'>".$rowhis['historic']."</a></li>";

} else {

echo "<li>".$rowhis['historic']."</li>";

}

}

echo "
</ul>
            </div>
</div>
        </section>";

} else {}

?>
    
        
        <!-- /Top tags -->

        <!-- Top tags -->
        
                   <?
$colquery = mysqli_query($con, "SELECT * FROM college WHERE newcity = '$city'") ;
if (mysqli_num_rows($colquery) > 0) {
 echo "
<section id='colleges' class='pt-0 pb-1'>
          <div class='card'>
    <div class='card-body'>
<img src='https://travnow.com/assets/img/icons/col_icon.jpg' style='max-width:75px; float:left;' alt='Colleges & Universities'>
        <h6 class='card-title'>Colleges / Universities</h6>
<ul>

";             

while ($rowcol = mysqli_fetch_array( $colquery ))
{

echo "<li>".$rowcol['college']."</li>";

}


echo "
</ul>
</div>
            </div>
        </section>";


} else {}


$airquery = mysqli_query($con, "SELECT * FROM airport WHERE newcity = '$city'") ;
if (mysqli_num_rows($attquery) > 0) {
 echo "
<section id='airports' class='pt-0 pb-1'>
 <div class='card'>
    <div class='card-body'>
<img src='https://travnow.com/assets/img/icons/air_icon.jpg' style='max-width:75px; float:left;' alt='Airports'>
        <h6 class='card-title'>Airports</h6>
<ul>
";             

while ($rowair = mysqli_fetch_array( $airquery ))
{

echo "<li>".$rowair['airport']."</li>";

}


echo "
</ul>
</div>
            </div>
        </section>";

} else {}


$milquery = mysqli_query($con, "SELECT * FROM military WHERE newcity = '$city'") ;
if (mysqli_num_rows($milquery) > 0) {
 echo "
<section id='military' class='pt-0 pb-1'>
        <div class='card'>
    <div class='card-body'>
<img src='https://travnow.com/assets/img/icons/mil_icon.jpg' style='max-width:75px; float:left;' alt='Military Bases'>
        <h6 class='card-title'>Military Bases</h6>
<ul>

";             

while ($rowmil = mysqli_fetch_array( $milquery ))
{

echo "<li>".$rowmil['military']."</li>";

}


echo "
</ul>
          </div>  </div>
        </section>";
} else {}

$hosquery = mysqli_query($con, "SELECT * FROM hospital WHERE newcity = '$city'") ;
if (mysqli_num_rows($hosquery) > 0) {
 echo "
<section id='hospitals' class='pt-0 pb-1'>
           <div class='card'>
    <div class='card-body'>
<img src='https://travnow.com/assets/img/icons/hos_icon.jpg' style='max-width:75px; float:left;' alt='Hospitals'>
        <h6 class='card-title'>Hospitals</h6>
<ul>
";

while ($rowhos = mysqli_fetch_array( $hosquery ))
{

echo "<li>".$rowhos['hospital']."</li>";

}


echo "
</ul>
         </div>   </div>
        </section>";

} else {}

?>
            

 