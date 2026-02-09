        <!-- Useful info -->
        <section id="info" class="pt-0">
            <div class="container">
                <!-- Heading -->
                <div class="d-block d-lg-flex align-items-center">
                    <div class="mb-6 me-lg-auto" style="text-align:left;">
                        <h2 class="h2 fw-bold mb-3 text-body-emphasis"><? echo $rowcity['name']; ?> Travel Guide</h2>

                    </div>
                   
                </div>
<div style="clear:both;"></div>
                <!-- /Heading -->
                <!-- Blog posts -->
                <div class="blog-mini">
                    <div class="row">
                        <div>
   <br>                       

<?

$blogquery2 = mysqli_query($con, "SELECT * FROM blog WHERE newcity = '$city'") ;

if(mysqli_num_rows($blogquery2) > 0) {

echo "<h5 class='h5 fw-bold mb-3 text-body-emphasis'>Featured ".$rowcity['name']." Tourism Information Articles</h5>";
  
$cd = $rowcity['name'];
$citydash =str_replace(' ', '-', $cd);

while ($rowblog2 = mysqli_fetch_array( $blogquery2 ))

{
$subcontent = $rowblog2['content'];
$shortdesc = substr ( $subcontent, 0, 200);
echo "<div class='card' style='width:45%; margin:5px; float:left;'><div class='card-body'> <img src='https://travnow.com/assets/img/icons/art_icon.jpg' style='max-width:25px; float:left;' alt='Tourism Information Articles'><h6 class='card-title'><a href='https://travnow.com/travel-guide.php?city=".$citydash."&article=".$rowblog2['id']."'>".$rowblog2['title']."</a></h6> <p class='card-text'>".$shortdesc."...</p> 
<br><a href='https://travnow.com/travel-guide.php?city=".$citydash."&article=".$rowblog2['id']."' class='btn btn-primary'>Read Article</a> </div> </div>";


}

} else {}

?>
                        
                    </div>
                </div>
                <!-- /Blog mini -->
            </div>
</div>
        </section>

        <!-- /Useful info -->