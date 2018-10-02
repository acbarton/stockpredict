<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">


    <head>
    	<title>Stock Prediction with Deep Learning</title>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
        <meta charset="UTF-8"/>
	<meta name="description" content="Stock Prediction with Deep Learning."/>
	<meta name="keywords" content="Stock Prediction with Deep Learning"/>
	<meta name="author" content="Stock Prediction with Deep Learning"/>
        <link type="text/css" rel="stylesheet" href="css/style.css"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="http://malsup.github.com/jquery.cycle2.js"></script>
        <script src="plugins/jquery.cycle2.carousel.js"></script>
        <script src="scripts/js/loadDefinition.js"></script>
        
       
    </head>
    <body onload="dashboard()">
    
        <div id="wrapper">
          
        <div id="topPage">
        <!-- <div id="logo"></div> -->
            
        <h1>AI Stock Trading</h1>
        <h2>Stock Prediction with Deep Learning</h2>
        
        

        <p></p>
        
            
        
        </div>
        
        <!--
        <div id="nav" >
            <?php
            include 'scripts/nav.php';
            ?>
        </div>
        -->
        
        <!--    
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
        -->    
        
          
            
        
            
        
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
            
            

        </div> 
        
         
          
        <div id="content">
           
            
            
            <div id="chapters">
                
                <div id="biblenav">
            
                <div id="oldtest">
                <?php
                include 'scripts/stocks.php';
                ?>
                    
                </div>
               
                
            </div>
            </div>
            <div id="stockIndicator" ><div id = "myDiv" style="display:none"><img id = "myImage" src = "images/yoyo.gif"></div></div>
            <div id="simulation" ></div>
            <div id = "yoyo" style="display:none"><img id = "myImage" src = "images/yoyo.gif"></div>
            <div id="simulation_out" ></div>
            
           
        
        
        
        
        </div>
        
        
            
        
            
        </div> 
        <div id="footer">
        
       
            
            <p >&copy; Copyright 2018 Armon Barton</p>
        </div>
         
    </body>
</html>    