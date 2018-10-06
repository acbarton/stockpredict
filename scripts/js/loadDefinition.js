function toggleTweets(){

var state = document.getElementById("toggle").innerHTML;
if(state=='Off'){
	document.getElementById("toggle").innerHTML = "On";
	var x = document.getElementById("scripture");
	var xlist = x.getElementsByClassName('tweetbuttons');
	for(i=0;i<xlist.length;i++){
		xlist[i].style.display='none';
	}
	
}
if(state=='On'){
	document.getElementById("toggle").innerHTML = "Off";
	var x = document.getElementById("scripture");
	var xlist = x.getElementsByClassName('tweetbuttons');
	for(i=0;i<xlist.length;i++){
		xlist[i].style.display='inline';
	}
	
	
	
}

}


function myFunction(str)
{

    str = str.replace('[','');
    str = str.replace(']','');
    str = str.replace(',','');
    str = str.replace('.','');
    str = str.replace('?','');
    str = str.replace(';','');
    str = str.replace('!','');
    str = str.replace('(','');
    str = str.replace(')','');
    str = str.replace(':','');
    
if (str.length==0) { 
    document.getElementById("dictionary").innerHTML="";
    document.getElementById("strongsGreek").innerHTML="";
    document.getElementById("strongsHebrew").innerHTML="";
    return;
} else {
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("dictionary").innerHTML=xmlhttp.responseText;
        }
    }
    
    
    xmlhttp.open("GET","/scripts/php/loadDefinition.php?word="+str,true);
    xmlhttp.send();
    
    var xmlhttp1=new XMLHttpRequest();
    xmlhttp1.onreadystatechange=function() {
        if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
            document.getElementById("strongsGreek").innerHTML=xmlhttp1.responseText;
        }
    }
    
    
    xmlhttp1.open("GET","/scripts/php/loadGreek.php?word="+str,true);
    xmlhttp1.send();
    
    var xmlhttp2=new XMLHttpRequest();
    xmlhttp2.onreadystatechange=function() {
        if (xmlhttp2.readyState==4 && xmlhttp2.status==200) {
            document.getElementById("strongsHebrew").innerHTML=xmlhttp2.responseText;
        }
    }
    
    
    xmlhttp2.open("GET","/scripts/php/loadHebrew.php?word="+str,true);
    xmlhttp2.send();
}    
}

function loadChapter(str)
{
    //document.getElementById("oldtest").innerHTML="";
   
if (str.length==0) { 
    document.getElementById("scripture").innerHTML="";
    return;
} else {
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("scripture").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","/scripts/php/loadChapter.php?chapter="+str,true);
    xmlhttp.send();
}    
}

function loadContents(str)
{

    
if (str.length==0) { 
    document.getElementById("chapters").innerHTML="";
    return;
} else {
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("chapters").innerHTML=xmlhttp.responseText;
        }
    }
    
    xmlhttp.open("GET","/scripts/php/contents.php?book="+str,true);
    xmlhttp.send();
}    
}

function loadStock(str)
{
    
 document.getElementById("oldtest").innerHTML="";  
 document.getElementById("oldtest").style.display="none";
 document.getElementById("rightpanel").style.display="block";
 document.getElementById("stockIndicator").style.display="block";
 document.getElementById("myDiv").style.display="block";
    setTimeout("hide()", 1000000);
    
if (str.length==0) { 
    document.getElementById("stockIndicator").innerHTML="";
    return;
} else {
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("stockIndicator").innerHTML=xmlhttp.responseText;
        }
    }
    
    xmlhttp.open("GET","/scripts/php/get_stock.php?stock="+str,true);
    xmlhttp.send();
    
}

loadNews(str)


}

function loadDash(str)
{
    
    
 document.getElementById(str).style.display="block";
    setTimeout("hide()", 7000);
    
if (str.length==0) { 
    document.getElementById(str).innerHTML="";
    return;
} else {
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById(str).innerHTML=xmlhttp.responseText;
        }
    }
    
    xmlhttp.open("GET","/scripts/php/get_stock_dash.php?stock="+str,true);
    xmlhttp.send();
    
}

}


function loadNews(str)
{
 document.getElementById("myDiv").style.display="block";
    setTimeout("hide()", 7000);
    
if (str.length==0) { 
    document.getElementById("rightpanel").innerHTML="";
    return;
} else {
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("rightpanel").innerHTML=xmlhttp.responseText;
        }
    }
    
    xmlhttp.open("GET","/scripts/php/get_news.php?stock="+str,true);
    xmlhttp.send();
    
}


}

function hide() {
    document.getElementById("myDiv").style.display="none";
}

function loadsim(str)
{   
    
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("simulation").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","/scripts/php/simulation.php?stock="+str,true);
    xmlhttp.send();

}


function slider()
{
    
    var slide = document.getElementById("myRange");
    var out = document.getElementById("demo");
    out.innerHTML = slide.value;
    
}

function sliderdays()
{
    
    var slide = document.getElementById("days");
    var out = document.getElementById("daysout");
    out.innerHTML = slide.value;
    
}

function simulate(str)
{   
    //document.getElementById("simulation_out").style.display="none";
    //document.getElementById("simulation_out").style.display="block";
    document.getElementById("stockIndicator").innerHTML = '<div id = "myDiv" style="display:block"><img id = "myImage" src = "images/loading-png.gif"></div>'
    //document.getElementById("myDiv").style.display="block";
    //setTimeout("hide()", 7000);
    //document.getElementById("yoyo").style.display="block";
    //setTimeout("hideyoyo()", 7000);
    var investment = document.getElementById("myRange").value;
    var days = document.getElementById("days").value;
    
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("stockIndicator").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","/scripts/php/simulation_out.php?stock="+str+"&invest="+investment+"&days="+days,true);
    xmlhttp.send();
    
    
}

function hideyoyo() {
    document.getElementById("yoyo").style.display="none";
}

function dashboard(){
    
    loadDash("AAPL")
    loadDash("XOM")
    loadDash("TSLA")
    
    
}