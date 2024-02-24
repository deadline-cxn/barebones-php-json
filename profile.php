<?php
include("header.php");

if(isset($_SESSION["LOGGED_IN"])){
    $USER_DATA=get_user_data($_SESSION["LOGGED_IN"]);
    echo "<h1>PROFILE</h1>";
    foreach($USER_DATA as $k => $v) {
        echo "$k => $v<br>";
    }
}
else {

}
include("footer.php");
