<?php


$investment = $_GET['invest'];
$days = $_GET['days'];
$stock = $_GET['stock'];


 
#$command = "python ../python/xom.py ".escapeshellarg($book);
#$command = "python ../python/XOM/CNN/test_net.py 2>&1";
$command = "python ../python/".escapeshellarg($stock)."/CNN/test_net_simulate.py ".escapeshellarg($investment)." ".escapeshellarg($days);


$pid = popen( $command,"r");
while( !feof( $pid ) )
{
 echo fread($pid, 256);
 flush();
 ob_flush();
 #usleep(100000);
}
pclose($pid);

?>
