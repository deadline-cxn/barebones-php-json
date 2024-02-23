<?php
include("header.php");

if(isset($_REQUEST["logout"])) {
    session_destroy();
    echo "<meta http-equiv=\"refresh\" content=\"0; url=$SITE_URL\">";
}

if(isset($_REQUEST["uname"])) { // login request
    $usr=$_REQUEST["uname"];
    $pw=md5($_REQUEST["psw"]); // md5 password
	$result=get_user_data($usr);
    if(!empty($result)) if($pw==$result["pw"]) {
         $_SESSION["LOGGED_IN"]=$usr;
    }
    echo "<meta http-equiv=\"refresh\" content=\"0; url=$SITE_URL\">";
}

include("footer.php");
