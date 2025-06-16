<?php 
include("config.php");
include("inc/funcs.php");
require("inc/json.php");
include("inc/class.email.php");
#include("../../include/phylactery/lib.funcs.php");

session_name($SITE_SESSION_NAME);
session_cache_expire(99999);
session_start();

if(isset($_SESSION["LOGGED_IN"])) {
    $user=$_SESSION["LOGGED_IN"];
    $USER_DATA=get_user_data($user);
}

echo "<!DOCTYPE html>";

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
		<meta content='width=device-width, initial-scale=1, shrink-to-fit=no' name='viewport'>
		<meta content='A Commodore IEC Serial multi-device emulator' name='description'>
		<meta content='Jaime Idolpx' name='author'>

		<meta name=\"keywords\" content=\"Meatloaf Commodore\" />
		<meta name=\"news_keywords\" content=\"Meatloaf Commodore\" />
		<meta name=\"language\" content=\"English\">

		<!-- TYPE BELOW IS PROBABLY: 'website' or 'article' or look on https://ogp.me/#types -->
		<meta property=\"og:type\" content='website'/>
		<meta property=\"og:locale\" content=\"en_US\" />
		<meta property=\"og:title\" content=\"Meatloaf!\" />
		<meta property=\"og:description\" content=\"A Commodore IEC Serial multi-device emulator\" />
		<meta property=\"og:url\" content=\"https://meatloaf.cc\" />
		<meta property=\"og:site_name\" content=\"Meatloaf!\" />
		<meta property=\"og:updated_time\" content=\"2024-02-28T14:22:00+00:00\" />
		<meta property=\"og:image:type\" content=\"image/svg\">
		<meta property=\"og:image\" content=\"http://meatloaf.cc/media/meatloaf.logo.svg\" />
		<meta property=\"og:image:secure_url\" content=\"https://meatloaf.cc/media/meatloaf.logo.svg\" />
		<meta property=\"og:image:width\" content=\"1200\" />
		<meta property=\"og:image:height\" content=\"630\" />
		<meta name=\"twitter:card\" content=\"summary_large_image\" />
		<meta name=\"twitter:description\" content=\"A Commodore IEC Serial multi-device emulator\" />
		<meta name=\"twitter:title\" content=\"Meatloaf!\" />
		<meta name=\"twitter:image\" content=\"https://meatloaf.cc/media/meatloaf.logo.svg\" />
		<link rel=\"shortcut icon\" type=\"image/png\" href=\"/media/meatloaf.icon.32.png\"/>
		<!--link rel=\"manifest\" href=\"manifest.json\"-->


        <link rel=\"stylesheet\" type=\"text/css\" href=\"$SITE_CSS_URL?v=$a\" />
        <meta charset=\"UTF-8\">
        <link rel=\"icon\" href=\"$SITE_FAVICON_URL?v=$a\" />
    </head>
<body>
";

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
        <form action=\"$SITE_URL/register.php\">
        <input type=\"submit\" value=REGISTER>
        </form>";
        
        echo "<a id=wut href=\"$SITE_URL/forgot.php\">Forgot Password?</a>";


    }
}
else {

    // show profile here, logout, my meatloaf, etc

    if($USER_DATA["profile_pic"]!="empty") {
        put_avatar($USER_DATA["profile_pic"],150,150,"","$SITE_URL/profile.php");
        
    }
    else {
        put_avatar("$SITE_URL/images/system/user.png",150,150,"","$SITE_URL/profile.php");
        
    }
    echo "&nbsp;&nbsp;<div class=white id=white>".$_SESSION["LOGGED_IN"]."</div><BR>";
    
    put_link("$SITE_URL/profile.php","PROFILE");

    
    foreach($SITE_LEFT_MENU as $k => $v) {
    $url=strtolower($k);
    $url=str_replace(" ","_",$url);
    $url.=".php";
    echo "<br>";
    echo "<br>";
    put_link($v["URL"],$k);
}

    echo "<BR>";
    echo "<BR>";
    put_link("$SITE_URL/login.php?logout=1","LOGOUT");
    
    echo "<BR>";
    echo "<BR>";

}

echo "</td><td valign=top><div class=middle>";

