<?php

$SITE_FOLDER       = "example"; // example and s are in .gitignore 
$SITE_NAME         = "Bare bones PHP JSON";
$SITE_URL          = "http://barebones-php-json";
$SITE_SESSION_NAME = "bbphpj";
$SITE_SEND_EMAIL   = "noreply@example.net";

$SITE_FAVICON      = "$SITE_FOLDER/favicon.ico";
$SITE_CSS          = "$SITE_FOLDER/site.css";
$SITE_IMAGES       = "$SITE_FOLDER/images";
$SITE_FONTS        = "$SITE_FOLDER/fonts";
$SITE_BANNER_IMG   = "$SITE_IMAGES/banner.png";

$SITE_FAVICON_URL   = "$SITE_URL/$SITE_FOLDER/favicon.ico";
$SITE_CSS_URL       = "$SITE_URL/$SITE_FOLDER/site.css";
$SITE_IMAGES_URL    = "$SITE_URL/$SITE_FOLDER/images";
$SITE_FONTS_URL     = "$SITE_URL/$SITE_FOLDER/fonts";
$SITE_BANNER_IMG_URL= "$SITE_URL/$SITE_IMAGES/banner.png";

$SITE_DISCORD_URL   = "";
$SITE_DISCORD_ICON  = "$SITE_IMAGES/social/discord.png";
$SITE_YOUTUBE_URL   = "";
$SITE_YOUTUBE_ICON  = "$SITE_IMAGES/social/youtube.png";
$SITE_GITHUB_URL    = "https://github.com/deadline-cxn/barebones-php-json";
$SITE_GITHUB_ICON   = "$SITE_IMAGES/social/github.png";
$SITE_FACEBOOK_URL  = "";
$SITE_FACEBOOK_ICON = "$SITE_IMAGES/social/facebook.png";

$SITE_VERIFY_SUBJECT = "$SITE_NAME Registration";
$SITE_VERIFY_MESSAGE = "Welcome to $SITE_NAME, if you click this link it will verify your email against the database. Thank You! 
<a href='$SITE_URL/verify.php?verify=true&id=ZZID&name=ZZNAME'>VERIFY EMAIL</a>";

$SITE_JSON_FOLDER         = "$SITE_FOLDER/db";
$SITE_JSON_USERS          = "$SITE_FOLDER/db/users";

$SITE_FOOTER_MESSAGE  = "Bare Bones PHP JSON by Deadline CXN";

if(file_exists("$SITE_FOLDER/config.php"))
include("$SITE_FOLDER/config.php");

