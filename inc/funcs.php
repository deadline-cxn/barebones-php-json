<?php
include("config.php");



function get_vars($x) {
    $out_vars="";
    foreach($x as $k => $v) {
        if(is_array($v)) {
            $out_vars.="$k = array<br>";
            $out_vars.=get_vars($v);
        }
        else
            $out_vars.="$k = [$v]<br>";
    }
    return $out_vars;
}


function get_vars2($x) {
    $o="<pre>";
    foreach ($x as $k => $v ) {
        if(is_array($v)) {
            $o.=get_vars($v);
        }
        else {
            $o.="-[$k] = [$v] <br>";
        }
    }
    $o.="</pre>";
    return $o;
}




function dump_vars($x) {
    echo "<pre>";
    foreach ($x as $k => $v ) {
        if(is_array($v)) {
            dump_vars($v);
        }
        else {
            echo "-[$k] = [$v] <br>";
        }
    }
    echo "</pre>";
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
function create_guid() { // Create GUID (Globally Unique Identifier)
    $guid = '';
    $namespace = rand(11111, 99999);
    $uid = uniqid('', true);
    $data = $namespace;
    $data .= $_SERVER['REQUEST_TIME'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $data .= $_SERVER['REMOTE_ADDR'];
    $data .= $_SERVER['REMOTE_PORT'];
    $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
    $guid = substr($hash,  0,  8) . '-' .
            substr($hash,  8,  4) . '-' .
            substr($hash, 12,  4) . '-' .
            substr($hash, 16,  4) . '-' .
            substr($hash, 20, 12);
    return $guid;
}


function send_discord_channel_message($SITE_DISCORD_CHANNEL_WEBHOOK,$SITE_DISCORD_DATA,$s) {
        $SITE_DISCORD_DATA["content"]=$s;
        $post_data = json_encode($SITE_DISCORD_DATA);
        $crl = curl_init($SITE_DISCORD_CHANNEL_WEBHOOK);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($crl, CURLINFO_HEADER_OUT, true);
        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($crl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($post_data)));
        $result = curl_exec($crl);
        curl_close($crl);
}



