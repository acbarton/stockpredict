
<?php
$str = $_GET['chapter'];
$command = "sudo python ../python/query.py ".escapeshellarg($str);
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