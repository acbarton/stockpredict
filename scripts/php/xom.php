<?php


$book = $_GET['book'];
#$command = "sudo python ../python/xom.py ".escapeshellarg($book);
#$command = "python ../python/XOM/CNN/test_net.py 2>&1";
$command = "python ../python/XOM/CNN/test_net.py";


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
