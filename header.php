<?php
include("config.php");
include("inc/funcs.php");
require("inc/json.php");
include("inc/class.email.php");


$USER_DB=new DB($SITE_USER_DB_FOLDER); // USER DB
// $MLSC_DB=new DB($SITE_MEATLOAF_DB_FOLDER); // MEAT LOAF SHORT CODE DB

session_name($SITE_SESSION_NAME);
session_cache_expire(99999);
session_start();

@$USER_DATA=$USER_DB->getSingle($_SESSION["LOGGED_IN"]);

include("acts/acts.php");

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

$CSS_FILE="site.css";
if(file_exists($SITE_CSS))
$CSS_FILE=$SITE_CSS;

$FAVICON="favicon.ico";
if(file_exists($SITE_FAVICON))
$FAVICON=$SITE_FAVICON;

echo "
<html>
    <head>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"$CSS_FILE?v=$a\" />
        <meta charset=\"UTF-8\">
        <link rel=\"icon\" href=\"$FAVICON?v=$a\" />
    </head>
<body>
";

if(isset($_SESSION["DEBUG_VARS"])) {
    $out_vars="";
    foreach($_REQUEST as $k => $v) {
        $out_vars.="$k = [$v]<br>";
    }
    if(!empty($out_vars))
    warn("DEBUG_VARS:<br>".$out_vars);
}

echo "<table border=0>";
echo "<tr><td>";
echo "<a href=\"$SITE_URL\">";
put_image($SITE_BANNER_IMG,$SITE_NAME);
echo "</a>";
echo "</td><td>";
if(!empty($SITE_DISCORD_URL)){
    if(empty($SITE_DISCORD_ICON))
        $SITE_DISCORD_ICON="images/social/discord.png";
    if(file_exists($SITE_DISCORD_ICON))
        put_simage_link_nw($SITE_DISCORD_ICON,64,64,"Discord!",$SITE_DISCORD_URL);
}
echo "</td><td>";
if(!empty($SITE_YOUTUBE_URL)){
    if(empty($SITE_YOUTUBE_ICON))
        $SITE_YOUTUBE_ICON="images/social/youtube.png";
    if(file_exists($SITE_YOUTUBE_ICON))
        put_simage_link_nw($SITE_YOUTUBE_ICON,64,64,"YouTube!",$SITE_YOUTUBE_URL);
}
echo "</td><td>";
if(!empty($SITE_GITHUB_URL)){
    if(empty($SITE_GITHUB_ICON))
        $SITE_GITHUB_ICON="images/social/github.png";
    if(file_exists($SITE_GITHUB_ICON))
        put_simage_link_nw($SITE_GITHUB_ICON,64,64,"GITHUB!",$SITE_GITHUB_URL);
}
echo "</td></tr>";
echo "</table>";

echo "<table border=0  cellpadding=10 cellspacing=10>";
echo "<tr><td>";
// echo ">> $uri "; probably add links across the top here...
put_link("index.php","HOME");

foreach($SITE_TOP_MENU as $k => $v) {
    $url=strtolower($k);
    $url=str_replace(" ","_",$url);
    $url.=".php";
    
    echo "</td><td>";
    put_link("$SITE_FOLDER/$url","$k");
}

if(access("admin")) {
    echo "</td><td>";
    put_link("admin.php","ADMIN");
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
            <form action=\"index.php\" method=\"post\">
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
        put_avatar("images/user.png",96,96,"","profile.php");
        
    }
    echo "&nbsp;&nbsp;<div class=white id=white>".$_SESSION["LOGGED_IN"]."</div><BR>";
    
    put_link("profile.php","EDIT PROFILE");
    echo "<br>";
    echo "<BR>";
    put_link("mymeatloaf.php","MY MEATLOAF");

    echo "<br>";
    echo "<BR>";
    put_link("myshortcodes.php","MY SHORT CODES");

    echo "<BR>";
    echo "<BR>";
    put_link("index.php?logout=1","LOGOUT");
    
    echo "<BR>";
    echo "<BR>";

}

echo "</td><td valign=top><div class=middle>";

