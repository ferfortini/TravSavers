<!-- About -->
        <section id="about" class="pt-0">
            <div class="container">
                <div class="row g-0 g-lg-8 align-items-center">
                    <div class="col-24 col-xl-12 order-1 order-lg-0">
                        <!-- Image list -->
                        <div class="mb-10">
                            <div class="bg-brand">
                                <div class="bg-brand-svg">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1379 1200">
                                        <path d="M1076.17 232c143.42 89.1 272.63 203.17 293.73 328.7 22.62 125.64-63.02 264.4-176.51 355.02-111.98 90.62-251.67 132.97-388.05 168-136.25 35.04-270.84 62.76-414.12 48.28-143.27-14.76-298.83-71.86-356.47-168.14-57.64-97.93-17.51-235.17 33.1-353.38a982.49 982.49 0 0 1 204.5-312.69c94.46-96.55 222.02-191.45 363.5-206.07 141.5-16 297.04 49.66 440.32 140.28Zm0 0" />
                                    </svg>
                                </div>
                                <div class="row g-3 g-md-5 align-items-center">
                                    <div class="col-12">
                                        <div class="row g-0 justify-content-end mt-10 mt-md-0">
                                            <div class="col-24">
                                                <!-- Image -->
                                                <div class="img-info">
                                                    <div class="img-info-shadow bg-body bg-opacity-90 rounded"></div>
                  
                              <figure class="img-info-thumbnail rounded">
<?
$stsl = strtolower ($rowcity['st']);
 echo "<img src='https://travnow.com/assets/img/states/".$stsl."1.jpg' class='img-fluid' alt='".$rowcity['name']." ".$rowcity['st']." hotels'>";
?>
  
       </figure>
                                                </div>
                                                <!-- /Image -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row g-0 mb-3 mb-md-5">
                                            <div class="col-18 col-md-14 col-xl-14">
                                                <!-- Image -->
                                                <div class="img-info">
                                                    <div class="img-info-shadow bg-body bg-opacity-90 rounded"></div>
                                                    <figure class="img-info-thumbnail rounded">
                                                       <?
 echo "<img src='https://travnow.com/assets/img/states/".$stsl."2.jpg' class='img-fluid' alt='hotels in ".$rowcity['name']."'>";
?>
  </figure>
                                                </div>
                                                <!-- /Image -->
                                            </div>
                                        </div>
                                        <div class="row g-0 justify-content-start">
                                            <div class="col-24 col-md-20">
                                                <!-- Image -->
                                                <div class="img-info">
                                                    <div class="img-info-shadow bg-body bg-opacity-90 rounded"></div>
                                                    <figure class="img-info-thumbnail rounded">
                                                        <?
 echo "<img src='https://travnow.com/assets/img/states/".$stsl."3.png' class='img-fluid' alt='".$rowcity['name']." hotels & vacation rentals'>";
?>  
        </figure>
                                                    
                                                </div>
                                                <!-- /Image -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Image list -->
                    </div>
                    <div class="col-24 col-xl-12 order-0 order-lg-1">
                        <div class="card border-0 mb-10">
                            <div class="card-body card-body p-0 p-lx-6">
                                <!-- Heading -->
                                <h2 class="h1 fw-bold text-body-emphasis">Where To Stay In <? echo $rowcity['name']; ?>, <? echo $rowcity['state']; ?></h2>
                                <!-- /Heading -->
                                <!-- Content -->
                               <? echo $rowcity['description']; ?>
                               
                                <!-- /Content -->
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
        <!-- /About -->