<?php


$book = $_GET['book'];
$command = "sudo python ../python/contents.py ".escapeshellarg($book);


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
