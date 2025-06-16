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