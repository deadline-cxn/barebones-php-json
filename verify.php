<?php
include("header.php");
if(isset($_SESSION["LOGGED_IN"])) $USER_DATA=get_user_data($_SESSION["LOGGED_IN"]);
if(isset($_REQUEST["other_profile"])) $USER_DATA=get_user_data($_REQUEST["other_profile"]);

// dump_vars($_REQUEST);

echo "<h1>VERIFY EMAIL!</h1>";

$v=$_REQUEST["verify"];
$n=$_REQUEST["name"];

echo "[$v]<br>";

if($v=="true"){
    // Ideally, we want to use some kind of limited time key passed to email/saved in json to bump against
    // if not anyone can craft a verify link to spoof this
    echo "YOU ARE NOW VERIFIED!<br>";
    $ud=get_user_data($n);
    // dump_vars($ud);
    $ud["verified"]=$v;
    set_user_data($n,$ud);
}
else {
    echo "ERROR WHEN VERIFYING YOUR EMAIL...<br>";
}

