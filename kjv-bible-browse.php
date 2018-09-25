<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">


    <head>
    	<title>KJV Bible Browse</title>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
        <meta charset="UTF-8"/>
	<meta name="description" content="King James Online Bible App and Bible Study Tools."/>
	<meta name="keywords" content="King James Version, Bible Study Tools, KJV, Bible, Bible Tools, KJV Bible Tools, Greek, Hebrew, Lexicon, Strong's Greek, Strong's Hebrew, 1828 Noah Webster, King James Version Bible Tools, KJV Bible, KJV APP, KJV Bible Verse, Bible Verse, Tweet Bible Verses, King James Bible, King James Bible Tweets, King James Bible App"/>
	<meta name="author" content="KJVBibleTools.com"/>
        <link type="text/css" rel="stylesheet" href="css/style.css"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="http://malsup.github.com/jquery.cycle2.js"></script>
        <script src="plugins/jquery.cycle2.carousel.js"></script>
        <script src="scripts/js/loadDefinition.js"></script>
        <script>
  	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  	ga('create', 'UA-66875348-1', 'auto');
  	ga('send', 'pageview');

	</script>
       
    </head>
    <body>
    
        <div id="wrapper">
          
        <div id="topPage">
        <div id="logo"></div>
            
        <h1>KJV Bible Browse</h1>
        
        
        <p><b>Hebrews 4:12 For the word of God [is] quick, and powerful, and sharper than any twoedged sword, piercing even to the dividing asunder of soul and spirit, and of the joints and marrow, and [is] a discerner of the thoughts and intents of the heart.</b></p>
        
            
        
        </div>
        
            
        <div id="nav" >
            <?php
            include 'scripts/nav.php';
            ?>
            
            <div id="social" align="right">
            
            <?php
            include 'scripts/social.php';
            ?>
            </div>
        
        </div>
        
        
            
        <div id="leftpanel" >
            
            <div class="sidebox">
            <h3>Strong's Greek Lexicon:</h3>
            <p id="strongsGreek">Instructions:<br />Click on a word from the Online KJV Bible to see Strong's Greek Lexicon results.</p>
            </div>
            
            <div class="sidebox">
            <h3>Strong's Hebrew Lexicon:</h3>
            <p id="strongsHebrew">Instructions:<br />Click on a word from the Online KJV Bible to see Strong's Hebrew Lexicon results.</p>
            </div>
            
            
        </div> 
            
        
          
            
        
            
        
        <!--
        <div id="slideshow">
            <div class="cycle-slideshow" 
                 data-cycle-fx="carousel" 
                 data-cycle-timeout="1"
                 data-cycle-easing="linear"
                 data-cycle-speed="6000"
                 data-cycle-random="true"
                 data-cycle-slides="> div">
            <?php
            include 'scripts/slideshow.php';
            ?>
        </div>
         -->
        
           
        <div id="rightpanel" >
            
            <div class="sidebox">
            <h3>1828 Noah Webster Dictionary:</h3>
            <p id="dictionary">Instructions:<br />Click on a word from the Online KJV Bible to see the 1828 Noah Webster Dictionary definition.</p>
            </div>

        </div> 
          
        <div id="content">
            
            <div id="chapters">
                
                <div id="biblenav">
            
                <div id="oldtest">
                <?php
                include 'scripts/biblenav.php';
                ?>
                </div>
                <div id="newtest">
                <?php
                include 'scripts/newtest.php';
                ?>
                </div>
                
            </div>
            </div>
            <div id="scripture" ></div>
            
            
        
        
        
        
        </div>
        
        
            
        
            
        </div> 
        <div id="footer">
        <p style="float:right;">References:<br /><a href="http://www.1828.mshaffer.com">www.1828.mshaffer.com</a><br /><a href="http://www.eliyah.com/lexicon.html/">www.eliyah.com/lexicon.html</a></p>
            <h3>KJV Bible Browse</h3>
            
            
            
            <p >&copy; Copyright 2016 KJVBibleTools.com</p>
        </div>
         
    </body>
</html>    