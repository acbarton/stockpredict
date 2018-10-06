<?php
#echo '<h2>Choose Company</h2>';
#echo '<ul>'
#. '<li><a class="button" href="#" onclick="loadStock(\'XOM\');return false;">ExxonMobile - XOM</a><p>sdfsdfs</p></li>'
#. '<li><a class="button" href="#" onclick="loadStock(\'TSLA\');return false;">Tesla - TSLA</a></li>'
#. '</ul>';



echo 
 '<div class="stockbutton"><a class="button" href="#" onclick="loadStock(\'AAPL\');return false;">Apple - AAPL</a><p id="AAPL"> <img id = "myImage" src = "images/loading.gif"> </p> </div>'
.'<div class="stockbutton"><a class="button" href="#" onclick="loadStock(\'XOM\');return false;">ExxonMobile - XOM</a><p id="XOM" > <img id = "myImage" src = "images/loading.gif"> </p> </div>'
. '<div class="stockbutton"><a class="button" href="#" onclick="loadStock(\'TSLA\');return false;">Tesla - TSLA</a><p id="TSLA"> <img id = "myImage" src = "images/loading.gif"> </p> </div>'
        
. '';






?>