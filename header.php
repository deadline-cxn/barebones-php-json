<?php
include("config.php");
include("inc/funcs.php");
require("inc/json.php");
include("inc/class.email.php");

session_name($SITE_SESSION_NAME);
session_cache_expire(99999);
session_start();

if(isset($_SESSION["LOGGED_IN"])) {
    $user=$_SESSION["LOGGED_IN"];
    $USER_DATA=get_user_data($user);
    // set_user_data($USER_DATA);
}

echo "<!DOCTYPE html>";

debug_print(__FILE__."<br>");
// predump($USER_DATA);

$uri=$_SERVER["REQUEST_URI"];
$uri=explode("?",$uri)[0];
$uri=str_replace("/","",$uri);
$uri=str_replace(".php","",$uri);
$uri=strtoupper($uri);

if(empty($uri)) $uri="HOME";

$a=rand(0,99999999);

echo "
<html>
    <head>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"$SITE_CSS_URL?v=$a\" />
        <meta charset=\"UTF-8\">
        <link rel=\"icon\" href=\"$SITE_FAVICON_URL?v=$a\" />
    </head>
<body>
";

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

if(isset($_SESSION["DEBUG_VARS"])) {
    $out_vars=get_vars($_REQUEST);
    if(!empty($out_vars))
    warn("DEBUG_VARS:<br>".$out_vars);
}

echo "<table border=0>";
echo "<tr><td>";
echo "<a href=\"$SITE_URL\">";
put_image("$SITE_URL/$SITE_BANNER_IMG",$SITE_NAME);
echo "</a>";
echo "</td><td>";
if(!empty($SITE_DISCORD_URL)){
    if(empty($SITE_DISCORD_ICON))
        $SITE_DISCORD_ICON="images/social/discord.png";
    if(file_exists($SITE_DISCORD_ICON))
        put_simage_link_nw("$SITE_URL/$SITE_DISCORD_ICON",64,64,"Discord!",$SITE_DISCORD_URL);
}
echo "</td><td>";
if(!empty($SITE_YOUTUBE_URL)){
    if(empty($SITE_YOUTUBE_ICON))
        $SITE_YOUTUBE_ICON="images/social/youtube.png";
    if(file_exists($SITE_YOUTUBE_ICON))
        put_simage_link_nw("$SITE_URL/$SITE_YOUTUBE_ICON",64,64,"YouTube!",$SITE_YOUTUBE_URL);
}
echo "</td><td>";
if(!empty($SITE_GITHUB_URL)){
    if(empty($SITE_GITHUB_ICON))
        $SITE_GITHUB_ICON="images/social/github.png";
    if(file_exists($SITE_GITHUB_ICON))
        put_simage_link_nw("$SITE_URL/$SITE_GITHUB_ICON",64,64,"GITHUB!",$SITE_GITHUB_URL);
}

echo "</td><td>";
if(!empty($SITE_FACEBOOK_URL)){
    
    $SITE_FACEBOOK_ICON="images/social/facebook.png";
    //if(file_exists($SITE_FACEBOOK_ICON))
        put_simage_link_nw("$SITE_URL/$SITE_FACEBOOK_ICON",64,64,"FACEBOOK!",$SITE_FACEBOOK_URL);
}

echo "</td></tr>";
echo "</table>";

echo "<table border=0  cellpadding=10 cellspacing=10>";
echo "<tr><td>";
// echo ">> $uri "; probably add links across the top here...
put_link("$SITE_URL/index.php","HOME");

foreach($SITE_TOP_MENU as $k => $v) {
    $url=strtolower($k);
    $url=str_replace(" ","_",$url);
    $url.=".php";
    
    echo "</td><td>";

    put_link($v["URL"],$k);
}

if(access("admin")) {
    echo "</td><td>";
    put_link("$SITE_URL/inc/admin.php","ADMIN");
}

echo "</td></tr>";
echo "</table>";

echo "<hr>";


echo "<table border=0>";
echo "<tr><td valign=top width=300>";


if(!logged_in()) {
    if($uri!="REGISTER") {
    //echo"<BR>LOGIN<BR><BR>";

    echo "
            <form action=\"$SITE_URL/login.php\" method=\"post\">
            <div class=\"containerz\">
                <label for=\"uname\"><b>Username</b></label>
                <input type=\"text\" placeholder=\"Enter Username\" name=\"uname\" required>
                <label for=\"psw\"><b>Password</b></label>
                <input type=\"password\" placeholder=\"Enter Password\" name=\"psw\" required>
            </div>
            <input type=\"submit\" value=LOGIN>
            </form>
            ";

        echo"
        <form action=\"register.php\">
        <input type=\"submit\" value=REGISTER>
        </form>";
        
        echo "<a id=wut href=\"forgot.php\">Forgot Password?</a>";


    }
}
else {

    // show profile here, logout, my meatloaf, etc

    if($USER_DATA["profile_pic"]!="empty") {
        put_avatar($USER_DATA["profile_pic"],96,96,"","profile.php");
        
    }
    else {
        put_avatar("$SITE_URL/images/system/user.png",96,96,"","profile.php");
        
    }
    echo "&nbsp;&nbsp;<div class=white id=white>".$_SESSION["LOGGED_IN"]."</div><BR>";
    
    put_link("$SITE_URL/profile.php","EDIT PROFILE");

    // echo "<br>";
    // echo "<BR>";
    // put_link("$SITE_URL/todo.php","TODO: LEFT MENUs");

   /*
    echo "<br>";
    echo "<BR>";
    put_link("mymeatloaf.php","MY MEATLOAF");

    echo "<br>";
    echo "<BR>";
    put_link("myshortcodes.php","MY SHORT CODES");

    */

    echo "<BR>";
    echo "<BR>";
    put_link("$SITE_URL/login.php?logout=1","LOGOUT");
    
    echo "<BR>";
    echo "<BR>";

}

echo "</td><td valign=top><div class=middle>";

