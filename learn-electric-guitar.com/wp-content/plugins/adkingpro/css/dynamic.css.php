<? 

    header("Content-type: text/css; charset: UTF-8");
//Now here, I can define any variables I need using the "of_get_option"
//That comes with the Options Framework (for example the below to get
//the background.
    $akp_css = get_option('akp_custom_css');
?>
/*--End PHP, Begin CSS---*/
<?= $akp_css ?>