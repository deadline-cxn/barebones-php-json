<?php
include("config.php");

function dump_vars() {
    foreach ($_REQUEST as $k => $v ) {
        echo "$k = $v <br>";
    }
}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%^&*(";
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, strlen($alphabet)-1);
        $pass[$i] = $alphabet[$n];
    }
    
    return implode("",$pass);
}

function debug_print($txt) {
    if(isset($_SESSION["DEBUG"]))
    echo "<div class=warn id=warn>DEBUG: $txt</div>";
    
}
function predump($x) {
        if(isset($_SESSION["DEBUG_VARS"])) {
        echo"<br><pre>";
        var_dump($x);
        echo"<br></pre>";
    }
}
function preprint($x) {
    echo"<br><pre>";
    $x;
    echo"<br></pre>";
}

function warn($txt) { 
    echo "<div class=warn id=warn>$txt</div>";
}

function are_you_sure($url_to_do) {
    echo "<br>";
    echo "<form action=\"$url_to_do\" method=post>";

    warn("<h2> ARE YOU SURE? </h2>");

    echo "<input type=submit name=Yes value=Yes>";
    echo "<input type=submit name=No value=No>";
    

    echo "</form>";
}

function put_image($url,$words) {  echo "<img src=\"$url\" alt=\"$words\">"; }

function put_icon($iurl,$w,$h,$words,$url) { 
    echo nl2br("<a href=\"$url\"><img id=icoimg src=\"$iurl\" width=$w height=$h alt=\"$words\"><br>$words</a>");
}

function put_avatar($iurl,$w,$h,$words,$url) { 
    echo nl2br("<a href=\"$url\"><img id=avimg src=\"$iurl\" width=$w height=$h alt=\"$words\"><br>$words</a>");
}

function put_simage_link($iurl,$w,$h,$words,$url) { 
    echo nl2br("<a href=\"$url\"><img src=\"$iurl\" width=$w height=$h alt=\"$words\"><br>$words</a>");
}
function put_simage_link_nw($iurl,$w,$h,$words,$url) { 
    echo nl2br("<div id=imgsr><a href=\"$url\" target=\"_blank\"><img src=\"$iurl\" width=$w height=$h alt=\"$words\"></a></div>");
}
function put_link($url,$words) {  echo "<a href=\"$url\">$words</a>"; }
function put_link_wtarg($url,$words,$target) {  echo "<a href=\"$url\" target=\"$target\">$words</a>"; }
function logged_in() {
    if(isset($_SESSION["LOGGED_IN"])) {
        return true;
    }
    return false;
}



function goto_page($x) {
	echo " <script language=\"javascript\" type=\"text/javascript\"> window.location=\"$x\"; </script> <!--// -->";
}
