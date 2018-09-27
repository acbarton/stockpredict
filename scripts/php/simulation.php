<?php
$stock = $_GET['stock'];
echo'<hr>';
#echo'<h2>Simulation</h2>';

echo'<h1>Simulation</h1>';
echo'<p>Choose your investment amount.</p>';

echo'<div class="slidecontainer">';
  echo'<input oninput="slider()" type="range" min="1000" max="100000" value="1000" class="slider" id="myRange">';
  echo'<p>Investment: $<span id="demo">1000</span></p>';
echo'</div>';


echo'<p>Choose investment time frame (days prior).</p>';

echo'<div class="slidecontainer">';
  echo'<input oninput="sliderdays()" type="range" min="10" max="365" value="10" class="slider" id="days">';
  echo'<p>Days: <span id="daysout">10</span></p>';
echo'</div>';

echo '<ul>'
. '<li><a class="button" href="#" onclick="simulate('.escapeshellarg($stock).');return false;">Simulate</a></li>'
. '</ul>';

?>





