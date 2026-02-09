<!-- Modal Travis -->
                                        <div class="modal fade" id="mdlTravis" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdlTravisTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                                <div class="modal-content" style="height:80%;">
                                                    <div class="modal-header" style="padding:5px; text-align:center;">
                                                        <h6 class="modal-title h6" id="mdlTravisTitle">Meet T.R.A.V.i.s<sup>&reg;</sup>, Your A.I. Travel Guide!</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:center;">
                                                     <div>
   <img src="https://travnow.com/assets/img/top_trav.png" style="float:left; max-width:18%; " alt="Use the Power of AI To Plan Your Vacation!">

<b>Hello!  I can answer questions about travel destinations, interesting things to do on your trip, and other travel-related topics. Let me help plan your upcoming trip<? if (isset($rowcity['name'])) { echo " to ".$rowcity['name']."!"; } else { echo "!"; } ?></b>
<br>
</div>

<?
if (isset($rowcity['name'])) { $_SESSION['aicity'] = $rowcity['name']; } else {}
if (isset($rowcity['st'])) { $_SESSION['aist'] = $rowcity['st']; } else {}

 ?>


<div style="clear:both;"></div>


<iframe style="display: block;    
    border: 0px; 
      width: 100%;
height:75%;" src="https://travnow.com/travis_tb.php"></iframe>
</div>

                                                    </div>
                                                </div>
                                            </div>
                                      
                                        <!-- /Modal Travis -->