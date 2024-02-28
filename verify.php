<?php
include("header.php");
if(isset($_SESSION["LOGGED_IN"])) $USER_DATA=get_user_data($_SESSION["LOGGED_IN"]);
if(isset($_REQUEST["other_profile"])) $USER_DATA=get_user_data($_REQUEST["other_profile"]);

echo "<h1>VERIFY EMAIL!</h1>";

$v=$_REQUEST["verify"];
$n=$_REQUEST["name"];
$i=$_REQUEST["id"];

echo "[$v]<br>";

if($v=="true"){
    if($i==$USER_DATA["id"]) {
        echo "[$i]<br>";
        echo "YOU ARE NOW VERIFIED!<br>";
        $ud=get_user_data($n);
        $ud["verified"]=$v;
        set_user_data($n,$ud);
    }
}
else {
    echo "ERROR WHEN VERIFYING YOUR EMAIL...<br>";
}

