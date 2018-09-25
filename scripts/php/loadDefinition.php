
<?php
include 'simple_html_dom.php';

$word = $_GET['word'];

$url = 'https://1828.mshaffer.com/d/word/'.$word;

$html = file_get_html($url);

$article = $html->find('div.dictionary',0);
echo $article;

?>