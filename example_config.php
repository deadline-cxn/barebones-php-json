<?php

$SITE_FOLDER       = "s/tcn"; 

$SITE_NAME         = "Bare Bones PHP";
$SITE_URL          = "http://barebones-php-json";
$SITE_SESSION_NAME = "barebonephp";
$SITE_SEND_EMAIL   = "noreply@barebones";
$SITE_BANNER_IMG   = "images/barebones_banner.png";

$SITE_FAVICON      = "";
$SITE_CSS          = "";
$SITE_IMAGES       = "";
$SITE_FONTS        = "";

$SITE_DISCORD_URL  = "";
$SITE_DISCORD_ICON = "";
$SITE_YOUTUBE_URL  = "";
$SITE_YOUTUBE_ICON = "";
$SITE_GITHUB_URL   = "";
$SITE_GITHUB_ICON  = "";

$SITE_VERIFY_SUBJECT = "$SITE_NAME Registration";
$SITE_VERIFY_MESSAGE = "Welcome to $SITE_NAME, if you click this link it will verify your email against the database. Thank You! 
<a href='$SITE_URL/verify.php?verify=true&id=ZZID&name=ZZNAME'>VERIFY EMAIL</a>";

$SITE_DB_TYPE             = "JSON"; // add others here later
$SITE_USER_DB_FOLDER      = "db/userdb.json";

if(file_exists("$SITE_FOLDER/config.php"))
include("$SITE_FOLDER/config.php");

