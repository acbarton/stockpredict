<?php
include 'simple_html_dom.php';

$word = $_GET['word'];

$url = 'http://www.eliyah.com/cgi-bin/strongs.cgi?file=greeklexicon&isindex='.$word;

//$url='http://www.eliyah.com';
$html = file_get_html($url);

$article = $html->find('table',0);
echo $article;

?>